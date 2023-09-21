@extends('layouts.html')

@section('body')
    @include('partials.header')
    @include('partials.breadcrumb')

    @yield('content')

    @include('partials.footer')
    @include('partials.modals.search')
    @include('partials.modals.modal')
@endsection
