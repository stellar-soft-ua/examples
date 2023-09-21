<div class="section {{ $background === 'gray' ? 'gray' : '' }}">
    <div class="header pointer"
         data-toggle="collapse"
         data-target="#section-{{ $index }}">

        <div class="d-flex flex-row justify-content-between align-items-center">
            <h2 class="lead font-italic">{{ $title }}</h2>
            <div class="icon chevron bottom"></div>
        </div>
    </div>

    <div class="content collapse" id="section-{{ $index }}">
        <div class="d-flex flex-column justify-content-center">
            @foreach($content as $index => $item)
                <div class="section--type-{{ str_replace('_','-', $item['_type']) }}">
                    @includeIf('partials.sections.types.' . $item['_type'], $item)
                </div>
            @endforeach
        </div>
    </div>
</div>
