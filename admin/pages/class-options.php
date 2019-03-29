<?php

namespace nebula\socials;

include_once NEBULA_SOCIAL_DIR .'common/class-common.php';

if (!class_exists('options_admin')) {

  class options_admin extends NEBULA_Common {

    public function __construct()  {
    	global $pagenow;
      // data array for active values
      $this->nebula_options = array();
      // data array for default values
      $this->nebula_default_options = array();
      // prefix for all variables
      $this->nebula_prefix = 'nebula_';
      // name of data record in wp_options
      $this->nebula_data = 'nebula-social-options';
      // used for style sheet reg
      $this->myname = 'nebula_social_options';
      // add the menu
      add_action( 'admin_menu', array( $this, 'add_options_page' ) );
      add_action( 'admin_post_NEBULA_social_settings', array( $this, 'validate_options' ) );
      // only call enqueue when our page is being called.
      if (($pagenow == 'options-general.php' ) && ( $_GET["page"] == 'social-options-page')) {
          add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
          add_action( 'admin_enqueue_scripts', array($this,'enqueue_scripts') );
      }
      $this->LoadOptions();
      $this->UpgradeOptions();
    }

    // content of options page
    public function options_page_html()
    {
        // check user capabilities
        if (!current_user_can('manage_options')) {
            return;
        }
        wp_enqueue_style($this->myname);
                    include (  NEBULA_SOCIAL_DIR . '/admin/views/options-html.php' );
                    include (  NEBULA_SOCIAL_DIR . '/admin/views/admin-footer.php' );
    }

    public function add_options_page() {
    	add_options_page(
        'Nebula Social Share Options',
        'Social Sharing Settings',
        'manage_options',       // admin level
        'social-options-page',    // page name
        array( $this, 'options_page_html' )
      );
	  }

    function InitOptions() {
    	// set a default version number
      // add in all default value fields here
      // then saved values will be loaded on top.
      $this->nebula_default_options[$this->nebula_prefix . 'version'] = 1.0;
      $this->nebula_default_options[$this->nebula_prefix . 'twitter_site'] = '';
      $this->nebula_default_options[$this->nebula_prefix . 'twitter_creator'] = '';
      $this->nebula_default_options[$this->nebula_prefix . 'user-posts'] = 1;
      $this->nebula_default_options[$this->nebula_prefix . 'user-pages'] = 1;
      $this->nebula_default_options[$this->nebula_prefix . 'meta-thumbnail-src'] = '';
      $this->nebula_default_options[$this->nebula_prefix . 'meta-thumbnail-alt'] = '';
      $this->nebula_default_options[$this->nebula_prefix . 'meta-thumbnail-title'] = '';
      $this->nebula_default_options[$this->nebula_prefix . 'site_title'] = '';
      $this->nebula_default_options[$this->nebula_prefix . 'site_desc'] = '';
      $this->nebula_default_options[$this->nebula_prefix . 'fb_url'] = 'default';
  	}

    /**
    * Upgrade data from old version
    * change or introduce new value from releases
    */
    function UpgradeOptions() {
    	if ( $this->nebula_options[$this->nebula_prefix . 'version'] < 1.0) {
    		$this->nebula_options[$this->nebula_prefix . 'version'] = '1.0';
    	}
    }

    public function validate_options() {
    	foreach ( $this->nebula_default_options as $key => $value) {
      	$targ = substr($key, strlen($this->nebula_prefix));

      	switch ($targ) {
      	    case 'string':
      	    case 'version':
      	    case 'twitter_site':
      	    case 'twitter_creator':
      	    case 'meta-thumbnail-src':
      	    case 'meta-thumbnail-alt':
      	    case 'meta-thumbnail-title':
      	    case 'site_title':
      	    case 'site_desc':
      	    case 'fb_url':
      	        $this->nebula_options[$key] = sanitize_text_field($_POST[$targ]);
      	        break;

      	    case 'checkbox':
      	    case 'user-posts':
      	    case 'user-pages':

      	        if (isset($_POST[$targ])) {
      	            $this->nebula_options[$key] = 1;
      	        }   else $this->nebula_options[$key] = 0;
      	        break;
      	}
      }
     	$this->Save_Options($this->nebula_data, $this->nebula_options);
    }

		public function enqueue_styles() {
   		wp_enqueue_style(
      	$this->myname,
				plugins_url('../css/options.css', __FILE__),
        array()
      );
		}

    public function enqueue_scripts() {
   		if ( 1==1 ) {
   		  wp_enqueue_media();
   		  wp_enqueue_script( 'jquery-ui-core' );

   		  wp_enqueue_script('demo-imag-load', plugins_url('../js/media-image.js', __FILE__),
   		    array('jquery'), '1.0', 'all'
   		  );
   		}
    }

   	public function has_valid_nonce() {
    	// If the field isn't even in the $_POST, then it's invalid.
      if (!isset($_POST['NEBULA-custom-message'])) {
      	return false;
      }

      $field = wp_unslash($_POST['NEBULA-custom-message']);
      $action = 'NEBULA-social-settings-save';

      return wp_verify_nonce($field, $action);
    }

  }

}
