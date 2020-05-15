<?php
/**
 * Plugin Name:     Current.org Local That Works Projects
 * Plugin URI:      https://github.com/INN/umbrella-currentorg/tree/master/wp-content/plugins
 * Description:     Creates the 'projects' post type powering the Local That Works database
 * Author:          INN Labs
 * Author URI:      https://labs.inn.org
 * Text Domain:     current-ltw-projects
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Current_Ltw_Projects
 */

$includes = array(
	'/post-types/projects.php',
);
foreach ( $includes as $include ) {
	if ( 0 === validate_file( $include ) ) {
		require_once( dirname( __FILE__ ) . $include );
	}
}
