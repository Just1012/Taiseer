@extends('dashboard.layouts.master')
@section('title', __('backend.shipment'))
@push('after-styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@endpush
@section('content')
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
                <h3>{{ __('backend.shipment') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                    {{ __('backend.webmasterTools') }} /
                    <a href="">{{ __('backend.shipment') }}</a>
                </small>
            </div>
            {{-- <div class="box-tool">
                <ul class="nav">
                    <li class="nav-item inline">
                        <a class="btn btn-fw primary" href="">
                            <i class="material-icons">&#xe02e;</i>
                            &nbsp; {{ __('backend.newCompany') }}</a>
                    </li>
                </ul>
            </div> --}}
            @if ($shipment->total() == 0)
                <div class="row p-a">
                    <div class="col-sm-12">
                        <div class=" p-a text-center light ">
                            {{ __('backend.noData') }}
                        </div>
                    </div>
                </div>
            @endif

            @if ($shipment->total() > 0)

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
                                <th class="text-center">{{ __('backend.shipmentDescription') }}</th>
                                <th class="text-center">{{ __('backend.shipmentStatus') }}</th>
                                <th class="text-center">{{ __('backend.shipmentHistort') }}</th>
                                <th class="text-center" style="width:200px;">{{ __('backend.options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $title_var = 'name_' . @Helper::currentLanguage()->code;
                            $title_var2 = 'name_' . config('smartend.default_language');
                            ?>
                            @foreach ($shipment as $WebSection)
                                <tr>
                                    <td class="dker"><label class="ui-check m-a-0">
                                            <input type="checkbox" name="ids[]" value="{{ $WebSection->id }}"><i
                                                class="dark-white"></i>
                                            {!! Form::hidden('row_ids[]', $WebSection->id, ['class' => 'form-control row_no']) !!}
                                        </label>
                                    </td>
                                    <td class="text-center">{{ $WebSection->id }}</td>
                                    <?php
                                    if ($WebSection->company) {
                                        if ($WebSection->$title_var != '') {
                                            $title = $WebSection->company->$title_var;
                                        } else {
                                            $title = $WebSection->company->$title_var2;
                                        }
                                    } else {
                                        $title = __('backend.noCompany'); // You can define this string in your language file
                                    }
                                    ?>
                                    <td class="h6">{!! $title !!}</td>
                                    <td class="h6">{{ $WebSection->shipment_type }}</td>
                                    <!-- Status Dropdown -->
                                    <td class="text-center">
                                        <select class="status-dropdown btn btn-info btn-sm"
                                            data-id="{{ $WebSection->id }}">

                                            <option value="new" {{ $WebSection->status == 'new' ? 'selected' : '' }}>New
                                            </option>
                                            <option value="accepted"
                                                {{ $WebSection->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                            <option value="in_transit"
                                                {{ $WebSection->status == 'in_transit' ? 'selected' : '' }}>In Transit
                                            </option>
                                            <option value="delivered"
                                                {{ $WebSection->status == 'delivered' ? 'selected' : '' }}>Delivered
                                            </option>
                                            <option value="rejected"
                                                {{ $WebSection->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            <option value="closed" {{ $WebSection->status == 'closed' ? 'selected' : '' }}>
                                                Closed</option>

                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm warning" data-toggle="modal"
                                            data-target="#ml-{{ $WebSection->id }}" ui-toggle-class="bounce"
                                            ui-target="#animate">
                                            <small>
                                                <i class="material-icons">access_alarms</i>
                                                {{ 'History' }}
                                            </small>
                                        </button>
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
                                <!-- Info modal -->
                                <div id="m-{{ $WebSection->id }}" class="modal fade" data-backdrop="true"
                                    style="text-align: center !important; text-transform: capitalize;">
                                    <div class="modal-dialog modal-lg d-flex justify-content-center align-items-center"
                                        id="animate">
                                        <div class="modal-content text-center">
                                            <div class="modal-header">
                                                <h5 class="modal-title w-100">{{ $title }}
                                                    {{ __('Company Information') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body p-lg">
                                                <!-- Row for Name and About -->
                                                <div class="row justify-content-center">
                                                    <div class="col-md-4">
                                                        <h6 class="text-muted">{{ __('Customer Name') }}:</h6>
                                                        <p><strong>{{ $WebSection->user->name }}</strong></p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h6 class="text-muted">{{ __('Company Name') }}:</h6>
                                                        <p><strong>{{ $title }}</strong></p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h6 class="text-muted">{{ __('Expected Delivery Date') }}:</h6>
                                                        <p>{{ $WebSection->expected_delivery_date }}</p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row justify-content-center">
                                                    <div class="col-md-6">
                                                        <h6 class="text-muted">{{ __('Shipment Type') }}:</h6>
                                                        <p>{{ $WebSection->shipment_type }}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6 class="text-muted">{{ __('Content Description') }}:</h6>
                                                        <p>{{ $WebSection->content_description }}</p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <!-- Contact Information -->
                                                <div class="row justify-content-center">

                                                    <div class="col-md-6">
                                                        <h6 class="text-muted">{{ __('From Address') }}:</h6>
                                                        <p>
                                                            <!-- Get the country and city name based on locale -->
                                                            {{ app()->getLocale() == 'ar' ? $WebSection->addressTo->country->name_ar : $WebSection->addressTo->country->name_en }}
                                                            -
                                                            {{ app()->getLocale() == 'ar' ? $WebSection->addressTo->city->title_ar : $WebSection->addressTo->city->title_en }}
                                                            -
                                                            {{ $WebSection->addressTo->address_line }}
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6 class="text-muted">{{ __('To Address') }}:</h6>
                                                        <p>
                                                            <!-- Get the country and city name based on locale -->
                                                            {{ app()->getLocale() == 'ar' ? $WebSection->addressFrom->country->name_ar : $WebSection->addressFrom->country->name_en }}
                                                            -
                                                            {{ app()->getLocale() == 'ar' ? $WebSection->addressFrom->city->title_ar : $WebSection->addressFrom->city->title_en }}
                                                            -
                                                            {{ $WebSection->addressTo->address_line }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <!-- Receiver Info -->
                                                <div class="row justify-content-center">
                                                    <div class="col-md-6">
                                                        <h6 class="text-muted">{{ __('Receiver Name') }}:</h6>
                                                        <p>{{ $WebSection->receiver_name }}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6 class="text-muted">{{ __('Receiver Phone') }}:</h6>
                                                        <p>{{ $WebSection->receiver_phone }}</p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <!-- Shipment Details -->
                                                <div class="row justify-content-center">
                                                    <div class="col-md-4">
                                                        <h6 class="text-muted">{{ __('Shipment Status') }}:</h6>
                                                        <p class="text-danger">{{ $WebSection->status }}</p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h6 class="text-muted">{{ __('Payment Method') }}:</h6>
                                                        <p class="text-success">{{ $WebSection->payment_method }}</p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h6 class="text-muted">{{ __('Tracking Number') }}:</h6>
                                                        <p>{{ $WebSection->tracking_number }}</p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row justify-content-center">
                                                    <div class="col-md-4">
                                                        <h6 class="text-muted">{{ __('Shipment Rate') }}:</h6>
                                                        <p class="text-danger">
                                                            @if ($WebSection->rating !== null)
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    @if ($i <= $WebSection->rating)
                                                                        <!-- Display filled star -->
                                                                        <i class="fa fa-star text-warning"></i>
                                                                    @else
                                                                        <!-- Display empty star -->
                                                                        <i class="fa fa-star-o text-warning"></i>
                                                                    @endif
                                                                @endfor
                                                            @else
                                                                <!-- Display a message if there's no rating -->
                                                                <span>{{ __('No Rating') }}</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                    @if ($WebSection->rejection_reason)
                                                        <div class="col-md-4">
                                                            <h6 class="text-muted">{{ __('Rejection Reason') }}:</h6>
                                                            <p class="text-danger">{{ $WebSection->rejection_reason }}</p>
                                                        </div>
                                                    @endif
                                                    <div class="col-md-4">
                                                        <h6 class="text-muted">{{ __('Shipment Created At') }}:</h6>
                                                        <p class="text-danger">{{ $WebSection->created_at }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-center">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    <i class="material-icons">close</i> {{ __('backend.close') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- / .modal -->
                                <!-- History modal -->
                                <div id="ml-{{ $WebSection->id }}" class="modal fade" data-backdrop="true"
                                    style="text-align: center !important; text-transform: capitalize;">
                                    <div class="modal-dialog modal-lg d-flex justify-content-center align-items-center"
                                        id="animate">
                                        <div class="modal-content text-center">
                                            <div class="modal-header">
                                                <h5 class="modal-title w-100">
                                                    {{ __('Shipment History') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body p-lg">
                                                <div class="row justify-content-center">
                                                    @php
                                                        $shipmentHistory = App\Models\ShipmentStatusHistory::with(
                                                            'changedBy',
                                                        )
                                                            ->where('shipment_id', $WebSection->id)
                                                            ->get();
                                                    @endphp
                                                    <div class="row justify-content-center">
                                                        <div class="col-md-3">
                                                            <h6 class="text-muted">{{ __('Status') }}:</h6>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <h6 class="text-muted">{{ __('Changed By') }}:</h6>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <h6 class="text-muted">{{ __('Changed At') }}:</h6>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <h6 class="text-muted">{{ __('Remarks') }}:</h6>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    @if ($shipmentHistory->isNotEmpty())
                                                        @foreach ($shipmentHistory as $history)
                                                            <div class="row justify-content-center">
                                                                <div class="col-md-3">
                                                                    <p>{{ ucfirst($history->status) }}
                                                                    </p>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <p>{{ $history->changedBy->name }}</p>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <p>{{ $history->changed_at }}</p>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <p>
                                                                        {{ $history->remarks ?? __('No Remarks') }}</p>
                                                                </div>
                                                            </div>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <p>{{ __('No shipment history available.') }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-center">
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
                                {{ $shipment->firstItem() }}
                                -{{ $shipment->lastItem() }} {{ __('backend.of') }}
                                <strong>{{ $shipment->total() }}</strong> {{ __('backend.records') }}
                            </small>
                        </div>
                        <div class="col-sm-6 text-right text-center-xs">
                            {!! $shipment->links() !!}
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
            var url = '{{ route('shipment.updateStatus', ':id') }}'; // URL for the status update
            var shipmentId = $(this).data('id'); // The ID of the company
            var newStatus = $(this).val(); // The new status value selected by the user
            url = url.replace(':id', shipmentId); // Replace the placeholder in the URL with the actual company ID

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
@endpush
