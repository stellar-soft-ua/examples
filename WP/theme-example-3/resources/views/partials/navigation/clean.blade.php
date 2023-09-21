<nav class="cleanhtmlnav desktop">
    <div>
        <ul class="nav navbar-nav">
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
                <li class="parent @if($menuItem->active) active @endif @if($activeparent) activeparent @endif @if($activeparentparent) activeparentparent @endif dropdown {{ $class }}">
                    <a href="{{$menuItem->url}}" @if( !empty($menuItem->target)) target="_blank" @endif >
                        {{$menuItem->title}}
                    </a>
                    <ul class="dropdown-menu">
                        @foreach($menuItem->theme_children as $subMenuItem)
                            @php( $classssub = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $subMenuItem->classes ), $subMenuItem) ) ) )
                            @php($activeparentparent = false)
                            @if(isset($subMenuItem->theme_children) && count($subMenuItem->theme_children) > 0)
                                @php( $classssub = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $subMenuItem->classes ), $subMenuItem) ) ) )
                                @foreach($subMenuItem->theme_children as $subSubMenuItem)
                                    @if($subSubMenuItem->active)
                                        @php($activeparentparent = true)
                                    @endif
                                @endforeach
                                <li class="parent @if($subMenuItem->active) active @endif  @if($activeparentparent) activeparentparent @endif {{ $classssub }}">
                                <a href="{{$subMenuItem->url}}" @if( !empty($menuItem->target)) target="_blank" @endif >{{$subMenuItem->title}}</a>
                                <ul class="dropdown-submenu">
                                    @foreach($subMenuItem->theme_children as $subSubMenuItem)
                                        @php( $classssubsub = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $subSubMenuItem->classes ), $subSubMenuItem) ) ) )
                                        <li class="@if($subSubMenuItem->active) active @endif {{ $classssubsub }}">
                                            <a href="{{$subSubMenuItem->url}}">{{$subSubMenuItem->title}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            @else
                                <li class="@if($subMenuItem->active) active @endif {{ $classssub }}">
                                    <a href="{{$subMenuItem->url}}" @if( !empty($menuItem->target)) target="_blank" @endif >{{$subMenuItem->title}}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            @else
                <li class="@if($menuItem->active) active @endif" {{ $class }}>
                    <a href="{{$menuItem->url}}" @if( !empty($menuItem->target)) target="_blank" @endif >
                        {{$menuItem->title}}
                    </a>
                </li>
            @endif
        @wpmenuend
        </ul>
    </div>
</nav>