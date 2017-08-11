# SVG Icon System

A system for inlining accessible SVG icons in WordPress themes.

## Features

* Render SVG icons inline using a simple function call in your WordPress templates.
* SVG icons are deconstructed and rebuilt in adherence to accessibility standards and guidelines.
* A single config file is used to configure all SVG icons.
* Choose whether to store SVG files in theme or plugin.

## Requirements

* [WordPress](https://wordpress.org/) >= 4.7
* [PHP](http://php.net/manual/en/install.php) >= 5.3
* [Composer](https://getcomposer.org/download/)
* [Node.js](http://nodejs.org/) >= 6.9.x

## Installation

1. In terminal (or console) navigate to your WordPress `plugins` directory.
2. Run this command: `composer create-project sb2-media/svg-icon-system`.
3. Change into the SVG Icon System directory: `cd svg-icon-system`.
4. Run `npm install`.
5. Run `npm run dev`.
6. Run `composer dump-autoload -o`.
7. In the WordPress dashboard, navigate to the *Plugins* page and locate the menu item that reads “SVG Icon System.”
8. Click on *Activate.*

## Usage

### Icon Folder Storage

You may choose to store your SVG icon files in this plugin or anywhere in your theme. The plugin will strip the files of all `<svg>`, `<title>` and `<desc>` tags and reconstruct them in adherence to accessibility standards and guidelines.

#### Plugin

By default SVG icons are stored in the `assets/icons` folder in this plugin and then copied over to `dist/icons` when the Laravel Mix build process is run. Store your SVG icons in the `assets/icons` and run the command `npm run dev` or `npm run production` in the plugin's root folder if you wish to utilize the default behavior. `npm run dev` or `npm run production` must be run after adding new SVG icon files to storage.

The `assets/icons` directory contains a SVG icon file for demonstration purposes.

* `icon_menu.svg`

#### Theme

If you wish to store your SVG icon files in your theme, simply change the value of the `icon_folder_path` in `config/svg-icons.php` to the path where the files will be stored. A few examples are given in the comments.

### Config

A single config file `config/svg-icons.php` is used to declare and configure the SVG icons. The configuration follows this convention:

```
    $icon_id => [
        'filename'              => $value,  // Required, MUST match the file name of the SVG icon
        'title'                 => $value,  // Optional but highly recommended for standalone, meaningful icons
        'description'           => $value,  // Optional but recommended for standalone, meaningful icons
        'viewbox_x'             => $value,  // Optional, will default to '0' if left blank
        'viewbox_y'             => $value,  // Optional, will default to '0' if left blank
        'viewbox_width'         => $value,  // Recommended, width must be set if left blank
        'viewbox_height'        => $value,  // Recommended, height must be set if left blank
        'width'                 => $value,  // Optional, viewbox_width must be set if left blank
        'height'                => $value,  // Optional, viewbox_height must be set if left blank
        'preserve_aspect_ratio' => $value,  // Optional
        'style'                 => $value,  // Optional
    ],
```

#### Notes

* The `filename` MUST match the name of the SVG icon file.
* Standalone, meaningful icons should have a title and possibly a description set in their configuration. If a title (and description) is declared, the plugin will render the SVG icon with the `aria-labelledby=` attribute with a unique ID to link the title (and description) to their respective `<title>` (and `<desc>`) elements.
* Purely decorative icons do not need a title and description. Leave them blank in the config and the `aria-hidden="true"` attribute will be added to the `<svg>` element instead.
* Either `width` and `height` or `viewbox_width` and `viewbox_height` attributes MUST be set in the config. If only a `width` and `height` are declared, `viewbox_width` and `viewbox_height` will inherit their values. If only `viewbox_width` and `viewbox_height` values are set, `width` and `height` attributes will not be added to the `<svg>` element.
* The `preservedAspectRatio` and `style` attributes are optional.

#### Examples

File `icon_menu.svg`
```
<?xml version="1.0" encoding="utf-8"?>
<svg viewBox="0 0 20 16" xmlns="http://www.w3.org/2000/svg">
  <rect x="0.016" y="6.41" width="19.969" height="3.18" style="fill: rgb(51, 51, 51);"/>
  <rect x="0.014" y="12.656" width="19.969" height="3.18" style="fill: rgb(51, 51, 51);"/>
  <rect x="0.017" y="0.164" width="19.969" height="3.18"  style="fill: rgb(51, 51, 51);"/>
</svg>
```

Config with the bare minimum set:
```
    'menu' =>   [
        'filename'              => 'icon_menu',
        'title'                 => '',
        'desc'                  => '',
        'viewbox_x'             => '',
        'viewbox_y'             => '',
        'viewbox_width'         => '20',
        'viewbox_height'        => '16',
        'width'                 => '',
        'height'                => '',
        'preserve_aspect_ratio' => '',
        'style'                 => '',
    ],
```

Output:
```
<svg class="icon icon-menu" aria-hidden="true" viewBox="0 0 20 16" role="img">        
    <rect x="0.016" y="6.41" width="19.969" height="3.18" style="fill: rgb(51, 51, 51);"></rect>
    <rect x="0.014" y="12.656" width="19.969" height="3.18" style="fill: rgb(51, 51, 51);"></rect>
    <rect x="0.017" y="0.164" width="19.969" height="3.18" style="fill: rgb(51, 51, 51);"></rect>
</svg>
```

Config with all attributes set:
```
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
        'preserve_aspect_ratio' => 'xMinYMin',
        'style'                 => 'color: red;',
    ],
```

Output:
```
<svg class="icon icon-menu" aria-labelledby="title-nYY desc-nYY" width="20" height="16" viewBox="0 0 20 16" preserveAspectRatio="xMinYMin" style="color: red;" role="img">
    <title id="title-nYY">Menu icon</title>
    <desc id="desc-nYY">Three equal width horizontal bars stacked on top of one another to symbolize a menu</desc>    
    <rect x="0.016" y="6.41" width="19.969" height="3.18" style="fill: rgb(51, 51, 51);"></rect>
    <rect x="0.014" y="12.656" width="19.969" height="3.18" style="fill: rgb(51, 51, 51);"></rect>
    <rect x="0.017" y="0.164" width="19.969" height="3.18" style="fill: rgb(51, 51, 51);"></rect>
</svg>
```

### Function

Icons defined in the config can be placed anywhere in your WordPress templates with the `get_svg_icon( $icon_id )` function call.

```
<button class="menu-toggle">
    <?php get_svg_icon( 'menu' ); ?>
</button>
```

## License

SVG Icon System is licensed under the GPL v2 or later.

> This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as published by the Free Software Foundation.

> This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

> You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA

A copy of the license is included in the root of the plugin’s directory. The file is named `LICENSE`.

## Credits

Portions of this plugin uses code and concepts adapted from [Carl Alexander](https://carlalexander.ca/) and Tonya Mork's [Fulcrum plugin](https://github.com/hellofromtonya/Fulcrum).
