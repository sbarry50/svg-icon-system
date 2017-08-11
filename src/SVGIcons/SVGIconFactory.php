<?php
/**
 * Icon Factory
 *
 * @package    SB2Media\SVGIconSystem\SVGIcons
 * @since      1.0.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace SB2Media\SVGIconSystem\SVGIcons;

use SB2Media\SVGIconSystem\Config\Config;
use SB2Media\SVGIconSystem\Constants as Constants;

class SVGIconFactory
{
    /**
     * Load the Config and SVGIcon objects. Return the SVGIcon render() method.
     *
     * @since  1.0.0
     * @param  string    $icon_id   The icon ID
     * @return string               The SVG icon XML code
     */
    public static function create( $icon_id )
    {
        $config_file_path = Constants\PLUGIN_CONFIG_PATH . 'svg-icons.php';
        $icons_config = new Config( $config_file_path );
        $svg_icon = new SVGIcon( $icon_id, $icons_config );

        return $svg_icon->render();
    }
}
