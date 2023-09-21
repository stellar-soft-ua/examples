<?php
/** @var int $id */
/** @var int $width */
/** @var int[] $sizes */

if ( ! is_numeric($id) && is_string($id) && ! empty($id)) {
    $id = attachment_url_to_postid($id);
}

// Make sure to always use an integer
$id = intval($id);

$attributes = wp_get_attachment_image_src($id, 'full');

if ( ! isset($width) || ! is_numeric($width)) {
    $width = 1220;
}

// Make sure, that the max width does not exceed the width of the original image
$width = min($width, array_get($attributes, 1, $width));

// Quit, if no image has been found or set
if ( ! $id > 0) {
    error_log('Could not generate img-tag for Image with id "' . $id . '"');

    return;
}

if ( ! isset($title) || $title === null) {
    $title = get_the_title($id);
}


if ( ! isset($alt) || $alt === null) {
    $alt = get_post_meta($id, '_wp_attachment_image_alt', true) ?: $title;
}

if ( ! isset($sizes)) {
    $sizes = [
        500  => 500,
        750  => 750,
        1000 => 1000,
        1220 => 1220
    ];
}

if ( ! isset($ratio)) {
    $ratio = null;
} else {
    list($ratioWidth, $ratioHeight) = array_map('intval', explode(':', $ratio, 2));
    $ratio = $ratioWidth / $ratioHeight;
}

ksort($sizes);

if ($width > 0) {
    $sizes = array_filter($sizes, function ($size) use ($width) {
        return $size < $width;
    }, ARRAY_FILTER_USE_KEY);
}

if (end($sizes) < $width) {
    $sizes[$width] = $width;
}

//$srcset = array_map(function ($size) use ($id, $ratio) {
//    $height = $ratio ? $size / $ratio : 0;
//
//    return flyImage($id, $size, $height)->source . ' ' . $size . 'w';
//}, $sizes);


//$viewportSizes = array_map(function ($size, $viewport) {
//    $viewport--;
//
//    return "(max-width: ${viewport}px) ${size}px";
//}, $sizes, array_keys($sizes));
//
//// Add default viewport size
//$viewportSizes[] = $width . 'px';

$sources = array_map(function ($size) use ($id, $ratio) {
    if (is_array($size)) {
        $height = $size[1];
        $size   = $size[0];
    } else {
        $height = $ratio ? $size / $ratio : 0;
    }

    return flyImage($id, $size, $height)->source;
}, $sizes);


$lastSource = array_pop($sources);

?>

<picture>
    @foreach($sources as $media => $source)
        <source media="(max-width: {{ $media }}px)" srcset="{{ $source }}">
    @endforeach
    <source srcset="{{ $lastSource }}">
    {{-- Fallback for older browsers --}}
    <img src="{{ $lastSource }}"
         @if($title)title="{{ $title }}" @endif
         @if($alt)alt="{{ $alt }}" @endif />
</picture>
