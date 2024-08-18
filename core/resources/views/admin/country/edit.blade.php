@extends('dashboard.layouts.master')
@section('title', __('backend.editCountry'))
@section('content')
    <div class="padding">
        <div class="box m-b-0">
            <div class="box-header dker">
                <h3><i class="material-icons">&#xe3c9;</i> {{ __('backend.editCountry') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                    {{ __('backend.webmasterTools') }} /
                    <a href="">{{ __('backend.siteSectionsSettings') }}</a>
                </small>
            </div>
            <div class="box-tool">
                <ul class="nav">
                    <li class="nav-item inline">
                        <a class="nav-link" href="{{ route('country.index') }}">
                            <i class="material-icons md-18">×</i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <?php
        $tab_1 = 'active';

        if (Session::has('activeTab')) {
            if (Session::get('activeTab') == 'fields') {
                $tab_1 = '';
            }
            if (Session::get('activeTab') == 'seo') {
                $tab_1 = '';
            }
        }
        ?>
        <div class="box nav-active-border b-info">
            <ul class="nav nav-md">
                <li class="nav-item inline">
                    <a class="nav-link {{ $tab_1 }}" data-toggle="tab" data-target="#tab_details">
                        <span class="text-md"><i class="material-icons">
                                &#xe31e;</i> {{ __('backend.topicTabSection') }}</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content clear b-t">
                <div class="tab-pane  {{ $tab_1 }}" id="tab_details">
                    <div class="box-body">
                        {{ Form::open(['route' => ['country.Update', $country->id], 'method' => 'POST', 'files' => true]) }}
                        @foreach (Helper::languagesList() as $ActiveLanguage)
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label">
                                    {!! __('backend.countryName') !!} {!! @Helper::languageName($ActiveLanguage) !!}
                                </label>
                                <div class="col-sm-10">
                                    {!! Form::text(
                                        'name_' . $ActiveLanguage->code,
                                        old('name_' . $ActiveLanguage->code, $country->{'name_' . $ActiveLanguage->code} ?? ''),
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
                            <label for="image" class="col-sm-2 form-control-label">{!! __('backend.flag') !!}</label>
                            <div class="col-sm-10">
                                {!! Form::file('image', [
                                    'class' => 'form-control dropify',
                                    'id' => 'image',
                                    'accept' => 'image/*',
                                    'data-default-file' => $country && $country->flag ? asset('uploads/topics/' . $country->flag) : '',
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
                            <label for="currency_id" class="col-sm-2 form-control-label">{!! __('backend.currency') !!} </label>
                            <div class="col-sm-10">
                                <select name="currency_id" id="currency_id" class="form-control c-select">
                                    <option value="0">- - {!! __('backend.currency') !!} - -</option>
                                    @foreach ($currency as $value)
                                        <option value="{{ $value->id }}"
                                            {{ $country->currency_id == $value->id ? 'selected' : '' }}>
                                            {{ $value->name }} - {{ $value->symbol }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row m-t-md">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary m-t"><i class="material-icons">
                                        &#xe31b;</i> {!! __('backend.update') !!}</button>
                                <a href="{{ route('currency.index') }}" class="btn btn-default m-t"><i
                                        class="material-icons">
                                        &#xe5cd;</i> {!! __('backend.cancel') !!}</a>
                            </div>
                        </div>

                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('after-scripts')
    <script type="text/javascript">
        $(".secs input[type='radio']").click(function() {
            $("label").removeClass("sec-active");
            if ($(this).is(":checked")) {
                $(this).parent().addClass("sec-active");
            }
        });
        $("#checkAll4").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        $("#action4").change(function() {
            if (this.value == "delete") {
                $("#submit_all4").css("display", "none");
                $("#submit_show_msg4").css("display", "inline-block");
            } else {
                $("#submit_all4").css("display", "inline-block");
                $("#submit_show_msg4").css("display", "none");
            }
        });
        $("input:radio[name=type]").click(function() {
            if ($(this).val() == 6 || $(this).val() == 7 || $(this).val() == 13) {
                $("#options").css("display", "inline");
                $(".in_statics_div").show();
            } else {
                $("#options").css("display", "none");
                $(".in_statics_div").hide();
            }
            $("#in_statics2").checked = true;
            if ($(this).val() == 8 || $(this).val() == 9 || $(this).val() == 10) {
                $("#default_val").css("display", "none");
            } else {
                $("#default_val").css("display", "block");
            }
        });
    </script>
@endpush
