<?php
/**
 * An event subscriber who can use the WordPress plugin API manager to
 * trigger additional event.
 *
 * @package    SB2Media\SVGIconSystem\EventManagement
 * @since      1.0.0
 * @author     Carl Alexander <contact@carlalexander.ca>
 * @link       http://carlalexander.ca
 * @license    GNU General Public License 2.0+
 */

namespace SB2Media\SVGIconSystem\EventManagement;

interface PluginAPIManagerAwareSubscriberInterface extends SubscriberInterface
{
    /**
     * Set the WordPress Plugin API manager for the subscriber.
     *
     * @param PluginAPIManager $plugin_api_manager
     */
    public function setPluginAPIManager(PluginAPIManager $plugin_api_manager);
}
