@extends('dashboard.layouts.master')
@section('title', __('backend.company'))

@section('content')
    <!-- Fullscreen Image CSS -->
    <style>
        /* Style for fullscreen container */
        .fullscreen-image-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            cursor: pointer;
        }

        /* Style for the image in fullscreen */
        .fullscreen-image {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
        }
    </style>
    <div class="padding">
        @if (session('status') == 'success')
            <div id="flash-message" class="alert alert-success">
                {{ session('message') }}
            </div>
        @elseif (session('status') == 'error')
            <div id="flash-message" class="alert alert-danger">
                {{ session('message') }}
            </div>
        @endif
        <div class="box">
            <div class="box-header dker m-b-xs">
                <h3>{{ __('backend.company') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                    {{ __('backend.webmasterTools') }} /
                    <a href="">{{ __('backend.company') }}</a>
                </small>
            </div>
            <div class="box-tool">
                <ul class="nav">
                    <li class="nav-item inline">
                        <a class="btn btn-fw primary" href="{{ route('company.Create') }}">
                            <i class="material-icons">&#xe02e;</i>
                            &nbsp; {{ __('backend.newCompany') }}</a>
                    </li>
                </ul>
            </div>
            @if ($company->total() == 0)
                <div class="row p-a">
                    <div class="col-sm-12">
                        <div class=" p-a text-center light ">
                            {{ __('backend.noData') }}
                        </div>
                    </div>
                </div>
            @endif

            @if ($company->total() > 0)

                {{ Form::open(['route' => 'WebmasterSectionsUpdateAll', 'method' => 'post']) }}
                <div class="table-responsive">
                    <table class="table table-bordered m-a-0">
                        <thead class="dker">
                            <tr>
                                <th class="width20 dker">
                                    <label class="ui-check m-a-0">
                                        <input id="checkAll" type="checkbox"><i></i>
                                    </label>
                                </th>
                                <th class="text-center w-64">ID</th>
                                <th>{{ __('backend.companyName') }}</th>
                                <th class="text-center">{{ __('backend.currency') }}</th>
                                <th class="text-center">{{ __('backend.companStatus') }}</th>
                                <th class="text-center">{{ __('backend.Rating & Followers') }}</th>
                                <th class="text-center" style="width:200px;">{{ __('backend.options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $title_var = 'name_' . @Helper::currentLanguage()->code;
                            $title_var2 = 'name_' . config('smartend.default_language');
                            ?>
                            @foreach ($company as $WebSection)
                                <?php
                                if ($WebSection->$title_var != '') {
                                    $title = $WebSection->$title_var;
                                } else {
                                    $title = $WebSection->$title_var2;
                                }
                                ?>
                                <tr>
                                    <td class="dker"><label class="ui-check m-a-0">
                                            <input type="checkbox" name="ids[]" value="{{ $WebSection->id }}"><i
                                                class="dark-white"></i>
                                            {!! Form::hidden('row_ids[]', $WebSection->id, ['class' => 'form-control row_no']) !!}
                                        </label>
                                    </td>
                                    <td class="text-center">{{ $WebSection->id }}</td>
                                    <td class="h6"> {!! $title !!}</td>
                                    <td class="h6">{{ $WebSection->email }}</td>
                                    <!-- Status Dropdown -->
                                    <td class="text-center">
                                        <select class="status-dropdown btn btn-info btn-sm"
                                            data-id="{{ $WebSection->id }}">

                                            <option value="1"
                                                {{ $WebSection->company_status_id == 1 ? 'selected' : '' }}>قيد الانتظار
                                            </option>
                                            <option value="2"
                                                {{ $WebSection->company_status_id == 2 ? 'selected' : '' }}>قبول</option>
                                            <option value="3"
                                                {{ $WebSection->company_status_id == 3 ? 'selected' : '' }}>رفض</option>

                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-sm secondry"
                                        @php
                                            // Calculate the average rating by summing the rate column and dividing by the count
                                            $ratings = App\Models\Rating::where('company_id', $WebSection->id);
                                            $totalRating = $ratings->sum('rate');
                                            $ratingsCount = $ratings->count();
                                            $averageRating = $ratingsCount > 0 ? $totalRating / $ratingsCount : 0;
                                            $fullStars = floor($averageRating); // Number of full stars
                                            $halfStar = $averageRating - $fullStars >= 0.5 ? true : false; // If there's a half star
                                            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0); // Remaining empty stars
                                        @endphp
                                            href="{{ route('getRating', ['companyId' => $WebSection->id]) }}">
                                            <small>
                                                <!-- Full Stars -->
                                                @for ($i = 0; $i < $fullStars; $i++)
                                                    <i class="fa fa-star text-warning"></i>
                                                @endfor

                                                <!-- Half Star -->
                                                @if ($halfStar)
                                                    <i class="fa fa-star-half-o text-warning"></i>
                                                @endif

                                                <!-- Empty Stars -->
                                                @for ($i = 0; $i < $emptyStars; $i++)
                                                    <i class="fa fa-star-o text-muted"></i>
                                                @endfor
                                            </small>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm success" data-toggle="modal"
                                            data-target="#m-{{ $WebSection->id }}" ui-toggle-class="bounce"
                                            ui-target="#animate">
                                            <small>
                                                <i class="material-icons">insert_comment</i>
                                                {{ 'View Info' }}
                                            </small>
                                        </button>
                                        <a class="btn btn-sm info"
                                            href="{{ route('company.Edit', ['company' => $WebSection->id]) }}">
                                            <small><i class="material-icons">&#xe3c9;</i> {{ __('backend.edit') }}
                                            </small>
                                        </a>
                                    </td>
                                </tr>
                                <!-- .modal -->
                                <div id="m-{{ $WebSection->id }}" class="modal fade" data-backdrop="true"
                                    style="text-align: center !important;">
                                    <div class="modal-dialog modal-lg" id="animate">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">{{ $title }}
                                                    {{ __('Company Information') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body p-lg">
                                                <!-- Row for Name and About -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6 class="text-muted">{{ __('Company Name (EN)') }}:</h6>
                                                        <p><strong>{{ $WebSection->name_en }}</strong></p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6 class="text-muted">{{ __('Company Name (AR)') }}:</h6>
                                                        <p><strong>{{ $WebSection->name_ar }}</strong></p>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6 class="text-muted">{{ __('About (EN)') }}:</h6>
                                                        <p>{{ $WebSection->about_ar }}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6 class="text-muted">{{ __('About (AR)') }}:</h6>
                                                        <p>{{ $WebSection->about_ar }}</p>
                                                    </div>
                                                </div>

                                                <!-- Contact Information -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6 class="text-muted">{{ __('Email') }}:</h6>
                                                        <p>{{ $WebSection->email }}</p>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <h6 class="text-muted">{{ __('Phone Number') }}:</h6>
                                                        <p>{{ $WebSection->code }} {{ $WebSection->phone }}</p>
                                                    </div>
                                                </div>

                                                <!-- License and IDs -->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h6 class="text-muted d-inline">{{ __('Business License') }}:</h6>
                                                        <p class="d-inline">
                                                            {{ $WebSection->BL ? $WebSection->BL : __('Not Provided') }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <!-- Country, City, and Activities -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6 class="text-muted">{{ __('Country') }}:</h6>
                                                        <p>
                                                            {{ implode(' - ', $WebSection->countries->pluck(App::getLocale() == 'ar' ? 'name_ar' : 'name_en')->toArray()) }}
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6 class="text-muted">{{ __('City') }}:</h6>
                                                        <p>
                                                            {{ implode(' - ', $WebSection->cities->pluck(App::getLocale() == 'ar' ? 'title_ar' : 'title_en')->toArray()) }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h6 class="text-muted">{{ __('Type of Activities') }}:</h6>
                                                        <p>
                                                            {{ implode(
                                                                ' - ',
                                                                $WebSection->typeActivityCompanies->map(function ($type) {
                                                                        return App::getLocale() == 'ar' ? $type->typeActivities->name_ar : $type->typeActivities->name_en;
                                                                    })->toArray(),
                                                            ) }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <!-- Additional Information -->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h6 class="text-muted">{{ __('Additional Info (EN)') }}:</h6>
                                                        <p>
                                                            @php
                                                                // Get default type information
                                                                $defuluteTypeInfArray = $WebSection->typeActivityCompanies
                                                                    ->map(function ($type) {
                                                                        return App::getLocale() == 'ar'
                                                                            ? $type->typeActivities->info_ar
                                                                            : $type->typeActivities->info_en;
                                                                    })
                                                                    ->toArray();

                                                                // Get type info based on current locale
                                                                $typeInfoArray = $WebSection->typeActivityCompanies
                                                                    ->pluck(
                                                                        App::getLocale() == 'ar'
                                                                            ? 'info_ar'
                                                                            : 'info_en',
                                                                    )
                                                                    ->toArray();

                                                                // Iterate through each type info and replace null values with the default type info
                                                                foreach ($typeInfoArray as $index => $value) {
                                                                    if (empty($value)) {
                                                                        $typeInfoArray[$index] =
                                                                            $defuluteTypeInfArray[$index] ?? ''; // Replace with default if it's null or empty
                                                                        }
                                                                    }

                                                                    // Implode the final type info array into a string
                                                                    $typeInfo = implode(' - ', $typeInfoArray);
                                                            @endphp
                                                            {{ $typeInfo }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <!-- Logos and Covers -->
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <h6 class="text-muted">{{ __('BL Image') }}:</h6>
                                                        @if ($WebSection->BL_image)
                                                            <img src="{{ asset('uploads/companies/' . $WebSection->BL_image) }}"
                                                                alt="BL Image" class="img-thumbnail" width="100"
                                                                onclick="openFullScreen(this)" style="cursor: pointer;">
                                                        @else
                                                            <p>{{ __('Not Provided') }}</p>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h6 class="text-muted">{{ __('ID Front Image') }}:</h6>
                                                        @if ($WebSection->id_front_image)
                                                            <img src="{{ asset('uploads/companies/' . $WebSection->id_front_image) }}"
                                                                alt="ID Front" class="img-thumbnail" width="100"
                                                                onclick="openFullScreen(this)" style="cursor: pointer;">
                                                        @else
                                                            <p>{{ __('Not Provided') }}</p>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h6 class="text-muted">{{ __('Company Logo') }}:</h6>
                                                        @if ($WebSection->logo)
                                                            <img src="{{ asset('uploads/companies/' . $WebSection->logo) }}"
                                                                alt="Logo" class="img-thumbnail" width="100"
                                                                onclick="openFullScreen(this)" style="cursor: pointer;">
                                                        @else
                                                            <p>{{ __('Not Provided') }}</p>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h6 class="text-muted">{{ __('Cover Image') }}:</h6>
                                                        @if ($WebSection->cover)
                                                            <img src="{{ asset('uploads/companies/' . $WebSection->cover) }}"
                                                                alt="Cover" class="img-thumbnail" width="100"
                                                                onclick="openFullScreen(this)" style="cursor: pointer;">
                                                        @else
                                                            <p>{{ __('Not Provided') }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    <i class="material-icons">close</i> {{ __('backend.close') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- / .modal -->
                            @endforeach

                        </tbody>
                    </table>

                </div>
                <footer class="dker p-a">
                    <div class="row">
                        <div class="col-sm-3 hidden-xs">
                            <!-- .modal -->
                            <div id="m-all" class="modal fade" data-backdrop="true">
                                <div class="modal-dialog" id="animate">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ __('backend.confirmation') }}</h5>
                                        </div>
                                        <div class="modal-body text-center p-lg">
                                            <p>
                                                {{ __('backend.confirmationDeleteMsg') }}
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn dark-white p-x-md"
                                                data-dismiss="modal">{{ __('backend.no') }}</button>
                                            <button type="submit"
                                                class="btn danger p-x-md">{{ __('backend.yes') }}</button>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div>
                            </div>
                            <!-- / .modal -->

                            <select name="action" id="action" class="form-control c-select w-sm inline v-middle"
                                required>
                                <option value="">{{ __('backend.bulkAction') }}</option>
                                <option value="order">{{ __('backend.saveOrder') }}</option>
                                <option value="activate">{{ __('backend.activeSelected') }}</option>
                                <option value="block">{{ __('backend.blockSelected') }}</option>
                                <option value="delete">{{ __('backend.deleteSelected') }}</option>
                            </select>
                            <button type="submit" id="submit_all" class="btn white">{{ __('backend.apply') }}</button>
                            <button id="submit_show_msg" class="btn white" data-toggle="modal" style="display: none"
                                data-target="#m-all" ui-toggle-class="bounce"
                                ui-target="#animate">{{ __('backend.apply') }}
                            </button>
                        </div>

                        <div class="col-sm-3 text-center">
                            <small class="text-muted inline m-t-sm m-b-sm">{{ __('backend.showing') }}
                                {{ $company->firstItem() }}
                                -{{ $company->lastItem() }} {{ __('backend.of') }}
                                <strong>{{ $company->total() }}</strong> {{ __('backend.records') }}
                            </small>
                        </div>
                        <div class="col-sm-6 text-right text-center-xs">
                            {!! $company->links() !!}
                        </div>
                    </div>
                </footer>
                {{ Form::close() }}
            @endif
        </div>
    </div>
@endsection
@push('after-scripts')
    <script type="text/javascript">
        $("#checkAll").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
        $("#action").change(function() {
            if (this.value == "delete") {
                $("#submit_all").css("display", "none");
                $("#submit_show_msg").css("display", "inline-block");
            } else {
                $("#submit_all").css("display", "inline-block");
                $("#submit_show_msg").css("display", "none");
            }
        });
    </script>
    <script>
        $(document).on('change', '.status-dropdown', function() {
            var url = '{{ route('company.updateStatus', ':id') }}'; // URL for the status update
            var companyId = $(this).data('id'); // The ID of the company
            var newStatus = $(this).val(); // The new status value selected by the user
            url = url.replace(':id', companyId); // Replace the placeholder in the URL with the actual company ID

            $.ajax({
                type: 'GET', // Sending the request as a GET (you can use POST if preferred)
                url: url, // The route URL for updating the status
                data: {
                    status: newStatus // Sending the new status value
                },
                success: function(response) {
                    // Refresh the page after the status update
                    location.reload();
                },
                error: function(response) {
                    // Refresh the page in case of error
                    location.reload();
                }
            });
        });
    </script>
    <script>
        // Wait until the document is fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Select the flash message by its ID
            var flashMessage = document.getElementById('flash-message');

            // If the flash message exists, set a timer to hide it after 5 seconds
            if (flashMessage) {
                setTimeout(function() {
                    // Fade out the message and remove it from the DOM
                    flashMessage.style.transition = 'opacity 1s ease';
                    flashMessage.style.opacity = '0';

                    // Remove the message from the DOM after the fade out completes
                    setTimeout(function() {
                        flashMessage.remove();
                    }, 1000); // 1 second to allow the fade-out effect
                }, 5000); // 5 seconds before starting to hide the message
            }
        });
    </script>
    <!-- Fullscreen Image Script -->
    <script>
        function openFullScreen(image) {
            var fullScreenContainer = document.createElement('div');
            fullScreenContainer.className = 'fullscreen-image-container';

            var fullScreenImage = document.createElement('img');
            fullScreenImage.src = image.src;
            fullScreenImage.className = 'fullscreen-image';

            fullScreenContainer.appendChild(fullScreenImage);
            document.body.appendChild(fullScreenContainer);

            // Close the fullscreen image on click
            fullScreenContainer.addEventListener('click', function() {
                document.body.removeChild(fullScreenContainer);
            });
        }
    </script>
@endpush
