<?php
/**
 * Regster the projects post type and associated metadata
 */

/**
 * Registers the `projects` post type.
 */
function projects_init() {
	register_post_type( 'projects', array(
		'labels'                => array(
			'name'                  => __( 'Local That Works Projects', 'current-ltw-projects' ),
			'singular_name'         => __( 'Project', 'current-ltw-projects' ),
			'all_items'             => __( 'All LTW Projects', 'current-ltw-projects' ),
			'archives'              => __( 'LTW Project Archives', 'current-ltw-projects' ),
			'attributes'            => __( 'LTW Project Attributes', 'current-ltw-projects' ),
			'insert_into_item'      => __( 'Insert into Project', 'current-ltw-projects' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Project', 'current-ltw-projects' ),
			'featured_image'        => _x( 'Project Featured Image', 'projects', 'current-ltw-projects' ),
			'set_featured_image'    => _x( 'Set featured image', 'projects', 'current-ltw-projects' ),
			'remove_featured_image' => _x( 'Remove featured image', 'projects', 'current-ltw-projects' ),
			'use_featured_image'    => _x( 'Use as featured image', 'projects', 'current-ltw-projects' ),
			'filter_items_list'     => __( 'Filter Projects list', 'current-ltw-projects' ),
			'items_list_navigation' => __( 'Projects list navigation', 'current-ltw-projects' ),
			'items_list'            => __( 'Projects list', 'current-ltw-projects' ),
			'new_item'              => __( 'New Project', 'current-ltw-projects' ),
			'add_new'               => __( 'Add New', 'current-ltw-projects' ),
			'add_new_item'          => __( 'Add New Project', 'current-ltw-projects' ),
			'edit_item'             => __( 'Edit Project', 'current-ltw-projects' ),
			'view_item'             => __( 'View Project', 'current-ltw-projects' ),
			'view_items'            => __( 'View LTW Projects', 'current-ltw-projects' ),
			'search_items'          => __( 'Search LTW Projects', 'current-ltw-projects' ),
			'not_found'             => __( 'No Projects found', 'current-ltw-projects' ),
			'not_found_in_trash'    => __( 'No Projects found in trash', 'current-ltw-projects' ),
			'parent_item_colon'     => __( 'Parent Project:', 'current-ltw-projects' ),
			'menu_name'             => __( 'Projects', 'current-ltw-projects' ),
		),
		'public'                => true,
		'hierarchical'          => false,
		'show_ui'               => true,
		'show_in_nav_menus'     => true,
		'supports'              => array( 'title', 'editor' ),
		'has_archive'           => true,
		'rewrite'               => array( 'slug' => 'local-that-works' ),
		'query_var'             => true,
		'menu_position'         => null,
		'menu_icon'             => 'dashicons-awards',
		'show_in_rest'          => true,
		'rest_base'             => 'projects',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'supports'              => array(
			'title',
			'editor',
			// 'author',
			'thumbnail',
			// 'excerpt',
			'custom-fields',
			// 'comments',
			// 'revisions',
			// 'page-attributes',
			// 'post-formats',
		),
	) );

}
add_action( 'init', 'projects_init' );

/**
 * Sets the post updated messages for the `projects` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `projects` post type.
 */
function projects_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['projects'] = array(
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Project updated. <a target="_blank" href="%s">View Project</a>', 'current-ltw-projects' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'current-ltw-projects' ),
		3  => __( 'Custom field deleted.', 'current-ltw-projects' ),
		4  => __( 'Project updated.', 'current-ltw-projects' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Project restored to revision from %s', 'current-ltw-projects' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Project published. <a href="%s">View Project</a>', 'current-ltw-projects' ), esc_url( $permalink ) ),
		7  => __( 'Project saved.', 'current-ltw-projects' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Project submitted. <a target="_blank" href="%s">Preview Project</a>', 'current-ltw-projects' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Project scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Project</a>', 'current-ltw-projects' ),
		date_i18n( __( 'M j, Y @ G:i', 'current-ltw-projects' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Project draft updated. <a target="_blank" href="%s">Preview Project</a>', 'current-ltw-projects' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'projects_updated_messages' );

/**
 * Register the custom post meta for Local That Works projects
 *
 * @link https://developer.wordpress.org/reference/functions/register_meta/
 * @link https://developer.wordpress.org/block-editor/tutorials/plugin-sidebar-0/
 */
function projects_register_post_meta() {
	register_post_meta(
		'projects',
		'project-contact-name',
		array(
			'object_subtype' => 'post',
			'type' => 'string',
			'description' => 'The contact human for this project.',
			'single' => true,
			'sanitize_callback' => 'sanitize_text_field',
			// 'auth_callback' => .... I don't know the answer to this question.
			'show_in_rest' => true,
		)
	);
	register_post_meta(
		'projects',
		'project-contact-email',
		array(
			'object_subtype' => 'post',
			'type' => 'string',
			'description' => 'The contact email for this project.',
			'single' => true,
			'sanitize_callback' => 'sanitize_text_field',
			// 'auth_callback' => .... I don't know the answer to this question.
			'show_in_rest' => true,
		)
	);
	register_post_meta(
		'projects',
		'project-organization',
		array(
			'object_subtype' => 'post',
			'type' => 'string',
			'description' => 'The organization responsible for this project.',
			'single' => true,
			'sanitize_callback' => 'sanitize_text_field',
			// 'auth_callback' => .... I don't know the answer to this question.
			'show_in_rest' => true,
		)
	);
	register_post_meta(
		'projects',
		'project-video',
		array(
			'object_subtype' => 'post',
			'type' => 'string',
			'description' => 'Link to video URL for this project',
			'single' => true,
			'sanitize_callback' => 'esc_url_raw',
			// 'auth_callback' => .... I don't know the answer to this question.
			'show_in_rest' => true,
		)
	);
}
add_action( 'init', 'projects_register_post_meta' );

/**
 * Add the meta boxes for the projects meta fields 
 *
 */
function projects_add_meta_box() {
	add_meta_box(
		'current-ltw-project',
		__( 'Project Metadata', 'current-ltw-projects' ),
		'projects_meta_box',
		'projects', // post type
		'advanced',
		'high',
		array(
			'__block_editor_compatible_meta_box' => true,
			'__back_compat_meta_box'             => false,
		)
	);
}
add_action( 'add_meta_boxes', 'projects_add_meta_box' );

/*
 * Save callback for the project meta fields
 */


/**
 * The meta box for the project meta fields
 */
function projects_meta_box( $post ) {
	?>
		<h1>hola</h1>
	<?php
	// project-contact-name - text
	// project-contact-email - email
	// project-organization - text
	// project-video - url
}
