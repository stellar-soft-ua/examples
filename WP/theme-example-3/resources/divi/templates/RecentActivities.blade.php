<div class="isotope-wrapper">
    <div class="isotope-grid">
        <div class="{{ $module_class }} row">
            @foreach($posts as $key => $post)
                @if($key === 1)
                    <div class="col-lg-6 order-1 isotope-item">
                        @component('components.carousel', ['id' => 'recent-activities-slider', 'square' => true, 'indicators' => count($slides)])
                            @foreach($slides as $key => $slide)
                                @component('components.carousel-item', ['active' => $key === 0])
                                    @if(array_key_exists('link', $slide))
                                        <a href="{{ $slide['link'] }}" target="{{ $slide['link_target'] ?? '_self' }}">
                                            <span class="h3 heading-outline slide--heading">{{ $slide['title'] }}</span>

                                            @include('partials.assets.image', [
                                                'id' => $slide['image'],
                                                'width' => 950,
                                                'ratio' => '1:1'
                                            ])
                                        </a>
                                    @else
                                        <span class="h3 heading-outline slide--heading">{{ $slide['title'] }}</span>

                                        @include('partials.assets.image', [
                                            'id' => $slide['image'],
                                            'width' => 950,
                                            'ratio' => '1:1'
                                        ])
                                    @endif
                                @endcomponent
                            @endforeach
                        @endcomponent
                    </div>
                @endif

                <div class="col-lg-6 order-{{ $key < 1 ? $key : $key + 1 }} isotope-item">
                    @include('partials.advanced-link', [
                        'title' => $post->post_title,
                        'description' => wp_trim_words(get_the_excerpt($post), 20),
                        'href' => get_permalink($post)
                    ])
                </div>
            @endforeach
        </div>
    </div>
</div>
