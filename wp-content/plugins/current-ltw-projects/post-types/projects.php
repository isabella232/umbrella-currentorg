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
		'supports'              => array( 'title', 'editor', 'excerpt' ),
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
			'excerpt',
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
 * canon source for metabox information
 *
 * Returns an array of arrays, each array containing arguments
 * for register_post_meta in a form that can be passed
 * through call_user_func_array.
 *
 * Additionally, within the array argument, this function specifies
 * some private parameters for our use:
 * - 
 *
 * @return Array 
 * @see call_user_func_array
 * @see projects_register_post_meta
 * @link https://developer.wordpress.org/reference/functions/register_meta/ for required params
 */
function projects_post_meta_items() {
	return array(
		array(
			'post',
			'project-submitter-name',
			array(
				'object_subtype' => 'projects',
				'type' => 'string',
				'description' => esc_html__('The name of the person who submitted this project. Kept private.', 'currentorg' ),
				'single' => true,
				'sanitize_callback' => 'sanitize_text_field',
				// 'auth_callback' => .... I don't know the answer to this question.
				'show_in_rest' => true,

				// now for our private arguments
				'_projects_input_type' => 'text', // HTML input type
			)
		),
		array(
			'post',
			'project-submitter-email',
			array(
				'object_subtype' => 'projects',
				'type' => 'string',
				'description' => esc_html__('The email address of the person who submitted this project. Kept private.', 'currentorg' ),
				'single' => true,
				'sanitize_callback' => 'sanitize_text_field',
				// 'auth_callback' => .... I don't know the answer to this question.
				'show_in_rest' => true,

				// now for our private arguments
				'_projects_input_type' => 'text', // HTML input type
			)
		),
		array(
			'post',
			'project-organization',
			array(
				'object_subtype' => 'projects',
				'type' => 'string',
				'description' => esc_html__( 'The organization responsible for this project.', 'currentorg' ),
				'single' => true,
				'sanitize_callback' => 'sanitize_text_field',
				// 'auth_callback' => .... I don't know the answer to this question.
				'show_in_rest' => true,
				'_projects_input_type' => 'text',
			)
		),
		array(
			'post',
			'project-city',
			array(
				'object_subtype' => 'projects',
				'type' => 'string',
				'description' => esc_html__('The city where this organization is located.', 'currentorg' ),
				'single' => true,
				'sanitize_callback' => 'sanitize_text_field',
				// 'auth_callback' => .... I don't know the answer to this question.
				'show_in_rest' => true,

				// now for our private arguments
				'_projects_input_type' => 'text', // HTML input type
			)
		),
		array(
			'post',
			'project-state',
			array(
				'object_subtype' => 'projects',
				'type' => 'string',
				'description' => esc_html__('The state or territory where this organization is located.', 'currentorg' ),
				'single' => true,
				'sanitize_callback' => 'sanitize_text_field',
				// 'auth_callback' => .... I don't know the answer to this question.
				'show_in_rest' => true,

				// now for our private arguments
				'_projects_input_type' => 'text', // HTML input type
			)
		),
		array(
			'post',
			'project-contact-name',
			array(
				'object_subtype' => 'projects',
				'type' => 'string',
				'description' => esc_html__('The public-facing human point-of-contact for this project.', 'currentorg' ),
				'single' => true,
				'sanitize_callback' => 'sanitize_text_field',
				// 'auth_callback' => .... I don't know the answer to this question.
				'show_in_rest' => true,

				// now for our private arguments
				'_projects_input_type' => 'text', // HTML input type
			)
		),
		array(
			'post',
			'project-contact-email',
			array(
				'object_subtype' => 'projects',
				'type' => 'string',
				'description' => esc_html__( 'The public-facing contact email for this project.', 'currentorg' ),
				'single' => true,
				'sanitize_callback' => 'sanitize_text_field',
				// 'auth_callback' => .... I don't know the answer to this question.
				'show_in_rest' => true,
				'_projects_input_type' => 'email',
			)
		),
		array(
			'post',
			'project-revenue',
			array(
				'object_subtype' => 'projects',
				'type' => 'string',
				'description' => esc_html__('Did the initiative generate revenue?', 'currentorg' ),
				'single' => true,
				'sanitize_callback' => 'sanitize_textarea_field',
				// 'auth_callback' => .... I don't know the answer to this question.
				'show_in_rest' => true,

				// now for our private arguments
				'_projects_input_type' => 'textarea', // HTML input type
			)
		),
		array(
			'post',
			'project-impact',
			array(
				'object_subtype' => 'projects',
				'type' => 'string',
				'description' => esc_html__('The project impact statement.', 'currentorg' ),
				'single' => true,
				'sanitize_callback' => 'sanitize_textarea_field',
				// 'auth_callback' => .... I don't know the answer to this question.
				'show_in_rest' => true,

				// now for our private arguments
				'_projects_input_type' => 'textarea', // HTML input type
			)
		),
		array(
			'post',
			'project-link',
			array(
				'object_subtype' => 'projects',
				'type' => 'string',
				'description' => esc_html__('The public-facing link for this project.', 'currentorg' ),
				'single' => true,
				'sanitize_callback' => 'sanitize_text_field',
				// 'auth_callback' => .... I don't know the answer to this question.
				'show_in_rest' => true,

				// now for our private arguments
				'_projects_input_type' => 'url', // HTML input type
			)
		),
		array(
			'post',
			'project-additional-link-1',
			array(
				'object_subtype' => 'projects',
				'type' => 'string',
				'description' => esc_html__('Internal link for judging, #1.', 'currentorg' ),
				'single' => true,
				'sanitize_callback' => 'sanitize_text_field',
				// 'auth_callback' => .... I don't know the answer to this question.
				'show_in_rest' => true,

				// now for our private arguments
				'_projects_input_type' => 'url', // HTML input type
			)
		),
		array(
			'post',
			'project-additional-link-2',
			array(
				'object_subtype' => 'projects',
				'type' => 'string',
				'description' => esc_html__('Internal link for judging, #2.', 'currentorg' ),
				'single' => true,
				'sanitize_callback' => 'sanitize_text_field',
				// 'auth_callback' => .... I don't know the answer to this question.
				'show_in_rest' => true,

				// now for our private arguments
				'_projects_input_type' => 'url', // HTML input type
			)
		),
		array(
			'post',
			'project-additional-link-3',
			array(
				'object_subtype' => 'projects',
				'type' => 'string',
				'description' => esc_html__('Internal link for judging, #3.', 'currentorg' ),
				'single' => true,
				'sanitize_callback' => 'sanitize_text_field',
				// 'auth_callback' => .... I don't know the answer to this question.
				'show_in_rest' => true,

				// now for our private arguments
				'_projects_input_type' => 'url', // HTML input type
			)
		),
		array(
			'post',
			'project-additional-link-4',
			array(
				'object_subtype' => 'projects',
				'type' => 'string',
				'description' => esc_html__('Internal link for judging, #4.', 'currentorg' ),
				'single' => true,
				'sanitize_callback' => 'sanitize_text_field',
				// 'auth_callback' => .... I don't know the answer to this question.
				'show_in_rest' => true,

				// now for our private arguments
				'_projects_input_type' => 'url', // HTML input type
			)
		),
		array(
			'post',
			'project-additional-link-5',
			array(
				'object_subtype' => 'projects',
				'type' => 'string',
				'description' => esc_html__('Internal link for judging, #5.', 'currentorg' ),
				'single' => true,
				'sanitize_callback' => 'sanitize_text_field',
				// 'auth_callback' => .... I don't know the answer to this question.
				'show_in_rest' => true,

				// now for our private arguments
				'_projects_input_type' => 'url', // HTML input type
			)
		),
		array(
			'post',
			'project-video',
			array(
				'object_subtype' => 'projects',
				'type' => 'string',
				'description' => esc_html__( 'Video URL for this project.', 'currentorg' ),
				'single' => true,
				'sanitize_callback' => 'esc_url_raw',
				// 'auth_callback' => .... I don't know the answer to this question.
				'show_in_rest' => true,
				'_projects_input_type' => 'url',
			)
		),
	);
}

