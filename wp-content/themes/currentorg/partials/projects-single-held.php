<?php

$args = array (
	// post-specific, should probably not be filtered but may be useful
	'post_id' => $post->ID,
	'hero_class' => largo_hero_class( $post->ID, FALSE ),

	// only used to determine the existence of a youtube_url
	'values' => get_post_custom( $post->ID ),

	// this should be filtered in the event of a term-specific archive
	'featured' => false,

	// $show_thumbnail does not control whether or not the thumbnail is displayed;
	// it controls whether or not the thumbnail is displayed normally.
	'show_thumbnail' => TRUE,
	'show_excerpt' => TRUE,
);

$args = apply_filters( 'largo_content_partial_arguments', $args, get_queried_object() );

extract( $args );

$entry_classes = 'entry-content';

$show_top_tag = largo_has_categories_or_tags();

$custom = get_post_custom();

if ( $featured ) {
	$entry_classes .= ' span10 with-hero';
	$show_thumbnail = FALSE;
}
if( ! empty ( $custom['project-video'][0] ) ) {
	$show_youtube = TRUE;
	$show_thumbnail = FALSE;
}

?>

<article class="projects-single-held">
    <h1 class="projects-single-title"><?php echo the_title(); ?></h1>
        <?php

        echo '<div class="' . $entry_classes . '">';
        
        // we may need to redo these links as search query params instead
        $status = get_the_terms( get_the_ID(), 'project-status' );
        $categories = get_the_terms( get_the_ID(), 'project-category' );
        // @todo this throws errors when no terms are found for this type of post 
        if ( is_array( $status ) && is_array( $categories ) ) {
            $terms = array_merge( $status, $categories );
        } else if ( is_array( $status ) ) {
            $terms = $status;
        } else if ( is_array( $categories ) ) {
            $terms = $categories;
        } else {
            $terms = array();
        }

        if ( ! empty( $terms ) ) {
            echo '<ul class="project-tags">';
            $terms_count = count( $terms );
            $terms_index = 0;
            $delimiter = '|';
            foreach ( $terms as $term ) {
                $terms_index++;
                printf(
                    '<a class="project-tag %1$s-%2$s" href="%3$s">%4$s</a>',
                    esc_attr( $term->taxonomy ),
                    esc_attr( $term->slug ),
                    // @todo: make this be a link that triggers the search filter for this term
                    get_term_link( $term ),
                    esc_html( $term->name ),
                );
                if( $terms_index != $terms_count ){
                    echo '<span class="delimiter">' . $delimiter . '</span>';
                }
            }
            echo '</ul>';
        }

        // thumbnail or video
        if ( $show_thumbnail ) {
            echo '<div class="has-thumbnail '.$hero_class.'"><a href="?project_id=' . get_the_ID() . '">' . get_the_post_thumbnail( get_the_ID(), 'large' ) . '</a></div>';
        } else if( $show_youtube && wp_oembed_get( $custom['project-video'][0] ) ) {
            echo wp_oembed_get( $custom['project-video'][0] );
        }

        // organization
        if ( ! empty( $custom['project-organization'][0] ) ) {
            printf(
                '<div><label class="project-single-organization">%1$s:</label>
                <span class="project-organization">%2$s</span></div>',
                __( 'Organization', 'current-ltw-projects' ),
                esc_html( $custom['project-organization'][0] )
            );
        }

        // year submitted
        printf(
            '<div><label class="project-single-submission-year">%1$s:</label>
            <span class="project-submission-year">%2$s</span></div>',
            __( 'Year Submitted', 'current-ltw-projects' ),
            get_the_date( 'Y' )
        );

        // type of org
        $org_types = get_the_terms( get_the_ID(), 'project-org-type' );
        if ( ! empty( $org_types ) ) {
            $delimiter = ', ';
            $org_types_count = count( $org_types );
            $org_type_index = 0;
            _e( '<div><label class="project-org-types-label">Type of Organization: </label>', 'current-ltw-projects' );
            foreach ( $org_types as $org_type ) {
                $org_type_index++;
                printf(
                    '<a href="%3$s">%4$s</a>',
                    esc_attr( $org_type->taxonomy ),
                    esc_attr( $org_type->slug ),
                    // @todo: make this be a link that triggers the search filter for this term
                    get_term_link( $org_type ),
                    esc_html( $org_type->name )
                );
                if( $org_type_index != $org_types_count ){
                    echo '<span class="comma-delimiter">' . $delimiter . '</span>';
                }
            }
            echo '</ul></div>';
        }

        // contact name and email
        if ( ! empty( $custom['project-contact-name'][0] ) || ! empty( $custom['project-contact-email'] ) ) {
            printf(
                '<label class="project-single-contact">%1$s: </label>',
                __( 'Contact', 'current-ltw-projects' ),
            );
        }

        if ( ! empty( $custom['project-contact-name'][0] ) ) {
            printf(
                '<span class="project-contact-name">%1$s</span><br/>',
                esc_html( $custom['project-contact-name'][0] )
            );
        }

        if ( ! empty( $custom['project-contact-email'][0] ) ) {
            printf(
                '<span class="project-contact-email">%1$s</span>',
                esc_html( $custom['project-contact-email'][0] )
            );
        }

        // tell your story / main content
        the_content();

        // project revenue
        if ( ! empty( $custom['project-revenue'][0] ) ) {
            printf(
                '<p class="project-revenue">%1$s</p>',
                esc_html( $custom['project-revenue'][0] )
            );
        }

        // specific impact
        if ( ! empty( $custom['project-impact'][0] ) ) {
            printf(
                '<p class="project-specific-impact">%1$s</p>',
                esc_html( $custom['project-impact'][0] )
            );
        }

        // primary url
        if ( ! empty( $custom['project-link'][0] ) ) {
            printf(
                '<label class="project-specific-link">%1$s:</label>
                <a class="project-specific-link" href="%2$s" target="_blank">%2$s</a>',
                __( 'Project Link', 'current-ltw-projects' ),
                esc_html( $custom['project-link'][0] )
            );
        }

        ?>
    </div>
</article>