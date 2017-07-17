<?php
/*
Plugin Name: Slidebars
Plugin URI:  http://www.webkinder.ch
Description: Let's you create and customize slide-in sidebars
Version:     0.4.2
Author:      WebKinder
Author URI:  http://www.webkinder.ch
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /lang/
Text Domain: wksl-slidebars
*/

class WKSL_Slidebars {

    /*==========================MEMBERS=========================*/

    private $settings, $sidebars, $shortcodes, $lifecycle, $i18n, $textdomain, $dependencies;

    /*==========================CONSTRUCTOR====================*/

    public function __construct() {

    	//Internal Setup
    	$this->textdomain = 'wksl-slidebars';
      $this->dependencies = array(
        'font-awesome' => '4.7.0',
        'dashicons' => '3.8'
      );
    	//===

    	//Lifecycle
    	require_once( plugin_dir_path( __FILE__ ) . 'includes/wksl-slidebars-lifecycle.php');
    	$this->lifecycle = new WKSL_Slidebars_Lifecycle( $this->textdomain );

    	register_activation_hook( __FILE__, array( $this, "activation" ) );
    	register_deactivation_hook( __FILE__, array( $this, "deactivation" ) );
    	//===

    	//i18n
    	require_once( plugin_dir_path( __FILE__ ) . 'includes/wksl-slidebars-i18n.php');
    	$this->i18n = new WKSL_Slidebars_i18n( $this->textdomain );

    	add_action('plugins_loaded', array( $this, "load_textdomain") );
    	//===

      //Settings
    	require_once( plugin_dir_path( __FILE__ ) . 'admin/wksl-slidebars-settings.php' );
      $this->settings = new WKSL_Slidebars_Settings( $this->textdomain, $this->dependencies );

      add_action( 'admin_init', array( $this, "register_settings" ) );
      add_action( 'admin_menu', array( $this, "render_settings_page" ) );
      //===

      //Sidebars
      require_once( plugin_dir_path( __FILE__ ) . 'public/wksl-slidebars-sidebars.php' );
      $this->sidebars = new WKSL_Slidebars_Sidebars( $this->textdomain );

      add_action( 'widgets_init', array( $this, "register_sidebars" ) );
      add_action( 'wp_footer', array( $this, "render_sidebars" ) );
      add_action( 'wp_head', array( $this, "custom_styles") );
      //===

      //Shortcodes
      require_once( plugin_dir_path( __FILE__ ) . 'public/wksl-slidebars-shortcodes.php' );
      $this->shortcodes = new WKSL_Slidebars_Shortcodes( $this->textdomain );

      $this->shortcodes->add();

      //===

      //Loader
      require_once( plugin_dir_path( __FILE__ ) . 'includes/wksl-slidebars-loader.php');
      $this->loader = new WKSL_Slidebars_Loader( $this->textdomain, $this->dependencies );
      add_action( 'admin_enqueue_scripts', array( $this, "load_admin_scripts") );
      add_action( 'wp_enqueue_scripts', array( $this, "load_public_scripts") );
      //===

    }

    /*==========================METHODS========================*/

    /**
     * Load Text Domain
     */
  	public function load_textdomain() {
        $this->i18n->load_textdomain();
  	}

    /**
     * Plugin Activation
     */
    public function activation() {
        $this->lifecycle->activate();
    }

    /**
     * Plugin Deactivation
     */
    public function deactivation() {
        $this->lifecycle->deactivate();
    }
    /**
     * Register Settings
     */
    public function register_settings() {
        $this->settings->register();
    }

    /**
     * Render Settings Page
     */
    public function render_settings_page() {
       	$this->settings->render();
    }

    /**
     * Register Sidebars
     */
    public function register_sidebars() {
       	$this->sidebars->register();
    }

    /**
     * Register Sidebars
     */
    public function render_sidebars() {
      if( $this->should_render_slidebar() ) {

        $settings_array = array(
          'button_icon' => $this->settings->get_wksl_slidebars_option('button_icon'),
          'use_content_overlay' => $this->settings->get_wksl_slidebars_option('use_content_overlay')
        );

        $this->sidebars->render( $settings_array );

      }
    }

    /**
     * Passes all style settings down to the custom styles method of sidebars class
     */
    public function custom_styles() {
      if( $this->should_render_slidebar() ) {

        $settings_array = array(
            'icon_background_color' => $this->settings->get_wksl_slidebars_option('icon_background_color'),
            'icon_color' => $this->settings->get_wksl_slidebars_option('icon_color'),
            'sidebar_background_color' => $this->settings->get_wksl_slidebars_option('sidebar_background_color'),
            'position' => $this->settings->get_wksl_slidebars_option('position'),
            'hide_on' => $this->settings->get_wksl_slidebars_option('hide_on'),
            'push_content' => $this->settings->get_wksl_slidebars_option('push_content'),
            'custom_css' => $this->settings->get_wksl_slidebars_option('custom_css'),
            'use_content_overlay' => $this->settings->get_wksl_slidebars_option('use_content_overlay')
        );

        $this->sidebars->custom_styles( $settings_array );

      }
    }

    /**
     * Admin Scripts
     */
    public function load_admin_scripts( $hook ) {
    	$this->loader->admin_scripts( $hook );
    }

    /**
     * Loads public scripts if the slidebar is active on frontend
     */
    public function load_public_scripts( $hook ) {
      if( $this->should_render_slidebar() ) {

         $this->loader->public_scripts( $hook );

      }
    }

    /**
     * Returns wether the slidebar gets rendered or not
     *
     * @return boolean
     *
     */
    public function should_render_slidebar() {
      $is_preview_mode = $this->settings->get_wksl_slidebars_option('preview_mode');
      $is_logged_in    = is_user_logged_in();

      return !$is_preview_mode || $is_logged_in;
    }


}

$wksl_slidebars = new WKSL_Slidebars();

?>
