@extends('frontEnd.layouts.master')

@section('content')
    <div>
        <section class="breadcrumbs">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>{{ $PageTitle }}</h2>
                    <ol>
                        <li><a href="{{ Helper::homeURL() }}">{{ __("backend.home") }}</a></li>
                        <li class="active">{{ $PageTitle }}</li>
                    </ol>
                </div>
            </div>
        </section>
        <section id="content">
            <div class="container">

                {{-- page content --}}
                <h1>{{ $PageTitle }}</h1>
                <p>You custom code here</p>

            </div>
        </section>
    </div>
@endsection
@section('footInclude')
    {{-- add you custom js code here --}}
@endsection
@push('before-styles')
    {{-- add your custom css links here --}}
@endpush
@push('after-scripts')
    {{-- add your custom js links here--}}
@endpush
