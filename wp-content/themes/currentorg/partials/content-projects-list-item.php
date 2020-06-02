<?php
/*
 * The default template for displaying content
 *
 * @package Largo
 */
$args = array (
	// post-specific, should probably not be filtered but may be useful
	'post_id' => $post->ID,
	'hero_class' => largo_hero_class( $post->ID, FALSE ),

	// only used to determine the existence of a youtube_url
	'values' => get_post_custom( $post->ID ),

	// $show_thumbnail does not control whether or not the thumbnail is displayed;
	// it controls whether or not the thumbnail is displayed normally.
	'show_thumbnail' => TRUE,
	'show_excerpt' => TRUE,
);

// @todo: remove this
extract( $args );

$entry_classes = 'entry-content';

$show_top_tag = largo_has_categories_or_tags();

$custom = get_post_custom();

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix projects-list-item'); ?>>

	<?php

		echo '<div class="' . $entry_classes . '">';

		if ( largo_has_categories_or_tags() ) {
			largo_maybe_top_term();
		}

		if ( $show_thumbnail ) {
			echo '<div class="has-thumbnail '.$hero_class.'"><a href="' . get_permalink() . '">' . get_the_post_thumbnail() . '</a></div>';
		}
	?>

		<h2 class="entry-title">
			<a href="?project_id=<?php echo get_the_ID(); ?>" title="<?php the_title_attribute( array( 'before' => __( 'Permalink to', 'largo' ) . ' ' ) )?>" rel="bookmark" data-post-id="<?php echo get_the_ID(); ?>"><?php the_title(); ?></a>
		</h2>

		<?php
			// get all terms for this project
			$terms = array();
			foreach ( array( 'project-status', 'project-category', 'project-org-type' ) as $tax ) {
				$tax_terms = get_the_terms( get_the_ID(), $tax );
				if ( is_array( $tax_terms ) ) {
					$terms = array_merge( $terms, $tax_terms );
				}
			}

			// output list of terms as links to search query for that term
			if ( ! empty( $terms ) ) {
				echo '<ul class="project-tags">';
				foreach ( $terms as $term ) {
					printf(
						'<li class="project-tag %1$s-%2$s"><a href="%3$s">%4$s</a></li>',
						esc_attr( $term->taxonomy ),
						esc_attr( $term->slug ),
						// @todo: make this be a link that triggers the search filter for this term
						esc_attr( '?' . $term->taxonomy . '=' . $term->term_id ),
						esc_html( $term->name )
					);
				}
				echo '</ul>';
			}

			if ( ! empty( $custom['project-organization'][0] ) ) {
				printf(
					'<span class="project-organization">%1$s</span>',
					esc_html( $custom['project-organization'][0] )
				);
			}


			if ( $show_excerpt ) {
				largo_excerpt();
			}
		?>

		</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
