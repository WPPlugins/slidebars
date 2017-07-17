<?php
/**
 * WK Slidebars
 * Loader Class
 */


class WKSL_Slidebars_Loader {

	/*==========================MEMBERS=========================*/

	private $textdomain;

	/*==========================METHODS========================*/

	/**
	 * Constructor
	 *
	 * @param $textdomain
	 * @param $dependencies, array of key value pairs specifying latest supported version of icon dependency
	 * 	- 'font-awesome'
	 *  - 'dashicons'
	 *
	 */
	public function __construct( $textdomain, $dependencies ) {
		$this->textdomain = $textdomain;
		$this->dependencies = $dependencies;
	}

	/**
	 * Localizes and loads scripts, styles and icon dependencies for the Slidebars settings page
	 */
	public function admin_scripts( $hook ) {

		if( is_admin() ) {

			if( $hook == 'settings_page_wksl_slidebars' ) {
				//wp_register
				wp_register_script( 'wksl-slidebars-admin-js', plugin_dir_url( __FILE__ ) . 'js/wksl-slidebars-admin.min.js', array('wp-color-picker') );

				//wp_localize
				$admin_js_translations = array(
					'preview_mode_tooltip' => __( 'In preview mode, the slidebar is only visible to logged in WordPress Users.', $this->textdomain ),
					'hide_on_tooltip' => __( 'Define all pages on which the slidebar should not be visible.', $this->textdomain ),
					'push_content_tooltip' => __( 'Decide wether this slidebar should overlap or push the content of your website', $this->textdomain ),
					'use_content_overlay_tooltip' => __( 'Creates a soft overlay over the main content while the slidebar is active.', $this->textdomain ),
				);
				wp_localize_script( 'wksl-slidebars-admin-js', wksl_settings_content , $admin_js_translations );

				//wp_enqueue
				wp_enqueue_style( 'wp-color-picker' );
				wp_enqueue_style( 'wksl-slidebars-admin-css', plugin_dir_url( __FILE__ ) . 'css/wksl-slidebars-admin.css' );
				$this->load_dependencies();
				wp_enqueue_script( 'wksl-slidebars-admin-js' );
			}

		}

	}

	/**
	 * Loads the frontend scripts and icon dependencies
	 */
	public function public_scripts( $hook ) {

		//wp_register
		wp_register_script( 'wksl-slidebars-public-js', plugin_dir_url( __FILE__ ) . 'js/wksl-slidebars-public.js', array('jquery') );

		//wp_localize

		//wp_enqueue
		$this->load_dependencies();
		wp_enqueue_script('wksl-slidebars-public-js');

	}

	/**
	 * Loads icon dependencies based on specified version numbers
	 */
	public function load_dependencies() {

		//Font Awesome
		$font_awesome_version = $this->dependencies['font-awesome'];
		$font_awesome_url = "https://maxcdn.bootstrapcdn.com/font-awesome/$font_awesome_version/css/font-awesome.min.css";
		wp_enqueue_style( 'font-awesome-icons', $font_awesome_url, array(), $font_awesome_version );

		$dashicons_version = $this->dependencies['dashicons'];
		wp_enqueue_style( 'dashicons', false, array(), $dashicons_version );

	}

}

?>
