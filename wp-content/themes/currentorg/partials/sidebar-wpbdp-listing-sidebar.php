<div class="listing-sidebar">

    <?php

        $listing_id = $wp_query->query_vars['_wpbdp_listing'];

        $wpbdp_listings_api = wpbdp_listings_api();
        $listing_thumbnail_id = wpbdp_listings_api()->get_thumbnail_id( $listing_id );
        $listing_thumbnail_url = wp_get_attachment_url( $listing_thumbnail_id );
        
        if ( $listing_thumbnail_id && $listing_thumbnail_url ){
            printf(
                '<div class="listing-main-image">
                    <img src="%1$s">
                </div>',
                $listing_thumbnail_url
            );
        }

    ?>
    <hr/>
    <div class="listing-services">
        <h3>Services</h3>
        <hr/>
        <?php 

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
</div>