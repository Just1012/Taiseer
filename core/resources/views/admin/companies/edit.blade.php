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
                {{ Form::open(['route' => ['company.Update', $company->id], 'method' => 'POST', 'files' => true]) }}

                @foreach (Helper::languagesList() as $ActiveLanguage)
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">{!! __('backend.companyName') !!} {!! @Helper::languageName($ActiveLanguage) !!}
                        </label>
                        <div class="col-sm-10">
                            {!! Form::text(
                                'name_' . @$ActiveLanguage->code,
                                old('name_' . @$ActiveLanguage->code, $company->{'name_' . @$ActiveLanguage->code}),
                                [
                                    'placeholder' => '',
                                    'class' => 'form-control',
                                    'required' => '',
                                    'dir' => @$ActiveLanguage->direction,
                                ],
                            ) !!}
                        </div>
                    </div>
                @endforeach

                <div class="form-group row">
                    <label class="col-sm-2 form-control-label">{!! __('backend.email') !!}
                    </label>
                    <div class="col-sm-10">
                        {!! Form::email('email', old('email', $company->email), [
                            'placeholder' => '',
                            'class' => 'form-control',
                            'required' => 'required',
                        ]) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 form-control-label">{!! __('backend.phone') !!}</label>
                    <div class="col-sm-2">
                        {!! Form::number('code', old('code', $company->code), [
                            'placeholder' => __('backend.key'), // Add translation for phone code
                            'class' => 'form-control',
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="col-sm-8">
                        {!! Form::number('phone', old('phone', $company->phone), [
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
                        {!! Form::number('BL', old('BL', $company->BL), [
                            'placeholder' => '',
                            'class' => 'form-control',
                            'required' => 'required',
                        ]) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="BL_image" class="col-sm-2 form-control-label">{!! __('backend.flag') !!}</label>
                    <div class="col-sm-10">
                        {!! Form::file('BL_image', [
                            'class' => 'form-control dropify',
                            'id' => 'BL_image',
                            'accept' => 'image/*',
                            'data-default-file' => $company && $company->BL_image ? asset('uploads/companies/' . $company->BL_image) : '',
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
                    <label for="id_front_image" class="col-sm-2 form-control-label">{!! __('backend.flag') !!}</label>
                    <div class="col-sm-10">
                        {!! Form::file('id_front_image', [
                            'class' => 'form-control dropify',
                            'id' => 'id_front_image',
                            'accept' => 'image/*',
                            'data-default-file' =>
                                $company && $company->id_front_image ? asset('uploads/companies/' . $company->id_front_image) : '',
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
                            {!! Form::textarea(
                                'about_' . @$ActiveLanguage->code,
                                old('about_' . @$ActiveLanguage->code, $company->{'about_' . @$ActiveLanguage->code}),
                                [
                                    'placeholder' => '',
                                    'class' => 'form-control',
                                    'required' => '',
                                    'dir' => @$ActiveLanguage->direction,
                                ],
                            ) !!}
                        </div>
                    </div>
                @endforeach

                <div class="form-group row">
                    <label for="logo" class="col-sm-2 form-control-label">{!! __('backend.flag') !!}</label>
                    <div class="col-sm-10">
                        {!! Form::file('logo', [
                            'class' => 'form-control dropify',
                            'id' => 'logo',
                            'accept' => 'image/*',
                            'data-default-file' => $company && $company->logo ? asset('uploads/companies/' . $company->logo) : '',
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
                    <label for="cover" class="col-sm-2 form-control-label">{!! __('backend.flag') !!}</label>
                    <div class="col-sm-10">
                        {!! Form::file('cover', [
                            'class' => 'form-control dropify',
                            'id' => 'cover',
                            'accept' => 'image/*',
                            'data-default-file' => $company && $company->cover ? asset('uploads/companies/' . $company->cover) : '',
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
                            <option value="0">- - {!! __('backend.country') !!} - -</option>
                            @foreach ($country as $value)
                                <?php
                                $title_var = 'name_' . @Helper::currentLanguage()->code;
                                $title_var2 = 'name_' . config('smartend.default_language');
                                $typeName = $value->$title_var != '' ? $value->$title_var : $value->$title_var2;
                                ?>
                                <option value="{{ $value->id }}"
                                    {{ $countries->contains('country_id', $value->id) ? 'selected' : '' }}>
                                    {{ $typeName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select name="city_id[]" id="city_id" class="form-control select2" multiple>
                            <option value="0">- - {!! __('backend.city') !!} - -</option>
                            @foreach ($city as $value)
                                <?php
                                $title_var = 'title_' . @Helper::currentLanguage()->code;
                                $title_var2 = 'title_' . config('smartend.default_language');
                                $typeName = $value->$title_var != '' ? $value->$title_var : $value->$title_var2;
                                ?>
                                <option value="{{ $value->id }}"
                                    {{ $cities->contains('city_id', $value->id) ? 'selected' : '' }}>
                                    {{ $typeName }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-3">
                        <select name="typeActivity_id[]" id="typeActivity_id" class="form-control select2" multiple>
                            <option value="0">- - {!! __('backend.type') !!} - -</option>
                            @foreach ($typeActivity as $value)
                                <?php
                                $title_var = 'name_' . @Helper::currentLanguage()->code;
                                $title_var2 = 'name_' . config('smartend.default_language');
                                $info_var = 'info_' . @Helper::currentLanguage()->code;
                                $info_var2 = 'info_' . config('smartend.default_language');
                                $typeName = $value->$title_var != '' ? $value->$title_var : $value->$title_var2;
                                $infoName = $value->$info_var != '' ? $value->$info_var : $value->$info_var2;
                                ?>
                                <option value="{{ $value->id }}" data-name-ar="{{ $value->name_ar }}"
                                    data-name-en="{{ $value->name_en }}" data-info-ar="{{ $value->info_ar }}"
                                    data-info-en="{{ $value->info_en }} "
                                    {{ $type->contains('type_activity_id', $value->id) ? 'selected' : '' }}>
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
            var selectedCountries = $(select).val(); // Get array of selected country IDs

            var citiesContainer = $('#city_id');
            var citiesUrl = "{{ route('getCities', ['ids' => ':countryIds']) }}";

            // Clear the city dropdown when the country is changed
            citiesContainer.empty();
            citiesContainer.append('<option value=""></option>');

            // If no country is selected, exit the function
            if (!selectedCountries || selectedCountries.length === 0) {
                return;
            }

            // Replace :countryIds with the actual array of selected country IDs
            var countryIds = selectedCountries.join(','); // Join the array into a string
            citiesUrl = citiesUrl.replace(':countryIds', countryIds);

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
    <script>
        $(document).ready(function() {
            // Initialize select2
            $('#country_id').select2({
                placeholder: '- - {!! __('backend.country') !!} - -',
                allowClear: true,
                width: '100%'
            });
            $('#city_id').select2({
                placeholder: '- - {!! __('backend.city') !!} - -',
                allowClear: true,
                width: '100%'
            });
            // Initialize select2
            $('#typeActivity_id').select2({
                placeholder: '- - {!! __('backend.type') !!} - -',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
    {{-- Type activision & the info textarea handling --}}
    <script>
        $(document).ready(function() {
            var currentLocale = "{{ app()->getLocale() }}"; // Fetch current locale

            // Initialize dynamic text areas with existing values
            function initializeTextAreas() {
                var textAreasHtml = '';
                @foreach (Helper::languagesList() as $ActiveLanguage)
                    var typeActivityCompanies = @json($company->typeActivityCompanies); // Fetch typeActivityCompanies
                    var languageName = {!! json_encode(Helper::languageName($ActiveLanguage)) !!}; // Language name
                    var languageCode = '{{ $ActiveLanguage->code }}'; // Language code
                    var direction = '{{ $ActiveLanguage->direction }}'; // Text direction

                    // Loop through each typeActivityCompany to generate the text areas
                    typeActivityCompanies.forEach(function(activity) {
                        var infoKey = 'info_' + languageCode; // Dynamically select info field
                        var value = sanitizeText(activity[infoKey] ||
                            ''); // Sanitize and get value or set default to empty

                        textAreasHtml += `
                <div class="form-group row" id="typeActivity-textarea-${activity.type_activity_id}">
                    <label class="col-sm-2 form-control-label">{{ __('backend.info') }} for ${languageName}</label>
                    <div class="col-sm-10">
                        <textarea name="info_${languageCode}[]" class="form-control" dir="${direction}" placeholder="Enter details for ${languageName}">${value}</textarea>
                    </div>
                </div>
                `;
                    });
                @endforeach
                // Append generated HTML to the dynamic-textareas div
                $('#dynamic-textareas').html(textAreasHtml);
            }

            // Sanitize any potential HTML content and return plain text
            function sanitizeText(text) {
                var div = document.createElement('div');
                div.innerHTML = text;
                return div.textContent || div.innerText || "";
            }

            // Call initialize function on page load
            initializeTextAreas();

            // Function to generate text areas based on selected types without removing any
            function generateTextAreas(selectedTypes) {
                $('#dynamic-textareas').empty();
                selectedTypes.forEach(function(typeId) {
                    var selectedOption = $('#typeActivity_id option[value="' + typeId + '"]');
                    var typeName = currentLocale === 'ar' ? sanitizeText(selectedOption.data('name-ar')) :
                        sanitizeText(selectedOption.data('name-en'));

                    if (!typeName) {
                        console.error(`Type name not found for typeId: ${typeId}`);
                        return; // Skip if no type name is found
                    }

                    var typeActivityCompanies = @json($company->typeActivityCompanies);



                    var textAreasHtml = '';

                    @foreach (Helper::languagesList() as $ActiveLanguage)
                        var languageCode = '{{ $ActiveLanguage->code }}'; // Language code
                        var direction = '{{ $ActiveLanguage->direction }}'; // Text direction
                        var languageName = {!! json_encode(Helper::languageName($ActiveLanguage)) !!}; // Language name

                        var langCode = languageCode === 'ar' ? 'info_ar' : 'info_en';
                        var typeInfo = sanitizeText(selectedOption.data(
                            langCode)); // Sanitize type info based on the language

                        var placeholder = sanitizeText(typeActivityCompanies.find(e => e[
                                'type_activity_id'] == typeId) ?
                            typeActivityCompanies.find(e => e['type_activity_id'] == typeId)[
                                "placeholder_" + languageCode] : '');
                        var value = sanitizeText(typeActivityCompanies.find(e => e['type_activity_id'] ==
                                typeId) ?
                            typeActivityCompanies.find(e => e['type_activity_id'] == typeId)[langCode] :
                            '');

                        // Append new textarea to HTML structure, keeping track of typeActivity ID
                        textAreasHtml += `
                    <div class="form-group row" id="typeActivity-textarea-${typeId}">
                        <label class="col-sm-2 form-control-label">{{ __('backend.info') }} for ${typeName} in ${languageName}</label>
                        <div class="col-sm-10">
                            <textarea name="info_${languageCode}[]" class="form-control" dir="${direction}" data-type-id="${typeId}" placeholder="${placeholder}">${value}</textarea>
                        </div>
                    </div>
                `;
                    @endforeach

                    // Append the new text area content
                    $('#dynamic-textareas').append(textAreasHtml);
                });
            }

            // Initial generation of text areas based on selected types on page load
            var initialSelectedTypes = $('#typeActivity_id').val();
            generateTextAreas(initialSelectedTypes);

            // Listen for changes in the typeActivity dropdown
            $('#typeActivity_id').on('change', function() {
                var selectedTypes = $(this).val();
                generateTextAreas(selectedTypes);
            });
        });
    </script>
@endpush
