<?php
/**
 * Class handler for the plugin's configuration files.
 * Loads a specified configuration file or array and provides several public methods to access and modify the configuration array.
 *
 * @package    SB2Media\SVGIconSystem\Config
 * @since      1.0.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

 /**
  * This class has been adapted from Tonya Mork's Fulcrum plugin which has a GPL v2 license.
  */

namespace SB2Media\SVGIconSystem\Config;

use ArrayObject;
use InvalidArgumentException;
use RuntimeException;
use SB2Media\SVGIconSystem\Support\Arr as Arr_Helpers;

class Config extends ArrayObject implements ConfigInterface
{
    /**
     * Runtime configuration parameters
     *
     * @var array    $config    Runtime configuration parameters
     */
    protected $config = array();

    /**
     * Accept the configuration file or array and create a new configuration repository.
     *
     * @since 1.0.0
     * @param string|array   $filename    Either the path and filename to the configuration array or an actual config array
     * @param string|array   $default     Optional defaults filename or config array to be merged into the initial config array
     */
    public function __construct( $config, $defaults = '' )
    {
        $this->config = $this->getParameters( $config );
        $this->initDefaults( $defaults );

        parent::__construct( $this->config, ArrayObject::ARRAY_AS_PROPS );
    }

    /**
     * Retrieves all of the runtime configuration parameters
     *
     * @since 1.0.0
     * @return array   The complete configuration parameters
     */
    public function all()
    {
        return $this->config;
    }

    /**
     * Get the specified configuration value.
     *
     * @param  string  $parameter_key
     * @param  mixed   $default
     * @return mixed                    The specified configuration value
     */
    public function get( $parameter_key, $default = null )
    {
        return Arr_Helpers::get( $this->config, $parameter_key, $default );
    }

    /**
     * Determine if the given configuration value exists.
     *
     * @param  string  $parameter_key
     * @return bool
     */
    public function has( $parameter_key )
    {
        return Arr_Helpers::has( $this->config, $parameter_key );
    }

    /**
     * Push a configuration in via the key
     *
     * @since 1.0.0
     *
     * @param  string    $parameter_key    Key to be assigned, which also becomes the property
     * @param  mixed     $value            Value to be assigned to the parameter key
     * @return null
     */
    public function push( $parameter_key, $value )
    {
        $this->config[ $parameter_key ] = $value;
        $this->offsetSet( $paramerter_key, $value );
    }

    /**
     * Retrive the speficied configuration parameters
     *
     * @since  1.0.0
     * @param  string|array   $file_or_array    Either the path and filename to the configuration array or an actual config array
     * @return array                            The configuration array
     */
    protected function getParameters( $file_or_array )
    {
        if( is_array( $file_or_array ) ) {
            return $file_or_array;
        }

        return $this->loadFile( $file_or_array );
    }

    /**
     * Initialize default configuration parameters & merge into the $config parameters
     *
     * @since  1.0.0
     * @param  string|array   $default    Defaults filename or config array to be merged into the initial config array
     * @return null
     */
    protected function initDefaults( $defaults )
    {
        if( ! $defaults ) {
            return;
        }

        $defaults = $this->getParameters( $defaults );
        $this->mergeDefaults( $defaults );
    }

    /**
     * Initialize the configuration array with the defaults
     *
     * @since  1.0.0
     * @param  array   $defaults    The defaults configuration array
     * @return null
     */
    protected function mergeDefaults( array $defaults )
    {
        $this->config = array_replace_recursive( $defaults, $this->config );
    }

    /**
     * Load the configuration file if it is validated
     *
     * @since  1.0.0
     * @param  string    $config_file    The path and filename which contains the configuration array
     * @return string
     */
    protected function loadFile( $config_file )
    {
        if ( $this->isFileValid( $config_file ) ) {
            return include $config_file;
        }
    }

    /**
     * Check if the configuration file is valid. Throws error exceptions if not.
     *
     * @since  1.0.0
     * @param  string    $config_file    The configuration file
     * @return bool
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function isFileValid( $config_file )
    {
        if ( ! $config_file ) {
            throw new InvalidArgumentException( __( 'A config filename must not be empty.', 'svg-icon-system' ) );
        }

        if ( ! is_readable( $config_file ) ) {
            throw new RuntimeException( sprintf( '%s %s', __( 'The specified config file is not readable', 'svg-icon-system' ), $config_file ) );
        }

        return true;
    }

    /**
     * Checks if the parameter key is a valid array, which means:
     *      1. Does it the key exists (which can be dot notation)
     *      2. If the value is an array
     *      3. Is the value empty, i.e. when $valid_if_not_empty is set
     *
     * @since 1.0.0
     *
     * @param string $parameter_key
     * @param bool $valid_if_not_empty
     * @return bool
     */
    public function isArray( $parameter_key, $valid_if_not_empty = true )
    {
        return Arr_Helpers::isArray( $this->config, $parameter_key, $valid_if_not_empty );
    }
}
