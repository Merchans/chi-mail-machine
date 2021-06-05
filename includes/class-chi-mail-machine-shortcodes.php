<?php

	/**
	 * Plugin shortcode functionality
	 *
	 * @link       https://www.facebook.com/markovic.richard
	 * @since      1.0.0
	 *
	 * @package    Chi_Mail_Machine
	 * @subpackage Chi_Mail_Machine_Shortcodes/includes
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
	 * @subpackage Chi_Mail_Machine_Shortcodes/includes
	 * @author     Richard Markovič <addmarkovic@gmail.com>
	 */
	class Chi_Mail_Machine_Shortcodes {


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

		/**
		 * Make a corecrt link for statistics
		 * Usage: [article id="xXx"]
		 * https://www.kongres-online.cz/respironews/komu-a-kdy-indikovat-monoklonalni-protilatky-v-lecbe-covid-19/?utm_source=email&utm_campaign=respironews&utm_medium=email33&utm_content=komu-a-kdy-indikovat-monoklonalni-protilatky-v-lecbe-covid-19/&external_id=zdedoplnitID
		 */
		public function make_link( $atts, $content ) {

			if ( ! is_numeric( $atts['id'] ) ) {
				return "ID must by a number: [article id='NUMBER']";
			}
			$special_number = get_post_meta( get_the_ID(), 'chi_email_special_number', true );
			$url            = get_permalink( get_post_meta( get_the_ID(), 'chi_email_search_ajax_multiple', true )[ ( $atts['id'] - 1 ) ] );

			$parts = explode( "/", $url );

			foreach ( $parts as $key => $value ) {
				if ( empty( $value ) ) {
					unset( $parts[ $key ] );
				}
			}

			$slug    = $parts[ count( $parts ) ];
			$special = get_the_terms( get_the_ID(), 'category' )[0]->slug;


			$link = "$url?utm_source=email&utm_campaign=respironews&utm_medium=email$special_number&utm_content=$slug&external_id=zdedoplnitID";

			return "<a href='$link'>" . $content . "</a>";
		}

	}
