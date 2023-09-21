<label>{{ $field_title }}</label><br/>

@foreach($radio_options as $index => $radio)
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" id="{{ $field_id }}[{{ $index }}]" name="{{ $field_id }}" value="{{ $radio['value'] }}" {{ $radio['checked'] ? 'checked' : '' }} />

        <label class="custom-control-label" for="{{ $field_id }}[{{ $index }}]">{{ $radio['value'] }}</label>
    </div>
@endforeach


