<?php
/**
 * Block Name: accordion-module
 *
 * This is the template that displays the feature module.
 */

// create id attribute for specific styling
$id = 'accordion-module-' . $block['id'];

$enable__disable = get_field('enable__disable');
$blurb = get_field('blurb');
$button = get_field('button');

if($enable__disable): 
  
?>
<section class="section ctafooter--section bgcolor-gray">
    <div class="container">
        <div class="ctafooter">
            <h2 class="heading"><?php echo $blurb; ?></h2>
            <?php if($button): ?>
            <a href="<?php echo $button['url']?>" class="btn btn-purple"><?php echo $button['title']?></a>
            <?php endif; ?>
        </div>
    </div>
</section>


<?php
endif;