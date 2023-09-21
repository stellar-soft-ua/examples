<?php
function get_frequency_filter($post_type, $types, $variations)
{
    $variations = get_terms([
        'taxonomy'   => $variations,
        'hide_empty' => false,
        'orderby'    => 'id',
        'order'      => 'ASC',
    ]);
    $types = get_terms([
        'taxonomy'   => $types,
        'hide_empty' => false,
        'orderby'    => 'term_id',
        'order'      => 'ASC',
    ]);

    //not wor sort on prod server
    $tmp_sort_mass = [];
    foreach($types as $val) {
        $tmp_sort_mass[] = $val->term_id;
    }
    array_multisort($types, $tmp_sort_mass);
    //
    $results = get_all_extensions($post_type);
    ?>
    <section class="upperfilter frequency-extension-filter">
        <input type="hidden" id="post_type"
               data-type='<?= $post_type ?>'/>
        <div class="container">
            <div class="table-border expanded-table">
                <table class="upperfilter__table">
                    <tr class="upperfilter__row">
                        <td class="upperfilter__col" colspan="2"><span class="upperfilter__title">Frequency Extension Bands</span></td>
                        <?php foreach ($variations as $variation): $term_meta = get_option( "taxonomy_term_$variation->term_id" );?>
                            <td class="upperfilter__col variation-title">
                                <p class="variation-name <?=$term_meta['variation_sub_name'] ? '' : 'with-margin'?>"><b><?= $variation->name ?></b></p>
                                <?php if($term_meta['variation_sub_name']):?>
                                    <p class="variation-subname"><b><?=$term_meta['variation_sub_name']?></b></p>
                                <?php endif; ?>
                                <p class="variation-description"><?= $variation->description ?></p>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                    <?php foreach ($types as $index => $type): ?>
                            <tr class="upperfilter__row">
                                <td class="upperfilter__col" colspan="2">
                                    <span class="ports-title <?= $type->name . '-port' ?>"><?= $type->name ?></span>
                                </td>
                                <?php foreach ($variations as $variation): ?>
                                    <?php
                                    $id = strval($type->term_id).strval($variation->term_id);
                                    $is_show = check_extensions($results, $type->term_id, $variation->name);
                                    $display = $is_show ? 'block' : 'none';
                                    ?>
                                    <td class="upperfilter__col">
                                        <input type="checkbox" name='<?= $variation->name ?>'
                                               value="<?= $variation->name ?>"
                                               id="<?= $id ?>"
                                               data-ext-type="<?= $type->term_id ?>"
                                               data-ext-variation="<?= $variation->name ?>"
                                        />
                                        <label class="upperfilter__checkbox" for="<?= $id ?>"
                                               style="display: <?= $display ?>"></label>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                    <?php endforeach; ?>
                    <tr class="upperfilter__row">
                        <td class="upperfilter__col bottom-legend" colspan="<?= count($variations) + 2 ?>">
                            <span class="reset-btn">Reset Filter</span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </section>
    <?php
    wp_enqueue_script('cmt-upper-frequency-filter',
        get_template_directory_uri() . '/assets/js/upper-frequency-filter.js', ['cmt-jquery'], false, true);
}
