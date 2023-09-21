<?php
 /**
  * Block Name: Content Block
  *
  * This is the template that displays the Content Block
  */
  ?>
 <?php 
   $pol_content = get_field('pol_content');
   $align_class = $block['align'] ? 'align' . $block['align'] : '';
 ?>
 <?php if(!empty($pol_content)) { ?>
  <section class="content-block padding-full-top-bottom <?php echo $align_class; ?>">
      <?php if(!empty($pol_content)) { ?>
       <?php echo ($pol_content);?>
      <?php } ?>
  </section>
<?php } ?>
