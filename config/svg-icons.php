<?php
/**
 * SVG icon system configuration parameters.
 *
 * @package    SB2Media\SVGIconSystem
 * @since      1.0.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

use SB2Media\SVGIconSystem\Constants as Constants;

return [

    /*********************************************************
    * Folder path to where svg icons reside. Can be in theme or plugin.
    *
    * Format:
    *    $unique_id => $value
    *
    * Plugin path:
    *    'icon_folder_path' => Constants\PLUGIN_DIST_PATH . 'icons/',
    *
    * TwentySeventeen WordPress theme:
    *    'icon_folder_path' => \get_template_directory() . '/assets/images/',
    *
    * Roots Sage 9 theme:
    *    'icon_folder_path' => dirname( \get_template_directory() ) . '/dist/images/',
    *
    *********************************************************/

    'icon_folder_path' => Constants\PLUGIN_DIST_PATH . 'icons/',

    /*********************************************************
    * SVG icon parameters
    *
    * Format:
    *    $icon_id => [
    *       'filename'              => $value,  // Required, MUST match the file name of the SVG icon
    *       'title'                 => $value,  // Optional but highly recommended for standalone, meaningful icons
    *       'description'           => $value,  // Optional but recommended for standalone, meaningful icons
    *       'viewbox_x'             => $value,  // Optional, will default to '0' if left blank
    *       'viewbox_y'             => $value,  // Optional, will default to '0' if left blank
    *       'viewbox_width'         => $value,  // Recommended, width must be set if left blank
    *       'viewbox_height'        => $value,  // Recommended, height must be set if left blank
    *       'width'                 => $value,  // Optional, viewbox_width must be set if left blank
    *       'height'                => $value,  // Optional, viewbox_height must be set if left blank
    *       'preserve_aspect_ratio' => $value,  // Optional
    *       'style'                 => $value,  // Optional
    *    ],
    ********************************************************/
    'menu' =>   [
        'filename'              => 'icon_menu',
        'title'                 => 'Menu icon',
        'desc'                  => 'Three equal width horizontal bars stacked on top of one another to symbolize a menu',
        'viewbox_x'             => '0',
        'viewbox_y'             => '0',
        'viewbox_width'         => '20',
        'viewbox_height'        => '16',
        'width'                 => '20',
        'height'                => '16',
        'preserve_aspect_ratio' => '',
        'style'                 => '',
    ],
    'logo' =>   [
        'filename'              => 'bg_logo_classic',
        'title'                 => 'Barry\'s Gravely Tractors Logo',
        'desc'                  => 'Classic logo for Barry\'s Gravely Tractors',
        'viewbox_x'             => '0',
        'viewbox_y'             => '0',
        'viewbox_width'         => '498',
        'viewbox_height'        => '100',
        'width'                 => '498',
        'height'                => '100',
        'preserve_aspect_ratio' => '',
        'style'                 => '',
    ],

];
