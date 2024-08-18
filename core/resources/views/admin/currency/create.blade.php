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
                {{ Form::open(['route' => ['currency.Store'], 'method' => 'POST', 'files' => true]) }}

                <div class="form-group row">
                    <label class="col-sm-2 form-control-label">{!! __('backend.currencyName') !!}
                    </label>
                    <div class="col-sm-10">
                        {!! Form::text('name', null, [
                            'placeholder' => '',
                            'class' => 'form-control',
                            'required' => 'required',
                        ]) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 form-control-label">{!! __('backend.currencySymbol') !!}
                    </label>
                    <div class="col-sm-10">
                        {!! Form::text('symbol', null, [
                            'placeholder' => '',
                            'class' => 'form-control',
                            'required' => 'required',
                        ]) !!}
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
