<?php

$search_query = $query->query_vars['s'];

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
			<?php esc_html_e( 'Search for:', 'currentorg' ); ?>
			<input type="text" class="searchbox search-query" value="<?php echo esc_attr( $search_query ); ?>" name="projects-search" />
		</label>
		<button type="submit" class="btn btn-submit"><?php esc_html_e( 'Search', 'currentorg' ); ?></button>
		<label for="projects-search">
			<?php esc_html_e( 'Limit by organization type:', 'currentorg' ); ?>
			<?php
				wp_dropdown_categories( array(
					'show_option_none' => __( 'Not limited', 'currentorg' ),
					'option_none_value' => '',
					'name' => 'project-org-type',
					'taxonomy' => 'project-org-type',
					'selected' => ( isset( $_GET['project-org-type'] ) ) ? (int) $_GET['project-org-type'] : '' ,
				) );
			?>
		</label>
	</div>
</form>
