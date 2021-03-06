<?php

	/**
	 * The file that defines the core plugin class
	 *
	 * A class definition that includes attributes and functions used across both the
	 * public-facing side of the site and the admin area.
	 *
	 * @link       https://www.facebook.com/markovic.richard
	 * @since      1.0.0
	 *
	 * @package    Chi_Mail_Machine
	 * @subpackage Chi_Mail_Machine/includes
	 */

	/**
	 * The core plugin class.
	 *
	 * This is used to define internationalization, admin-specific hooks, and
	 * public-facing site hooks.
	 *
	 * Also maintains the unique identifier of this plugin as well as the current
	 * version of the plugin.
	 *
	 * @since      1.0.0
	 * @package    Chi_Mail_Machine
	 * @subpackage Chi_Mail_Machine/includes
	 * @author     Richard Markovič <addmarkovic@gmail.com>
	 */
	class Chi_Mail_Machine {

		/**
		 * The loader that's responsible for maintaining and registering all hooks that power
		 * the plugin.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      Chi_Mail_Machine_Loader $loader Maintains and registers all hooks for the plugin.
		 */
		protected $loader;

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

		/**
		 * Define the core functionality of the plugin.
		 *
		 * Set the plugin name and the plugin version that can be used throughout the plugin.
		 * Load the dependencies, define the locale, and set the hooks for the admin area and
		 * the public-facing side of the site.
		 *
		 * @since    1.0.0
		 */
		public function __construct() {
			if ( defined( 'CHI_MAIL_MACHINE_VERSION' ) ) {
				$this->version = CHI_MAIL_MACHINE_VERSION;
			} else {
				$this->version = '1.0.0';
			}
			$this->plugin_name = 'chi-mail-machine';

			$this->load_dependencies();
			$this->set_locale();
			$this->define_admin_hooks();
			$this->define_public_hooks();
			$this->define_post_type_hooks();

		}

		/**
		 * Load the required dependencies for this plugin.
		 *
		 * Include the following files that make up the plugin:
		 *
		 * - Chi_Mail_Machine_Loader. Orchestrates the hooks of the plugin.
		 * - Chi_Mail_Machine_i18n. Defines internationalization functionality.
		 * - Chi_Mail_Machine_Admin. Defines all hooks for the admin area.
		 * - Chi_Mail_Machine_Public. Defines all hooks for the public side of the site.
		 *
		 * Create an instance of the loader which will be used to register the hooks
		 * with WordPress.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		private function load_dependencies() {

			/**
			 * The class responsible for orchestrating the actions and filters of the
			 * core plugin.
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-chi-mail-machine-loader.php';

			/**
			 * The class responsible for defining internationalization functionality
			 * of the plugin.
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-chi-mail-machine-i18n.php';

			/**
			 * The class responsible for defining all actions that occur in the admin area.
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-chi-mail-machine-admin.php';

			/**
			 * The class responsible for defining all actions that occur in the public-facing
			 * side of the site.
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-chi-mail-machine-public.php';

			/**
			 * The class responsible for all registration and settings CPT
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-chi-mail-machine-email-post-type.php';

			/**
			 * The class responsible for all Meta Box throw plugin. CMB2 init for meta box
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'vendor/CMB2/init.php';

			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'vendor/cmb2-field-post-search-ajax/cmb-field-post-search-ajax.php';

			$this->loader = new Chi_Mail_Machine_Loader();

		}

		/**
		 * Define the locale for this plugin for internationalization.
		 *
		 * Uses the Chi_Mail_Machine_i18n class in order to set the domain and to register the hook
		 * with WordPress.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		private function set_locale() {

			$plugin_i18n = new Chi_Mail_Machine_i18n();

			$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

		}

		/**
		 * Register all of the hooks related to the admin area functionality
		 * of the plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		private function define_admin_hooks() {

			$plugin_admin = new Chi_Mail_Machine_Admin( $this->get_plugin_name(), $this->get_version() );

			$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
			$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		}

		/**
		 * Register all of the hooks related to the public-facing functionality
		 * of the plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		private function define_public_hooks() {

			$plugin_public = new Chi_Mail_Machine_Public( $this->get_plugin_name(), $this->get_version() );

			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

//		$this->loader->add_action( 'init', $plugin_public, 'register_chi_email_post_type');

		}

		/**
		 * Run the loader to execute all of the hooks with WordPress.
		 *
		 * @since    1.0.0
		 */
		public function run() {
			$this->loader->run();
		}

		/**
		 * The name of the plugin used to uniquely identify it within the context of
		 * WordPress and to define internationalization functionality.
		 *
		 * @return    string    The name of the plugin.
		 * @since     1.0.0
		 */
		public function get_plugin_name() {
			return $this->plugin_name;
		}

		/**
		 * The reference to the class that orchestrates the hooks with the plugin.
		 *
		 * @return    Chi_Mail_Machine_Loader    Orchestrates the hooks of the plugin.
		 * @since     1.0.0
		 */
		public function get_loader() {
			return $this->loader;
		}

		/**
		 * Retrieve the version number of the plugin.
		 *
		 * @return    string    The version number of the plugin.
		 * @since     1.0.0
		 */
		public function get_version() {
			return $this->version;
		}

		/**
		 * Defining all actions and filters hooks for registration CPT
		 */
		public function define_post_type_hooks() {

			$plugin_post_type = new Chi_Mail_Machine_Email_Post_Type($this->get_plugin_name(), $this->get_version() );

			$this->loader->add_action( 'init', $plugin_post_type, 'init');

			$this->loader->add_filter( 'the_content', $plugin_post_type, 'content_single_email');

			$this->loader->add_filter( 'single_template', $plugin_post_type, 'single_template_email');

			$this->loader->add_filter( 'archive_template', $plugin_post_type, 'archive_template_email');

			$this->loader->add_filter( 'post_type_link', $plugin_post_type, 'single_filter_post_type_link', 3, 2);

			$this->loader->add_filter( 'cmb2_admin_init', $plugin_post_type, 'register_cmb2_metabox_chi_email');

//			$this->loader->add_filter( 'cmb2_init', $plugin_post_type, 'cmb2_post_search_ajax_metaboxes_example');


		}

	}
