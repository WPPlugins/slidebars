<?php
/**
 * WK SLidebars
 * Shortcodes Class
 */


class WKSL_Slidebars_Shortcodes {

	/**
	 * Text Domain
	 */
	public $textdomain;

	/**
	 * Defines all the shortcode identifiers
	 */
	public function __construct( $textdomain ) {
		$this->textdomain = $textdomain;
    $this->identifiers = ['wksl_slidebar_button'];
	}

  /**
   * Adds all shortcode registered in constructor
   */
  public function add() {
    foreach( $this->identifiers as $identifier ) {
      add_shortcode( $identifier, array( $this, 'output_shortcode_content') );
    }
  }

  /**
   * Reads the markup for a shortcode from the /shortcodes/identifier.php template
   * where identifier is exactly the shortcode name itself.
   *
   * @return String containing the resulting markup for this shortcode with these attributes
   *
   */
  public function output_shortcode_content( $atts, $content, $identifier ) {

		ob_start();
		include( plugin_dir_path(__FILE__) . "/shortcodes/$identifier.php" );
		$output = ob_get_clean();
		return $output;

  }

}

?>
