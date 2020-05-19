<?php
/**
 * The general layout of the projects page
 *
 */

if ( have_posts() || largo_have_featured_posts() ) {
				$counter = 1;
				while ( have_posts() ) : the_post();
					$post_type = get_post_type();
					$partial = largo_get_partial_by_post_type( 'archive', $post_type, 'archive' );
					get_template_part( 'partials/content', $partial );
					do_action( 'largo_loop_after_post_x', $counter, $context = 'archive' );
					$counter++;
				endwhile;

				largo_content_nav( 'nav-below' );
		} else {
			get_template_part( 'partials/content', 'not-found' );
		}

