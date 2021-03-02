<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.facebook.com/markovic.richard
 * @since      1.0.0
 *
 * @package    Chi_Mail_Machine
 * @subpackage Chi_Mail_Machine/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Chi_Mail_Machine
 * @subpackage Chi_Mail_Machine/includes
 * @author     Richard Markovič <addmarkovic@gmail.com>
 */
class Chi_Mail_Machine_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'chi-mail-machine',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
