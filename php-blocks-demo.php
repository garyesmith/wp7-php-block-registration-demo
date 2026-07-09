<?php
/**
 * Plugin Name: WP7 PHP Block Demo
 * Description: Demonstrates the loading and registration of a custom Block for WordPress 7
 * 				using only PHP (no React). This code is extended from another example
 * 				provided by Brian Coords at https://github.com/bacoords/example-php-block
 * Version: 1.0.0
 * Requires: WordPress 7.0 or newer
 * Author: Gary Smith
 * 
 * @package wp7-php-block-demo
 */

defined( 'ABSPATH' ) || exit; // prevent direct access via browser

define( 'PHPBLOCKS_VERSION', '1.0.0' );
define( 'PHPBLOCKS_DIR', plugin_dir_path( __FILE__ ) );
define( 'PHPBLOCKS_URL', plugin_dir_url( __FILE__ ) );

// Load custom block registration (for multiple blocks, put each block in its own subfolder)
require_once PHPBLOCKS_DIR . 'simple-block-demo/register.php';

