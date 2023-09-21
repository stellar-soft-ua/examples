<?php
/**
 * Block Name: Banner with download links 
 *
 * This is the template that displays the Banner with download links block
 */
?>
<?php   
    $pol_download_banner_tagline = get_field('pol_download_banner_tagline'); 
    $pol_download_banner_heading = get_field('pol_download_banner_heading');
    $pol_download_banner_description = get_field('pol_download_banner_description');
    $pol_download_banner_background_image = get_field('pol_download_banner_background_image');
    $align_class = $block['align'] ? 'align' . $block['align'] : '';
?>
<?php if(!empty($pol_download_banner_heading) || !empty($pol_download_banner_description) || !empty($pol_download_banner_cta) ||  !empty($pol_download_banner_background_image)) { ?>
<section class="banner-with-download-links padding-half-top-bottom <?php echo $align_class; ?>" style="<?php if (!empty($pol_download_banner_background_image)) { ?>background-image: url('<?php echo $pol_download_banner_background_image;?>');<?php }else{ ?>background-image: url('<?php echo get_stylesheet_directory_uri(); ?>');<?php } ?>"> 
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-7 d-flex flex-column justify-content-center">
                <?php if(!empty($pol_download_banner_tagline)) { ?>
                    <span class="tagline"><?php echo $pol_download_banner_tagline;?></span>
                <?php } ?>
                <?php if(!empty($pol_download_banner_heading)) { ?>
                    <h1 class="heading"><?php echo $pol_download_banner_heading;?></h1>
                <?php } ?>
                <?php if(!empty($pol_download_banner_description)) { ?>
                    <span class="text"><?php echo $pol_download_banner_description;?></span>
                <?php } ?>
            </div>
            </div>
    </div>
</section>
        <section class="<?php echo $align_class; ?>">
            <div class="inner-bullets">
                <ul>
                    <?php
                    // Check rows exists.
                    if( have_rows('inner_bullets_section') ):
                    while( have_rows('inner_bullets_section') ) : the_row();
                    $pol_inr_bullets_heading = get_sub_field('pol_inr_bullets_heading');
                    ?>
                        <li>
                            <?php 
                            $link = $pol_inr_bullets_heading;
                            if( $link ): 
                                $link_url = $link['url'];
                                $link_title = $link['title'];
                                $link_target = $link['target'] ? $link['target'] : '_self';
                                ?>
                                <a class="download-list" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?>
                                <span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 40 40" xml:space="preserve"><path d="M20,0C8.973,0,0,8.973,0,20c0,11.027,8.973,20,20,20c11.029,0,20-8.973,20-20C40,8.973,31.029,0,20,0z M30.725,18.706 l-8.666,7.386c-0.588,0.501-1.312,0.752-2.041,0.754c-0.725,0.002-1.451-0.248-2.041-0.746l-8.692-7.354 c-1.328-1.125-1.494-3.115-0.369-4.443c1.125-1.33,3.114-1.496,4.442-0.371l6.648,5.627l6.629-5.648 c1.326-1.131,3.316-0.971,4.445,0.354C32.209,15.587,32.051,17.577,30.725,18.706z"></path></svg></span>
                                </a>
                                <?php endif; ?>
                        </li>
                    <?php 
                    endwhile;
                    // No value.
                    else :
                    // Do something...
                    endif;
                    ?>
                </ul>
            </div>
                </section>
   
<?php  } ?>