<?php
/**
 * WK SLidebars
 * Lifecycle Class
 */


class WKSL_Slidebars_Lifecycle {

	/**
	 * Text Domain
	 */
	public $textdomain;

	/**
	 * Constructor
	 */
	public function __construct( $textdomain ) {
		$this->textdomain = $textdomain;
	}

	/**
	 * Runs on plugin activation
	 */
	public function activate() {}

	/**
	 * Runs on plugin deactivation
	 */
	public function deactivate() {}

}

?>
