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

		// debug code tiem
		printf(
			'<pre><code>%1$s</code></pre>',
			var_export( $terms, true)
		);
	?>
</div>

<?php if ( $listings ): ?>
	<?php echo $listings; ?>
<?php endif; ?>
