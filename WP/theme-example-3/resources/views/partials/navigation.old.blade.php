<header>
    <div class="container">
    
        <div class="row">
            <div class="col-sm-12">
                <a href="#thememmenu" class="mobilemenutoggler"><i class="material-icons hamburgeropen">&#xE5D2;</i><i class="material-icons hamburgerclose">&#xE5CD;</i></a>
                <a class="logo-link" href="<?php echo get_home_url(); ?>">
                    LOGO
                </a>
            </div>
        </div>

        @if(function_exists('icl_get_languages'))
            <?php $languages = icl_get_languages('skip_missing=0'); ?>
            @if(! empty($languages))
                <div class="language__switcher desktop">
                    <ul>
                        @foreach($languages as $language)
                            @if ($language['code'] === ICL_LANGUAGE_CODE)
                                <li class="active language-switcher-{{ $language['code'] }}">
                                    <a href="{{ $language['url'] }}">{{ icl_disp_language($language['translated_name']) }}</a>
                                </li>
                            @endif
                        @endforeach
                        @foreach($languages as $language)
                            @if ($language['code'] !== ICL_LANGUAGE_CODE)
                                <li class="active language-switcher-{{ $language['code'] }}">
                                    <a href="{{ $language['url'] }}">{{ icl_disp_language($language['translated_name']) }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif
        @endif
        


        @if(get_option( 'menu_frontend_framework' ) == 'bootstrap')
            @include('partials.navigation.bootstrap')
            
        @elseif(get_option( 'menu_frontend_framework' ) == 'materialize')
            @include('partials.navigation.materialize')
            
        @elseif(get_option( 'menu_frontend_framework' ) == 'clean')
            @include('partials.navigation.clean')

        @endif


        <div class="main-navigation__search">
            <svg width="22" height="22" viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg"><g fill="#FFF" fill-rule="nonzero"><path d="M10.44 19.94a9.5 9.5 0 1 1 0-19 9.5 9.5 0 0 1 0 19zm0-2.1a7.39 7.39 0 1 0 0-14.78 7.39 7.39 0 0 0 0 14.77z"/><path d="M21.75 20.25a1.06 1.06 0 1 1-1.5 1.5l-4.59-4.6a1.06 1.06 0 0 1 1.5-1.49l4.59 4.6z"/></g></svg>
            <div class="main-navigation__search__field">
                <form class="search-form" role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
                    <div class="main-navigation__search__name">
                        <?php echo esc_html__('Search', 'theme'); ?>
                    </div>
                    <div class="main-navigation__search__input">
                        <input name="s" id="s" type="search" value="<?php the_search_query(); ?>" placeholder="<?php echo esc_html__('Suchbegriff...', 'theme'); ?>" required>
                        <button type="submit" id="searchsubmit" class="animated zoomIn" value="" />
                        <svg width="22" height="22" viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg"><g fill="#1D1D1B" fill-rule="nonzero"><path d="M11 22a11 11 0 1 1 0-22 11 11 0 0 1 0 22zm0-2a9 9 0 1 0 0-18 9 9 0 0 0 0 18z"/><path d="M10.3 7.7a1 1 0 1 1 1.4-1.4l4 4a1 1 0 0 1 0 1.4l-4 4a1 1 0 1 1-1.4-1.4l3.29-3.3-3.3-3.3z"/><path d="M7 12a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2H7z"/></g></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>


    </div>
</header>