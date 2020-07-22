<?php
/**
 * The general layout of the projects page
 *
 */

// this can be filtered later, in https://github.com/INN/umbrella-currentorg/issues/122
$args = array(
	'post_type' => 'projects',
	'post_status' => 'publish',
	'orderby' => array(
		// sort date by DESC so it grabs newest years first
		'date' => 'DESC',
		// sort titel by ASC so it grabs alphabetically
		'title' => 'ASC'
	)
);

if ( isset( $_GET['projects-search'] ) && ! empty( $_GET['projects-search'] ) ) {
	$args['s'] = sanitize_title_for_query( $_GET['projects-search'] );
}

$tax_query = array();
if ( isset( $_GET['tax_input']['project-org-type'] ) && is_array( $_GET['tax_input']['project-org-type'] ) ) {
	foreach( $_GET['tax_input']['project-org-type'] as $term ) {
		$term = sanitize_title_for_query( $term );
		if ( ! empty( $term ) && is_numeric( $term ) ) {
			$tax_query[] = array(
				'taxonomy' => 'project-org-type',
				'field' => 'term_id',
				'terms' => $term,
			);
		}
		unset( $term );
	}
}
if ( isset( $_GET['tax_input']['project-status'] ) && is_array( $_GET['tax_input']['project-status'] ) ) {
	foreach( $_GET['tax_input']['project-status'] as $term ) {
		$term = sanitize_title_for_query( $term );
		if ( ! empty( $term ) && is_numeric( $term ) ) {
			$tax_query[] = array(
				'taxonomy' => 'project-status',
				'field' => 'term_id',
				'terms' => $term,
			);
		}
		unset( $term );
	}
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

// only load the single holder if posts are found
if ( $query->have_posts() ) {
    include( locate_template( 'partials/projects-single-holder.php', false, false ) );
} 
