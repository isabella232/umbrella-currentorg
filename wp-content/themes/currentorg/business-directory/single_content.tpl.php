<?php
/**
 * Listing detail view rendering template
 *
 * @package BDP/Templates/Single Content
 */

// phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
?>

<div class="listing-details cf">
    
    <?php 
        foreach ( $fields->not( 'social' ) as $field ){
            if($field->id == 2){
                
                echo '<div class="listing-categories">';
                $listing_categories = $field->raw;
                
                foreach( $listing_categories as $index => $category ){

                    $category = get_term( $category );

                    printf(
                        '<a href="%2$s">%1$s</a>',
                        $category->name,
                        get_term_link( $category )
                    );
    
                    if( $index != array_key_last( $listing_categories ) ){
                        echo '<span> | </span>';
                    }

                }
                echo '</div>';

            } else {
                echo $field->html;
            }
        }
    ?>

    <?php if ( $images->extra ) : ?>
    <div class="extra-images">
        <ul>
            <?php foreach ( $images->extra as $img ) : ?>
                <li><?php echo $img->html; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <div class="listing-contact-details">
        <h3>Get In Touch</h3>
        <?php 

            $contact_name = wpbdp_get_form_field( 10 );
            $contact_email = wpbdp_get_form_field( 8 );
            $contact_phone = wpbdp_get_form_field( 6 );
            $contact_fax = wpbdp_get_form_field( 7 );
            $contact_website = wpbdp_get_form_field( 5 );

            if( $contact_name->value( $listing_id ) ){

                printf(
                    '<div class="contact-name">
                        <h5>
                            %1$s
                        </h5>
                    </div>',
                    $contact_name->value( $listing_id )
                );

            }

            if( $contact_email->value( $listing_id ) ){

                printf(
                    '<div class="listing-contact-detail contact-email">
                        <span class="dashicons dashicons-email"></span>
                        <a href="mailto:%1$s">%1$s</a>
                    </div>',
                    $contact_email->value( $listing_id )
                );

            }

            if( $contact_phone->value( $listing_id ) ){

                printf(
                    '<div class="listing-contact-detail contact-phone">
                        <span class="dashicons dashicons-phone"></span>
                        %1$s
                    </div>',
                    $contact_phone->value( $listing_id )
                );

            }

            if( $contact_fax->value( $listing_id ) ){

                printf(
                    '<div class="listing-contact-detail contact-fax">
                        <span class="dashicons dashicons-welcome-write-blog"></span>
                        %1$s
                    </div>',
                    $contact_fax->value( $listing_id )
                );

            }

            if( $contact_website->value( $listing_id ) ){

                printf(
                    '<div class="listing-contact-detail contact-website">
                        <span class="dashicons dashicons-admin-site"></span>
                        <a href="%1$s" target="_blank">%1$s</a>
                    </div>',
                    $contact_website->value( $listing_id )[0]
                );

            }

        ?>
    </div>

    <?php $social_fields = $fields->filter( 'social' ); ?>
    <?php if ( $social_fields ) : ?>
        <div class="social-fields cf"><?php echo $social_fields->html; ?></div>
    <?php endif; ?>
</div>