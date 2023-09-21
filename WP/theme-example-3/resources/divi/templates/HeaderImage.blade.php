<div class="{{ $module_class }} mb-3">
    <span class="h1 heading-outline">{{ $title }}</span>

    <div class="img-wrapper">
        @include('partials.assets.image', [
            'id' => $image,
            'ratio' => '3:1',
            'width' => 1180,
            'sizes' => [
                500 => [500, 500],
                750  => 750,
                1000 => 1000
            ]
        ])
    </div>
</div>
