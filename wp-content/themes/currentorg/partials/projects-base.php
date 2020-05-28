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

$tax_query = array();
if ( isset( $_GET['project-org-type'] ) && ! empty( $_GET['project-org-type'] ) ) {
	$term = sanitize_title_for_query( $_GET['project-org-type'] );
	if ( ! empty( $term ) && is_numeric( $term ) ) {
		$tax_query[] = array(
			'taxonomy' => 'project-org-type',
			'terms' => $term,
			'field' => 'term_id',
		);
	}
	unset( $term );
}
if ( isset( $_GET['tax_input']['project-category'] ) && is_array( $_GET['tax_input']['project-category'] ) ) {
	foreach( $_GET['tax_input']['project-category'] as $term ) {
		$term = sanitize_title_for_query( $term );
		if ( ! empty( $term ) && is_numeric( $term ) ) {
			$tax_query[] = array(
				'taxonomy' => 'project-category',
				'field' => 'term_id',
				'terms' => $term,
			);
		}
		unset( $term );
	}
}
if ( ! empty( $tax_query ) ) {
	$args['tax_query'] = $tax_query;
}
if ( count( $tax_query ) > 1 ) {
	$args['tax_query']['relation'] = 'AND';
}


$query = new WP_Query( $args );

// so we can pass $query to these
include( locate_template( 'partials/projects-search-form.php', false, false ) );
include( locate_template( 'partials/projects-list.php', false, false ) );

get_template_part( 'partials/projects-single-holder' );
