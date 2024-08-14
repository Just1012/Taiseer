<?php
$title_var = "title_" . @Helper::currentLanguage()->code;
$title_var2 = "title_" . config('smartend.default_language');

?>
@extends('dashboard.layouts.master')
@section('title','Test')
@section('content')

@endsection
