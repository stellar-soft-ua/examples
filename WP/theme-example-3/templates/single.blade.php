@extends('template::index')

@section('before_content')
    <div class="{{ $container }} mb-5">
        <div class="row">
            <div class="col-md-{{ has_post_thumbnail($post) ? '6' : '11' }}">
                @if(!boolval(rwmb_meta('hide_title')))
                    @if(isset($term))
                        <h1 style="color: {{ carbon_get_term_meta($term->term_id ?? 0, 'theme_color_primary') }};">{{ the_title() }}</h1>
                    @else
                        <h1>{{ the_title() }}</h1>
                    @endif

                    @if($tagline = get_post_meta($post->ID, '_tagline', true))
                        <h2 class="h1">{{ $tagline }}</h2>
                    @endif
                @else
                    @if($tagline = get_post_meta($post->ID, '_tagline', true))
                        <h1>{{ $tagline }}</h1>
                    @endif
                @endif
            </div>
            @if(has_post_thumbnail($post))
                <div class="col-md-6">
                    @include('partials.assets.image', [
                        'id' => get_post_thumbnail_id($post),
                        'width' => 1000,
                        'ratio' => '3:2',
                        'sizes' => [
                            500 => 450,
                            750 => 694,
                            1000 => 935
                        ]
                    ])
                </div>
            @endif
        </div>
    </div>
@endsection

@section('after_content')
    @if(is_array($sections) && count($sections) > 0)
        <div class="{{ $container }} connect{{ in_array($post->post_type, ['page','post']) ? ' mb-5' : '' }}">
            @include('partials.sections.container', ['sections' => $sections])
        </div>
    @endif

    @if(in_array($post->post_type, ['project', 'event', 'zenodo_deposit']))
        <div class="{{ $container }} connect">
            <hr class="mt-0">
            <div class="row pb-big">
                <div class="col-md-6 col-lg-5 offset-lg-1">
                    @if($footer)
                        {!! wpautop($footer) !!}
                    @endif
                </div>
                <div class="col-md-6 col-lg-5 text-right mt-md-0 mt-xl">
                    @include('partials.social-share', [
                        'permalink' => get_the_permalink()
                    ])
                </div>
            </div>
        </div>

        @if(count($related_posts) > 0)
            <div class="{{ $container }} connect-top pt-xxl pb-xxl">
                <div class="row">
                    <div class="col-xl-12 offset-xl-0 col-lg-10 offset-lg-1 col-md-12 offset-md-0">
                        @include('partials.projects-grid', ['projects' => $related_posts])
                    </div>
                </div>
            </div>
        @endif
    @endif
@endsection
