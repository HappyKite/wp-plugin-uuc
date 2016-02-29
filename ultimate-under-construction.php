<?php
/*
Plugin Name: Ultimate Under Construction page
Plugin URI: http://www.happykite.co.uk
Description: Once Active this will replace your Wordpress site with a customizable Under Construction holding page. Admins will still be able to log in and see the original site.
Author: HappyKite
Author URI: http://www.happykite.co.uk/
Version: 1.9
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

$my_prefix = 'uuc_';
$my_plugin_name = 'Ultimate Under Construction page';

//Retrieve settings from Admin Options table
$uuc_options = get_option('uuc_settings');

/***************************
* includes
***************************/

include('includes/scripts.php'); //includes all JS and CSS
include('includes/display-functions.php'); //display content functions
include('includes/uucadmin.php'); //plugin admin options

/***************************
* Activation Notice // Work in progress still //
***************************/

register_activation_hook(__FILE__, 'my_plugin_activation');
function my_plugin_activation() {
  $url = admin_url('tools.php?page=uuc-options');
  $notices= get_option('my_plugin_deferred_admin_notices', array());
  $notices[]= "Under Construction: You will need to complete set up <a href='$url'>here</a> before your Under Construction page will be visible. Please be aware that upon deactivation you may need to flush your server cache.";
  update_option('my_plugin_deferred_admin_notices', $notices);
}

//To do here (Using get_plugin_data) find the current plugin version number.
add_action('admin_init', 'my_plugin_admin_init');
function my_plugin_admin_init() {
  $current_version = 1.9;
  $version= get_option('my_plugin_version');
  if ($version != $current_version) {
    // Do whatever upgrades needed here.
    update_option('my_plugin_version', $current_version);
    $notices= get_option('my_plugin_deferred_admin_notices', array());
    $notices[]= "Under Construction: To avoid any possible issues, please upgrade to the latest version ($current_version).";
    update_option('my_plugin_deferred_admin_notices', $notices);
  }
}

add_action('admin_notices', 'my_plugin_admin_notices');
function my_plugin_admin_notices() {
  if ($notices= get_option('my_plugin_deferred_admin_notices')) {
    foreach ($notices as $notice) {
      echo "<div class='updated'><p>$notice</p></div>";
    }
    delete_option('my_plugin_deferred_admin_notices');
  }
}

register_deactivation_hook(__FILE__, 'my_plugin_deactivation');
function my_plugin_deactivation() {
  delete_option('my_plugin_version'); 
  delete_option('my_plugin_deferred_admin_notices');
  $notices= get_option('my_plugin_deferred_admin_notices', array());
  $notices[]= "Under Construction: Please be aware that you might need to flush your server cache after deactivation.";
  delete_option('my_plugin_deferred_admin_notices');
}