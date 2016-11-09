<?php
/**
 * Template Name: JobTarget blank page
 * Single Post Template: Full-width (no sidebar)
 * Description: No sidebars, no page content. Includes global, main and secondary navs, and footer.
 */


// Not using get_header because its settings cannot be faked.

// get_header();

// Copied from Largo/header.php
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
</head>

<body <?php body_class(); ?>>

	<div id="top"></div>

	<?php do_action( 'largo_top' ); ?>

	<?php
		// faking sticky nav to be false, so that the main nav and other items display
		$sn_backup = of_get_option('show_sticky_nav');
		of_set_option('show_sticky_nav', false);
	?>

	<div id="page" class="hfeed clearfix">

<?php
do_action( 'largo_before_header' );
get_template_part( 'partials/largo-header' );
do_action( 'largo_after_header' );

// Including the navs
if ( TRUE ) {

	get_template_part( 'partials/nav', 'main' );

	// un-faking the sticky nav option
	of_set_option('show_sticky_nav', $sn_backup);
	unset($sn_backup);
}
?>
<?php
if ( SHOW_SECONDARY_NAV === TRUE ) {
	get_template_part( 'partials/nav', 'secondary' );
}

?>

<?php do_action( 'largo_after_nav' ); ?>

<div id="main" class="row-fluid clearfix">
<!-- JobTarget code goes here-->

<?php 
do_action( 'largo_main_top' );
// End of Largo/header.php

// End of page
get_footer();
