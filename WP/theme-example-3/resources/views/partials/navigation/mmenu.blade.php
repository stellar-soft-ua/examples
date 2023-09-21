<nav class="mobile nav" id="thememmenu">
    <ul>
        @wpmenu('header-menu')
        @if(isset($menuItem->theme_children) && count($menuItem->theme_children) > 0)
            {{-- Setze Hauptmenüpunkt als Aktiv, falls ein Untermenüpunkt aktiv ist --}}
            @php($activeparent = false)
            @php($activeparentparent = false)
            @foreach($menuItem->theme_children as $subMenuItem)
                @if($subMenuItem->active)
                    @php($activeparent = true)
                @endif
                @foreach($subMenuItem->theme_children as $subSubMenuItem)
                    @if($subSubMenuItem->active)
                        @php($activeparentparent = true)
                    @endif
                @endforeach
            @endforeach
            @php( $class = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $menuItem->classes ), $menuItem) ) ) )
            <li class="parent @if($menuItem->active) active @endif @if($activeparent) activeparent @endif @if($activeparentparent) activeparentparent @endif {{$class}}">
                <a href="{{$menuItem->url}}" @if( !empty($menuItem->target)) target="_blank" @endif >
                    {{$menuItem->title}}
                </a>
                <ul>
                    @foreach($menuItem->theme_children as $subMenuItem)
                        @if(isset($subMenuItem->theme_children) && count($subMenuItem->theme_children) > 0)
                            @php( $classssub = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $subMenuItem->classes ), $subMenuItem) ) ) )
                            @php($activeparentparent = false)
                            @foreach($subMenuItem->theme_children as $subSubMenuItem)
                                @if($subSubMenuItem->active)
                                    @php($activeparentparent = true)
                                @endif
                            @endforeach
                            <li class="parent @if($subMenuItem->active) active @endif  @if($activeparentparent) activeparentparent @endif {{$classssub}}">
                                <a href="{{$subMenuItem->url}}" @if( !empty($subMenuItem->target)) target="_blank" @endif >{{$subMenuItem->title}}</a>
                                <ul>
                                    @foreach($subMenuItem->theme_children as $subSubMenuItem)
                                        @php( $classssubsub = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $subSubMenuItem->classes ), $subSubMenuItem) ) ) )
                                        <li class="@if($subSubMenuItem->active) active @endif {{$classssubsub}}">
                                            <a href="{{$subSubMenuItem->url}}" @if( !empty($subSubMenuItem->target)) target="_blank" @endif>{{$subSubMenuItem->title}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            @php( $classssub = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $subMenuItem->classes ), $subMenuItem) ) ) )
                            <li class="@if($subMenuItem->active) active @endif {{$classssub}}">
                                <a href="{{$subMenuItem->url}}" @if( !empty($subMenuItem->target)) target="_blank" @endif >{{$subMenuItem->title}}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>
        @else
            @php( $class = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $menuItem->classes ), $menuItem) ) ) )
            <li class="@if($menuItem->active) active @endif {{$class}}"><a href="{{$menuItem->url}}" @if( !empty($menuItem->target)) target="_blank" @endif >{{$menuItem->title}}</a></li>
        @endif
        @wpmenuend
    </ul>
</nav>

{{-- The following template will be loaded by mmenu --}}
<script type="text/x-template" id="mmenu-template">
    <div class="navigation__footer">
        <div class="navigation__search-button">
            <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M15.634 2.679C12.063-.893 6.25-.893 2.68 2.679c-3.57 3.572-3.57 9.384 0 12.956 3.18 3.18 8.133 3.52 11.702 1.037.076.356.247.695.524.971l5.2 5.201a1.934 1.934 0 002.738 0 1.933 1.933 0 000-2.737l-5.201-5.202a1.935 1.935 0 00-.97-.522c2.484-3.57 2.143-8.522-1.038-11.704zm-1.642 11.314c-2.666 2.666-7.006 2.666-9.671 0a6.85 6.85 0 010-9.671c2.665-2.666 7.005-2.666 9.671 0a6.846 6.846 0 010 9.67z"
                      fill="var(--color-primary)" fill-rule="nonzero"/>
            </svg>
        </div>
        @if(function_exists('icl_get_languages'))
            <?php $languages = icl_get_languages('skip_missing=0&orderby=code'); ?>

            @if(!empty($languages))
                <div class="navigation__lanuage-wrapper">
                    <ul>
                        @foreach($languages as $language)
                            <li>
                                <a class="navigation-button navigation__language-{{ $language['code'] }} @if($language["active"]) active @endif" href="{{ $language['url'] }}">
                                    {{ substr(icl_disp_language($language['translated_name']), 0, 2) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        @endif
    </div>
</script>