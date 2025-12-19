@extends('layouts.app')

@section('title', 'Hotelux - Home')

@section('content')
    @include('landing-page.hero')
    @include('landing-page.about')
    @include('landing-page.rooms')
    @include('landing-page.facilities')
    @include('landing-page.promotions')
    @include('landing-page.testimonials')
    @include('landing-page.booking')
@endsection
