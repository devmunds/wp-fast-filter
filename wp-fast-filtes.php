<?php
/*
* Plugin name: WP FAST FILTES
* Version: 1.0.1
* Description: Custom filter by shortcode [wp-fast-filtes posts_per_page="10" category_slug="economico"]
* Author: Devmunds
* Author uri: https://devmunds.com.br/
* Requires PHP: 7.0.2
* Requires at least: 5.0
* Tested up to: 5.6.2
* License: GPLv2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

$plugin_uri = plugin_dir_path(__FILE__);

require_once($plugin_uri . 'includes/functions.php');
require_once( $plugin_uri . 'includes/hooks.php');