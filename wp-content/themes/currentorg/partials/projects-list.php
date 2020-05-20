<div class="projects-list">
	<?php
		if ( $query->have_posts() ) {
			$counter = 1;
			while ( $query->have_posts() ) {
				$query->the_post();
				get_template_part( 'partials/content', 'projects-list-item' );
				$counter++;
			}
			largo_content_nav( 'nav-below' );
		} else {
			get_template_part( 'partials/content', 'not-found' );
		}
	?>
</div>
