<?php
/**
 * The core SVG Icon class. Responsible for retrieving and applying accessibility standards to a SVG Icon.
 *
 * @package    SB2Media\SVGIconSystem\SVGIcons
 * @since      1.0.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

namespace SB2Media\SVGIconSystem\SVGIcons;

use DOMDocument;
use ErrorException;
use OutOfBoundsException;
use SB2Media\SVGIconSystem\File\TemplateLoader;
use SB2Media\SVGIconSystem\Config\ConfigInterface;
use SB2Media\SVGIconSystem\Constants as Constants;
use SB2Media\SVGIconSystem\Support\Arr as ArrayHelpers;

class SVGIcon
{
    /**
     * The icon ID
     *
     * @var string
     */
    public $icon_id;

    /**
     * SVG icon configuration
     *
     * @var object
     */
    public $config;

    /**
     * Path to the SVG icon folder. Set in config/icons.php. Can reside in plugin or theme.
     *
     * @var string
     */
    private $icon_folder_path;

    /**
     * Constructor
     *
     * @since 1.0.0
     * @param ConfigInterface $config
     */
    public function __construct( $icon_id, ConfigInterface $config )
    {
        $this->icon_id = $icon_id;

        if( $this->isValidID( $icon_id, $config ) ) {
            $this->config = $config->get( $this->icon_id );
        }

        $this->icon_folder_path = $config->get( 'icon_folder_path' );

        $this->constructConfig();
    }

    /**
     * Render the SVG icon template
     *
     * @since  1.0.0
     * @return
     */
    public function render()
    {
        printf( $this->loadTemplate() );
    }

    /**
     * Final construction of the SVG icon configuration. Conditionally add ARIA accessibility parameters and the primary SVG icon content.
     *
     * @since  1.0.0
     * @return
     */
    private function constructConfig()
    {
        if ( ! array_key_exists( 'filename', $this->config ) ) {
            return __( 'Please define an SVG icon filename.', Constants\PLUGIN_TEXT_DOMAIN );
        }

        $defaults = $this->getDefaults();
        $this->config = \wp_parse_args( $this->config, $defaults );
        $this->config = ArrayHelpers::add( $this->config, 'aria', 'aria-hidden="true"');

        if ( $this->config['title'] ) {
            $this->config = ArrayHelpers::add( $this->config, 'unique_id', $this->generateUniqueID(2) );
            $this->config['aria'] = 'aria-labelledby="title-' . $this->config['unique_id'] . '"';

            if ( $this->config['desc'] ) {
                $this->config['aria'] = 'aria-labelledby="title-' . $this->config['unique_id'] . ' desc-' . $this->config['unique_id'] . '"';
            }
        }

        if( empty( $this->config['viewbox_x'] ) ) {
            $this->config['viewbox_x'] = '0';
        }

        if( empty( $this->config['viewbox_y'] ) ) {
            $this->config['viewbox_y'] = '0';
        }

        if( $this->configHasWidth() ) {
            if( empty( $this->config['viewbox_width'] ) ) {
                $this->config['viewbox_width'] = $this->config['width'];
            }
        }

        if( $this->configHasHeight() ) {
            if( empty( $this->config['viewbox_height'] ) ) {
                $this->config['viewbox_height'] = $this->config['height'];
            }
        }

        $this->config = ArrayHelpers::add( $this->config, 'content', $this->getContent() );
    }

    /**
     * Get the array of svg icon configuration defaults.
     *
     * @since  1.0.0
     * @return array
     */
    private function getDefaults()
    {
        return array(
            'filename'              => '',
            'title'                 => '',
            'desc'                  => '',
            'viewbox_x'             => '0',
            'viewbox_y'             => '0',
            'viewbox_width'         => '',
            'viewbox_height'        => '',
            'width'                 => '',
            'height'                => '',
            'preserve_aspect_ratio' => '',
            'class'                 => '',
            'style'                 => '',
    	);
    }

    /**
     * Load and return the SVG file.
     *
     * @since  1.0.0
     * @return string   The SVG file
     */
    private function loadSVG()
    {
        $file_path = $this->icon_folder_path . $this->config['filename'] . '.svg';
        return file_get_contents( $file_path );
    }

    /**
     * Get the primary SVG icon content (code that displays the icon)
     *
     * @since  1.0.0
     * @return string    The SVG icon content
     */
    private function getContent()
    {
        $svg = $this->loadSVG();
        $inner_tags = array( 'title', 'desc' );
        $outer_tag = 'svg';
        $doc = new DOMDocument();
        $xml_parser = new XMLParser( $doc );

        return $xml_parser->parse( $svg, $inner_tags, $outer_tag );
    }

    /**
     * Generate an unique ID
     *
     * @since  1.0.0
     * @param  integer    $random_id_length  The length of the ID to be generated
     * @return string     $token             The unique ID
     */
    private function generateUniqueID( $random_id_length = 5 )
    {
        $token = '';

        do {
            $bytes = random_bytes( $random_id_length );
            $token .= str_replace(
                ['.','/','=','+'],
                '',
                base64_encode($bytes)
            );
        } while (strlen($token) < $random_id_length );

        return $token;
    }

    /**
     * Load the SVG icon template.
     *
     * @since  1.0.0
     * @return string    The SVG icon template.
     */
    private function loadTemplate()
    {
        $template = new TemplateLoader(
            Constants\PLUGIN_VIEWS_PATH . 'svg-icon.php',
            'svg_icon_template_path',
            'svg-icon'
        );

        return $template->setDependency($this)->loadTemplate();
    }

    /**
     * Checks if the icon ID exists in the icon configuration file.
     *
     * @since  1.0.0
     * @param  string   $icon_id  The icon ID
     * @param  array    $config   The configuation array
     * @return boolean
     */
    private function isValidID( $icon_id, $config )
    {
        if( ! array_key_exists( $icon_id, $config ) ) {
            throw new OutOfBoundsException( __( "The icon ID '{$icon_id}' passed to get_svg_icon() does not exist in the icon configuration file.", Constants\PLUGIN_TEXT_DOMAIN ) );
        }

        return true;
    }

    /**
     * Checks if either a width or viewbox width has been declared in the SVG icon configuration
     *
     * @since  1.0.0
     * @return boolean
     */
    private function configHasWidth()
    {
        if( empty( $this->config['viewbox_width'] ) && empty( $this->config['width'] ) ) {
            throw new ErrorException( __( "A 'width' or 'viewbox_width' must be declared for '{$this->icon_id}' in config/svg-icons.php.", Constants\PLUGIN_TEXT_DOMAIN ) );
        }

        return true;
    }

    /**
     * Checks if either a height or viewbox height has been declared in the SVG icon configuration
     *
     * @since  1.0.0
     * @return boolean
     */
    private function configHasHeight()
    {
        if( empty( $this->config['viewbox_height'] ) && empty( $this->config['height'] ) ) {
            throw new ErrorException( __( "A 'height' or 'viewbox_height' must be declared for '{$this->icon_id}' in config/svg-icons.php.", Constants\PLUGIN_TEXT_DOMAIN ) );
        }

        return true;
    }
}
