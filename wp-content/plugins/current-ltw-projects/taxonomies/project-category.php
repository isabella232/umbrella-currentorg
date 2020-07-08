<?php

/**
 * Registers the `ltw_content_categories` taxonomy,
 * for use with 'projects'.
 */
function ltw_content_categories_init() {
	register_taxonomy( 'project-category', array( 'projects' ), array(
		'hierarchical'      => true,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_ui'           => true,
		'show_admin_column' => false,
		'query_var'         => true,
		'rewrite'           => true,
		'capabilities'      => array(
			'manage_terms'  => 'edit_projects',
			'edit_terms'    => 'edit_projects',
			'delete_terms'  => 'edit_projects',
			'assign_terms'  => 'edit_projects',
		),
		'labels'            => array(
			'name'                       => __( 'Content Categories', 'current-ltw-projects' ),
			'singular_name'              => _x( 'Content Category', 'taxonomy general name', 'current-ltw-projects' ),
			'search_items'               => __( 'Search Content Categories', 'current-ltw-projects' ),
			'popular_items'              => __( 'Popular Content Categories', 'current-ltw-projects' ),
			'all_items'                  => __( 'All Content Categories', 'current-ltw-projects' ),
			'parent_item'                => __( 'Parent Content Category', 'current-ltw-projects' ),
			'parent_item_colon'          => __( 'Parent Content Category:', 'current-ltw-projects' ),
			'edit_item'                  => __( 'Edit Content Category', 'current-ltw-projects' ),
			'update_item'                => __( 'Update Content Category', 'current-ltw-projects' ),
			'view_item'                  => __( 'View Content Category', 'current-ltw-projects' ),
			'add_new_item'               => __( 'Add New Content Category', 'current-ltw-projects' ),
			'new_item_name'              => __( 'New Content Category', 'current-ltw-projects' ),
			'separate_items_with_commas' => __( 'Separate Content Categories with commas', 'current-ltw-projects' ),
			'add_or_remove_items'        => __( 'Add or remove Content Categories', 'current-ltw-projects' ),
			'choose_from_most_used'      => __( 'Choose from the most used Content Categories', 'current-ltw-projects' ),
			'not_found'                  => __( 'No Content Category found.', 'current-ltw-projects' ),
			'no_terms'                   => __( 'No Content Category', 'current-ltw-projects' ),
			'menu_name'                  => __( 'Content Categories', 'current-ltw-projects' ),
			'items_list_navigation'      => __( 'Content Categories list navigation', 'current-ltw-projects' ),
			'items_list'                 => __( 'Content Categories list', 'current-ltw-projects' ),
			'most_used'                  => _x( 'Most Used', 'ltw-content-categories', 'current-ltw-projects' ),
			'back_to_items'              => __( '&larr; Back to Content Categories', 'current-ltw-projects' ),
		),
		'show_in_rest'      => true,
		'rest_base'         => 'project-category',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	) );

}
add_action( 'init', 'ltw_content_categories_init' );

/**
 * Sets the post updated messages for the `ltw_content_categories` taxonomy.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `ltw_content_categories` taxonomy.
 */
function ltw_content_categories_updated_messages( $messages ) {

	$messages['project-category'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => __( 'Content Category added.', 'current-ltw-projects' ),
		2 => __( 'Content Category deleted.', 'current-ltw-projects' ),
		3 => __( 'Content Category updated.', 'current-ltw-projects' ),
		4 => __( 'Content Category not added.', 'current-ltw-projects' ),
		5 => __( 'Content Category not updated.', 'current-ltw-projects' ),
		6 => __( 'Content Category deleted.', 'current-ltw-projects' ),
	);

	return $messages;
}
add_filter( 'term_updated_messages', 'ltw_content_categories_updated_messages' );
