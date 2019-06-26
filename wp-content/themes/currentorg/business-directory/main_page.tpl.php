<div id="wpbdp-categories">
	<?php
		/**
		 * The following copies code from the function wpbdp_directory_categories()
		 */
		$args = apply_filters(
			'wpbdp_main_categories_args',
			array(
				'hide_empty'  => wpbdp_get_option( 'hide-empty-categories' ),
				'parent_only' => wpbdp_get_option( 'show-only-parent-categories' ),
			)
		);

		/**
		 * The following copies code from the function wpbdp_list_categories()
		 */
		$args = wp_parse_args(
			$args, array(
				'parent'       => null,
				'echo'         => false,
				'orderby'      => wpbdp_get_option( 'categories-order-by' ),
				'order'        => wpbdp_get_option( 'categories-sort' ),
				'show_count'   => wpbdp_get_option( 'show-category-post-count' ),
				'hide_empty'   => false,
				'parent_only'  => false,
				'parent'       => 0,
				'no_items_msg' => _x( 'No listing categories found.', 'templates', 'WPBDM' ),
			)
		);

		/**
		 * The following copies code from the function _wpbdp_list_categories_walk
		 */

		$term_ids = get_terms(
			WPBDP_CATEGORY_TAX,
			array(
				'orderby'    => $args['orderby'],
				'order'      => $args['order'],
				'hide_empty' => false,
				'pad_counts' => false,
				'parent'     => is_object( $args['parent'] ) ? $args['parent']->term_id : intval( $args['parent'] ),
				'fields'     => 'ids',
			)
		);

		$term_ids = apply_filters( 'wpbdp_category_terms_order', $term_ids );

		$terms = array(); // Now we're cooking with Crisco!

		foreach ( $term_ids as $term_id ) {
			$t = get_term( $term_id, WPBDP_CATEGORY_TAX );
			// 'pad_counts' doesn't work because of WP bug #15626 (see http://core.trac.wordpress.org/ticket/15626).
			// we need a workaround until the bug is fixed.
			_wpbdp_padded_count( $t );

			$terms[] = $t;
		}

		// filter empty terms
		if ( $args['hide_empty'] ) {
			$terms = array_filter( $terms, function( $x ) {
				return $x->count > 0;
			} );
		}

		// At this point $terms is full of WP_Term objects for the terms on this page.
		// And now is the point where this code deviates from WPBDP's code to render our own templates.

		foreach ( $terms as $term ) {
			?>
				<div class="cat-item cat-item-<?php esc_attr_e( $term->term_id ); ?>">
					<?php
						// this depends on Largo's term meta shims and term meta featured images
						if ( function_exists( 'largo_get_term_meta_post' ) ) {
							$thumbnail_post = largo_get_term_meta_post( WPBDP_CATEGORY_TAX, $term->term_id );
							echo get_the_post_thumbnail( $thumbnail_post );
						}

						printf(
							'<h2>%1$s</h2>',
							wp_kses_post( $term->name, true)
						);

						// this is the permissions level that the plugin uses. &shrug;.
						if ( current_user_can( 'administrator' ) ) {
							printf(
								'<a href="%1$s" class="edit-category-link">%2$s</a>',
								get_edit_term_link( $term->term_id, WPBDP_CATEGORY_TAX, WPBDP_POST_TYPE ),
								__( 'Edit Listing Category', 'currentorg' )
							);
						}


						printf(
							'<p class="category-description">%1$s</p>',
							wp_kses_post( apply_filters( 'category_description', $term->description, $term ), true)
						);

						printf(
							'<a class="listing-link" href="%1$s">%2$s</a>',
							esc_attr( apply_filters( 'wpbdp_categories_term_link', esc_url( get_term_link( $term ) ) ) ),
							sprintf(
								// translators: %1$s is a whole number
								_n(
									'<b>%1$s</b> listing in category',
									'<b>%1$s</b> listings in category',
									$term->count,
									'currentorg'
								),
								wp_kses_post( $term->count, true)
							)
						);
					?>
				</div>
			<?php
		}

	?>
</div>

<?php
	if ( $listings ) {
		echo $listings;
	}
