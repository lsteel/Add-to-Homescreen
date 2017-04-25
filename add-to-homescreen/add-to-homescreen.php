<?php
/*
Plugin Name: Add to Homescreen - Standalone mode for Apple and Android Devices
Plugin URI: https://github.com/lsteel/Add-to-Homescreen
Description: This plugin adds the meta tags needed to allow mobile devices like iPhones and Androids to add sites to the homescreen and have the weblinks use the site as a standalone mobile app, removing the normal browser interface.
Version: 1.01
Author: Lotion Starlord
Author URI: https://lotionstarlord.com
License: GPL2
*/

function ath_register_settings() {
  register_setting( 'ath_options_group', 'ath_option_background_color' );
  register_setting( 'ath_options_group', 'ath_option_ios_padding' );
}

function ath_register_options_page() {
  add_options_page( 'Add to Homescreen Page', 'Add to Homescreen', 'manage_options', 'add-to-homescreen', 'ath_setup_init' );
}

function ath_setup_init() {
  ?>
  <div class="wrap">
    <h1>Add to Homescreen - Settings</h1>
    <p>Here you can customize settings for standalone mode.</p>
    <br>
    <form method="post" action="options.php">
      <?php settings_fields( 'ath_options_group' ); ?>
      <h3>iOS Settings</h3>
      <label for="ath_option_ios_padding">iOS Padding:</label><br>
      <input type="text" id="ath_option_ios_padding" name="ath_option_ios_padding" value="<?php echo get_option('ath_option_ios_padding') ?>" />
      <br><br>
      <label for="ath_option_background_color">Background Color:</label><br>
      <input type="text" id="ath_option_background_color" name="ath_option_background_color" value="<?php echo get_option('ath_option_background_color'); ?>" />
      <?php do_settings_sections( 'ath_options_group-group' ); ?>
      <?php  submit_button(); ?>
    </form>
    <br><br><br>
    <h3>Like the plugin?</h3>
    <p>🙏🏻 Consider donating towards further plugin development! 🚀 (Atleast buy me a drink 🍺? Maybe a coffee ☕️? Something atleast for my troubles. 🤓🙏🏻 )</p>
    <br>
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
      <input type="hidden" name="cmd" value="_s-xclick">
      <input type="hidden" name="hosted_button_id" value="B2D2LDJYC9SHW">
      <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
      <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
    </form>
  </div>
  <?php
}

function ls_add_to_homescreen_header() {
  ?>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="mobile-web-app-title" content="<?php echo get_bloginfo( 'name' ); ?>">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-title" content="<?php echo get_bloginfo( 'name' ); ?>">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <?php
}

function ls_add_to_homescreen_footer() {
  ?>
  <script>
  function isIOS() {
    var userAgent = window.navigator.userAgent.toLowerCase();
    return /iphone|ipad|ipod/.test( userAgent );
  };
  if (window.navigator.standalone && isIOS()) {
    function create(htmlStr) {
      var frag = document.createDocumentFragment(),
      temp = document.createElement('div');
      temp.innerHTML = htmlStr;
      while (temp.firstChild) {
        frag.appendChild(temp.firstChild);
      }
      return frag;
    }

    var fragment = create('<div class="ath-standalone-pad" style="position:relative;width:100%;height:<?php echo get_option('ath_option_ios_padding') ?>px;margin:0;padding:0;background:<?php echo get_option('ath_option_background_color'); ?>;"></div>');
    var headers = document.getElementsByTagName('header');
    for (var i = 0; i < headers.length; i++) {
      headers[i].insertBefore(fragment, headers[i].childNodes[0]);
    }
  };
  </script>
  <?php
}

if ( is_admin() ){ // admin actions
  add_action( 'admin_menu', 'ath_register_options_page' );
  add_action( 'admin_init', 'ath_register_settings' );
}
else {
  // non-admin enqueues, actions, and filters
}

add_action( 'wp_head', 'ls_add_to_homescreen_header', 100 );
add_action( 'wp_footer', 'ls_add_to_homescreen_footer', 100 );
?>
