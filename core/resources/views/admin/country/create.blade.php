@extends('dashboard.layouts.master')
@section('title', __('backend.siteSectionsSettings'))
@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3><i class="material-icons">&#xe02e;</i> {{ __('backend.newCurrency') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                    {{ __('backend.currency') }} /
                    <a href="">{{ __('backend.newCurrency') }}</a>
                </small>
            </div>
            <div class="box-tool">
                <ul class="nav">
                    <li class="nav-item inline">
                        <a class="nav-link" href="{{ route('currency.index') }}">
                            <i class="material-icons md-18">×</i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="box-body">
                {{ Form::open(['route' => ['country.Store'], 'method' => 'POST', 'files' => true]) }}

                @foreach (Helper::languagesList() as $ActiveLanguage)
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">{!! __('backend.countryName') !!} {!! @Helper::languageName($ActiveLanguage) !!}
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
                    <label for="image" class="col-sm-2 form-control-label">{!! __('backend.flag') !!}</label>
                    <div class="col-sm-10">
                        {!! Form::file('image', ['class' => 'form-control dropify', 'id' => 'image', 'accept' => 'image/*']) !!}
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
                                <option value="{{ $value->id }}">{{ $value->name }} - {{ $value->symbol }}</option>
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
