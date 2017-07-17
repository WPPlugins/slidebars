<?php
/**
 * WK Slidebars
 * Settings Class
 */

class WKSL_Slidebars_Settings {

	/*==========================MEMBERS=========================*/

	private $textdomain;

	/*==========================METHODS========================*/

	/**
	 * Constructor
	 */
	public function __construct( $textdomain, $dependencies ) {
		$this->textdomain = $textdomain;
		$this->dependencies = $dependencies;
	}

	/**
	 * Registers one global settings group and setting that saves all options as serialized array
	 * and all the individual settings fields
	 */
	public function register() {

		register_setting( 'wksl_slidebars_group', 'wksl_slidebars_settings' );

		add_settings_section(
			'slidebar',
			__( 'Slidebar', $this->textdomain ),
			array( $this, 'slidebar'),
			'wksl_slidebars'
		);

		add_settings_field(
			'preview_mode',
			__('Preview mode', $this->textdomain),
			array( $this, 'preview_mode'),
			'wksl_slidebars',
			'slidebar'
		);

		add_settings_field(
			'hide_on',
			__('Hide on', $this->textdomain),
			array( $this, 'hide_on'),
			'wksl_slidebars',
			'slidebar'
		);

		add_settings_field(
			'push_content',
			__('Push content', $this->textdomain),
			array( $this, 'push_content'),
			'wksl_slidebars',
			'slidebar'
		);

		add_settings_field(
			'use_content_overlay',
			__('Content overlay', $this->textdomain),
			array( $this, 'use_content_overlay'),
			'wksl_slidebars',
			'slidebar'
		);

		add_settings_field(
			'position',
			__('Position', $this->textdomain),
			array( $this, 'position'),
			'wksl_slidebars',
			'slidebar'
		);

		add_settings_field(
			'sidebar_background_color',
			__('Sidebar background', $this->textdomain),
			array( $this, 'sidebar_background_color'),
			'wksl_slidebars',
			'slidebar'
		);

		add_settings_field(
			'icon_background_color',
			__('Icon background', $this->textdomain),
			array( $this, 'icon_background_color'),
			'wksl_slidebars',
			'slidebar'
		);

		add_settings_field(
			'icon_color',
			__('Icon color', $this->textdomain),
			array( $this, 'icon_color'),
			'wksl_slidebars',
			'slidebar'
		);

		add_settings_field(
			'button_icon',
			__('Icon', $this->textdomain),
			array( $this, 'button_icon'),
			'wksl_slidebars',
			'slidebar'
		);

		add_settings_field(
			'custom_css',
			__('Custom CSS', $this->textdomain),
			array( $this, 'custom_css'),
			'wksl_slidebars',
			'slidebar'
		);

	}

	/**
	 * Adds a new options subpage to 'Settings'
	 */
	public function render() {
		add_options_page(
			'Slidebars',
			'Slidebars',
			'manage_options',
			'wksl_slidebars',
			array( $this, 'content' )
			);
	}

	/**
	 * Outputs all the markup for the options page, renders all the registered settings
	 * and the mailchimp newsletter form
	 */
	public function content() {

		?>
		<div class="wrap">
			<h2><?php _e('Slidebar Settings', $this->textdomain); ?></h2>
			<div class="wk-left-part">
				<form action="options.php" method="POST">
					<?php settings_fields( 'wksl_slidebars_group' ); ?>
					<?php do_settings_sections( 'wksl_slidebars' ); ?>
					<?php submit_button( __( 'Save' , $this->textdomain) ); ?>
				</form>
			</div>
			<div class="wk-right-part">
				<h2>Button with Shortcode</h2>
				This plugin supports custom slidebar buttons using the shortcode
				<code>[wksl_slidebar_button text="yourtext"]</code> where you can replace "yourtext" with whatever you like.
				The button will use the default styling defined by your theme.
				<?php include_once( __DIR__ . "/components/mailchimp-form.php" ); ?>
			</div>
		</div>

		<?php
	}

	/**
	 * Section: Slidebar
	 * Name: 		slidebar
	 */
	public function slidebar() {
		_e('Customize your Slidebar using the settings below. If you check preview mode, only logged in WordPress users will see the slidebar.', $this->textdomain);
	}

	/**
	 * Field: 	Preview Mode
	 * Name:		preview_mode
	 */
	public function preview_mode() {

		$field = 'preview_mode';
		$value = $this->get_wksl_slidebars_option( $field );
		?>

			<input type="checkbox" name="wksl_slidebars_settings[<?php echo $field; ?>]" value="1" <?php checked( 1 == $value); ?> />

		<?php
	}

	/**
	 * Field: 	Content Overlay
	 * Name:		use_content_overlay
	 */
	public function use_content_overlay() {

		$field = 'use_content_overlay';
		$value = $this->get_wksl_slidebars_option( $field );
		?>

			<input type="checkbox" name="wksl_slidebars_settings[<?php echo $field; ?>]" value="1" <?php checked( 1 == $value); ?> />

		<?php
	}

	/**
	 * Field: 	Sidebar Background Color
	 * Name:		sidebar_background_color
	 */
	public function sidebar_background_color() {

		$field = 'sidebar_background_color';
		$value = $this->get_wksl_slidebars_option( $field );

		echo "<input type='text' class='wksl-slidebars-color-field' name='wksl_slidebars_settings[$field]' value='$value' />";

	}

