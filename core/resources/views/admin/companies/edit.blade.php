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
                    <div class="col-sm-5">
                        <select name="country_id[]" id="country_id" class="form-control select2" multiple>
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
                    <div class="col-sm-5">
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
        $(document).ready(function() {
            // Initialize select2
            $('#country_id').select2({
                placeholder: '- - {!! __('backend.country') !!} - -',
                allowClear: true,
                width: '100%'
            });
            // Initialize select2
            $('#typeActivity_id').select2({
                placeholder: '- - {!! __('backend.type') !!} - -',
                allowClear: true,
                width: '100%'
            });


            var currentLocale = "{{ app()->getLocale() }}";


            // Initialize dynamic text areas with old values
            function initializeTextAreas() {
                var textAreasHtml = '';
                @foreach (Helper::languagesList() as $ActiveLanguage)
                    // Retrieve the typeActivityCompanies for the current language
                    var typeActivityCompanies = @json($company->typeActivityCompanies);
                    var languageName = {!! json_encode(Helper::languageName($ActiveLanguage)) !!}; // Get the language name safely
                    var languageCode = '{{ $ActiveLanguage->code }}'; // Language code
                    var direction = '{{ $ActiveLanguage->direction }}'; // Text direction

                    // Construct text areas for each type activity company
                    typeActivityCompanies.forEach(function(activity) {
                        var infoKey = 'info_' +
                            languageCode; // Construct the key for info based on language code
                        var value = activity[infoKey] ||
                            ''; // Fetch the value for this language if available, or default to empty

                        textAreasHtml += `
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">{{ __('backend.info') }} for ${languageName}</label>
                        <div class="col-sm-10">
                            <textarea name="info_${languageCode}[]" class="form-control" dir="${direction}" placeholder="Enter details for ${languageName}">${value}</textarea>
                        </div>
                    </div>
                `;
                    });
                @endforeach

                // Insert generated HTML into the DOM
                $('#dynamic-textareas').html(textAreasHtml);
            }




            // Call initialize function on page load
            initializeTextAreas();

            $(document).ready(function() {

                var currentLocale = $('html').attr('lang'); // Get the current locale from the HTML tag

                // Function to generate text areas based on selected types
                function generateTextAreas(selectedTypes) {
                    // Clear previous text areas
                    $('#dynamic-textareas').empty();

                    // If types are selected, generate the text areas
                    if (selectedTypes && selectedTypes.length > 0) {

                        var textAreasHtml = '';
                        let a7aa = 0;

                        selectedTypes.forEach(function(typeId) {

                            // Find the selected option's text (name of the type) based on current locale
                            var selectedOption = $('#typeActivity_id option[value="' + typeId +
                                '"]');
                            var typeName = currentLocale === 'ar' ? selectedOption.data('name-ar') :
                                selectedOption.data('name-en');

                            if (!typeName) {
                                console.error(`Type name not found for typeId: ${typeId}`);
                                return; // Skip if type name is not found
                            }

                            var typeActivityCompanies = @json($company->typeActivityCompanies);
                            console.log(typeActivityCompanies);


                            @foreach (Helper::languagesList() as $ActiveLanguage)
                                var languageCode = '{{ $ActiveLanguage->code }}'; // Language code
                                var direction =
                                    '{{ $ActiveLanguage->direction }}'; // Text direction
                                var languageName =
                                    {!! json_encode(Helper::languageName($ActiveLanguage)) !!}; // Get the language name safely

                                var langCode = languageCode === 'ar' ? 'info_ar' : 'info_en';
                                var typeInfo = selectedOption.data(
                                    langCode); // Get the info based on the language

                                if (!typeInfo) {
                                    console.warn(
                                        `Type info not found for typeId: ${typeId}, langCode: ${langCode}`
                                    );
                                }

                                // Generate the HTML structure for the text areas with the type name
                                textAreasHtml += `
                <div class="form-group row">
                    <label class="col-sm-2 form-control-label">{{ __('backend.info') }} for ${typeName} in ${languageName}</label>
                    <div class="col-sm-10">
<textarea name="info_{{ $ActiveLanguage->code }}[]" class="form-control" dir="${direction}" placeholder="${
        typeActivityCompanies.find(e => e['type_activity_id'] == typeId)
        ? typeActivityCompanies.find(e => e['type_activity_id'] == typeId)["placeholder_" + languageCode]
        : ''
    }">${
        typeActivityCompanies.find(e => e['type_activity_id'] == typeId)[langCode] !=null
        ? typeActivityCompanies.find(e => e['type_activity_id'] == typeId)[langCode]
        : ''
    }</textarea></div>
                </div>
                `;
                            @endforeach

                            a7aa++;
                        });

                        // Append the generated text areas to the DOM once
                        $('#dynamic-textareas').html(textAreasHtml);
                    }
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


        });
    </script>
@endpush
