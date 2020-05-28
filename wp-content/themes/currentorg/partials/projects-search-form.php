<?php
/**
 * The search box and other controls for the [current-ltw-project] shortcode
 */

// Because wp_terms_checklist is not defined otherwise
if ( ! function_exists( 'wp_terms_checklist' ) ) {
	include ABSPATH . 'wp-admin/includes/template.php';
}

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
			<span class="visuallyhidden"><?php esc_html_e( 'Search for:', 'currentorg' ); ?></span>
			<input type="text" class="searchbox search-query" value="<?php echo esc_attr( $search_query ); ?>" name="projects-search" placeholder="<?php esc_attr_e( 'Search', 'currentorg' ); ?>"/>
		</label>
		<button type="submit" class="btn btn-submit"><?php esc_html_e( 'Search', 'currentorg' ); ?></button>
		<label for="project-org-type" class="project-org-type">
			<?php
				printf(
					'<span class="visuallyhidden">%1$s</span>',
					esc_html__( 'Limit by organization type:', 'currentorg' )
				);
				wp_dropdown_categories( array(
					'show_option_none' => __( 'Organization type', 'currentorg' ),
					'option_none_value' => '',
					'name' => 'project-org-type',
					'taxonomy' => 'project-org-type',
					'selected' => ( isset( $_GET['project-org-type'] ) ) ? (int) $_GET['project-org-type'] : '' ,
				) );
			?>
		</label>

		<details class="project-category">
			<?php
				printf(
					'<summary class="btn">%1$s</summary>',
					__( 'Categories', 'currentorg' )
				);
				wp_terms_checklist( null, array(
					'taxonomy' => 'project-category',
					'selected_cats' => ( isset( $_GET['tax_input']['project-category'] ) && is_array( $_GET['tax_input']['project-category'] ) ) ? $_GET['tax_input']['project-category'] : '' ,
				) );
			?>
		</details>
	</div>
</form>
