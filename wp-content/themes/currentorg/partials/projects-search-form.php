<?php

$qo = get_queried_object();
if ( is_a( $qo, 'WP_Post_Type' ) ) {
	$form_url = get_post_type_archive_link( $qo->name );
} else if ( is_a( $qo, 'WP_Post' ) ) {
	$form_url = get_permalink( $qo );
} else if ( is_a( $qo, 'WP_Term' ) ) {
	$form_url = get_term_link( $qo );
} else {
	$form_url = get_search_link();
}


?>
<form class="projects-search-form-search form-search" role="search" method="get" action="<?php echo esc_url( $form_url ); ?>">
	<div class="project-search-container">
		<label for="projects-search">
			<?php esc_html_e( 'Search for:', 'mwen' ); ?>
			<input type="text" class="searchbox search-query" value="<?php the_search_query(); ?>" name="projects-search" />
		</label>
	</div>
</form>
