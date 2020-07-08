<?php

/**
 * Registers the `project_org_type` taxonomy,
 * for use with 'projects'.
 */
function project_org_type_init() {
	register_taxonomy( 'project-org-type', array( 'projects' ), array(
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
			'name'                       => __( 'Organization Types', 'current-ltw-projects' ),
			'singular_name'              => _x( 'Organization Type', 'taxonomy general name', 'current-ltw-projects' ),
			'search_items'               => __( 'Search Organization Types', 'current-ltw-projects' ),
			'popular_items'              => __( 'Popular Organization Types', 'current-ltw-projects' ),
			'all_items'                  => __( 'All Organization Types', 'current-ltw-projects' ),
			'parent_item'                => __( 'Parent Organization Type', 'current-ltw-projects' ),
			'parent_item_colon'          => __( 'Parent Organization Type:', 'current-ltw-projects' ),
			'edit_item'                  => __( 'Edit Organization Type', 'current-ltw-projects' ),
			'update_item'                => __( 'Update Organization Type', 'current-ltw-projects' ),
			'view_item'                  => __( 'View Organization Type', 'current-ltw-projects' ),
			'add_new_item'               => __( 'Add New Organization Type', 'current-ltw-projects' ),
			'new_item_name'              => __( 'New Organization Type', 'current-ltw-projects' ),
			'separate_items_with_commas' => __( 'Separate Organization Types with commas', 'current-ltw-projects' ),
			'add_or_remove_items'        => __( 'Add or remove Organization Types', 'current-ltw-projects' ),
			'choose_from_most_used'      => __( 'Choose from the most used Organization Types', 'current-ltw-projects' ),
			'not_found'                  => __( 'No Organization Types found.', 'current-ltw-projects' ),
			'no_terms'                   => __( 'No Organization Types', 'current-ltw-projects' ),
			'menu_name'                  => __( 'Organization Types', 'current-ltw-projects' ),
			'items_list_navigation'      => __( 'Organization Types list navigation', 'current-ltw-projects' ),
			'items_list'                 => __( 'Organization Types list', 'current-ltw-projects' ),
			'most_used'                  => _x( 'Most Used', 'project-org-type', 'current-ltw-projects' ),
			'back_to_items'              => __( '&larr; Back to Organization Types', 'current-ltw-projects' ),
		),
		'show_in_rest'      => true,
		'rest_base'         => 'project-org-type',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	) );

}
add_action( 'init', 'project_org_type_init' );

/**
 * Sets the post updated messages for the `project_org_type` taxonomy.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `project_org_type` taxonomy.
 */
function project_org_type_updated_messages( $messages ) {

	$messages['project-org-type'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => __( 'Organization Type added.', 'current-ltw-projects' ),
		2 => __( 'Organization Type deleted.', 'current-ltw-projects' ),
		3 => __( 'Organization Type updated.', 'current-ltw-projects' ),
		4 => __( 'Organization Type not added.', 'current-ltw-projects' ),
		5 => __( 'Organization Type not updated.', 'current-ltw-projects' ),
		6 => __( 'Organization Types deleted.', 'current-ltw-projects' ),
	);

	return $messages;
}
add_filter( 'term_updated_messages', 'project_org_type_updated_messages' );
