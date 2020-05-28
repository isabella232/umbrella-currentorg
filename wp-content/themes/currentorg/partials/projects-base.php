<?php
/**
 * The general layout of the projects page
 *
 */

// this can be filtered later, in https://github.com/INN/umbrella-currentorg/issues/122
$args = array(
	'post_type' => 'projects',
	'post_status' => 'publish',
);
if ( isset( $_GET['projects-search'] ) && ! empty( $_GET['projects-search'] ) ) {
	$args['s'] = sanitize_title_for_query( $_GET['projects-search'] );
}
$query = new WP_Query( $args );

// so we can pass $query to these
include( locate_template( 'partials/projects-search-form.php', false, false ) );
include( locate_template( 'partials/projects-list.php', false, false ) );

get_template_part( 'partials/projects-single-holder' );
