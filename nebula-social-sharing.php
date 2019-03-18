<?php
/* *********
*
* Plugin Name: Nebula Social Sharing
* Description: Display your content correctly on social media
* Version: 1.0.0
* Author: Katrine-Marie Burmeister
* Author URI: https://fjordstudio.dk
* License:     GPL-2.0+
* License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*
** */

namespace nebula\socials;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Go away!' );
}

$plugin_url = plugin_dir_path(__DIR__);
if(is_ssl()){
	$plugin_url = str_replace('http://', 'https://', $plugin_url);
}
define( 'NEBULA_SOCIAL_URL', $plugin_url.'udm-social/');
define( 'NEBULA_SOCIAL_DIR', plugin_dir_path(__FILE__));
define( 'NEBULA_SOCIAL_VERS', '1.0.0');