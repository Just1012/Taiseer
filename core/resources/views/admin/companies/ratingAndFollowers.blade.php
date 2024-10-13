@extends('dashboard.layouts.master')
@section('title', __('backend.countryRatingAndFollowers'))
@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker m-b-xs">
                @if ($rating->isNotEmpty() && $rating->first()->company)
                    <?php
                    $title_var = 'name_' . @Helper::currentLanguage()->code;
                    $title_var2 = 'name_' . config('smartend.default_language');
                    $title = $rating->first()->company->$title_var != '' ? $rating->first()->company->$title_var : $rating->first()->company->$title_var2;
                    ?>
                    <h3>{{ $title }}</h3>
                    <small>
                        <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                        {{ 'Rating' }} /
                        <a href="{{ route('company.index') }}">{{ $title }}</a>
                    </small>
                @else
                    <?php
                    $title_var = 'name_' . @Helper::currentLanguage()->code;
                    $title_var2 = 'name_' . config('smartend.default_language');
                    $title = $company->$title_var != '' ? $company->$title_var : $rating->first()->company->$title_var2;
                    ?>
                    <h3>{{ $title }}</h3>
                    <small>
                        <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                        {{ 'Rating' }} /
                        <a href="{{ route('company.index') }}">{{ $title }}</a>
                    </small>
                @endif
            </div>
            <div class="box-tool">
                <ul class="nav">
                    <li class="nav-item inline">
                        <a class="btn btn-fw primary open-modal" href="javascript:void(0);"
                            data-target="{{ $company->id }}">
                            <i class="material-icons">person_add</i>&nbsp; {{ __('backend.followers') }}
                        </a>
                    </li>
                </ul>
                <!-- Modal for Company Info -->
                <div id="company-modal" class="modal fade" data-backdrop="true" style="text-align: center !important;">
                    <div class="modal-dialog modal-lg" id="animate">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ __('Company Followers') }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body p-lg">
                                <div class="row">
                                    <table class="table table-bordered m-a-0">
                                        <thead>
                                            <tr>
                                                <th class="text-center">User Name</th>
                                                <th class="text-center">Company Shipment Count</th>
                                                <th class="text-center">Total Shipment Count</th>
                                            </tr>
                                        </thead>
                                        <tbody id="followers-list">
                                            @php
                                                // Fetch the followers along with their user and shipment relationships
                                                $followers = App\Models\Follower::where('company_id', $company->id)
                                                    ->with(['user.shipment']) // Eager load shipments relationship
                                                    ->get();
                                            @endphp

                                            @foreach ($followers as $follower)
                                                @php
                                                    // Count shipments related to this specific company for the user
                                                    $companyShipmentCount = $follower->user->shipment
                                                        ->where('company_id', $follower->company_id)
                                                        ->count();

                                                    // Count total shipments for the user
                                                    $totalShipmentCount = $follower->user->shipment->count();
                                                @endphp
                                                <tr>
                                                    <td class="text-center">{{ $follower->user->name }}</td>
                                                    <td class="text-center">{{ $companyShipmentCount }}</td>
                                                    <td class="text-center">{{ $totalShipmentCount }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
            </div>

            @if ($rating->total() == 0)
                <div class="row p-a">
                    <div class="col-sm-12">
                        <div class="p-a text-center light">
                            {{ __('backend.noData') }}
                        </div>
                    </div>
                </div>
            @endif

            @if ($rating->total() > 0)
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
                                <th>Shipment No.</th>
                                <th class="text-center">{{ __('backend.user') }}</th>
                                <th class="text-center">{{ __('backend.rate') }}</th>
                                <th class="text-center">{{ __('backend.feedback') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rating as $WebSection)
                                <tr>
                                    <td class="dker">
                                        <label class="ui-check m-a-0">
                                            <input type="checkbox" name="ids[]" value="{{ $WebSection->id }}"><i
                                                class="dark-white"></i>
                                            {!! Form::hidden('row_ids[]', $WebSection->id, ['class' => 'form-control row_no']) !!}
                                        </label>
                                    </td>
                                    <td class="text-center">shipment# {{ $WebSection->shipment->id }}</td>
                                    <td class="h6">{{ $WebSection->user->name }}</td>
                                    <td class="h6 text-center">
                                        @for ($i = 1; $i <= $WebSection->rate; $i++)
                                            <i class="fa fa-star text-warning"></i>
                                        @endfor
                                        @for ($i = $WebSection->rate + 1; $i <= 5; $i++)
                                            <i class="fa fa-star-o text-muted"></i>
                                        @endfor
                                    </td>
                                    <td class="h6">{{ $WebSection->comment }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <footer class="dker p-a">
                    <div class="row">
                        <div class="col-sm-3 hidden-xs">
                            <div id="m-all" class="modal fade" data-backdrop="true">
                                <div class="modal-dialog" id="animate">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ __('backend.confirmation') }}</h5>
                                        </div>
                                        <div class="modal-body text-center p-lg">
                                            <p>{{ __('backend.confirmationDeleteMsg') }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn dark-white p-x-md"
                                                data-dismiss="modal">{{ __('backend.no') }}</button>
                                            <button type="submit"
                                                class="btn danger p-x-md">{{ __('backend.yes') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                ui-target="#animate">{{ __('backend.apply') }}</button>
                        </div>
                        <div class="col-sm-3 text-center">
                            <small class="text-muted inline m-t-sm m-b-sm">{{ __('backend.showing') }}
                                {{ $rating->firstItem() }} -{{ $rating->lastItem() }} {{ __('backend.of') }}
                                <strong>{{ $rating->total() }}</strong> {{ __('backend.records') }}</small>
                        </div>
                        <div class="col-sm-6 text-right text-center-xs">
                            {!! $rating->links() !!}
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
        $(document).ready(function() {
            $('.open-modal').on('click', function() {
                var companyId = $(this).data('target'); // Get the company ID
                var currentLocale = "{{ app()->getLocale() }}"; // Get the current locale from Blade
                $('#company-modal').modal('show');
                // // Make AJAX call to fetch the followers for the company
                // $.ajax({
                //     url: '/admin/get-company/' + companyId, // Define your route
                //     method: 'GET',
                //     success: function(response) {
                //         console.log(response);

                //         // Clear the current list of followers
                //         $('#followers-list').empty();

                //         // Loop through the followers and append them to the table
                //         response.followers.forEach(function(follower) {
                //             // Check for the current locale and display the company name accordingly
                //             var companyName = follower.company ?
                //                 (currentLocale === 'ar' ? follower.company.name_ar :
                //                     follower.company.name_en) :
                //                 'N/A'; // If no company, show "N/A"


                //             // Append the follower data to the table
                //             $('#followers-list').append(`
            //             <tr>
            //                 <td class="text-center">${follower.user.name}</td>
            //                 <td class="text-center">${companyName}</td>
            //             </tr>
            //         `);
                //         });

                //         // Show the modal
                //         $('#company-modal').modal('show');
                //     },
                //     error: function() {
                //         alert('Error loading company data.');
                //     }
                // });
            });
        });
    </script>
@endpush
