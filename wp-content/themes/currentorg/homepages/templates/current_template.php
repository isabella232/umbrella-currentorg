<?php global $shown_ids; ?>

<div class="current-h-top-post">

	<?php
	$homepage_feature_term = get_term_by( 'name', __('Homepage Featured', 'largo'), 'prominence' );

	$topstory = largo_get_featured_posts( array(
		'tax_query' => array(
			array(
				'taxonomy' 	=> 'prominence',
				'field' 	=> 'slug',
				'terms' 	=> $homepage_feature_term->slug
			)
		),
		'showposts' => 2
	) );

	if ( $topstory->have_posts() ) : $topstory->the_post(); $shown_ids[] = get_the_ID();

		?>

		<?php get_template_part('partials/content', 'home'); ?>

	<?php
		wp_reset_postdata();
	else:
		echo "No top posts, add one for it to show up here";
	endif;
	?>

</div>


<div class="current-h-top-rail">

	<div class="current-h-top-rail-left">
	<?php if ( $topstory->have_posts() ) : $topstory->the_post(); $shown_ids[] = get_the_ID();

			?>

			<?php get_template_part('partials/content', 'home-2'); ?>

		<?php
			wp_reset_postdata();
		else:
			echo "No top posts, add one for it to show up here";
		endif;
		?>
	</div>

	<div class="current-h-top-rail-right bold-widget-title">

		<?php

		$widget = "<div class='widget-area bold-widget-title'>";

		if (!dynamic_sidebar('Homepage next to second post')) {
			$widget .= "<div style=''> Add a widget to the 'Homepage next to second post' sidebar</div>";
		}

		$widget .= "</div>";

		echo $widget;

		?>

	</div>

	<div class="clearfix"></div>

</div>