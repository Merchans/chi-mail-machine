<?php

	/**
	 * Plugin shortcode functionality
	 *
	 * @link       https://www.facebook.com/markovic.richard
	 * @since      1.0.0
	 *
	 * @package    Chi_Mail_Machine
	 * @subpackage Chi_Mail_Machine_Blocks/includes
	 */

	/**
	 * The core plugin class.
	 *
	 * This is used to define internationalization, admin-specific hooks, and
	 * public-facing site hooks.
	 *
	 *
	 *
	 * @since      1.0.0
	 * @package    Chi_Mail_Machine
	 * @subpackage Chi_Mail_Machine_Blocks/includes
	 * @author     Richard Markovič <addmarkovic@gmail.com>
	 */
	class Chi_Mail_Machine_Blocks {


		/**
		 * The unique identifier of this plugin.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      string $plugin_name The string used to uniquely identify this plugin.
		 */
		protected $plugin_name;

		/**
		 * The current version of the plugin.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      string $version The current version of the plugin.
		 */
		protected $version;


		public function __construct( $plugin_name, $version ) {

			$this->plugin_name = $plugin_name;
			$this->$version    = $version;

		}

		public function block_activation() {

			wp_enqueue_script( $this->plugin_name . '_blocks', CHI_MAIL_BASE_URL . 'admin/js/blocks/firtst-block.js', array(
				'wp-blocks',
				'wp-i18n',
				'wp-element'
			), $this->version, true );

		}

	}
