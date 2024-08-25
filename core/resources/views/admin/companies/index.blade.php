@extends('dashboard.layouts.master')
@section('title', __('backend.company'))
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
                                        <a class="btn btn-sm info"
                                            href="{{ route('company.Edit', ['company' => $WebSection->id]) }}">
                                            <small><i class="material-icons">&#xe3c9;</i> {{ __('backend.edit') }}
                                            </small>
                                        </a>
                                    </td>
                                </tr>
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
@endpush