<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://www.facebook.com/markovic.richard
 * @since      1.0.0
 *
 * @package    Chi_Mail_Machine
 * @subpackage Chi_Mail_Machine/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Chi_Mail_Machine
 * @subpackage Chi_Mail_Machine/includes
 * @author     Richard Markovič <addmarkovic@gmail.com>
 */
class Chi_Mail_Machine_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

		// Un-registration CPT
		unregister_post_type('chi_email');

		// Flush Permalinks
		flush_rewrite_rules();

	}

}
