<div class="form-group field-submit">
    <input type="hidden" name="page_id" value="{{ get_the_ID() }}"/>
    <input type="hidden" name="module_id" value="{{ $module_id }}"/>
    <button type="submit" class="btn btn-primary float-right">{{ $submit_button_text ?: 'Absenden' }}</button>
</div>
