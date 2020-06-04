<div class="projects-results-count">
	<?php
		if ( $query->found_posts ) {
			printf(
				'<p>%1$s %2$s</p>',
				$query->found_posts,
                __( 'results found.', 'current-ltw-projects' )
            );
		}
	?>
</div>
<div class="projects-list">
	<?php
		if ( $query->have_posts() ) {
			$counter = 1;
			while ( $query->have_posts() ) {
				$query->the_post();
				get_template_part( 'partials/content', 'projects-list-item' );
				$counter++;
			}

			// not using largo_content_nav( 'nav-below' ) so that we can set $query
			largo_render_template(
				'partials/load-more-posts',
				null,
				array(
					'nav_id' => 'nav-below',
					'the_query' => $query,
					'posts_term' => ( ! empty( $posts_term ) ) ? $posts_term : esc_html__( 'Projects', 'current-ltw-projects' )
				)
			);
		} else {
			echo wpautop( esc_html__( 'Apologies, but no results were found. Perhaps searching for something else will help.', 'current-ltw-projects' ) );
		}
	?>
</div>
