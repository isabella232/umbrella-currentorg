<?php
/**
 * Functions modifying the Business Directory Plugin
 *
 * @link https://github.com/INN/umbrella-currentorg/pull/24
 */

/**
 * Add custom form fields to wpbdp_tag taxonomy add/edit pages
 */
function wpbdp_tag_edit_form_fields( $tag ){

	if( $tag ){

		$wpbdp_tag_meta = get_term_meta($tag->term_id);
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
		__( 'Parent Category' ),
		wp_dropdown_categories(
			array(
				'taxonomy'         => 'wpbdp_category',
				'id'               => 'wpbdp_tag_parent_category',
				'name'             => 'wpbdp_tag_parent_category',
				'show_option_none' => __( 'Select category' ),
				'depth'            => 1,
				'echo'			   => false,
				'selected'		   => $wpbdp_tag_parent_category
			)
		),
		__( 'Select the parent category for this tag.' )
	);

}
add_action('wpbdp_tag_add_form_fields', 'wpbdp_tag_edit_form_fields');
add_action('wpbdp_tag_edit_form_fields', 'wpbdp_tag_edit_form_fields');

/**
 * Save custom form fields from wpbdp_tag taxonomy add/edit pages
 */
function wpbdp_tag_form_fields_save( $term_id, $tt_id ) {

    if ( !empty( $_POST['wpbdp_tag_parent_category'] ) ) {

        update_term_meta( $term_id, 'wpbdp_tag_parent_category', 'wpbdp_category--'.$_POST['wpbdp_tag_parent_category'] );

    }

}
add_action( 'created_wpbdp_tag', 'wpbdp_tag_form_fields_save', 10, 2 );
add_action( 'edited_wpbdp_tag', 'wpbdp_tag_form_fields_save', 10, 2 );

/**
 * Modify the wpdb_tag tag cloud to include wpbdp_category--id class
 */
function wpbdp_modify_tag_cloud( $tag_data ) {
	
    return array_map ( 

        function ( $tag ){	

			$term = get_term( $tag['id'] );

			if( $term->taxonomy == 'wpbdp_tag' ){

				$wpbdp_tag_parent_category = get_term_meta( $tag['id'] );
				$wpbdp_tag_parent_category = $wpbdp_tag_parent_category['wpbdp_tag_parent_category'][0];
				$tag['class'] .= ' ' . $wpbdp_tag_parent_category;

			}

			return $tag;
			
		}, (array) $tag_data 
		
    );

}
add_filter( 'wp_generate_tag_cloud_data', 'wpbdp_modify_tag_cloud' );

/**
 * Return all tags in a list in the wpbdp_tag tag cloud
 */
function wpbdp_tag_cloud_show_all_tags( $args ) {
	
	if($args['taxonomy'][0] == 'wpbdp_tag'){

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX && isset( $_POST['action'] ) && $_POST['action'] === 'get-tagcloud') {

			unset( $args['number'] );
			$args['hide_empty'] = 0;

			echo '<script>
				jQuery(document).ready(function(){

					jQuery("#wpbdp_categorychecklist li input").each(function(){
						var wpbdp_category_id = jQuery(this).val();
						if(!jQuery(this).is(":checked")){
							jQuery("#tagsdiv-wpbdp_tag .wpbdp_category--"+wpbdp_category_id).toggleClass("hidden");
						}
					});
				});
			</script>';

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
	
	if( $current_screen->post_type == 'wpbdp_listing' ){

		?>
		<script>
			jQuery(window).load(function() {

				jQuery("body.wp-admin #tagsdiv-wpbdp_tag #link-wpbdp_tag").trigger("click");
				jQuery("body.wp-admin #tagsdiv-wpbdp_tag #link-wpbdp_tag").hide();

			});

			jQuery(document).ready(function(){

				// if a category is selected/deselected, do things
				jQuery("#wpbdp_categorychecklist input").on("click", function(){

					// get id of clicked category
					var wpbdp_category_id = jQuery(this).val();

					// toggle all child tags of this category
					jQuery("#tagsdiv-wpbdp_tag .wpbdp_category--"+wpbdp_category_id).toggleClass("hidden");

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
		</script>
		<style>
			body.wp-admin #tagsdiv-wpbdp_tag #link-wpbdp_tag{visibility:hidden;}
			body.wp-admin #tagsdiv-wpbdp_tag #wpbdp_tag .jaxtag{display:none;} 
			body.wp-admin #tagsdiv-wpbdp_tag #tagcloud-wpbdp_tag.the-tagcloud ul li{display:block;}
			body.wp-admin #tagsdiv-wpbdp_tag #tagcloud-wpbdp_tag.the-tagcloud ul li a{font-size:13px!important;}
		</style>';
		<?php
	}

}
add_action( 'admin_head', 'wpbdp_tag_cloud_custom_css_js' );
