@extends('dashboard.layouts.master')
@section('title', __('backend.newCompanyCreate'))
@push('after-styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3><i class="material-icons">&#xe02e;</i> {{ __('backend.newCompany') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                    {{ __('backend.company') }} /
                    <a href="">{{ __('backend.newCompany') }}</a>
                </small>
            </div>
            <div class="box-tool">
                <ul class="nav">
                    <li class="nav-item inline">
                        <a class="nav-link" href="{{ route('company.index') }}">
                            <i class="material-icons md-18">×</i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="box-body">
                {{ Form::open(['route' => ['company.Store'], 'method' => 'POST', 'files' => true]) }}

                @foreach (Helper::languagesList() as $ActiveLanguage)
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">{!! __('backend.companyName') !!} {!! @Helper::languageName($ActiveLanguage) !!}
                        </label>
                        <div class="col-sm-10">
                            {!! Form::text('name_' . @$ActiveLanguage->code, '', [
                                'placeholder' => '',
                                'class' => 'form-control',
                                'required' => '',
                                'dir' => @$ActiveLanguage->direction,
                            ]) !!}
                        </div>
                    </div>
                @endforeach

                <div class="form-group row">
                    <label class="col-sm-2 form-control-label">{!! __('backend.email') !!}
                    </label>
                    <div class="col-sm-10">
                        {!! Form::email('email', null, [
                            'placeholder' => '',
                            'class' => 'form-control',
                            'required' => 'required',
                        ]) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 form-control-label">{!! __('backend.phone') !!}</label>
                    <div class="col-sm-2">
                        {!! Form::number('code', null, [
                            'placeholder' => __('backend.key'), // Add translation for phone code
                            'class' => 'form-control',
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="col-sm-8">
                        {!! Form::number('phone', null, [
                            'placeholder' => __('backend.phone_number'), // Add translation for phone number
                            'class' => 'form-control',
                            'required' => 'required',
                        ]) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 form-control-label">{!! __('backend.licenseNumber') !!}
                    </label>
                    <div class="col-sm-10">
                        {!! Form::number('BL', null, [
                            'placeholder' => '',
                            'class' => 'form-control',
                            'required' => 'required',
                        ]) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="BL_image" class="col-sm-2 form-control-label">{!! __('backend.licenseImage') !!}</label>
                    <div class="col-sm-10">
                        {!! Form::file('BL_image', ['class' => 'form-control dropify', 'id' => 'BL_image', 'accept' => 'image/*']) !!}
                    </div>
                </div>
                <div class="form-group row m-t-md" style="margin-top: 0 !important;">
                    <div class="offset-sm-2 col-sm-10">
                        <small>
                            <i class="material-icons">&#xe8fd;</i>
                            {!! __('backend.imagesTypes') !!}
                        </small>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="id_front_image" class="col-sm-2 form-control-label">{!! __('backend.idFrontImage') !!}</label>
                    <div class="col-sm-10">
                        {!! Form::file('id_front_image', [
                            'class' => 'form-control dropify',
                            'id' => 'id_front_image',
                            'accept' => 'image/*',
                        ]) !!}
                    </div>
                </div>
                <div class="form-group row m-t-md" style="margin-top: 0 !important;">
                    <div class="offset-sm-2 col-sm-10">
                        <small>
                            <i class="material-icons">&#xe8fd;</i>
                            {!! __('backend.imagesTypes') !!}
                        </small>
                    </div>
                </div>

                @foreach (Helper::languagesList() as $ActiveLanguage)
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">{!! __('backend.about') !!} {!! @Helper::languageName($ActiveLanguage) !!}
                        </label>
                        <div class="col-sm-10">
                            {!! Form::textarea('about_' . @$ActiveLanguage->code, '', [
                                'placeholder' => '',
                                'class' => 'form-control',
                                'required' => '',
                                'dir' => @$ActiveLanguage->direction,
                            ]) !!}
                        </div>
                    </div>
                @endforeach

                <div class="form-group row">
                    <label for="logo" class="col-sm-2 form-control-label">{!! __('backend.logo') !!}</label>
                    <div class="col-sm-10">
                        {!! Form::file('logo', [
                            'class' => 'form-control dropify',
                            'id' => 'logo',
                            'accept' => 'image/*',
                        ]) !!}
                    </div>
                </div>
                <div class="form-group row m-t-md" style="margin-top: 0 !important;">
                    <div class="offset-sm-2 col-sm-10">
                        <small>
                            <i class="material-icons">&#xe8fd;</i>
                            {!! __('backend.imagesTypes') !!}
                        </small>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="cover" class="col-sm-2 form-control-label">{!! __('backend.cover') !!}</label>
                    <div class="col-sm-10">
                        {!! Form::file('cover', [
                            'class' => 'form-control dropify',
                            'id' => 'cover',
                            'accept' => 'image/*',
                        ]) !!}
                    </div>
                </div>
                <div class="form-group row m-t-md" style="margin-top: 0 !important;">
                    <div class="offset-sm-2 col-sm-10">
                        <small>
                            <i class="material-icons">&#xe8fd;</i>
                            {!! __('backend.imagesTypes') !!}
                        </small>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-2 form-control-label"></label>
                    <div class="col-sm-3">
                        <select name="country_id[]" id="country_id" onchange="toggleInput()" class="form-control select2"
                            multiple>
                            @foreach ($country as $value)
                                <?php
                                $title_var = 'name_' . @Helper::currentLanguage()->code;
                                $title_var2 = 'name_' . config('smartend.default_language');
                                $typeName = $value->$title_var != '' ? $value->$title_var : $value->$title_var2;
                                ?>
                                <option value="{{ $value->id }}" data-name-ar="{{ $value->name_ar }}"
                                    data-name-en="{{ $value->name_en }}">
                                    {{ $typeName }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-3">
                        <select name="city_id[]" id="city_id" class="form-control select2" multiple>

                        </select>
                    </div>

                    <div class="col-sm-3">
                        <select name="typeActivity_id[]" id="typeActivity_id" class="form-control select2" multiple>
                            @foreach ($typeActivity as $type)
                                <?php
                                $title_var = 'name_' . @Helper::currentLanguage()->code;
                                $title_var2 = 'name_' . config('smartend.default_language');
                                $info_var = 'info_' . @Helper::currentLanguage()->code;
                                $info_var2 = 'info_' . config('smartend.default_language');
                                $typeName = $type->$info_var != '' ? $type->$info_var : $type->$info_var2;
                                $typeInfo = $type->$info_var != '' ? $type->$info_var : $type->$info_var2;
                                ?>
                                <option value="{{ $type->id }}" data-name-ar="{{ $type->name_ar }}"
                                    data-name-en="{{ $type->name_en }} " data-info-ar="{{ $type->info_ar }}"
                                    data-info-en="{{ $type->info_en }} ">
                                    {{ $typeName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Placeholder for dynamically generated text areas -->
                <div id="dynamic-textareas"></div>


                <hr />

                <div class="form-group row m-t-md">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary m-t"><i class="material-icons">
                                &#xe31b;</i> {!! __('backend.add') !!}</button>
                        <a href="{{ route('WebmasterSections') }}" class="btn btn-default m-t"><i class="material-icons">
                                &#xe5cd;</i> {!! __('backend.cancel') !!}</a>
                    </div>
                </div>

                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        function toggleInput() {
            var select = document.getElementById("country_id");
            var countryId = select.value;

            var citiesContainer = $('#city_id');
            var citiesUrl = "{{ route('getCities', ['id' => ':countryId']) }}";

            // Clear the city dropdown when the country is changed
            citiesContainer.empty();
            citiesContainer.append('<option value="" ></option>');

            // If no country is selected, exit the function
            if (!countryId) {
                return;
            }

            // Replace :countryId with the actual country ID
            citiesUrl = citiesUrl.replace(':countryId', countryId);

            $.ajax({
                url: citiesUrl,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // If there are cities returned, populate the city dropdown
                    if (data && data.length > 0) {
                        var citiesSelect = '<option value=""></option>';

                        $.each(data, function(index, city) {
                            // Use the appropriate language based on the current locale
                            var cityName = "{{ App::getLocale() }}" === "ar" ? city.title_ar : city
                                .title_en;

                            citiesSelect += '<option value="' + city.id + '">' + cityName + '</option>';
                        });

                        citiesContainer.append(citiesSelect);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching cities:', error);
                }
            });
        }
    </script>
    <script type="text/javascript">
        $(".secs input[type='radio']").click(function() {
            $("label").removeClass("sec-active");
            if ($(this).is(":checked")) {
                $(this).parent().addClass("sec-active");
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#country_id').select2({
                placeholder: '- - {!! __('backend.country') !!} - -',
                allowClear: true,
                width: '100%' // Adjusts width within the form control
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#city_id').select2({
                placeholder: '- - {!! __('backend.city') !!} - -',
                allowClear: true,
                width: '100%' // Adjusts width within the form control
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#typeActivity_id').select2({
                placeholder: '- - {!! __('backend.type') !!} - -',
                allowClear: true,
                width: '100%' // Adjusts width within the form control
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Initialize select2
            $('#typeActivity_id').select2({
                placeholder: '- - {!! __('backend.type') !!} - -',
                allowClear: true,
                width: '100%'
            });

            // Get the current application locale (Arabic or English)
            var currentLocale = "{{ app()->getLocale() }}"; // Assuming 'ar' for Arabic and 'en' for English

            // Listen for changes in the typeActivity dropdown
            $('#typeActivity_id').on('change', function() {
                // Get selected values
                var selectedTypes = $(this).val();

                // Clear previous text areas
                $('#dynamic-textareas').empty();

                // If a type is selected, generate the text areas
                if (selectedTypes && selectedTypes.length > 0) {
                    selectedTypes.forEach(function(typeId) {

                        // Find the selected option's text (name of the type) based on current locale
                        var typeName = currentLocale === 'ar' ?
                            $('#typeActivity_id option[value="' + typeId + '"]').data(
                                'name-ar') // Arabic name
                            :
                            $('#typeActivity_id option[value="' + typeId + '"]').data(
                                'name-en');
                        // English name


                        // Loop through each language
                        @foreach (Helper::languagesList() as $ActiveLanguage)
                            var langCode = '{{ $ActiveLanguage->code }}';
                            var typeInfo = langCode === 'ar' ?
                                $('#typeActivity_id option[value="' + typeId + '"]').data(
                                    'info-ar') // Arabic info
                                :
                                $('#typeActivity_id option[value="' + typeId + '"]').data(
                                    'info-en'); // English info


                            var textarea = `
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">{{ __('backend.info') }} for ${typeName} in {!! @Helper::languageName($ActiveLanguage) !!}</label>
                            <div class="col-sm-10">
                                <textarea name="info_{{ @$ActiveLanguage->code }}[]" class="form-control" dir="{{ @$ActiveLanguage->direction }}" placeholder="${typeInfo}"></textarea>
                            </div>
                        </div>
                    `;
                            // Append to the dynamic text area container
                            $('#dynamic-textareas').append(textarea);
                        @endforeach
                    });
                }
            });
        });
    </script>
@endpush
