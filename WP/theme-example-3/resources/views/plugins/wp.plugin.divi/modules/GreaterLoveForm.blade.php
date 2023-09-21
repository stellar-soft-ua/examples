@component('divi::modules.GreaterLoveForm.partials.module_wrapper', ['module_class' => $module_class])
    @if($title)
        @include('divi::modules.GreaterLoveForm.partials.form_header', ['title' => $title])
    @endif

    <form action="/wp-json/weloveyou/v1/form/submit" method="POST" novalidate data-theme-form="{{ $module_id }}">
        @include('divi::modules.GreaterLoveForm.partials.honeypot')

        @component('divi::modules.GreaterLoveForm.partials.fields_wrapper')
            {!! do_shortcode($content, true) !!}
        @endcomponent

        @if($captcha === 'on')
            @component('divi::modules.GreaterLoveForm.partials.fields_wrapper')
                @include('divi::modules.GreaterLoveFormField', [
                'field_id' => 'g-recaptcha-response',
                'field_description' => null,
                'field_type' => 'captcha',
                'classes' => 'form-field field-captcha',
                'field_width' => 'col-lg-12'
            ])
            @endcomponent
        @endif

        <div class="form-group when-submitting float-right">
            <theme-spinner></theme-spinner>
        </div>

        @include('divi::modules.GreaterLoveForm.partials.server_error')
        @include('divi::modules.GreaterLoveFormField.submit')
    </form>
@endcomponent
