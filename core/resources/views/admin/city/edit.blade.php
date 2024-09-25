@extends('dashboard.layouts.master')
@section('title', __('backend.editCity'))
@section('content')
    <div class="padding">
        <div class="box m-b-0">
            <div class="box-header dker">
                <h3><i class="material-icons">&#xe3c9;</i> {{ __('backend.editCity') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                    {{ __('backend.webmasterTools') }} /
                    <a href="">{{ __('backend.siteSectionsSettings') }}</a>
                </small>
            </div>
            <div class="box-tool">
                <ul class="nav">
                    <li class="nav-item inline">
                        <a class="nav-link" href="{{ route('city.index') }}">
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
                        {{ Form::open(['route' => ['city.Update', $city->id], 'method' => 'POST', 'files' => true]) }}
                        @foreach (Helper::languagesList() as $ActiveLanguage)
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label">
                                    {!! __('backend.cityName') !!} {!! @Helper::languageName($ActiveLanguage) !!}
                                </label>
                                <div class="col-sm-10">
                                    {!! Form::text(
                                        'title_' . $ActiveLanguage->code,
                                        old('title_' . $ActiveLanguage->code, $city->{'title_' . $ActiveLanguage->code} ?? ''),
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
                            <label for="country_id" class="col-sm-2 form-control-label">{!! __('backend.country') !!} </label>
                            <div class="col-sm-10">
                                <select name="country_id" id="country_id" class="form-control c-select">
                                    <option value="0">- - {!! __('backend.country') !!} - -</option>
                                    <?php
                                    $title_var = 'name_' . @Helper::currentLanguage()->code;
                                    $title_var2 = 'name_' . config('smartend.default_language');
                                    ?>
                                    @foreach ($country as $value)
                                        <?php
                                        if ($value->$title_var != '') {
                                            $title = $value->$title_var;
                                        } else {
                                            $title = $value->$title_var2;
                                        }
                                        ?>
                                        <option value="{{ $value->id }}"
                                            {{ $city->country_id == $value->id ? 'selected' : '' }}>
                                            {{ $title }}
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
