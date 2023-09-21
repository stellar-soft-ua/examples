@extends('layouts.master')

@section('content')
    <main role="main">
        @wpposts
        <article class="template--content">
            @hasSection('before_content')
                @yield('before_content')
            @else
                @if($include_title)
                    <div class="{{ $container }}">
                        <h1 class="mb-5">{{ the_title() }}</h1>
                    </div>
                @endif
            @endif

            <div class="{{ $container }} connect the-content mb-5">
                @if($is_using_divi)
                    {{ the_content() }}
                @else
                    <div class="row">
                        <div class="{{ $columns }}">
                            {{ the_content() }}
                        </div>
                    </div>
                @endif
            </div>

            @yield('after_content')
        </article>
        @wpend
    </main>
@endsection
