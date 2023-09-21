<div id="sections">
    @foreach($sections as $index => $section)
        @if($section['_type'] === 'section')
            @include('partials.sections.section', $section)
        @endif
    @endforeach
</div>
