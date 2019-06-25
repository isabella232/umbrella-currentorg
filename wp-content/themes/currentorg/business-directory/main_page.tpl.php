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

		$categories = _wpbdp_list_categories_walk( 0, 0, $args );

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

		// debug code tiem
		printf(
			'<pre><code>%1$s</code></pre>',
			var_export( $categories, true)
		);
	?>
</div>

<?php if ( $listings ): ?>
	<?php echo $listings; ?>
<?php endif; ?>
