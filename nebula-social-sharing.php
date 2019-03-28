<?php
/* *********
*
* Plugin Name: Nebula Social Sharing
* Description: Display your content correctly on social media
* Version: 1.0.0
* Author: Katrine-Marie Burmeister
* Author URI: https://fjordstudio.dk
* License:     GNU General Public License v3.0
* License URI: https://www.gnu.org/licenses/gpl-3.0.html
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

$startup = new Initialization();



function launch () {

    require_once NEBULA_SOCIAL_DIR . 'admin/class-welcome.php';
		$my_welcome = new welcome_class();

    include_once NEBULA_SOCIAL_DIR .'admin/pages/class-options.php';
		$my_options = new options_admin();

    include_once NEBULA_SOCIAL_DIR .'user/class-user-meta.php';
    $my_user = new user_meta();

}
launch();



class Initialization{
	public function __construct(){
	  register_activation_hook( __FILE__, array($this, 'plugin_activated' ));
	  register_deactivation_hook( __FILE__, array($this, 'plugin_deactivated' ));
	  register_uninstall_hook( __FILE__, array($this, 'plugin_uninstall' ) );
	}
	public static function plugin_activated(){
	  set_transient('_nebula_social_welcome', true,30);
	}
	public function plugin_deactivated(){
		delete_transient('_nebula_social_welcome');
	}
	public function plugin_uninstall() {
	  delete_transient('_nebula_social_welcome');
	}
}
