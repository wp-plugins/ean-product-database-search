<?php

/**
 * Plugin Name: EAN product database search
 * Plugin URI: http://pleep.net
 * Description: Das Plugin zeigt Preise und Bewertungen zu EAN-Codes von Produkten an.
 * Version: 1.0
 * Author: pleep.net
 * Author URI: http://pleep.net
 * License: GPL2
 */

/*  Copyright 2014  Webworks Nürnberg  (email : kontakt@webworks-nuernberg.de)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (!defined('ABSPATH')) {
    die("No direct access please!");
};

if (!defined('AD_PLUGIN_DIR_NAME')) {
    define('AD_PLUGIN_DIR_NAME', basename(__DIR__));
}

require_once __DIR__. DIRECTORY_SEPARATOR. 'lib/api.php';

function pleep_ean_shortcode($atts) {
    $a = shortcode_atts(array(
        'ean'       => 'something',
    ), $atts);

    $ean = $a['ean'];
    $api = new PleepApi();
    echo $api->getData($ean)->getHtml();
}

add_shortcode('pleep', 'pleep_ean_shortcode');
