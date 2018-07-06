<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.1.1
 * @package           Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       SVG Icon System
 * Plugin URI:        https://github.com/sbarry50/svg-icon-system.git
 * Description:       A system for inlining accesible SVG icons in WordPress themes.
 * Version:           1.1.1
 * Author:            sbarry
 * Author URI:        http://sb2media.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       svg-icon-system
 * Domain Path:       /resources/lang/
 */

use SB2Media\SVGIconSystem\Plugin;
use SB2Media\SVGIconSystem\SVGIcons\SVGIconFactory;

 // If this file is called directly, abort.
 if ( ! defined( 'WPINC' ) ) {
 	die;
 }

$autoloader = dirname( __FILE__ ) . '/vendor/autoload.php';
if ( file_exists( $autoloader ) ) {
	include_once $autoloader;
}

add_action( 'plugins_loaded', function () {
    $plugin = new Plugin( __FILE__ );
    $plugin->load()->run();
});

/**
 * Returns the SVG icon based on the icon ID
 *
 * @since  1.0.0
 * @param  string    $icon_id   The icon ID
 * @return string               The SVG icon XML code
 */
function get_svg_icon( $icon_id ) {
    return SVGIconFactory::create( $icon_id );
}
