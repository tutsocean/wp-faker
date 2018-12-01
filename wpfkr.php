<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://tutsocean.com/about-me
 * @since             1.0.0
 * @package           Wpfkr
 *
 * @wordpress-plugin
 * Plugin Name:       WP faker
 * Plugin URI:        http://tutsocean.com/wp-faker
 * Description:       This plugin is purely made by developers and for developers. Use this plugin to generate dummy/fake users, posts, custom posts and woocommerce products for various purposes. 
 * Version:           1.0.0
 * Author:            Deepak anand
 * Author URI:        http://tutsocean.com/about-me
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpfkr
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );
define( 'PLUGIN_BASE_URL',plugin_basename( __FILE__ )); 
define( 'PLUGIN_BASE_URI',plugin_dir_path( __FILE__ )); 
define("PLUGIN_DIR",plugin_basename( __DIR__ ));
define("PLUGIN_NAME",'WP Faker');
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wpfkr-activator.php
 */
function activate_wpfkr() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpfkr-activator.php';
	Wpfkr_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wpfkr-deactivator.php
 */
function deactivate_wpfkr() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpfkr-deactivator.php';
	Wpfkr_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wpfkr' );
register_deactivation_hook( __FILE__, 'deactivate_wpfkr' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wpfkr.php';

add_action("wp_loaded","qwWpLoaded");
function qwWpLoaded(){
  require_once plugin_dir_path( __FILE__ ) . 'includes/functions.php';
  require_once plugin_dir_path( __FILE__ ) . 'includes/functions-posts.php';
  require_once plugin_dir_path( __FILE__ ) . 'includes/functions-users.php';
}

// redirect to plugin page after activation
function wpfkrActivationRedirect( $plugin ) {
   if( $plugin == plugin_basename( __FILE__ ) ) {
       if(!isset($_GET['activate-multi']))
       {
         exit( wp_redirect( admin_url( 'admin.php?page=wpfkr-dashboard' ) ) );
      }
   }
}
add_action( 'activated_plugin', 'wpfkrActivationRedirect' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wpfkr() {

	$plugin = new Wpfkr();
	$plugin->run();

}
run_wpfkr();
