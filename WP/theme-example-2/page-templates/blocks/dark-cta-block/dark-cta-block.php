<?php
/**
 * Block Name: Download block
 * This is the template that displays the Download Block
 */
?>
<?php 
$pol_dcta_heading = get_field('pol_dcta_heading');
$pol_dcta_button = get_field('pol_dcta_button');
$align_class = $block['align'] ? 'align' . $block['align'] : '';
?>
<?php if(!empty($pol_dcta_heading) || !empty($pol_dcta_button)) { ?>
<section class="dark-cta-block <?php echo $align_class; ?>">
    <div class="dcta">
        <?php if (!empty($pol_dcta_heading)) {?>
            <p><?php echo $pol_dcta_heading; ?></p>
        <?php } ?>
        <?php 
            $link = $pol_dcta_button;
            if( !empty($link['title'])):
            $link_url = $link['url'];
            $link_title = $link['title'];
            $link_target = $link['target'] ? $link['target'] : '_self';
            ?>
            <a class="default-btn" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
            <?php endif; ?>
    </div>
</section>
<?php } ?>
