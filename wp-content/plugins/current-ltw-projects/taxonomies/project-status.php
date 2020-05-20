<?php

/**
 * Registers the `ltw_status` taxonomy,
 * for use with 'projects'.
 */
function ltw_status_init() {
	register_taxonomy( 'project-status', array( 'projects' ), array(
		'hierarchical'      => true,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_ui'           => true,
		'show_admin_column' => false,
		'query_var'         => true,
		'rewrite'           => true,
		'capabilities'      => array(
			'manage_terms'  => 'edit_posts',
			'edit_terms'    => 'edit_posts',
			'delete_terms'  => 'edit_posts',
			'assign_terms'  => 'edit_posts',
		),
		'labels'            => array(
			'name'                       => __( 'Status', 'current-ltw-projects' ),
			'singular_name'              => _x( 'Status', 'taxonomy general name', 'current-ltw-projects' ),
			'search_items'               => __( 'Search Statuses', 'current-ltw-projects' ),
			'popular_items'              => __( 'Popular Statuses', 'current-ltw-projects' ),
			'all_items'                  => __( 'All Statuses', 'current-ltw-projects' ),
			'parent_item'                => __( 'Parent Status', 'current-ltw-projects' ),
			'parent_item_colon'          => __( 'Parent Status:', 'current-ltw-projects' ),
			'edit_item'                  => __( 'Edit Status', 'current-ltw-projects' ),
			'update_item'                => __( 'Update Status', 'current-ltw-projects' ),
			'view_item'                  => __( 'View Status', 'current-ltw-projects' ),
			'add_new_item'               => __( 'Add New Status', 'current-ltw-projects' ),
			'new_item_name'              => __( 'New Status', 'current-ltw-projects' ),
			'separate_items_with_commas' => __( 'Separate Statuses with commas', 'current-ltw-projects' ),
			'add_or_remove_items'        => __( 'Add or remove Statuses', 'current-ltw-projects' ),
			'choose_from_most_used'      => __( 'Choose from the most used Statuses', 'current-ltw-projects' ),
			'not_found'                  => __( 'No Status found.', 'current-ltw-projects' ),
			'no_terms'                   => __( 'No Status', 'current-ltw-projects' ),
			'menu_name'                  => __( 'Statuses', 'current-ltw-projects' ),
			'items_list_navigation'      => __( 'Statuses list navigation', 'current-ltw-projects' ),
			'items_list'                 => __( 'Statuses list', 'current-ltw-projects' ),
			'most_used'                  => _x( 'Most Used', 'ltw-status', 'current-ltw-projects' ),
			'back_to_items'              => __( '&larr; Back to Statuses', 'current-ltw-projects' ),
		),
		'show_in_rest'      => true,
		'rest_base'         => 'project-status',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	) );

}
add_action( 'init', 'ltw_status_init' );

/**
 * Sets the post updated messages for the `ltw_status` taxonomy.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `ltw_status` taxonomy.
 */
function ltw_status_updated_messages( $messages ) {

	$messages['project-status'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => __( 'Status added.', 'current-ltw-projects' ),
		2 => __( 'Status deleted.', 'current-ltw-projects' ),
		3 => __( 'Status updated.', 'current-ltw-projects' ),
		4 => __( 'Status not added.', 'current-ltw-projects' ),
		5 => __( 'Status not updated.', 'current-ltw-projects' ),
		6 => __( 'Status deleted.', 'current-ltw-projects' ),
	);

	return $messages;
}
add_filter( 'term_updated_messages', 'ltw_status_updated_messages' );
