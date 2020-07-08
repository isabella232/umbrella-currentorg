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
		<div class="left">
			<label class="projects-search" for="projects-search">
				<span class="visuallyhidden"><?php esc_html_e( 'Search for:', 'currentorg' ); ?></span>
				<input type="text" class="searchbox search-query" value="<?php echo esc_attr( $search_query ); ?>" name="projects-search" placeholder="<?php esc_attr_e( 'Search', 'currentorg' ); ?>"/>
			</label>

			<button type="submit" class="btn btn-submit"><?php esc_html_e( 'Search', 'currentorg' ); ?></button>
		</div>

		<div class="right">

			<label for="tax_input[project-org-type][]" class="project-org-type">
				<?php
					printf(
						'<span class="visuallyhidden">%1$s</span>',
						esc_html__( 'Limit by organization type:', 'currentorg' )
					);

					// normalize the selected item before using it as an argument on wp_dropdown_categories.
					if ( isset( $_GET['tax_input'] ) && array_key_exists( 'project-org-type', $_GET['tax_input'] ) ) {
						$selected_maybe = $_GET['tax_input']['project-org-type'];
						if ( is_array( $selected_maybe ) ) {
							$selected = (int) $selected_maybe[0];
						} elseif ( is_string( $selected_maybe ) || is_number( $selected_maybe ) ) {
							$selected = (int) $selected_maybe;
						}
					} else {
						$selected = 0;
					}
					wp_dropdown_categories( array(
						'show_option_none' => __( 'Organization type', 'currentorg' ),
						'option_none_value' => '',
						'name' => 'tax_input[project-org-type][]',
						'taxonomy' => 'project-org-type',
						'selected' => $selected
					) );
				?>
			</label>

			<div class="project-category-holder">
				<details class="project-category">
					<?php
						printf(
							'<summary class="btn">%1$s</summary>',
							__( 'Categories', 'currentorg' )
						);
						
						echo '<ul>';
						// whether an input is disabled is based on the present $post,
						// but we're using it outside that context,
						// so we must remove the disabled arguments if they exist.
						$checklist = wp_terms_checklist( null, array(
							'taxonomy' => 'project-category',
							'selected_cats' => ( isset( $_GET['tax_input']['project-category'] ) && is_array( $_GET['tax_input']['project-category'] ) ) ? $_GET['tax_input']['project-category'] : '' ,
							'echo' => false,
						) );
						echo str_replace(
							disabled( false, false, false ), // get the wp-generated disabled attribute, which doesn't vary from case to case.
							'',
							$checklist
						);
						echo '</ul>';
					?>
				</details>
			</div>

			<button type="submit" class="btn btn-submit"><?php esc_html_e( 'Search', 'currentorg' ); ?></button>
		</div>
	</div>
</form>
