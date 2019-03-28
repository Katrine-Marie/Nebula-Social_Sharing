<div class="wrap admin-page nebula-options" >

  <h1 class="title"><?php echo esc_html( get_admin_page_title() ); ?></h1>

  <form method="post" action="<?php echo esc_html(admin_url('admin-post.php')); ?>">

    <label for="user-posts" class="regular-number">Show on Posts: </label>
    <input type="checkbox" name="user-posts" value="1" <?php echo $this->GetCheckbox('user-posts'); ?> >
    <br/>
    <label for="user-pages" class="regular-number">Show on Pages: </label>
    <input type="checkbox" name="user-pages" value="1" <?php echo $this->GetCheckbox('user-pages'); ?> >

    <h3>Default Meta Image</h3>
    <P>This will display unless a featured image is found on a post or page.</P>
    <div class='features'>
      <p  class="hide-if-no-js">
        <a title="Set Meta Image" href="javascript:;" id="set-first-thumbnail">Set a default Meta Image</a>
      </p>
      <div id="featured-first-image-container" class="text">
        <img src="<?php echo $this->GetOption('meta-thumbnail-src'); ?>"
             alt="<?php echo $this->GetOption('meta-thumbnail-alt'); ?>"
             title="<?php echo $this->GetOption('meta-thumbnail-title'); ?>" />
      </div>

      <p class="hide-if-no-js text">
        <a title="Remove Background Image" href="javascript:;" id="remove-first-thumbnail">Remove meta Image</a>
      </p><!-- .hide-if-no-js -->

      <p id="featured-first-image-info">These are hidden here
        <input type="text" id="first-thumbnail-src" name="meta-thumbnail-src" value="<?php echo $this->GetOption('meta-thumbnail-src'); ?>" />
        <input type="text" id="first-thumbnail-title" name="meta-thumbnail-title" value="<?php echo $this->GetOption('meta-thumbnail-title'); ?>" />
        <input type="text" id="first-thumbnail-alt" name="meta-thumbnail-alt" value="<?php echo $this->GetOption('meta-thumbnail-alt'); ?>" />
      </p><!-- #featured-first-image-meta -->
    </div>

    <h3>Facebook</h3>
    <p>
      How do you want facebook links and shares to be shown?<br/>
      Most useful when you have many shares as http://yoursite.com and then you changed to SSL.
    </p>
    <label for="fb_url" class="regular-number">Facebook url as: </label>
    <select id="fb_url" name="fb_url">
      <option value="default" <?php echo $this->GetSelected('fb_url','default'); ?>>Default to Site URL</option>
      <option value="http"<?php echo $this->GetSelected('fb_url','http'); ?>>Default to http://sitename</option>
      <option value="SSL" <?php echo $this->GetSelected('fb_url','SSL'); ?>>Default to https://sitename (SSL)</option>
    </select>

    <h3>Twitter Handles</h3>
    <p>If these are empty then nothing is shown</p>
    <label for="twitter_site" class="regular-number">Twitter Site Tag: </label>
    <input type="text" name="twitter_site" value="<?php echo $this->GetOption('twitter_site'); ?>" >
    <br/>
    <label for="twitter_creator" class="regular-number">Twitter Creator Tag: </label>
    <input type="text" name="twitter_creator" value="<?php echo $this->GetOption('twitter_creator'); ?>" >

    <h3>For other pages (not page or post)</h3>
    <p>If these are empty then the General Settings: Site title and tagline are shown.</p>
    <label for="site_title" class="regular-number">Site Title: </label>
    <input type="text" name="site_title" class="meta-large" value="<?php echo $this->GetOption('site_title'); ?>" >
    <br/>
    <label for="site_desc" class="regular-number">Site Description: </label>
    <input type="text" name="site_desc" class="meta-large" value="<?php echo $this->GetOption('site_desc'); ?>" >

    <!--
    <h3>Google Data</h3>
    <p>If you want to use this to register with Google Search Console</p>
    <label for="search_meta" class="regular-number">Google Search</label>
    <input type="text" name="search_meta" class="meta-large"  value="<?php echo $this->GetOption('search_meta'); ?>" >
    <br/>
    <p>If you want to use this to setup Google Tag manager</p>
    <label for="google_tag" class="regular-number">Tag manager: </label>
    <input type="text" name="google_tag" value="<?php echo $this->GetOption('google_tag'); ?>" >
		-->
    <input type="hidden" name="action" value="NEBULA_social_settings">
    <input type="hidden" name="version" value="<?php echo $this->GetOption('version'); ?>">
    <?php
      wp_nonce_field( 'NEBULA-social-settings-save', 'NEBULA-custom-message' );
      submit_button();
    ?>
  </form>
    
  <h5><a href="index.php?page=nebula-social-about">Return to the Welcome Page</a></h5>

</div>
