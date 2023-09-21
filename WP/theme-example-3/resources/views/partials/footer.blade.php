<footer class="footer">
    <div class="footer--content {{ $container }}">
        <div class="row">
            <div class="col-lg-4 order-2 order-lg-0">
                @if(is_active_sidebar('footer_contact'))
                    @php(dynamic_sidebar('footer_contact'))
                @endif
            </div>

            <div class="col-lg-4 text-lg-center nav-primary order-0">
                @php(wp_nav_menu( array(
                    'theme_location' => 'footer_nav',
                    'fallback_cb'    => false, // Do not fall back to wp_page_menu()
                    'container_class' => 'footer-nav'
                ) ))
            </div>

            <div class="col-lg-4 text-lg-right order-1 children-gutter-y">
                <div>
                    <p>{{ get_translated_option('theme_theme_social_heading') }}</p>
                    @include('partials.social-icons')
                </div>
            </div>

            <section class="col-lg-12 order-3 children-gutter-y mt-lg-4">
                <div class="row">
                    <div class="col-lg-6 flex">
                        <a class="aplus-logo" href="{{ get_translated_option('theme_theme_aplus_link') ?: '#' }}" target="_blank">
                            {!! include_uploaded_svg(get_translated_option('theme_theme_aplus_logo')) !!}
                        </a>
                    </div>
                    <div class="col-lg-6 text-lg-right">
                        @php(wp_nav_menu( array(
                            'theme_location' => 'footer_subnav',
                            'fallback_cb'    => false, // Do not fall back to wp_page_menu()
                            'container_class' => 'footer-subnav'
                        )))
                    </div>
                </div>
            </section>
        </div>
    </div>
</footer>
