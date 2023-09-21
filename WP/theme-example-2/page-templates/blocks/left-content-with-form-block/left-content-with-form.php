<?php
/**
 * Block Name: Left Content with Form Block
 * This is the template that displays the Left Content with Form Block
 */
?>
<?php 
$pol_left_editor = get_field('pol_left_editor');
$mktoforms_id = get_field('mktoforms_id');
$munchkinid = get_field('munchkinid');
$pol_left_background_color = get_field('pol_left_background_color');
$align_class = $block['align'] ? 'align' . $block['align'] : ''; 
?>
<?php if(!empty($pol_left_editor) || !empty($mktoforms_id) || !empty($munchkinid)) { ?>
  <section class="left-content-form-block padding-full-top-bottom <?php echo $align_class; ?>" style="background-color:<?php echo $pol_left_background_color;?>">
    <div class="container">
      <div class="row <?php echo $pol5_select_section;?>">
        <div class="col-lg-6 col-md-6">
          <div class="content-left">
         <?php if(!empty($pol_left_editor)) { ?>
           <?php echo $pol_left_editor;?>
         <?php } ?>
       </div>
     </div>

       <div class="col-lg-6 col-md-6">
        <?php if (!empty($mktoforms_id) || !empty($munchkinid)) { ?>
          <script src="//go.politico.com/js/forms2/js/forms2.min.js"></script>
          <form id="mktoForm_<?php echo $mktoforms_id;?>" class="form-inline custom-contact-form"></form><script>MktoForms2.loadForm("//go.politico.com", "<?php echo $munchkinid;?>", <?php echo $mktoforms_id;?>);</script>
        <?php } ?>
     </div>
     
   </div>
 </div>
</section>
<?php } ?>
