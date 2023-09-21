<?php
 /**
  * Block Name: Quote Block
  *
  * This is the template that displays the Quote Block
  */
  ?>
 <?php 
   $pol_quote = get_field('pol_quote');
   $align_class = $block['align'] ? 'align' . $block['align'] : '';
 ?>
 <?php if(!empty($pol_quote)) { ?>
  <section class="quote-block padding-full-top-bottom <?php echo $align_class; ?>">
  
      <?php if(!empty($pol_quote)) { ?>
       <h2><em><?php echo ($pol_quote);?></em></h2>
      <?php } ?>
 
  </section>
<?php } ?>
