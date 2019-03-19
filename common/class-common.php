<?php

namespace nebula\socials;

class NEBULA_Common {

  /********************************************************************************************************************/
  // Functions common across all plugins

  public function GetOption($key) {
    $key = $this->nebula_prefix . $key;
      if (array_key_exists($key, $this->nebula_options)) {
        return $this->nebula_options[$key];
      } else
        return null;
  }

  public function GetCheckbox($key) {
    $key = $this->nebula_prefix . $key;
    if (array_key_exists($key, $this->nebula_options)) {
      if ($this->nebula_options[$key]==1) {
        return 'checked';
      } else return;
    } else
      return $key;
  }

  public function CheckValue($key, $chk = 'static' ) {
    $key = $this->nebula_prefix . $key;
    if (array_key_exists($key, $this->nebula_options)) {
      if ($this->nebula_options[$key]==$chk) {
        return true;
      } else return false;
    } else
    { return false; }
  }

  public function GetSelected($key, $value) {
    $key = $this->nebula_prefix . $key;
    if (array_key_exists($key, $this->nebula_options)) {
      if ($this->nebula_options[$key]==$value) {
        return 'selected';
      }
    }
  }

  /**
   *  Loads options from database.
   * loops through Only values that already known in the settings.
   * and laods any stored values
   */
  function LoadOptions () {
    $this->InitOptions();
    // load default values
    foreach ($this->nebula_default_options as $key => $value) {
      $this->nebula_options[$key] = $value;
    }
    // bring in loaded values
    $storedoptions = get_option($this->nebula_data);
    if ($storedoptions && is_array($storedoptions)) {
      foreach ($storedoptions as $key => $value) {
        $this->nebula_options[$key] = $value;
      }
    } else
      update_option($this->nebula_data, $this->nebula_default_options);
  }

  public function Save_Options ( $save_option, $new_value) {
    // Validate the nonce and verify the user as permission to save.
    if (!( $this->has_valid_nonce() && current_user_can('manage_options') )) {
      echo "Error: You can not save this data";
      die;
    }
    // validation in main class
    update_option($save_option, $new_value);
    $this->redirect();
  }

  private function redirect() {

    if (!isset($_POST['_wp_http_referer'])) { // Input var okay.
      $_POST['_wp_http_referer'] = wp_login_url();
    }

    $url = sanitize_text_field(
      wp_unslash($_POST['_wp_http_referer']) // Input var okay.
    );

    // Redirect back to the admin page.
    wp_safe_redirect(urldecode($url));
    exit;
  }

}
