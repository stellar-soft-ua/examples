<header>
    <!-- Fixed navbar -->
    <nav class="navbar fixed-top navbar-light navbar-expand-md align-items-start">
        <div class="{{ $container }} align-items-center align-items-md-start">
            <a class="navbar-brand" href="<?php echo get_home_url(); ?>">
                @if($logoId = get_theme_mod('custom_logo'))
                    <img class="logo" src="{{ esc_url( wp_get_attachment_image_url($logoId) ) }}" alt="{{ bloginfo('title')  }} Logo">
                @else
                    {{ bloginfo('title')  }}
                @endif
            </a>

            <button class="menu-button collapsed"
                    type="button"
                    data-toggle="collapse"
                    data-target="#navbarCollapse"
                    aria-controls="navbarCollapse"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="bar top"></span>
                <span class="bar middle"></span>
                <span class="bar bottom"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="mobile-spacer"></div>
                @include('partials.navigation.bootstrap')

                @include('template::sidebars.navigation-right')

                @php(wp_nav_menu( array(
                        'theme_location' => 'footer_nav',
                        'fallback_cb'    => false, // Do not fall back to wp_page_menu()
                        'menu_class' => 'd-md-none menu-mobile-nav navbar-nav menu-items',
                        'container' => 'ul'
                    )))
            </div>
        </div>
    </nav>
</header>
