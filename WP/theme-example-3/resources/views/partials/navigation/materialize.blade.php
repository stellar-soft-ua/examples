<nav class="materializenav desktop">
    <div class="nav-wrapper">
        <ul class="right hide-on-med-and-down">
        @wpmenu('header-menu')
        {{--@php(dump($menuItem))--}}
            {{ $class = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $menuItem->classes ), $menuItem) ) ) }}
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
                <li class="parent {{ $class }} @if($menuItem->active) active @endif @if($activeparent) activeparent @endif @if($activeparentparent) activeparentparent @endif">
                    <a class="dropdown-button" data-activates="dropdownmenu{{ $menuItem->ID }}" href="{{$menuItem->url}}" @if( !empty($menuItem->target)) target="_blank" @endif >
                        {{$menuItem->title}}
                    </a>
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
        

        @wpmenu('header-menu')
            @php($activeparentparent = false)
                @foreach($menuItem->theme_children as $subMenuItem)
                @foreach($subMenuItem->theme_children as $subSubMenuItem)
                    @if($subSubMenuItem->active)
                        @php($activeparentparent = true)
                    @endif
                @endforeach
            @endforeach
            @if(isset($menuItem->theme_children) && count($menuItem->theme_children) > 0)
                <ul id="dropdownmenu{{ $menuItem->ID }}" class="dropdown-content">
                    @foreach($menuItem->theme_children as $subMenuItem)
                        {{ $classssub = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $subMenuItem->classes ), $subMenuItem) ) ) }}
                        @php($activeparentparent = false)
                        @if(isset($subMenuItem->theme_children) && count($subMenuItem->theme_children) > 0)
                            @php( $classssub = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $subMenuItem->classes ), $subMenuItem) ) ) )
                            @foreach($subMenuItem->theme_children as $subSubMenuItem)
                                @if($subSubMenuItem->active)
                                    @php($activeparentparent = true)
                                @endif
                            @endforeach
                                <li class="parent {{ $classssub }} @if($subMenuItem->active) active @endif  @if($activeparentparent) activeparentparent @endif">
                                <a class="dropdown-button-sub" data-activates="dropdownmenu{{ $subMenuItem->ID }}" href="{{$subMenuItem->url}}" @if( !empty($menuItem->target)) target="_blank" @endif >{{$subMenuItem->title}}1</a>
                            </li>
                        @else
                            <li class="@if($subMenuItem->active) active @endif {{ $classssub }}">
                                <a href="{{$subMenuItem->url}}" @if( !empty($menuItem->target)) target="_blank" @endif >{{$subMenuItem->title}}2</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            
                @foreach($menuItem->theme_children as $subMenuItem)
                    @if(isset($subMenuItem->theme_children) && count($subMenuItem->theme_children) > 0)
                        <ul id="dropdownmenu{{ $subMenuItem->ID }}" class="dropdown-content">
                            @foreach($subMenuItem->theme_children as $subSubMenuItem)
                                {{ $classssubsub = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $subMenuItem->classes ), $subMenuItem) ) ) }}
                                <li class="{{ $classssubsub }} @if($subSubMenuItem->active) active @endif">
                                    <a href="{{$subSubMenuItem->url}}">{{$subSubMenuItem->title}}3</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                @endforeach
            @endif

        @wpmenuend
        <!--/.nav-collapse -->
    </div>
    <!--/.container-fluid -->
</nav>