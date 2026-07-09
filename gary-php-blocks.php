<?php
/**
 * Plugin Name: Gary's PHP Blocks Demo
 * Description: Demonstrates the loading and registration of a custom Block for WordPress 7
 * 				using only PHP (no React). This code is extended from another example
 * 				provided by Brian Coords at https://github.com/bacoords/example-php-block
 * Version: 1.0.0
 * Requires at least: 7.0
 * Author: Gary Smith
 * 
 * @package gary-simple-block
 */

defined( 'ABSPATH' ) || exit; // prevent direct access via browser

define( 'PHPBLOCKS_VERSION', '1.0.0' );
define( 'PHPBLOCKS_DIR', plugin_dir_path( __FILE__ ) );
define( 'PHPBLOCKS_URL', plugin_dir_url( __FILE__ ) );

// Load custom block registration (for multiple blocks, put each block in its own subfolder)
require_once PHPBLOCKS_DIR . 'gary-simple-block/register.php';

// Example of loading a block that has a dependency, for example, on WooCommerce being installed
//function phpblocks_woocommerce_loaded() {
//	require_once PHPBLOCKS_DIR . 'woo-block/register.php';
//}
//add_action( 'woocommerce_loaded', 'phpblocks_woocommerce_loaded' );