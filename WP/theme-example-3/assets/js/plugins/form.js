export const initForms = () => {
    window.greaterLoveForm({
        invalid_field_target($field) {
            if ($field.hasClass('selectpicker')) {
                return $field.parent();
            }

            return $field;
        }
    });

}