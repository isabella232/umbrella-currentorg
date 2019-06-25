<?php
/**
 * Functions modifying the Business Directory Plugin
 *
 * @link https://github.com/INN/umbrella-currentorg/pull/24
 */

/**
 * Add custom form fields to wpbdp_tag taxonomy add/edit pages
 *
 * @param Mixed $tag The term being edited
 */
function wpbdp_tag_edit_form_fields( $tag ) {

	if ( is_object( $tag ) ){

		$wpbdp_tag_meta = get_term_meta( $tag->term_id );
		$wpbdp_tag_parent_category = $wpbdp_tag_meta['wpbdp_tag_parent_category'][0];
		$wpbdp_tag_parent_category = str_replace('wpbdp_category--', '', $wpbdp_tag_parent_category);

	} else {

		$wpbdp_tag_parent_category = '';

	}

	printf(
		'<tr class="form-field">
			<th scope="row" valign="top">
				<label for="wpbdp_tag_parent_category">%1$s</label>
			</th>
			<td>
				%2$s
				<p class="description">%3$s</p>
			</td>
		</tr>',
		esc_html__( 'Parent Category', 'currentorg' ),
		wp_dropdown_categories(
			array(
				'taxonomy'         => 'wpbdp_category',
				'id'               => 'wpbdp_tag_parent_category',
				'name'             => 'wpbdp_tag_parent_category',
				'show_option_none' => __( 'Select category' ),
				'depth'            => 1,
				'echo'             => false,
				'selected'         => $wpbdp_tag_parent_category,
			)
		),
		__( 'Select the parent category for this tag.', 'currentorg' )
	);

	wp_nonce_field( 'wpbdp_tag_parent_category_update', 'wpbdp_tag_parent_category_nonce' );

}
add_action( 'wpbdp_tag_add_form_fields', 'wpbdp_tag_edit_form_fields' );
add_action( 'wpbdp_tag_edit_form_fields', 'wpbdp_tag_edit_form_fields' );

/**
 * Save custom form fields from wpbdp_tag taxonomy add/edit pages
 *
 * @param int $term_id
 * @param int $tt_id
 */
function wpbdp_tag_form_fields_save( $term_id, $tt_id ) {

	if( isset( $_POST['wpbdp_tag_parent_category_nonce'] ) && wp_verify_nonce( $_POST['wpbdp_tag_parent_category_nonce'], 'wpbdp_tag_parent_category_update' ) ) {

		if ( ! empty( $_POST['wpbdp_tag_parent_category'] ) ) {

			update_term_meta( $term_id, 'wpbdp_tag_parent_category', 'wpbdp_category--' . $_POST['wpbdp_tag_parent_category'] );

		}

	}

}
add_action( 'created_wpbdp_tag', 'wpbdp_tag_form_fields_save', 10, 2 );
add_action( 'edited_wpbdp_tag', 'wpbdp_tag_form_fields_save', 10, 2 );

/**
 * Modify the wpdb_tag tag cloud to include wpbdp_category--id class
 *
 * @param Array $tag_data
 * @return Array the new tag data
 */
function wpbdp_modify_tag_cloud( $tag_data ) {
	return array_map(
		function ( $tag ) {
			$term = get_term_by( 'slug', $tag[ 'slug' ], 'wpbdp_tag' );

			if ( 'wpbdp_tag' === $term->taxonomy ) {

				$wpbdp_tag_parent_category = get_term_meta( $term->term_id );
				$wpbdp_tag_parent_category = $wpbdp_tag_parent_category['wpbdp_tag_parent_category'][0];
				$tag['class'] .= ' ' . $wpbdp_tag_parent_category;

			}

			return $tag;
		},
		(array) $tag_data
	);
}
add_filter( 'wp_generate_tag_cloud_data', 'wpbdp_modify_tag_cloud' );

/**
 * Return all tags in a list in the wpbdp_tag tag cloud.
 *
 * Runs during an AJAX call to get the tags in the list.
 *
 * @param Array $args
 */
function wpbdp_tag_cloud_show_all_tags( $args ) {
	
	if( in_array( 'wpbdp_tag', $args['taxonomy'] ) ){

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX && isset( $_POST['action'] ) && $_POST['action'] === 'get-tagcloud') {

			unset( $args['number'] );
			$args['hide_empty'] = 0;

		}

	}

	return $args;
}
add_filter( 'get_terms_args', 'wpbdp_tag_cloud_show_all_tags' );

/**
 * Show all existing tags inside of the wpbdp_tag tag cloud
 */
function wpbdp_tag_cloud_custom_css_js(){

	global $current_screen;

	if( 'wpbdp_listing' === $current_screen->post_type ) {
		?>
		<script type="text/javascript">
			jQuery(window).load(function() {

				jQuery("body.wp-admin #tagsdiv-wpbdp_tag #link-wpbdp_tag").trigger("click");
				jQuery("body.wp-admin #tagsdiv-wpbdp_tag #link-wpbdp_tag").hide();

			});

			jQuery(document).ready(function(){

				jQuery('#tagsdiv-wpbdp_tag .inside').prepend('<label>Selected Tags:</label>');
				jQuery('<label>Available Tags:</label>').insertAfter('#tagsdiv-wpbdp_tag .tagsdiv');

				// if a category is selected/deselected, do things
				jQuery("#wpbdp_categorychecklist input").on("click", function(){

					// get id of clicked category
					var wpbdp_category_id = jQuery(this).val();

					if(jQuery(this).is(":checked")){
						// show all child tags of this category
						jQuery("#tagsdiv-wpbdp_tag .wpbdp_category--"+wpbdp_category_id).removeClass("hidden");
					} else {
						// hide all child tags of this category
						jQuery("#tagsdiv-wpbdp_tag .wpbdp_category--"+wpbdp_category_id).addClass("hidden");
					}

					// if this categoy is unchecked, we need to remove all of its child tags that were selected
					if(!jQuery(this).is(":checked")){

						// grab text name of child tag
						var wpbdp_parent_category_child_tag = jQuery("#tagsdiv-wpbdp_tag .wpbdp_category--"+wpbdp_category_id).text();

						// loop through all selected tags and remove if it matches the name of one with an unchecked parent category
						jQuery(".tagchecklist li").each(function(){
							if(jQuery(this).find(".screen-reader-text").text().replace("Remove term: ", "") == wpbdp_parent_category_child_tag){
								jQuery(this).find("button").click();
							}
						});
					}

				});

			});

			jQuery(document).ajaxStop(function() {

				// loop through all selected categories and hide any tags without active parent categories
				jQuery("#wpbdp_categorychecklist li input").each(function(){

					var wpbdp_category_id = jQuery(this).val();

					if(!jQuery(this).is(":checked")){
						jQuery("#tagsdiv-wpbdp_tag .wpbdp_category--"+wpbdp_category_id).addClass("hidden");
					}
					
				});

			});

		</script>
		<style>
			/* hide the show/hide button */
			body.wp-admin #tagsdiv-wpbdp_tag #link-wpbdp_tag{visibility:hidden;}
			body.wp-admin #tagsdiv-wpbdp_tag #wpbdp_tag .jaxtag{display:none;} 
			/* make the tag cloud not a tag cloud */
			body.wp-admin #tagsdiv-wpbdp_tag #tagcloud-wpbdp_tag.the-tagcloud ul li{display:block;margin-bottom:0;}
			body.wp-admin #tagsdiv-wpbdp_tag #tagcloud-wpbdp_tag.the-tagcloud ul li a{font-size:13px!important;}
		</style>
		<?php
	}

}
add_action( 'admin_head', 'wpbdp_tag_cloud_custom_css_js' );
