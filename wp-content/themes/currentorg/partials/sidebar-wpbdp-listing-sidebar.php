<div class="listing-sidebar">

    <?php

        $listing_id = $wp_query->query_vars['_wpbdp_listing'];
        $listing_logo = wpbdp_get_form_field( 11 );

        if ( is_object( $listing_logo ) && $listing_logo->value( $listing_id ) ){

            printf(
                '<div class="listing-main-image">
                    <img src="%1$s">
                </div>',
                $listing_logo->value( $listing_id )
            );

        }

    ?>
    <hr/>
    <div class="listing-services">
        <h3>Services</h3>
        <hr/>
        <?php

            $listing_id = $wp_query->query_vars['_wpbdp_listing'];
            $wpbdp_listing_tags = wp_get_post_terms( $listing_id, 'wpbdp_tag' );

        ?>
        <ul class="listing-services-list">
            <?php
            foreach( $wpbdp_listing_tags as $tag ){

                printf(
                    '<li>
                        <a href="%2$s">%1$s</a>
                    </li>',
                    $tag->name,
                    get_term_link( $tag )
                );

            }
            ?>
        </ul>
    </div>

    <?php

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
</div>
