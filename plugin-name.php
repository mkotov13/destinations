<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Plugin_Name
 *
 * @wordpress-plugin
 * Plugin Name:       Tote Destination Display
 * Plugin URI:        https://github.com/mkotov13/destination
 * Description:       This Plugin presents info stored in the database in a user friendly-format
 * Version:           1.0.0
 * Author:            Maksim Kotov
 * Author URI:        https://github.com/mkotov13
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tote-destination
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-plugin-name-activator.php';
	Plugin_Name_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-plugin-name-deactivator.php';
	Plugin_Name_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_plugin_name' );
register_deactivation_hook( __FILE__, 'deactivate_plugin_name' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-plugin-name.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_plugin_name() {

	$plugin = new Plugin_Name();
	$plugin->run();

}
run_plugin_name();



// Selecting the number of entries in table wp_Destinations
function destination_count_shortcode() {
    global $wpdb;
    $destination_count = $wpdb->get_var( "SELECT COUNT(*) FROM wp_Results2Destinations WHERE result_id = 1" );
    echo "<p>There are {$destination_count} destinations in the request</p>";
}

// displaying a row from wp_Destinations
function destination_select_shortcode() {
    global $wpdb;
    $destination_select = $wpdb->get_row( "SELECT * FROM wp_Destinations" );
    $output = "<hr>";
    $output .= "<div class='col-md-2'> Name - {$destination_select->name}</div>
    <div class='col-md-6'>Description - {$destination_select->description}</div>
    <div class='col-md-2'>Image - {$destination_select->image}</div>
    <br>";
    
    return $output;
}

function destination_results_shortcode() {
    global $wpdb;
    $destination_results = $wpdb->get_results(
        "
        SELECT r2d.result_id, r2d.destination_id, d.name, d.ID
        FROM wp_Results2Destinations AS r2d, wp_Destinations AS d
        WHERE r2d.result_id = 1 
        AND r2d.destination_id = d.ID
        "
    );
    
    echo "<hr>";
    
    foreach($destination_results as $row){    
        echo $row->destination_id." ".$row->name."<br>";
    }
    
    /*$output = "<hr>";
    $output .= "<p>name of the 1st destination is {$destination_results[0]->name}</p>";
    
    return $output;
    echo $output;*/
    
}

// Registering function destination_shortcode under a shortcode
function register_destination_count_shortcode() {
    add_shortcode( 'destination_count', 'destination_count_shortcode' );
}
// Registering function destination_select under a shortcode
function register_destination_select_shortcode() {
    add_shortcode( 'destination_select', 'destination_select_shortcode' );
}
// Registering function destination_results under a shortcode
function register_destination_results_shortcode() {
    add_shortcode( 'destination_results', 'destination_results_shortcode' );
}

// Initializing shortcodes as soon as wordpress starts
add_action('init', 'register_destination_count_shortcode');
add_action('init', 'register_destination_select_shortcode');
add_action('init', 'register_destination_results_shortcode');

// display destination_shortcode in the admin_notices panel
add_action('admin_notices', 'destination_results_shortcode');