/**
 * Register the custom post meta for Local That Works projects
 *
 * @uses projects_post_meta_items;
 * @link https://developer.wordpress.org/reference/functions/register_meta/
 * @link https://developer.wordpress.org/block-editor/tutorials/plugin-sidebar-0/
 */
function projects_register_post_meta() {
	$items = projects_post_meta_items();
	foreach ( $items as $item ) {
		call_user_func_array( 'register_post_meta', $item );
	}
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
		'projects_meta_box_callback',
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
 *
 * @uses projects_post_meta_items, specifically sanitize_callback
 * @return Bool whether the post meta was attempted to be updated
 */
function projects_meta_save( $post_id ) {
	if ( ! isset( $_POST['project-meta-fields-nonce'] ) ) {
		error_log(var_export( 'nonce not set', true));
		return false;
	}

	if ( ! wp_verify_nonce( $_POST['project-meta-fields-nonce'], 'project-meta-fields-nonce' ) ) {
		error_log(var_export( 'nonce did not verify', true));
		return false;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		error_log(var_export( 'current user cannot edit post', true));
		return false;
	}

	if ( wp_is_post_autosave( $post_id ) ) {
		error_log(var_export( 'is post autosave', true));
		return false;
	}

	if ( wp_is_post_revision( $post_id ) ) {
		error_log(var_export( 'is post revision', true));
		return false;
	}

	if ( 'projects' !== get_post_type( $post_id ) ) {
		error_log(var_export( 'wrong post type to save this data on', true));
		return false;
	}

	$items = projects_post_meta_items();
	foreach ( $items as $item ) {
		// $item[0] is 'post'
		// $item[1] is the field/meta name
		// $item[2] is an array of arguments passed to register_post_type
		if ( isset( $_POST[$item[1]] ) ) {

			$sanitize_callback = $item[2]['sanitize_callback'];
			$value = call_user_func_array(
				$sanitize_callback,
				array( $_POST[$item[1]] )
			);

			update_post_meta(
				$post_id,
				$item[1],
				$value
			);
		}
	}

	return true;
}
add_action( 'save_post', 'projects_meta_save' );


/**
 * The meta box for the project meta fields
 */
function projects_meta_box_callback( $post ) {
	$items = projects_post_meta_items();
	wp_nonce_field( 'project-meta-fields-nonce', 'project-meta-fields-nonce' );

	// stealing a lot of styles from #postcustomstuff
	?>
		<style class="text/css">
			#current-ltw-project table {
				width: 100%;
				border: 1px solid #ddd;
				border-spacing: 0;
				background-color: #f9f9f9;
			}
			#current-ltw-project tr {
				vertical-align: top;
			}
			#current-ltw-project th {
				padding: 5px 8px 8px;
				background-color: #f1f1f1;
			}
			#current-ltw-project th.left,
			#current-ltw-project td.left {
				width: 38%;
			}
			#current-ltw-project td label {
				margin: 8px;
				display: block;
				font-size: 14px;
			}
			#current-ltw-project td textarea,
			#current-ltw-project td input {
				margin: 8px;
				width: 96%;
				box-sizing: border-box;
			}
		</style>

	<?php

	echo '<table>';

	echo '<thead>';
	printf(
		'<tr><th class="left">%1$s</th><th>%2$s</th></tr>',
		esc_html__( 'Description', 'currentorg' ),
		esc_html__( 'Value', 'currentorg' )
	);
	echo '</thead>';

	echo '<tbody>';

	foreach ( $items as $item ) {
		// check that we've got valid items
		if (
			! is_string( $item[0] )
			|| ! is_string( $item[1] )
			|| ! is_array( $item[2] )
			|| isset( $item[3] )
		) {
			error_log( 'unexpected parameter passed in projects_meta_box_callback: ' . var_export( $item, true));
		}

		switch ( $item[2]['_projects_input_type'] ) {
			case 'textarea':
				printf(
					'<tr><td class="left"><label for="%1$s">%2$s</label></td><td class="right"><textarea id="%1$s" name="%1$s" class="" >%4$s</textarea></td></tr>',
					esc_attr( $item[1] ),
					esc_html( $item[2]['description'] ),
					null,
					esc_html( get_post_meta( $post->ID, $item[1], true ) )
				);
				break;
			case 'url':
			case 'text':
			case 'email':
				printf(
					'<tr><td class="left"><label for="%1$s">%2$s</label></td><td class="right"><input id="%1$s" name="%1$s" class="" type="%3$s" value="%4$s"></input></td></tr>',
					esc_attr( $item[1] ),
					esc_html( $item[2]['description'] ),
					esc_attr( $item[2]['_projects_input_type'] ),
					esc_attr( get_post_meta( $post->ID, $item[1], true ) )
				);
				break;
			default:
				echo "This is a textarea!";
		}
	}

	echo '</tbody>';
	echo '</table>';
}

add_action('largo_before_post_header', function() {
	printf(
		'<pre>%1$s</pre>',
		esc_html( var_export( get_post_custom( get_the_ID() ), true) )
	);
});
