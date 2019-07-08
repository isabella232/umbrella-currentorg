<?php
/**
 * Customized template for listing single view.
 *
 * @package BDP/Templates/Single
 */

// phpcs:disable
?>
<div id="<?php echo $listing_css_id; ?>" class="<?php echo $listing_css_class; ?>">
    <?php 

        // return to directory link
        wpbdp_get_return_link();

    ?>
    <div class="listing-title">
        <h2><?php echo $title; ?></h2>
    </div>
    <?php wpbdp_x_part( 'single_content' ); ?>

</div>
