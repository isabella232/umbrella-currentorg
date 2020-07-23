<?php
/**
 * Template Name: Local That Works Template
 * Description: No sidebars, only logo and page content. Does not include global, main and secondary navs.
 */
wp_head();

// enqueue stylesheet for this template
wp_enqueue_style('current-ltw-template-stylesheet'); 

// dequeue nav script since there is no nav here
wp_dequeue_script('largo-navigation');

$queried_object = get_queried_object();

?>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<?php
    // Fallback <title> tag on WP pre 4.1
    // @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
    // @since 0.6
    if ( ! function_exists( '_wp_render_title_tag' ) ) {
        printf(
            '<title>%1$s</title>',
            wp_title( '|', false, 'right' )
        );
    }
?>
<link rel="profile" href="https://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
    if ( is_singular() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

?>
<body <?php body_class(); ?>>
<div id="page" class="hfeed clearfix">

	<?php
		do_action( 'largo_before_header' );
		get_template_part( 'partials/largo-header' );
		do_action( 'largo_after_header' );
    ?>
    <div id="main" class="row-fluid clearfix">
        <div id="content" role="main">
            <?php
                while ( have_posts() ) : the_post();

                    $shown_ids[] = get_the_ID();

                    $partial = ( is_page() ) ? 'page' : 'single';

                    get_template_part( 'partials/content', $partial );

                    if ( $partial === 'single' ) {

                        do_action( 'largo_before_post_bottom_widget_area' );

                        do_action( 'largo_post_bottom_widget_area' );

                        do_action( 'largo_after_post_bottom_widget_area' );

                        do_action( 'largo_before_comments' );

                        comments_template( '', true );

                        do_action( 'largo_after_comments' );
                    }

                endwhile;
            ?>
        </div>
    </div>

<?php
// End of page
get_footer();
