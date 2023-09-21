@extends('layouts.master')
@section('content')
@php
    global $post, $product;
        if ( is_woocommerce() ) {
        $product = wc_get_product($productPost->ID);
        $post = get_post($productPost->ID);
    }

@endphp

    @php do_action('woocommerce_before_single_product') @endphp
    <div class="main-article">
        <h1 class="title is-2">{{ $post->post_title }}</h1>
        <h5 class="subtitle is-5">
            <time class="timestamp">
                <small>{{ get_the_date(null, $post) }} {{ get_the_time(null, $post) }}</small>
            </time>
        </h5>

        <div class="columns">
            <div class="entry-images column is-6">
                @php do_action('woocommerce_before_single_product_summary') @endphp
            </div>

            <div class="column is-6">
                @php do_action('woocommerce_single_product_summary') @endphp
            </div>
        </div>

        @php do_action('woocommerce_after_single_product_summary') @endphp
        <meta itemprop="url" content="{{ $post->post_date }}" />
    </div>

    @php do_action('woocommerce_after_single_product') @endphp

@stop

