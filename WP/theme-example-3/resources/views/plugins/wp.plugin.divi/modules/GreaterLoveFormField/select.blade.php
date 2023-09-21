<label for="theme_{{ $field_id }}">{{ $field_title }}</label><br/>

<select id="theme_{{ $field_id }}" name="{{ $field_id }}" class="selectpicker form-control" data-style="btn-select">
    @if($select_placeholder)
        <option value="" disabled selected>{{ $select_placeholder }}</option>
    @endif
    @foreach($select_options as $option)
        <option value="{{ $option['value'] }}">{{ $option['value'] }}</option>
    @endforeach
</select>
