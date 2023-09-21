<?php
function category_taxonomy_custom_fields($tag)
{
    $t_id = $tag->term_id;
    $term_meta = get_option("taxonomy_term_$t_id");
    $colors = ['border-blue', 'border-green', 'border-yellow', 'border-red', 'border-grey','border-pink','sc-blue','sc-grey','sc-green'];
    $saved_color = $term_meta['tax_color'];
    $select_options = '';
    ?>

    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="tax_color"><?php _e('Category color'); ?></label>
        </th>
        <td>
            <select name="term_meta[tax_color]">
                <?php
                foreach ($colors as $color) {
                    $option = '<option value="' . $color . '">';
                    $option .= $color;
                    $option .= '</option>';
                    $select_options .= $option;
                }
                $select_options = str_replace('value="' . $saved_color . '"',
                    'value="' . $saved_color . '" selected="selected"', $select_options);
                echo $select_options;
                ?>
            </select>
        </td>
    </tr>
    <?php
}


function add_new_custom_fields()
{
    $colors = ['border-blue', 'border-green', 'border-yellow', 'border-red', 'border-grey','border-pink','sc-blue','sc-grey','sc-green'];
    $saved_color = '';
    $select_options = '';
    ?>
    <div class="form-field">
        <label for="tax_color"><?php _e('Category color'); ?></label>
        <select name="term_meta[tax_color]">
            <?php
            foreach ($colors as $color) {
                $option = '<option value="' . $color . '">';
                $option .= $color;
                $option .= '</option>';
                $select_options .= $option;
            }
            $select_options = str_replace('value="' . $saved_color . '"',
                'value="' . $saved_color . '" selected="selected"', $select_options);
            echo $select_options;
            ?>
        </select>
    </div>
    <?php
}


function save_taxonomy_custom_fields($term_id)
{
    if (isset($_POST['term_meta'])) {
        $t_id = $term_id;
        $term_meta = get_option("taxonomy_term_$t_id");
        $cat_keys = array_keys($_POST['term_meta']);
        foreach ($cat_keys as $key) {
            if (isset($_POST['term_meta'][$key])) {
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }

        update_option("taxonomy_term_$t_id", $term_meta);
    }
}

add_action('vna_category_edit_form_fields', 'category_taxonomy_custom_fields', 10, 2);
add_action('vna_category_add_form_fields', 'category_taxonomy_custom_fields', 10, 2);
add_action('edited_vna_category', 'save_taxonomy_custom_fields', 10, 2);
add_action('create_vna_category', 'save_taxonomy_custom_fields', 10, 2);

add_action('calibration_kits_category_edit_form_fields', 'category_taxonomy_custom_fields', 10, 2);
add_action('calibration_kits_category_add_form_fields', 'category_taxonomy_custom_fields', 10, 2);
add_action('edited_calibration_kits_category', 'save_taxonomy_custom_fields', 10, 2);
add_action('create_calibration_kits_category', 'save_taxonomy_custom_fields', 10, 2);

add_action('solutions_category_edit_form_fields', 'category_taxonomy_custom_fields', 10, 2);
add_action('solutions_category_add_form_fields', 'category_taxonomy_custom_fields', 10, 2);
add_action('edited_solutions_category', 'save_taxonomy_custom_fields', 10, 2);
add_action('create_solutions_category', 'save_taxonomy_custom_fields', 10, 2);

add_action('vna_application_solutions_edit_form_fields', 'category_taxonomy_custom_fields', 10, 2);
add_action('vna_application_solutions_add_form_fields', 'category_taxonomy_custom_fields', 10, 2);
add_action('edited_vna_application_solutions', 'save_taxonomy_custom_fields', 10, 2);
add_action('create_vna_application_solutions', 'save_taxonomy_custom_fields', 10, 2);