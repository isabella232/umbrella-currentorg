<?php
/**
 * The general layout of the projects page
 *
 */

// this can be filtered later, in https://github.com/INN/umbrella-currentorg/issues/122
$query = new WP_Query(
	array(
		'post_type' => 'projects',
		'post_status' => 'publish',
	)
);

get_template_part( 'partials/projects-search-form' );
// so we can pass $query to it
include( locate_template( 'partials/projects-list.php', false, false ) );
get_template_part( 'partials/projects-single-holder' );
