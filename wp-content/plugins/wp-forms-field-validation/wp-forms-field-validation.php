<?php
/*
Plugin Name: WP Forms Field Validation
Description: Provides specific validation criteria for WP Forms fields
Author: Tim Mannino
Author URI: https://kettul.com
Version: 1.0
Text Domain: wp-forms-field-validation
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

/**
 * Confirm the correct social network link in profile.
 *
 * @link   https://wpforms.com/developers/how-to-validate-a-social-media-url-field-in-your-form/
 *
 */

function wpf_validate_video_url(){ 
  wp_enqueue_script('wpforms-validate-url-js', plugins_url('/js/wpforms-validate-url.js', __FILE__));

}
add_action('wp_head', 'wpf_validate_video_url');

?>