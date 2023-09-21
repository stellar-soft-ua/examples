<label>{{ $field_title }}</label><br/>

@foreach($checkbox_options as $index => $checkbox)
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="{{ $field_id }}[{{ $index }}]" name="{{ $field_id }}[{{ $index }}]" value="{{ $checkbox['value'] }}" {{ $checkbox['checked'] ? 'checked' : '' }} />

        <label class="custom-control-label" for="{{ $field_id }}[{{ $index }}]">{{ $checkbox['value'] }}</label>
    </div>
@endforeach


