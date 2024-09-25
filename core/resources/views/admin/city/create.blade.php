@extends('dashboard.layouts.master')
@section('title', __('backend.siteSectionsSettings'))
@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3><i class="material-icons">&#xe02e;</i> {{ __('backend.newCity') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                    {{ __('backend.city') }} /
                    <a href="">{{ __('backend.newCity') }}</a>
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
            <div class="box-body">
                {{ Form::open(['route' => ['city.Store'], 'method' => 'POST', 'files' => true]) }}

                @foreach (Helper::languagesList() as $ActiveLanguage)
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">{!! __('backend.cityName') !!} {!! @Helper::languageName($ActiveLanguage) !!}
                        </label>
                        <div class="col-sm-10">
                            {!! Form::text('title_' . @$ActiveLanguage->code, '', [
                                'placeholder' => '',
                                'class' => 'form-control',
                                'required' => '',
                                'dir' => @$ActiveLanguage->direction,
                            ]) !!}
                        </div>
                    </div>
                @endforeach


                <div class="form-group row m-t-md" style="margin-top: 0 !important;">
                    <div class="offset-sm-2 col-sm-10">
                        <small>
                            <i class="material-icons">&#xe8fd;</i>
                            {!! __('backend.imagesTypes') !!}
                        </small>
                    </div>
                </div>

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
                                <option value="{{ $value->id }}">{{ $title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
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
    <script type="text/javascript">
        $(".secs input[type='radio']").click(function() {
            $("label").removeClass("sec-active");
            if ($(this).is(":checked")) {
                $(this).parent().addClass("sec-active");
            }
        });
    </script>
@endpush
