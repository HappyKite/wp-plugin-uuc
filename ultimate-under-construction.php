<?php
/*
Plugin Name: Ultimate Under Construction page
Plugin URI: http://www.happykite.co.uk
Description: Once Active this will replace your Wordpress site with a customizable Under Construction holding page. Admins will still be able to log in and see the original site.
Author: HappyKite
Author URI: http://www.happykite.co.uk/
Version: 2.0
*/

/*
 This file is part of ultimateUnderConstruction.
 ultimateUnderConstruction is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 (at your option) any later version.
 ultimateUnderConstruction is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.
 You should have received a copy of the GNU General Public License
 along with ultimateUnderConstruction.  If not, see <http://www.gnu.org/licenses/>.
 */


/***************************
* global variables
***************************/

define( 'UCC_PREFIX', 'uuc_' );
define( 'UCC_NAME', __( 'Ultimate Under Construction page', 'hpy' ) );
define( 'UUC_VERSION', '2.0' );
define( 'UUC_URI', plugin_dir_url( __FILE__ ) );
define( 'UUC_PATH', plugin_dir_path( __FILE__ ) );
define( 'UUC_ASSETS', UUC_URI . 'assets/' );
define( 'UUC_OPTIONS', get_option('uuc_settings') );

//Retrieve settings from Admin Options table
$uuc_options = get_option('uuc_settings');

/***************************
* includes
***************************/

include('includes/scripts.php'); //includes all JS and CSS
include('includes/display-functions.php'); //display content functions
include('includes/uucadmin.php'); //plugin admin options

/***************************
* Activation Notice
***************************/

register_activation_hook(__FILE__, 'uuc_activation');
function uuc_activation() {
  $url = admin_url('tools.php?page=uuc-options');
  $notices= get_option('uuc_deferred_admin_notices', array());
  $notices[]= "Under Construction: You will need to complete set up <a href='$url'>here</a> before your Under Construction page will be visible. Please be aware that upon deactivation you may need to flush your server cache.";
  update_option('uuc_deferred_admin_notices', $notices);
}

//To do here (Using get_plugin_data) find the current plugin version number.
add_action('admin_init', 'uuc_admin_init');
function uuc_admin_init() {
  $current_version = 2.0;
  $plugin_data = get_plugin_data( __FILE__ );
  $version = $plugin_data['Version'];
  if ($version > $current_version) {
    // Do whatever upgrades needed here.
    update_option('uuc_plugin_version', $current_version);
    $notices= get_option('uuc_deferred_admin_notices', array());
    $notices[]= "Under Construction: To avoid any possible issues, please upgrade to the latest version ($current_version).";
    update_option('uuc_deferred_admin_notices', $notices);
  } else {
    $notices= get_option('uuc_deferred_admin_notices', array());
    delete_option( 'uuc_deferred_admin_notices', $notices );
  }
}

add_action('admin_notices', 'uuc_admin_notices');
function uuc_admin_notices() {
  if ($notices= get_option('uuc_deferred_admin_notices')) {
    foreach ($notices as $notice) {
      echo "<div class='updated'><p>$notice</p></div>";
    }
    delete_option('uuc_deferred_admin_notices');
  }
}

register_deactivation_hook(__FILE__, 'uuc_deactivation');
function uuc_deactivation() {
  delete_option('uuc_version'); 
  delete_option('uuc_deferred_admin_notices');
  $notices= get_option('uuc_deferred_admin_notices', array());
  $notices[]= "Under Construction: Please be aware that you might need to flush your server cache after deactivation.";
  delete_option('uuc_deferred_admin_notices');
}


/***************************
 * Adding Functionality to Plugin page - Under title
 ***************************/

add_filter( 'plugin_action_links', 'uuc_action_plugin', 10, 5 );
function uuc_action_plugin( $actions, $plugin_file ){
    static $plugin;

    if( !isset( $plugin ) )
        $plugin = plugin_basename( __FILE__ );

    if( $plugin == $plugin_file ) {
        $settings = array('settings' => '<a href="tools.php?page=uuc-options">' . __('Settings', 'hpy') . '</a>');

        $actions = array_merge($settings, $actions);
    }

    return $actions;
}

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'uuc_action_links' );
function uuc_action_links( $links ) {
    $links[] = '<a href="https://wordpress.org/support/plugin/ultimate-under-construction" target="_blank">Support</a>';
    return $links;
}

/***************************
 * Wordpress Command Line (WP CLI)
 ***************************/

//Once Plugins are loaded check for WP CLI
add_action( 'wp_loaded', 'hpy_uuc_cli_loaded', 20 );
function hpy_uuc_cli_loaded() {
	if ( defined( 'WP_CLI' ) && WP_CLI && ! class_exists( 'UUC_Cli' ) ) {
        //Load the wp-cli uuc classes
		require_once dirname( __FILE__ ) . '/classes/class-uuc-cli.php';
		require_once dirname( __FILE__ ) . '/classes/class-uuc-cli-user.php';
	}
}

add_action( 'wp_loaded', 'hpy_uuc_load_email_class', 20 );
function hpy_uuc_load_email_class() {
	require_once dirname( __FILE__ ) . '/classes/class-uuc-email-support.php';
}

function load_wp_media_files() {
    wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'load_wp_media_files' );

add_action( 'rest_api_init', function () {
    register_rest_route( 'uuc/v1', '/get_settings/', array(
        'methods' => 'GET',
        'callback' => 'get_uuc_settings_object',
    ) );

    register_rest_route( 'uuc/v1', '/update_settings/', array(
        'methods' => 'POST',
        'callback' => 'get_uuc_settings_object',
    ) );
} );

function get_uuc_settings_object(){
    $settings = array();
    $settings['page_title'] = false !== get_option('uuc_page_title') ? get_option('uuc_page_title') : '' ;
    $settings['holding_message'] = false !== get_option('uuc_holding_message') ? get_option('uuc_holding_message') : '' ;
    $settings['editor'] = false !== get_option('uuc_editor') ? get_option('uuc_editor') : '' ;
    $settings['progress'] = false !== get_option('uuc_progress') ? get_option('uuc_progress') : '' ;

    return new WP_REST_Response( array('success' => true, 'setting' => $settings ) );
}

function update_uuc_settings( $request ){
    $params = $request->get_params();

    foreach( $params as $param => $value ){
        if( 0 === strpos( 'setting_', $value ) ){
            update_option( str_replace( 'setting_', '', $param ), $value );
        }
    }

    return new WP_REST_Response( array('success' => true, 'setting' => $params ) );
}