<?php

namespace nebula\socials;

class welcome_class {
  public function __construct()  {
    add_action( 'admin_init', array($this,'welcome_do_activation_redirect') );

    if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
      return;
    }
    // add to menu
    add_action('admin_menu', array($this, 'welcome_pages') );
    add_action('admin_head', array($this, 'welcome_remove_menus' ) );
  }

  public function welcome_do_activation_redirect() {
    // Bail if no activation redirect
    if ( ! get_transient( '_nebula_social_welcome' ) ) {
      return;
    }
    // Redirect
    wp_safe_redirect( add_query_arg( array( 'page' => 'nebula-social-about' ), admin_url( 'index.php' ) ) );
  }

  public function welcome_pages() {
    add_dashboard_page(
      'Plugin Welcome',
      'Plugin Welcome',
      'read',
      'nebula-social-about',
      array( $this,'welcome_content')
    );
  }

  public function welcome_remove_menus() {
    remove_submenu_page( 'index.php', 'nebula-social-about' );
  }

  public static function welcome_content() {
    include(  NEBULA_SOCIAL_DIR . '/admin/views/welcome_content.php' );
    include(  NEBULA_SOCIAL_DIR . '/admin/views/admin-footer.php' );

    delete_transient( '_nebula_social_welcome' );
  }


}
