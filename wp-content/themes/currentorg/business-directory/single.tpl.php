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
        
        echo wpbdp_render(
            'parts/listing-buttons', array(
                'listing_id' => $listing_id,
                'view'       => 'single',
            ), false
        );

        echo wpbdp_main_links( array( 'create' ) );

    ?>
    <div class="listing-title">
        <h2><?php echo $title; ?></h2>
    </div>
    <?php wpbdp_x_part( 'single_content' ); ?>

</div>
