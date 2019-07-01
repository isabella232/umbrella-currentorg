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

        // Formerly a call to wpbdp_main_links( array( 'create' ) ),
        // but we didn't like the button text
        // so we copied all this over
        echo '<div class="wpbdp-main-links-container" data-breakpoints=\'{"tiny": [0,360], "small": [360,560], "medium": [560,710], "large": [710,999999]}\' data-breakpoints-class-prefix="wpbdp-main-links">';
            echo '<div class="wpbdp-main-links">';
                printf(
                    '<input id="wpbdp-bar-submit-listing-button" type="button" value="%s" onclick="window.location.href = \'%s\'" class="button wpbdp-button" />',
                    __( 'Create a Listing', 'WPBDM' ),
                    wpbdp_url( 'submit_listing' )
                );
            echo '</div>';
        echo '</div>';

    ?>
    <div class="listing-title">
        <h2><?php echo $title; ?></h2>
    </div>
    <?php wpbdp_x_part( 'single_content' ); ?>

</div>
