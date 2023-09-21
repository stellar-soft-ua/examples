<?php
function get_upper_frequency_filter($post_type, $impedance, $ports, $frequencies)
{
    $frequencies = get_terms([
        'taxonomy'   => $frequencies,
        'hide_empty' => false,
        'orderby'    => 'id',
        'order'      => 'ASC',
    ]);
    $ports = get_terms([
        'taxonomy'   => $ports,
        'hide_empty' => false,
        'orderby'    => 'id',
        'order'      => 'ASC',
    ]);
    // replace ports by meta
    if ($ports) {
        foreach ($ports as $port) {
            $no_different_options = boolval(get_term_meta($port->term_id, "no_different_options", true));
            $do_not_add_text_port = boolval(get_term_meta($port->term_id, "do_not_add_text_port", true));
            $term_order = get_term_meta($port->term_id, "term_order", true);
            $ports_order[] = $term_order ? $term_order : 999999;
            $port->do_not_add_text_port = $do_not_add_text_port;
            $port->no_different_options = $no_different_options;
        }
        // Sort ports by order
        array_multisort($ports_order, $ports, SORT_ASC); // bad sort
        // END
    }
    // END
    $results = get_all_posts($post_type, $impedance);
    ?>
    <section class="upperfilter">
        <input type="hidden" id="post_type"
               data-type='<?= $post_type ?>'/>
        <div class="container">
            <h2 class="upperfilter__header">Upper Frequency Product Selector <span class="table-collapse"></span></h2>
            <div class="table-border expanded-table">
                <table class="upperfilter__table">
                    <tr class="upperfilter__row">
                        <td class="upperfilter__col" colspan="2"><span class="upperfilter__title">CMT VNAs</span></td>

                        <?php foreach ($frequencies as $frequency): ?>
                            <td class="upperfilter__col"><?= freguency_converter($frequency->name); ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <?php foreach ($ports as $index => $port): ?>
                        <?php if (isset($port->no_different_options) && intval($port->no_different_options)): ?>
                            <tr class="upperfilter__row">
                                <td class="upperfilter__col" colspan="2">
                                <?php if (isset($port->do_not_add_text_port) && intval($port->do_not_add_text_port)){ ?>
                                    <span class="ports-title <?= $port->name ?>"><?= $port->name ?></span>
                                <?php } else { ?>
                                    <span class="ports-title <?= $port->name . '-port' ?>"><?= $port->name ?>-Port</span>
                                <?php } ?>
                                </td>
                                <?php foreach ($frequencies as $frequency): ?>
                                    <?php
                                    $id = uniqid();
                                    $is_show = check_product($results, $frequency->name, null, $port->name);
                                    $display = $is_show ? 'block' : 'none';
                                    ?>
                                    <td class="upperfilter__col">
                                        <input type="checkbox" name='<?= $frequency->name ?>'
                                               value="<?= $frequency->name ?>"
                                               id="<?= $id ?>"
                                               data-port="<?= $port->name ?>"
                                               data-frequency="<?= $frequency->name ?>"
                                        />
                                        <label class="upperfilter__checkbox" for="<?= $id ?>"
                                               style="display: <?= $display ?>"></label>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php else: ?>
                            <tr class="upperfilter__row">
                                <th class="upperfilter__col" rowspan="3">
                                    <?php if (isset($port->do_not_add_text_port) && intval($port->do_not_add_text_port)){ ?>
                                        <span class="ports-title <?= $port->name ?>"><?= $port->name ?></span>
                                    <?php } else { ?>
                                        <span class="ports-title <?= $port->name . '-port' ?>"><?= $port->name ?>-Port</span>
                                    <?php } ?>
                                </th>
                                <td class="upperfilter__col"><b>Standard</b></td>
                                <?php foreach ($frequencies as $frequency): ?>
                                    <?php
                                    $id = uniqid();
                                    $is_show = check_product($results, $frequency->name, 'Base', $port->name);
                                    $display = $is_show ? 'block' : 'none';
                                    ?>
                                    <td class="upperfilter__col">
                                        <input type="checkbox" name='<?= $frequency->name ?>'
                                               value="<?= $frequency->name ?>"
                                               id="<?= $id ?>"
                                               data-port="<?= $port->name ?>"
                                               data-frequency="<?= $frequency->name ?>"
                                               data-product-type="Base"
                                        />
                                        <label class="upperfilter__checkbox" for="<?= $id ?>"
                                               style="display: <?= $display ?>"></label>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            <tr class="upperfilter__row">
                                <td class="upperfilter__col">DRA</td>
                                <?php foreach ($frequencies as $frequency): ?>
                                    <?php
                                    $id = uniqid();
                                    $is_show = check_product($results, $frequency->name, 'DRA', $port->name);
                                    $display = $is_show ? 'block' : 'none';
                                    ?>
                                    <td class="upperfilter__col">
                                        <input type="checkbox" name='<?= $frequency->name ?>'
                                               value="<?= $frequency->name ?>"
                                               id="<?= $id ?>"
                                               data-port="<?= $port->name ?>"
                                               data-frequency="<?= $frequency->name ?>"
                                               data-product-type="DRA"
                                        />
                                        <label class="upperfilter__checkbox" for="<?= $id ?>"
                                               style="display: <?= $display ?>"></label>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            <tr class="upperfilter__row">
                                <td class="upperfilter__col">Fx</td>
                                <?php foreach ($frequencies as $frequency): ?>
                                    <?php
                                    $id = uniqid();
                                    $is_show = check_product($results, $frequency->name, 'Fx', $port->name);
                                    $display = $is_show ? 'block' : 'none';
                                    ?>
                                    <td class="upperfilter__col">
                                        <input type="checkbox" name='<?= $frequency->name ?>'
                                               value="<?= $frequency->name ?>"
                                               id="<?= $id ?>"
                                               data-port="<?= $port->name ?>"
                                               data-frequency="<?= $frequency->name ?>"
                                               data-product-type="Fx"
                                        />
                                        <label class="upperfilter__checkbox" for="<?= $id ?>"
                                               style="display: <?= $display ?>"></label>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <tr class="upperfilter__row">
                        <td class="upperfilter__col bottom-legend" colspan="<?= count($frequencies) + 2 ?>">
                            <span class="legend">Legend:</span> <span class="legend-description">DRA — Direct Receiver Access; Fx — Frequency Extension Compatible</span>
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
