<?php

	/**
	 * Fired during plugin activation
	 *
	 * @link       https://www.facebook.com/markovic.richard
	 * @since      1.0.0
	 *
	 * @package    Chi_Mail_Machine
	 * @subpackage Chi_Mail_Machine/includes
	 */

	/**
	 * Fired during plugin activation.
	 *
	 * This class defines all code necessary to run during the plugin's activation.
	 *
	 * @since      1.0.0
	 * @package    Chi_Mail_Machine
	 * @subpackage Chi_Mail_Machine/includes
	 * @author     Richard Markovič <addmarkovic@gmail.com>
	 */
	class Chi_Mail_Machine_Activator {

		/**
		 * Short Description. (use period)
		 *
		 * Long Description.
		 *
		 * @since    1.0.0
		 */
		public static function activate() {

			require_once CHI_MAIL_BASE_DIR . '/includes/class-chi-mail-machine-email-post-type.php';
			require_once CHI_MAIL_BASE_DIR . '/includes/class-chi-mail-machine-email-advertising-post-type.php';

			// Register CPT
			$plugin_post_type_email    = new Chi_Mail_Machine_Email_Post_Type( CHI_MAIL_MACHINE_NAME, CHI_MAIL_MACHINE_VERSION );
			$plugin_post_type_email_ad = new Chi_Mail_Machine_Email_Ad_Post_Type( CHI_MAIL_MACHINE_NAME, CHI_MAIL_MACHINE_VERSION );

			$plugin_post_type_email->init();
			$plugin_post_type_email_ad->init();

			// Flush Permalinks
			flush_rewrite_rules();
		}

	}
