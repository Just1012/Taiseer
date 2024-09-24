@extends('dashboard.layouts.master')
@section('title', __('backend.usersPermissions'))
@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3><i class="material-icons">&#xe3c9;</i> {{ __('backend.editUser') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                    <a href="">{{ __('backend.settings') }}</a> /
                    <a href="">{{ __('backend.usersPermissions') }}</a>
                </small>
            </div>
            <div class="box-tool">
                <ul class="nav">
                    <li class="nav-item inline">
                        <a class="nav-link" href="{{ route('users') }}">
                            <i class="material-icons md-18">×</i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="box-body">
                {{ Form::open(['route' => ['usersUpdate', $Users->id], 'method' => 'POST', 'files' => true]) }}

                <div class="form-group row">
                    <label for="name" class="col-sm-2 form-control-label">{!! __('backend.fullName') !!}</label>
                    <div class="col-sm-10">
                        {!! Form::text('name', $Users->name, [
                            'placeholder' => '',
                            'class' => 'form-control',
                            'id' => 'name',
                            'required' => '',
                        ]) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-sm-2 form-control-label">{!! __('backend.loginEmail') !!}</label>
                    <div class="col-sm-10">
                        {!! Form::email('email', $Users->email, [
                            'placeholder' => '',
                            'class' => 'form-control',
                            'id' => 'email',
                            'required' => '',
                        ]) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="phone" class="col-sm-2 form-control-label">{!! __('backend.phone') !!}</label>
                    <div class="col-sm-10">
                        {!! Form::text('phone', $Users->phone, [
                            'placeholder' => '',
                            'class' => 'form-control',
                            'id' => 'phone',
                            'required' => '',
                        ]) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-sm-2 form-control-label">{!! __('backend.loginPassword') !!}</label>
                    <div class="col-sm-10">
                        <input type="password" name="password" minlength="6" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="photo_file" class="col-sm-2 form-control-label">{!! __('backend.topicPhoto') !!}</label>
                    <div class="col-sm-10">
                        @if ($Users->photo != '')
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="user_photo" class="col-sm-4 box p-a-xs">
                                        <a target="_blank" href="{{ asset('uploads/users/' . $Users->photo) }}"><img
                                                src="{{ asset('uploads/users/' . $Users->photo) }}" class="img-responsive">
                                            {{ $Users->photo }}
                                        </a>
                                        <br>
                                        <a onclick="document.getElementById('user_photo').style.display='none';document.getElementById('photo_delete').value='1';document.getElementById('undo').style.display='block';"
                                            class="btn btn-sm btn-default">{!! __('backend.delete') !!}</a>
                                    </div>
                                    <div id="undo" class="col-sm-4 p-a-xs" style="display: none">
                                        <a
                                            onclick="document.getElementById('user_photo').style.display='block';document.getElementById('photo_delete').value='0';document.getElementById('undo').style.display='none';">
                                            <i class="material-icons">&#xe166;</i> {!! __('backend.undoDelete') !!}
                                        </a>
                                    </div>

                                    {!! Form::hidden('photo_delete', '0', ['id' => 'photo_delete']) !!}
                                </div>
                            </div>
                        @endif

                        {!! Form::file('photo', ['class' => 'form-control', 'id' => 'photo', 'accept' => 'image/*']) !!}
                        <small>
                            <i class="material-icons">&#xe8fd;</i>
                            {!! __('backend.imagesTypes') !!}
                        </small>
                    </div>
                </div>

                @php
                    use App\Enums\UserType;
                @endphp
                @if (@Auth::user()->permissionsGroup->webmaster_status)
                    <div class="form-group row">
                        <label for="permissions1" class="col-sm-2 form-control-label">{!! __('backend.Permission') !!}</label>
                        <div class="col-sm-10">
                            <div class="radio">
                                <select name="permissions_id" id="permissions_id" required class="form-control c-select">
                                    <option value="">- - {!! __('backend.selectPermissionsType') !!} - -</option>
                                    @foreach ($Permissions as $Permission)
                                        <option value="{{ $Permission->id }}" {!! $Users->permissions_id == $Permission->id ? "selected='selected'" : '' !!}>
                                            {{ $Permission->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Enum for user_type -->
                    <div class="form-group row">
                        <label for="user_type" class="col-sm-2 form-control-label">User Type</label>
                        <div class="col-sm-10">
                            <select name="user_type" id="user_type" class="form-control c-select" required>
                                <option value="">- - Select User Type - -</option>
                                @foreach (UserType::cases() as $type)
                                    <option value="{{ $type->value }}" {!! $Users->user_type == $type->value ? "selected='selected'" : '' !!}>
                                        {{ ucfirst(str_replace('_', ' ', $type->name)) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Company ID (conditionally visible) -->
                    <div class="form-group row" id="company_id_section"
                        style="{{ $Users->user_type == 'company_user' ? 'display: block;' : 'display: none;' }}">
                        <label for="company_id" class="col-sm-2 form-control-label">{!! __('backend.Company') !!}</label>
                        <div class="col-sm-10">
                            <select name="company_id" id="company_id" class="form-control c-select">
                                <option value="">- - {!! __('backend.selectCompanysType') !!} - -</option>
                                <?php
                                $title_var = 'name_' . @Helper::currentLanguage()->code;
                                $title_var2 = 'name_' . config('smartend.default_language');
                                ?>
                                @foreach ($companies as $company)
                                    <?php
                                    $title = $company->$title_var != '' ? $company->$title_var : $company->$title_var2;
                                    ?>
                                    <option value="{{ $company->id }}"
                                        {{ $Users->company_id == $company->id ? 'selected' : '' }}>{!! $title !!}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="link_status" class="col-sm-2 form-control-label">{!! __('backend.status') !!}</label>
                        <div class="col-sm-10">
                            <div class="radio">
                                <label class="ui-check ui-check-md">
                                    {!! Form::radio('status', '1', $Users->status == 1 ? true : false, ['id' => 'status1', 'class' => 'has-value']) !!}
                                    <i class="dark-white"></i>
                                    {{ __('backend.active') }}
                                </label>
                                &nbsp; &nbsp;
                                <label class="ui-check ui-check-md">
                                    {!! Form::radio('status', '0', $Users->status == 0 ? true : false, ['id' => 'status2', 'class' => 'has-value']) !!}
                                    <i class="dark-white"></i>
                                    {{ __('backend.notActive') }}
                                </label>
                            </div>
                        </div>
                    </div>
                @else
                    {!! Form::hidden('permissions_id', $Users->permissions_id) !!}
                    {!! Form::hidden('status', $Users->status) !!}

                @endif

                <div class="form-group row m-t-md">
                    <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary m-t"><i class="material-icons">
                                &#xe31b;</i> {!! __('backend.update') !!}</button>
                        <a href="{{ route('users') }}" class="btn btn-default m-t"><i class="material-icons">
                                &#xe5cd;</i> {!! __('backend.cancel') !!}</a>
                    </div>
                </div>

                {{ Form::close() }}
            </div>
        </div>
    </div>

    <!-- JavaScript to handle dynamic visibility of company_id based on user_type -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var userTypeSelect = document.getElementById('user_type');
            var companyIdSection = document.getElementById('company_id_section');

            userTypeSelect.addEventListener('change', function() {
                if (this.value === 'company_user') {
                    companyIdSection.style.display = 'block'; // Show company_id section
                } else {
                    companyIdSection.style.display = 'none'; // Hide company_id section
                }
            });

            // Trigger the change event on page load to set the correct visibility
            userTypeSelect.dispatchEvent(new Event('change'));
        });
    </script>
@endsection
