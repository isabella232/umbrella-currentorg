<?php
/**
 * Template Name: Local That Works Template
 * Description: No sidebars, only logo and page content. Does not include global, main and secondary navs.
 */

?>

<!DOCTYPE html>
<!--[if lt IE 7]> <html <?php language_attributes(); ?> class="no-js ie6"> <![endif]-->
<!--[if IE 7]>    <html <?php language_attributes(); ?> class="no-js ie7"> <![endif]-->
<!--[if IE 8]>    <html <?php language_attributes(); ?> class="no-js ie8"> <![endif]-->
<!--[if IE 9]>    <html <?php language_attributes(); ?> class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

	<title>
		<?php
			global $page, $paged;
			wp_title( '|', true, 'right' );
			bloginfo( 'name' ); // Add the blog name.
			// Add the blog description for the home/front page.
			$site_description = get_bloginfo( 'description', 'display' );
			if ( $site_description && ( is_home() || is_front_page() ) )
				echo " | $site_description";
		?>
	</title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <?php wp_head(); ?>
    <?php 
        // enqueue stylesheet for this template
        wp_enqueue_style('current-ltw-template-stylesheet'); 

        // dequeue nav script since there is no nav here
        wp_dequeue_script('largo-navigation');
    ?>
</head>

<body <?php body_class(); ?>>

	<div id="page" class="hfeed clearfix">

        <?php
            do_action( 'largo_before_header' );
            get_template_part( 'partials/largo-header' );
            do_action( 'largo_after_header' );
        ?>

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

<?php
// End of page
get_footer();
