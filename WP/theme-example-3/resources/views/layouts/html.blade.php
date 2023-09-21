<!doctype html>
<html @if($lang = apply_filters('wpml_current_language', null)) lang="{{ $lang }}" @endif>
<head>
    <meta charset="utf-8">
    <meta name="generator" content="WeLoveYou">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php wp_title() ?></title>

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="194x194" href="/favicon-194x194.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#000000">
    <meta name="msapplication-TileColor" content="#000000">
    <meta name="msapplication-TileImage" content="/mstile-144x144.png">
    <meta name="theme-color" content="#ff7e00">

    {{wp_head()}}
    {{-- Google Tag Manager: kann in den Theme Einstellungen eingetragen werden --}}
    {!! get_option('google_tag_manager_head') !!}
</head>
<body {{ body_class([$is_using_divi ? 'divi-enabled' : 'divi-disabled', 'has-fixed-navbar']) }}>

{{-- Google Tag Manager: kann in den Theme Einstellungen eingetragen werden --}}
{!! get_option('google_tag_manager_body') !!}
@if(isset($json))
    <script>
        {{-- A global variable to pass data to the javascript world --}}
            window['wp_data'] = {!! json_encode($json) !!};
    </script>
@endif

@yield('body')

{{ wp_footer() }}
</body>
</html>
