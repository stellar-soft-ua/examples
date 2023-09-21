{{--
    This module is basically built on the YoutubePlayer Vue Component.
    Therefore the [data-vue-instance] property is necessary to enable Vue inside that element.

    Remember, that this file is a blade template. You can use any blade syntax here, but not the
    usual vue syntax for variables (you should not need to anyway).
 --}}
<div class="theme-youtube-video {{ $module_class }}" @if($scroll_id)id="{{ $scroll_id }}" @endif data-vue-instance>
    {{-- The theme-youtube component is found under src/js/vue/components/YoutubePlayer --}}
    <theme-youtube id="{{ $youtube_link }}">
        {{--
            The content of preview slot is shown at the beginnging, before the video has been started.
            It is wrapped in a div with the class .vue--youtube-player__preview
            The "video" property has two method: start() and stop().
        --}}
        <template v-slot:preview="video">
            <div class="theme-youtube-video__poster">
                @if($image)
                    <img src="{{ flyImage($image, 70)->source }}"
                         srcset="{{ flyImage($image, 540)->source }} 540w,
                                 {{ flyImage($image, 700)->source }} 700w,
                                 {{ flyImage($image, 930)->source }} 930w,
                                 {{ flyImage($image, 1140)->source }} 1140w,
                                 {{ flyImage($image, 1250)->source }} 1250w"
                         sizes="(max-width: 767px) 540px,
                                (max-width: 992px) 700px,
                                (max-width: 1200px) 930px,
                                (max-width: 1310px) 1140px,
                                (min-width: 1311px) 1250px"
                         class="theme-youtube-video__poster__image">
                @else
                    <img src="https://img.youtube.com/vi/{{ $youtube_link }}/maxresdefault.jpg" class="theme-youtube-video__poster__image">
                @endif
                <div class="theme-youtube-video__poster__content">
                    <svg width="79" height="79" viewBox="0 0 79 79" xmlns="http://www.w3.org/2000/svg"><g fill="#000" fill-rule="evenodd"><circle cx="40" cy="39" r="38"/><path d="M39.5 78.5c-21.54 0-39-17.46-39-39s17.46-39 39-39 39 17.46 39 39-17.46 39-39 39zm0-3c19.882 0 36-16.118 36-36s-16.118-36-36-36-36 16.118-36 36 16.118 36 36 36z" fill-rule="nonzero"/><path class="theme-youtube-play-icon" d="M33.295 51.612L51.672 39.5 33.295 27.388v24.224zM32.62 23.35l22.603 14.898a1.5 1.5 0 0 1 0 2.504L32.62 55.65c-.997.657-2.325-.058-2.325-1.253V24.603c0-1.195 1.328-1.91 2.325-1.253z" fill-rule="nonzero"/></g></svg>
                    @if($title)
                        <p class="title">{{ $title }}</p>
                    @endif
                </div>
            </div>
        </template>

        {{--
            The content of the overlay slot will be shown above the video, after it has been started and
            the "open-as-overlay" attribute of the component has been set to 1. Otherwise the content will
            be ignored. It is wrapped in a div with the class .vue--youtube-player__overlay-content
            The "window" property has three methods: close(), play() and stop().
        --}}
        {{--        <template v-slot:overlay="window">--}}
        {{--            <button @click="window.close">X</button>--}}
        {{--        </template>--}}
    </theme-youtube>
</div>
