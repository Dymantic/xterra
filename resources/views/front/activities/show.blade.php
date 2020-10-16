@extends('front.base')

@section('content')
    @include('front.activities.banner')
    @include('front.activities.activity-nav')
    @include('front.activities.courses')
    @include('front.activities.schedule')
    @include('front.activities.prizes')
    @include('front.activities.fees')
    @include('front.activities.rules')
@endsection
