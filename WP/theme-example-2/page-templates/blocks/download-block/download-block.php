<?php
/**
 * Block Name: Download block
 * This is the template that displays the Download Block
 */
?>
<?php 
$pol_download_heading = get_field('pol_download_heading');
$pol_download_image = get_field('pol_download_image');
$pol_download_sub_text = get_field('pol_download_sub_text');
$download_button = get_field('download_button');
$align_class = $block['align'] ? 'align' . $block['align'] : '';
?>
<section class="download-block <?php echo $align_class; ?>">
    <div class="row dwn-blc">
        <?php if (!empty($pol_download_heading)) { ?>
        <h1 class="heading"><?php echo $pol_download_heading; ?></h1>
        <?php } ?>
        <div class="dwn-img">
            <?php if (!empty($pol_download_image)) { ?>
                 <img src="<?php echo $pol_download_image['url'];?>" alt="<?php echo $pol_download_image['alt'];?>" />
            <?php } ?>
        </div>

        <?php if (!empty($pol_download_sub_text)) { ?>
            <p><?php echo $pol_download_sub_text; ?></p>
        <?php } ?>

        <?php 
            $link = $download_button;
            if( !empty($link['title'])):
            $link_url = $link['url'];
            $link_title = $link['title'];
            $link_target = $link['target'] ? $link['target'] : '_self';
            ?>
            <a class="default-btn bg-blue" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
            <?php endif; ?>
    </div>
</section>