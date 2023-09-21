@extends('layouts.master')

@section('content')
    <main role="main" class="container">
        <div class="page-header">
            <h1 class="page-title">
                {{ $title }}
            </h1>
        </div>
        @wpposts
        <div class="page">
            {{ the_content() }}
        </div>
        @wpend
    </main>
@endsection
