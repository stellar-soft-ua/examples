<div class="{{ $classes }} form-group {{ $field_width }}" {!! $field_id ? 'data-field-id="'.$field_id.'"' : '' !!}>
    @includeIf('divi::modules.GreaterLoveFormField.' . $field_type)

    @if(isset($field_description) and $field_description)
        <div class="form-field-description form-text form-muted" id="help_{{ $field_id }}">{{ $field_description }}</div>
    @endif

    @if($field_id)
        <div class="form-field-error invalid-feedback" data-error-message></div>
    @endif
</div>
