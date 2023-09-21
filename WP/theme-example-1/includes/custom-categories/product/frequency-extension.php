<?php
function frequency_extension_category()
{
    register_taxonomy(FREQUENCY_EXTENSION_CATEGORY, FREQUENCY_EXTENSION_POST_TYPE,
        [
            'labels'            => [
                'name'          => 'Categories',
                'singular_name' => 'Categories',
                'search_items'  => 'Search Categories',
                'all_items'     => 'All Categories',
                'edit_item'     => 'Edit Categories',
                'update_item'   => 'Update Category',
                'add_new_item'  => 'Add New Category',
                'new_item_name' => 'New Category Name',
                'menu_name'     => 'Categories',
            ],
            'hierarchical'      => true,
            'sort'              => true,
            'args'              => ['orderby' => 'term_order'],
            'rewrite'           => ['slug' => 'frequency-category'],
            'show_admin_column' => true
        ]
    );
}

function frequency_extension_ports()
{
    register_taxonomy(FREQUENCY_EXTENSION_PORTS, FREQUENCY_EXTENSION_POST_TYPE,
        [
            'labels'            => [
                'name'          => 'Number of Ports',
                'singular_name' => 'Number of Ports',
                'search_items'  => 'Search Ports',
                'all_items'     => 'All Ports',
                'edit_item'     => 'Edit Ports',
                'update_item'   => 'Update Port',
                'add_new_item'  => 'Add New Port',
                'new_item_name' => 'New Port Name',
                'menu_name'     => 'Number of Ports',
            ],
            'hierarchical'      => true,
            'sort'              => true,
            'args'              => ['orderby' => 'term_order'],
            'rewrite'           => ['slug' => 'frequency-ports'],
            'show_admin_column' => false
        ]
    );
}


function frequency_extension_frequency()
{
    register_taxonomy(FREQUENCY_EXTENSION_FREQUENCY, FREQUENCY_EXTENSION_POST_TYPE,
        [
            'labels'            => [
                'name'          => 'Frequencies',
                'singular_name' => 'Frequencies',
                'search_items'  => 'Search Frequency',
                'all_items'     => 'All Frequency',
                'edit_item'     => 'Edit Frequency',
                'update_item'   => 'Update Frequency',
                'add_new_item'  => 'Add New Frequency',
                'new_item_name' => 'New Frequency',
                'menu_name'     => 'Frequencies',
            ],
            'hierarchical'      => true,
            'sort'              => true,
            'args'              => ['orderby' => 'term_order'],
            'rewrite'           => ['slug' => 'frequency-frequency'],
            'show_admin_column' => false
        ]
    );
}

function frequency_extension_types()
{
    register_taxonomy(FREQUENCY_EXTENSION_TYPE, FREQUENCY_EXTENSION_POST_TYPE,
        [
            'labels'            => [
                'name'          => 'Extension Type',
                'singular_name' => 'Extension Types',
                'search_items'  => 'Search Extension Type',
                'all_items'     => 'All Extension Types',
                'edit_item'     => 'Edit Extension Type',
                'update_item'   => 'Update Extension Type',
                'add_new_item'  => 'Add New Extension Type',
                'new_item_name' => 'New Extension Type',
                'menu_name'     => 'Extension Types',
            ],
            'hierarchical'      => true,
            'sort'              => true,
            'args'              => ['orderby' => 'term_order'],
            'rewrite'           => ['slug' => FREQUENCY_EXTENSION_TYPE],
            'show_admin_column' => false
        ]
    );
}

function frequency_extension_variations()
{
    register_taxonomy(FREQUENCY_EXTENSION_VARIATIONS, FREQUENCY_EXTENSION_POST_TYPE,
        [
            'labels'            => [
                'name'          => 'Extension Variation',
                'singular_name' => 'Extension Variations',
                'search_items'  => 'Search Variation',
                'all_items'     => 'All Variations',
                'edit_item'     => 'Edit Variation',
                'update_item'   => 'Update Variation',
                'add_new_item'  => 'Add New Variation',
                'new_item_name' => 'New Variation',
                'menu_name'     => 'Extension Variations',
            ],
            'hierarchical'      => true,
            'sort'              => true,
            'args'              => ['orderby' => 'term_order'],
            'rewrite'           => ['slug' => FREQUENCY_EXTENSION_VARIATIONS],
            'show_admin_column' => false
        ]
    );
}

function variations_custom_fields($tag) {
    // Check for existing taxonomy meta for the term you're editing
    $t_id = $tag->term_id; // Get the ID of the term you're editing
    $term_meta = get_option( "taxonomy_term_$t_id" ); // Do the check
    ?>

    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="variation_sub_name"><?php _e('Sub name'); ?></label>
        </th>
        <td>
            <input type="text" name="term_meta[variation_sub_name]" id="term_meta[variation_sub_name]" size="25" style="width:60%;" value="<?php echo $term_meta['variation_sub_name'] ? $term_meta['variation_sub_name'] : ''; ?>"><br />
        </td>
    </tr>

    <?php
}

// A callback function to save our extra taxonomy field(s)
function save_variations_custom_fields( $term_id ) {
    if ( isset( $_POST['term_meta'] ) ) {
        $t_id = $term_id;
        $term_meta = get_option( "taxonomy_term_$t_id" );
        $cat_keys = array_keys( $_POST['term_meta'] );
        foreach ( $cat_keys as $key ){
            if ( isset( $_POST['term_meta'][$key] ) ){
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        //save the option array
        update_option( "taxonomy_term_$t_id", $term_meta );
    }
}

// Add the fields to the "presenters" taxonomy, using our callback function
add_action( 'frequency_extension_variations_edit_form_fields', 'variations_custom_fields', 10, 2 );

// Save the changes made on the "presenters" taxonomy, using our callback function
add_action( 'edited_frequency_extension_variations', 'save_variations_custom_fields', 10, 2 );

add_action('init', 'frequency_extension_types');
add_action('init', 'frequency_extension_variations');
add_action('init', 'frequency_extension_ports');
add_action('init', 'frequency_extension_category');
add_action('init', 'frequency_extension_frequency');