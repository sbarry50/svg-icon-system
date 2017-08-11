<?php
namespace SB2Media\SVGIconSystem;

use SB2Media\SVGIconSystem\Setup\Compatibility;
use SB2Media\SVGIconSystem\Constants as Constants;
?>

<div class="error">
    <p>
        <strong>Your current system environment does not meet the minimum requirements to run <?= Constants\PLUGIN_NAME ?>:</strong></br>
        <table style="text-align: center;">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Minimum</th>
                    <th>Current</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th style="text-align: left;">Wordpress</th>
                    <td><?= Constants\PLUGIN_MIN_WP_VERSION; ?></td>
                    <td><?= Constants\WP_VERSION; ?></td>
                    <td><?php Compatibility::renderDashicon( Constants\WP_VERSION, Constants\PLUGIN_MIN_WP_VERSION ); ?></td>
                </tr>
                <tr>
                    <th style="text-align: left;">PHP</th>
                    <td><?= Constants\PLUGIN_MIN_PHP_VERSION; ?></td>
                    <td><?= PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION . '.' . PHP_RELEASE_VERSION; ?></td>
                    <td><?php Compatibility::renderDashicon( PHP_VERSION, Constants\PLUGIN_MIN_PHP_VERSION ); ?></td>
                </tr>
            </tbody>
        </table>
    </p>
    <p>
        <strong><?= Constants\PLUGIN_NAME ?> has been deactivated.</strong>
    </p>
    <p>
        <strong>Please update your environment to activate <?= Constants\PLUGIN_NAME ?>.</strong>
    </p>
</div>
