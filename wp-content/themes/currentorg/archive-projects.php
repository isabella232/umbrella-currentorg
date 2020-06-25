<?php
/**
 * Template for various non-category archive pages (tag, term, date, etc.)
 *
 * @package Largo
 * @since 0.1
 * @filter largo_partial_by_post_type
 */

wp_head();

wp_enqueue_style('current-ltw-template-stylesheet'); 

$queried_object = get_queried_object();
?>
<body <?php body_class(); ?>>
<div id="page" class="hfeed clearfix">

	<?php

		do_action( 'largo_before_header' );
		get_template_part( 'partials/largo-header' );
		do_action( 'largo_after_header' );
		
		if ( have_posts() || largo_have_featured_posts() ) {

			/*
			 * Display some different stuff in the header
			 * depending on what type of archive page we're looking at
			 */

			if ( is_post_type_archive() )  {
				$post_type = $wp_query->query_vars['post_type'];
				/**
				 * Make the title of the post_type archive filterable
				 * @param string $title The title of the archive page
				 * @since 0.5.4
				 */
				$title = apply_filters(
					'largo_archive_' . $post_type . '_title',
					__( post_type_archive_title( '', false ), 'largo' )
				);
				/**
				 * Make the feed url of the post_type archive filterable
				 * @param string $title The title of the archive page
				 * @since 0.5.5
				 */
				$rss_link = apply_filters(
					'largo_archive_' . $post_type . '_feed',
					site_url('/feed/?post_type=' . urlencode($post_type))
				);
			}
		?>

		<header class="archive-background clearfix">
			<?php
				$title = __( 'Local That Works', 'current' );
				if ( isset( $title ) ) {
					echo '<h1 class="page-title">' . $title . '</h1>';
				}
			?>
		</header>

		<div class="row-fluid clearfix">
			<div class="stories span12" role="main" id="content">
			<?php
				// and finally wind the posts back so we can go through the loop as usual
				rewind_posts();

				echo do_shortcode( '[current-ltw-projects]', true );

			?>
			</div><!-- end content -->
		</div>
	<?php
		} else {
			get_template_part( 'partials/content', 'not-found' );
		}
	?>
</div>

<?php get_footer();
