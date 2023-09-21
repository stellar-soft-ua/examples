<div id="{{ $id }}"
     class="component--carousel carousel slide{{ isset($square) && $square === true ? ' carousel-square' : '' }}{{ isset($indicators) && $indicators > 0 ? ' has-indicators' : '' }}"
     data-ride="carousel">
    @if(isset($indicators) && $indicators > 0)
        <ol class="carousel-indicators">
            <li data-target="#{{ $id }}" data-slide-to="0" class="active"></li>
            @for($i = 1; $i < $indicators; $i++)
                <li data-target="#{{ $id }}" data-slide-to="{{ $i }}"></li>
            @endfor
        </ol>
    @endif

    <div class="carousel-inner">
        {!! $slot !!}
    </div>
</div>
