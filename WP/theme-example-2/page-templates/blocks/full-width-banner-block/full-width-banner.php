<?php
/**
 * Block Name: Full Width Banner Block
 *
 * This is the template that displays the Full Width Banner Block
 */
?>
<?php
$pol_background_image = get_field('pol_background_image') ?? get_stylesheet_directory_uri() . '/images/Hero-degault-image.png';
$pol_description = get_field('pol_description');
$align_class = $block['align'] ? 'align' . $block['align'] : '';
$custom_class = $block['className'] ?? '';
?>
<?php if(!empty($pol_background_image) || !empty($pol_description)) { ?>
    <section class="section d-1 pro-reporting-section-d-1 <?php echo $align_class; ?> <?php echo $custom_class ?>">
        <div class="container">
            <div class="content">
                <?php if(!empty($pol_description)) { ?>
                    <?php echo $pol_description;?>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>
