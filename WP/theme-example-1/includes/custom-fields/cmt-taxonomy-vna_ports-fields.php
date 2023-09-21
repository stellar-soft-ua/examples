<?php
function taxonomy_vna_ports_custom_fields($tag)
{
    $term_id = $tag->term_id;

    $no_different_options = boolval(get_term_meta($term_id, "no_different_options", true));
    $do_not_add_text_port = boolval(get_term_meta($term_id, "do_not_add_text_port", true));
    $term_order = get_term_meta($term_id, "term_order", true);
    ?>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="no_different_options"><?php _e('No Different Options'); ?></label>
        </th>
        <td>
            <input id="no_different_options" type="checkbox" name="no_different_options"<?php echo $no_different_options ? " checked" : "" ?> value="1">
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="do_not_add_text_port"><?php _e('Don\'t add the text "-port"'); ?></label>
        </th>
        <td>
            <input id="do_not_add_text_port" type="checkbox" name="do_not_add_text_port"<?php echo $do_not_add_text_port ? " checked" : "" ?> value="1">
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="term_order"><?php _e('Order'); ?></label>
        </th>
        <td>
            <input id="term_order" type="number" name="term_order" value="<?php echo $term_order ?>">
        </td>
    </tr>
    <?php
}

function save_taxonomy_vna_ports_custom_fields($term_id)
{
    update_term_meta($term_id, "no_different_options", isset($_POST['no_different_options']) ? 1 : 0);
    update_term_meta($term_id, "do_not_add_text_port", isset($_POST['do_not_add_text_port']) ? 1 : 0);

    if (isset($_POST['term_order']) && (intval($_POST['term_order']) || $_POST['term_order'] === "0")) {
        update_term_meta($term_id, "term_order", intval($_POST['term_order']));
    } else {
        delete_term_meta($term_id, "term_order");
    }
}

add_action('vna_ports_edit_form_fields', 'taxonomy_vna_ports_custom_fields', 10, 2);
add_action('vna_ports_add_form_fields', 'taxonomy_vna_ports_custom_fields', 10, 2);
add_action('edited_vna_ports', 'save_taxonomy_vna_ports_custom_fields', 10, 2);
add_action('create_vna_ports', 'save_taxonomy_vna_ports_custom_fields', 10, 2);
