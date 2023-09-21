<article class="tease-product column is-4">

    <div class="media">

        @php
            global $post, $product;
                if ( is_woocommerce() ) {
                $product = wc_get_product($productPost->get_id());
                $post = get_post($productPost->get_id());
            }

        @endphp

        {{--
        <div class="media-figure {{ empty($product->get_image_id()) ? 'placeholder' : '' }}">
            <a href="{{ $product->get_permalink() }}">
                @if (!empty($product->get_image_id()))
                    <img src="{{ wp_get_attachment_image_src(  $product->get_image_id(), 'full' )[0] }}"/>
                @else
                    <span class="thumb-placeholder"><i class="icon-camera"></i></span>
                @endif
            </a>
        </div>
        --}}

        <div class="media-content">

            @php do_action('woocommerce_before_shop_loop_item_title') @endphp

            <h3 class="entry-title"><a href="{{ $product->get_permalink() }}">{{ $product->get_title() }}</a></h3>

            @php do_action('woocommerce_after_shop_loop_item_title') @endphp
            @php do_action('woocommerce_after_shop_loop_item') @endphp

        </div>

    </div>
</article>