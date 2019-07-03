<?php
/**
 * Customized listing detail view rendering template
 *
 * @package BDP/Templates/Single Content
 */
?>

<div class="listing-details cf">

    <?php
        // This loop handles the normal listing fields in the order they are configured to be output
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

                    $number_of_categories = count( $listing_categories );

                    if( $index != ( $number_of_categories - 1 ) ){
                        echo '<span> | </span>';
                    }

                }
                echo '</div>';

            } else {
                echo $field->html;
            }
        }
    ?>

    <div class="listing-contact-details">
        <h3>Get In Touch</h3>
        <?php
            // Specific contact fields
            $contact_email = wpbdp_get_form_field( 8 );
            $contact_phone = wpbdp_get_form_field( 6 );
            $contact_website = wpbdp_get_form_field( 5 );

            if ( is_object( $contact_email ) && $contact_email->value( $listing_id ) ){

                printf(
                    '<div class="listing-contact-detail contact-email">
                        <span class="dashicons dashicons-email"></span>
                        <a href="mailto:%1$s">%1$s</a>
                    </div>',
                    $contact_email->value( $listing_id )
                );

            }

            if ( is_object( $contact_phone) && $contact_phone->value( $listing_id ) ){

                printf(
                    '<div class="listing-contact-detail contact-phone">
                        <span class="dashicons dashicons-phone"></span>
                        %1$s
                    </div>',
                    $contact_phone->value( $listing_id )
                );

            }

            if ( is_object( $contact_phone ) && $contact_website->value( $listing_id ) ){

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

	<?php if ( $images->extra ) : ?>
		<div class="extra-images">
			<ul>
				<?php foreach ( $images->extra as $img ) : ?>
					<li><?php echo $img->html; ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>


	<?php
		$social_fields = $fields->filter( 'social' );
		if ( $social_fields ) {
			printf(
				'<div class="social-fields cf">%1$s</div>',
				$social_fields->html
			);
		}
	?>
</div>
