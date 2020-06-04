<?php
/**
 * The [current-ltw-projects] shortcode and related functions
 *
 */

/**
 * the shortcode
 *
 * Attributes:
 * - align: should be one of: left, center, right, none, wide, full, ''
 *
 * @param Array  $atts    the attributes passed in the shortcode.
 * @param String $content the enclosed content; should be empty for this shortcode.
 * @param String $tag     the shortcode tag.
 * @link https://developer.wordpress.org/plugins/shortcodes/shortcodes-with-parameters/#complete-example
 */
function current_ltw_projects_shortcode( $atts = [], $content = null, $tag = '') {

	// normalize attribute keys, lowercase
	$atts = array_change_key_case((array)$atts, CASE_LOWER);

	// override default attributes with user attributes
	$wporg_atts = shortcode_atts( array( 'align' => '', ) , $atts, $tag);

	// create class names to be applied to this element
	$align = empty( $atts['align'] ) ? '' : 'align' . esc_attr( $atts['align'] );
	$actual_classes = implode( ' ', array(
		$align,
		'current-ltw-shortcode',
	) );

	// placeholder in case we're ever worried about having more than one of this on a page:
	// we can make a singleton class that returns an incrementing number here
	$actual_id = "current-ltw-shortcode-1";

	// start output
	wp_enqueue_style('current-ltw-stylesheet');
	wp_enqueue_script('current-ltw-script');
	ob_start();

	// start box
	printf(
		'<div id="%1$s" class="%2$s">',
		esc_attr( $actual_id ),
		esc_attr( $actual_classes )
	);

	// enclosing tags
	if (!is_null($content)) {
		// secure output by executing the_content filter hook on $content
		echo apply_filters('the_content', $content);

		// run shortcode parser recursively
		echo do_shortcode($content);
	}

	get_template_part( 'partials/projects-base' );

	// end box
	echo '</div>';

	// return output
	return ob_get_clean();
}

/**
 * Register the shortcode
 */
add_action( 'init', function() {
	if ( post_type_exists( 'projects' ) ) {
		add_shortcode( 'current-ltw-projects', 'current_ltw_projects_shortcode' );
	}
});

/**
 * Register the assets for this project
 */
function current_ltw_projects_assets() {
	wp_register_style(
		'current-ltw-stylesheet',
		get_stylesheet_directory_uri() . '/css/current-ltw-projects.css',
		array(),
		filemtime( get_stylesheet_directory() . '/css/current-ltw-projects.css' )
	);
	wp_register_script(
		'current-ltw-script',
		get_stylesheet_directory_uri() . '/js/current-ltw-projects.js',
		array( 'jquery' ),
		filemtime( get_stylesheet_directory() . '/js/current-ltw-projects.js' ),
		true
	);
	wp_localize_script( 
		'current-ltw-script', 
		'ajax_object',
		array( 'ajax_url' => admin_url( 'admin-ajax.php' ) )
	);
}
add_action( 'wp_enqueue_scripts', 'current_ltw_projects_assets' );

/**
 * Load a single project when it is selected from the project list
 */
function current_ltw_projects_load_single_project_callback() {

	// make sure post id is set and actually a valid post
    if( isset( $_GET['post_id'] ) && get_post_status( $_GET['post_id'] ) ) {

		$post_id = $_GET["post_id"];
		
		// set up basic args for our query to grab the post
		$single_project_args = array(
			'post_type' => 'projects',
			'p' => abs( intval( $post_id ) )
		);

		$single_project_query = new WP_Query( $single_project_args );

		if( $single_project_query->have_posts() ){
			
			while ( $single_project_query->have_posts() ) : $single_project_query->the_post();

				// show singular project with the project single template partial
				get_template_part( 'partials/projects', 'single-held' );

			endwhile;

		}
		
	} else {

		echo '<p>The project could not be found.</p>';

	}
	
	wp_die();
	
}
add_action( 'wp_ajax_load_more_post', 'current_ltw_projects_load_single_project_callback' );
add_action( 'wp_ajax_nopriv_load_more_post', 'current_ltw_projects_load_single_project_callback' );
/**
 * Filter queries for the projects post type
 */
function current_ltw_projects_pre_get_posts( $query ) {
	if ( is_admin() ) {
		return $query;
	}

	if ( isset( $query->query_vars['post_type'] ) && 'projects' !== $query->query_vars['post_type'] ) {
		return $query;
	}

	if ( isset( $_GET['projects-search'] ) && ! empty( $_GET['projects-search'] ) ) {
		$query->set( 's', sanitize_title_for_query( $_GET['projects-search'] ) );
	}
}
#add_action( 'pre_get_posts', 'current_ltw_projects_pre_get_posts', 10, 1 );

/**
 * Filter which post type partial Largo uses for the LMP button on projects
 *
 * @link https://github.com/INN/largo/blob/v0.6.4/inc/ajax-functions.php#L203
 */
function current_ltw_projects_largo_lmp_template_partial( $partial, $query ) {
	// on the assumption that the only place where this site will LMP some posts of this type is on the list view
	// an assumption that is only valid because the archive uses the shortcode that renders the list view
	if ( isset( $query->query_vars['post_type'] ) && 'projects' === $query->query_vars['post_type'] ) {
		return 'projects-list-item';
	}

	return $partial;
}
add_filter( 'largo_lmp_template_partial', 'current_ltw_projects_largo_lmp_template_partial', 10, 2);
