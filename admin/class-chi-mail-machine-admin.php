<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.facebook.com/markovic.richard
 * @since      1.0.0
 *
 * @package    Chi_Mail_Machine
 * @subpackage Chi_Mail_Machine/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Chi_Mail_Machine
 * @subpackage Chi_Mail_Machine/admin
 * @author     Richard Markovič <addmarkovic@gmail.com>
 */
class Chi_Mail_Machine_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Chi_Mail_Machine_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Chi_Mail_Machine_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/chi-mail-machine-admin.css', array(), $this->version, 'all' );
		if ('chi_email' == get_post_type()) {
			wp_enqueue_style( 'chi-email-editor', plugin_dir_url( __FILE__ ) . 'css/chi-editor.css', array(), $this->version, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Chi_Mail_Machine_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Chi_Mail_Machine_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name.'_logsystem', plugin_dir_url( __FILE__ ) . 'js/logsystem.js', array('jquery'), $this->version, true );
		wp_enqueue_script( $this->plugin_name.'_autocomplete', plugin_dir_url( __FILE__ ) . 'js/autocomplete.js', array('jquery'), $this->version, true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/chi-mail-machine-admin.js', array( 'jquery' ), $this->version, true );
//		wp_enqueue_script( $this->plugin_name.'_blocks', plugin_dir_url( __FILE__ ) . 'js/blocks/firtst-block.js', array( 'wp-blocks', 'wp-i18n', 'wp-element' ), $this->version, true );

	}

}
