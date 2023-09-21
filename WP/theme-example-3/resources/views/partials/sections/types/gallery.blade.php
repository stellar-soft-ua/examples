<div class="row">
    <div class="header col-md-12">
        <strong>{{ array_get($item, 'title') }}</strong>
        <div>{!! wpautop(array_get($item, 'description')) !!}</div>
    </div>
    <div class="col-lg-10 offset-lg-1 col-md-12">
        @component('components.carousel', ['id' => 'gallery-' . time(), 'indicators' => count($items)])
            @foreach($items as $key => $item)
                @component('components.carousel-item', ['active' => $key === 0])
                    @include('partials.assets.image', [
                        'id' => $item,
                        'title' => null,
                        'alt' => null,
                        'width' => 920,
                        'ratio' => '3:2'
                    ])
                @endcomponent
            @endforeach
        @endcomponent
    </div>
</div>
