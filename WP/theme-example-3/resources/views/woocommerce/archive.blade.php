@extends('layouts.master')
@section('content')
    @php do_action('woocommerce_before_main_content') @endphp

    <div class="before-shop-loop">
        @php do_action('woocommerce_before_shop_loop') @endphp
    </div>

    <div class="products columns is-multiline">
        @foreach ($products as $productPost)
            @include('woocommerce.tease-product')
        @endforeach
    </div>

    @php do_action('woocommerce_after_shop_loop') @endphp
    @php do_action('woocommerce_after_main_content') @endphp

@stop
