<ul class="navbar-nav menu-items align-self-start flex-grow-1">
    @wpmenu('header-menu')
    @php( $class = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $menuItem->classes ), $menuItem) ) ) )
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
        <li class="{{ $class }}{{ ($menuItem->active || $activeparent || $activeparentparent) ? 'active' : '' }}">
            <a role="button" aria-haspopup="true" aria-expanded="false" href="{{$menuItem->url}}"
               @if( !empty($menuItem->target)) target="_blank" @endif >
                {{$menuItem->title}}
            </a>
            @if(count($menuItem->theme_children) > 0)
                <ul class="dropdown-menu">
                    @foreach($menuItem->theme_children as $subMenuItem)
                        @php( $classssub = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $subMenuItem->classes ), $subMenuItem) ) ) )

                        @if(isset($subMenuItem->theme_children) && count($subMenuItem->theme_children) > 0)
                            @php( $classssub = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $subMenuItem->classes ), $subMenuItem) ) ) )
                            @foreach($subMenuItem->theme_children as $subSubMenuItem)
                                @if($subSubMenuItem->active)
                                    @php($activeparentparent = true)
                                @endif
                            @endforeach
                            <li class="{{ $classssub }} {{ $subMenuItem->active || $activeparentparent ? ' active' : '' }}">
                                <a href="{{$subMenuItem->url}}"
                                   @if( !empty($menuItem->target)) target="_blank" @endif >{{$subMenuItem->title}}</a>
                                <ul class="dropdown-menu">
                                    @foreach($subMenuItem->theme_children as $subSubMenuItem)
                                        @php( $classssubsub = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $subMenuItem->classes ), $subMenuItem) ) ) )
                                        <li class="{{ $classssubsub }} {{ $subSubMenuItem->active ? 'active' : '' }}">
                                            <a href="{{$subSubMenuItem->url}}">{{$subSubMenuItem->title}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="{{ $classssub }}{{ $subMenuItem->active ? ' active' : '' }}">
                                <a href="{{$subMenuItem->url}}"
                                   @if( !empty($menuItem->target)) target="_blank" @endif >{{$subMenuItem->title}}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            @endif
        </li>
    @else
        <li class="{{ $class }} @if($menuItem->active) active @endif">
            <a href="{{$menuItem->url}}" @if( !empty($menuItem->target)) target="_blank" @endif >
                {{$menuItem->title}}
            </a>
        </li>
    @endif
    @wpmenuend
</ul>
