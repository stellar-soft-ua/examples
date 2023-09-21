<?php
function get_product_filter($category, $post_type, $hide_filters = false)
{
    $terms = get_terms([
        'taxonomy'   => $category,
        'hide_empty' => true,
    ]);
    ?>
    <div class="filters">
        <?php if($post_type===FREQUENCY_EXTENSION_POST_TYPE):?>
            <h2 class="_filters__title"><?= check_page() ?>
                <i></i>
            </h2>
        <?php else: ?>
            <h2 class="filters__title"><?= check_page() ?>
                <i></i>
            </h2>
        <?php endif ?>
        <div class="filters__wrap">
            <input type="hidden" id="post_type"
                   data-type='<?= htmlspecialchars(json_encode($post_type), ENT_QUOTES, 'UTF-8') ?>'/>
            <input type="hidden" id="product_category_name" value="<?= $category ?>"/>
            <?php if (!$hide_filters): ?>
                <?php if (!empty($terms)): ?>
                    <div class="categories block">
                        <?php foreach ($terms as $term): ?>
                            <div class="categories__item">
                                <input type="checkbox" name="<?= $term->name ?>" value="<?= $term->name ?>"
                                       id="<?= $term->term_id ?>" class="tax-filter">
                                <label for=<?= $term->term_id ?>></label>
                                <span class="categories__text title-checkbox"><?= $term->name ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="button-xs filter-accept-btn">Ok</button>
                <?php endif; ?>
            <?php endif; ?>
            <?php if (is_array($post_type)): ?>
                <div class="categories block">
                    <div class="categories__item">
                        <input type="checkbox" name="<?=VNA_POST_TYPE?>" value="75_vna"
                               id="75_vna" class="type-filter">
                        <label for=75_vna></label>
                        <span class="categories__text title-checkbox">75 Ohm VNAs</span>
                    </div>
                    <div class="categories__item">
                        <input type="checkbox" name="<?=CALIBRATION_KITS_POST_TYPE?>" value="75_accessories"
                               id="75_accessories" class="type-filter">
                        <label for=75_accessories></label>
                        <span class="categories__text title-checkbox">75 Ohm Accessories</span>
                    </div>
                </div>
                <button class="button-xs filter-accept-btn">Ok</button>
            <?php endif; ?>
        </div>
    </div>
    <?php
}