	/**
	 * Field: 	Icon Background Color
	 * Name:		icon_background_color
	 */
	public function icon_background_color() {

		$field = 'icon_background_color';
		$value = $this->get_wksl_slidebars_option( $field );

		echo "<input type='text' class='wksl-slidebars-color-field' name='wksl_slidebars_settings[$field]' value='$value' />";

	}

	/**
	 * Field: 	Icon Color
	 * Name:		icon_color
	 */
	public function icon_color() {

		$field = 'icon_color';
		$value = $this->get_wksl_slidebars_option( $field );

		echo "<input type='text' class='wksl-slidebars-color-field' name='wksl_slidebars_settings[$field]' value='$value' />";

	}

	/**
	 * Field: 	Position
	 * Name:		position
	 */
	public function position() {

		$field = 'position';
		$value = $this->get_wksl_slidebars_option( $field );

		?>
			<div class="wk-setting-radio"><input type="radio" name="wksl_slidebars_settings[<?php echo $field; ?>]" value="left" <?php checked('left', $value, true); ?> /><?php _e('left', $this->textdomain); ?></div>
			<div class="wk-setting-radio"><input type="radio" name="wksl_slidebars_settings[<?php echo $field; ?>]" value="right" <?php checked('right', $value, true); ?> /><?php _e('right', $this->textdomain); ?></div>
		<?php

	}

	/**
	 * Field: Hide on
	 * Name: 	hide_on
	 */
	public function hide_on() {

		$field = 'hide_on';
		$value = $this->get_wksl_slidebars_option( $field );
		?>

		<div class="wk-json-setting">
			<?php wp_dropdown_pages(); ?>
			<span class="wk-json-value-adder">+</span>
			<input type="hidden" class="wk-json-value-container" name="wksl_slidebars_settings[<?php echo $field; ?>]" value="<?php echo $value; ?>" />
			<ul class="wk-json-value-display"></ul>
		</div>

		<?php

	}

	/**
	 * Field: Button Icon
	 * Name: 	button_icon
	 */
	public function button_icon() {

		$field = 'button_icon';
		$value = $this->get_wksl_slidebars_option( $field );
		$font_awesome_version = $this->dependencies['font-awesome'];
		$font_awesome_classes = json_decode( file_get_contents( __DIR__ . "/source/fontawesome-$font_awesome_version.json") );

		$dashicons_version = $this->dependencies['dashicons'];
		$dashicons_classes = json_decode( file_get_contents( __DIR__ . "/source/dashicons-$dashicons_version.json") );
		?>

		<div class="wk-select-setting">
			<input type="hidden" class="wk-select-value-container" name="wksl_slidebars_settings[<?php echo $field; ?>]" value="<?php echo $value; ?>" placeholder="search for icon" />
			<input type="text" class="wk-select-value-search" value="" placeholder="<?php _e("Search icons by name...", $this->textdomain); ?>" />
			<ul class="wk-select-options-container">
			<h6><?php _e("Font Awesome", $this->textdomain); ?> (<?php echo count( $font_awesome_classes ); ?> <?php _e("icons", $this->textdomain); ?>) </h6>
			<?php
				foreach( $font_awesome_classes as $font_awesome_class ) {
					?>
						<li class="wk-select-value-option <?php echo $font_awesome_class; ?>" data-value="<?php echo $font_awesome_class; ?>"></li>
					<?php
				}
			?>
			<h6><?php _e("WordPress", $this->textdomain); ?> (<?php echo count( $dashicons_classes ); ?> <?php _e("icons", $this->textdomain); ?>) </h6>
			<?php
				foreach( $dashicons_classes as $dash_icon_class ) {
					?>
						<li class="wk-select-value-option <?php echo $dash_icon_class; ?>" data-value="<?php echo $dash_icon_class; ?>"></li>
					<?php
				}
			?>
			</ul>
		</div>

		<?php

	}

	/**
	 * Field: 	Push Content
	 * Name:		push_content
	 */
	public function push_content() {

		$field = 'push_content';
		$value = $this->get_wksl_slidebars_option( $field );
		?>

			<input type="checkbox" name="wksl_slidebars_settings[<?php echo $field; ?>]" value="1" <?php checked( 1 == $value); ?> />

		<?php
	}

	/**
	 * Field: 	Custom CSS
	 * Name:		custom_css
	 */
	public function custom_css() {

		$field = 'custom_css';
		$value = $this->get_wksl_slidebars_option( $field );
		?>

			<textarea class="wk-textarea-setting" name="wksl_slidebars_settings[<?php echo $field; ?>]" value="<?php echo $value; ?>" ><?php echo $value; ?></textarea>

		<?php
	}

	/**
	 * Options helper functions that checks all settings against an array of defaults
	 *
	 * @param Option name, a.k.a. name of the settings field
	 *
	 * @return Defaulted value of the requested setting
	 *
	 */
	public function get_wksl_slidebars_option( $optionname ) {

		$defaults = array(
			'icon_background_color' => 'black',
			'icon_color' => 'white',
			'sidebar_background_color' => 'white',
			'position' => 'left',
			'hide_on' => '[]',
			'button_icon' => 'fa-bars',
			'push_content' => null,
			'preview_mode' => false,
			'custom_css' => ''
			);

		$defaulted_options = wp_parse_args( get_option( 'wksl_slidebars_settings' ), $defaults );

		return $defaulted_options[$optionname];
	}

}

?>
