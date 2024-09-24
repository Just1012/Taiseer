@extends('dashboard.layouts.master')
@section('title', __('backend.usersPermissions'))
@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3><i class="material-icons">&#xe02e;</i> {{ __('backend.newUser') }}</h3>
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
                {{ Form::open(['route' => ['usersStore'], 'method' => 'POST', 'files' => true]) }}

                <div class="form-group row">
                    <label for="name" class="col-sm-2 form-control-label">{!! __('backend.fullName') !!}</label>
                    <div class="col-sm-10">
                        {!! Form::text('name', '', ['placeholder' => '', 'class' => 'form-control', 'id' => 'name', 'required' => '']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-sm-2 form-control-label">{!! __('backend.loginEmail') !!}</label>
                    <div class="col-sm-10">
                        {!! Form::email('email', '', [
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
                        {!! Form::text('phone', '', [
                            'placeholder' => '',
                            'class' => 'form-control',
                            'id' => 'phone',
                            'required' => '',
                            'pattern' => '[0-9]{10,15}', // Ensures phone numbers are digits with length between 10 and 15
                        ]) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-sm-2 form-control-label">{!! __('backend.loginPassword') !!}</label>
                    <div class="col-sm-10">
                        <input type="password" name="password" class="form-control" minlength="6" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="photo" class="col-sm-2 form-control-label">{!! __('backend.personalPhoto') !!}</label>
                    <div class="col-sm-10">
                        {!! Form::file('photo', ['class' => 'form-control', 'id' => 'photo', 'accept' => 'image/*']) !!}
                        <small>
                            <i class="material-icons">&#xe8fd;</i>
                            {!! __('backend.imagesTypes') !!}
                        </small>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="permissions_id" class="col-sm-2 form-control-label">{!! __('backend.Permission') !!}</label>
                    <div class="col-sm-10">
                        <select name="permissions_id" id="permissions_id" required class="form-control c-select">
                            <option value="">- - {!! __('backend.selectPermissionsType') !!} - -</option>
                            @foreach ($Permissions as $Permission)
                                <option value="{{ $Permission->id }}">{{ $Permission->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @php
                    use App\Enums\UserType;
                @endphp
                <!-- Enum for user_type -->
                <div class="form-group row">
                    <label for="user_type" class="col-sm-2 form-control-label">User Type</label>
                    <div class="col-sm-10">
                        <select name="user_type" id="user_type" class="form-control c-select" required>
                            <option value="">- - Select User Type - -</option>
                            @foreach (UserType::cases() as $type)
                                <option value="{{ $type->value }}"
                                    {{ old('user_type') == $type->value ? 'selected' : '' }}>
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
                <div class="form-group row" id="company_id_section" style="display: none;">
                    <label for="company_id" class="col-sm-2 form-control-label">{!! __('backend.Company') !!}</label>
                    <div class="col-sm-10">
                        <select name="company_id" id="company_id" class="form-control c-select">
                            <option value="">- - {!! __('backend.selectCompanysType') !!} - -</option>
                            <?php
                            $title_var = 'name_' . @Helper::currentLanguage()->code;
                            $title_var2 = 'name_' . config('smartend.default_language');
                            ?>
                            @foreach ($companies as $companey)
                                <?php
                                if ($companey->$title_var != '') {
                                    $title = $companey->$title_var;
                                } else {
                                    $title = $companey->$title_var2;
                                }
                                ?>
                                <option value="{{ $companey->id }}">{!! $title !!}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row m-t-md">
                    <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary m-t"><i class="material-icons">&#xe31b;</i>
                            {!! __('backend.add') !!}</button>
                        <a href="{{ route('users') }}" class="btn btn-default m-t"><i class="material-icons">&#xe5cd;</i>
                            {!! __('backend.cancel') !!}</a>
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
