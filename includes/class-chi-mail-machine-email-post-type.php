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
	 * Functionality for the CPT Emails
	 *
	 * @since      1.0.0
	 * @package    Chi_Mail_Machine
	 * @subpackage Chi_Mail_Machine/includes
	 * @author     Richard Markovič <addmarkovic@gmail.com>
	 */
	class Chi_Mail_Machine_Email_Post_Type {

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
		public function __construct( $plugin_name, $version ) {

			$this->plugin_name = $plugin_name;
			$this->$version    = $version;

		}

		/**
		 * hooked into 'init' action
		 * @return Chi_Mail_Machine_Loader
		 */
		public function init() {
			$this->register_cpt_chi_email();
		}

		/**
		 * Registering Post Type: CHI Email
		 */
		public function register_cpt_chi_email() {
			$labels = array(
				'name'                  => _x( 'Emails', 'Post type general name', ' chi-mail-machine' ),
				'singular_name'         => _x( 'Email', 'Post type singular name', ' chi-mail-machine' ),
				'menu_name'             => _x( 'Emails', 'Admin Menu text', ' chi-mail-machine' ),
				'name_admin_bar'        => _x( 'Email', 'Add New on Toolbar', ' chi-mail-machine' ),
				'add_new'               => __( 'Add New', ' chi-mail-machine' ),
				'add_new_item'          => __( 'Add New Email', ' chi-mail-machine' ),
				'new_item'              => __( 'New Email', ' chi-mail-machine' ),
				'edit_item'             => __( 'Edit Email', ' chi-mail-machine' ),
				'view_item'             => __( 'View Email', ' chi-mail-machine' ),
				'all_items'             => __( 'All Emails', ' chi-mail-machine' ),
				'search_items'          => __( 'Search Emails', ' chi-mail-machine' ),
				'parent_item_colon'     => __( 'Parent Emails:', ' chi-mail-machine' ),
				'not_found'             => __( 'No mails found.', ' chi-mail-machine' ),
				'not_found_in_trash'    => __( 'No mails found in Trash.', ' chi-mail-machine' ),
				'featured_image'        => _x( 'Email Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', ' chi-mail-machine' ),
				'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', ' chi-mail-machine' ),
				'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', ' chi-mail-machine' ),
				'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', ' chi-mail-machine' ),
				'archives'              => _x( 'Email archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', ' chi-mail-machine' ),
				'insert_into_item'      => _x( 'Insert into email', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', ' chi-mail-machine' ),
				'uploaded_to_this_item' => _x( 'Uploaded to this email', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', ' chi-mail-machine' ),
				'filter_items_list'     => _x( 'Filter emails list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', ' chi-mail-machine' ),
				'items_list_navigation' => _x( 'Emails list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', ' chi-mail-machine' ),
				'items_list'            => _x( 'Emails list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', ' chi-mail-machine' ),
			);

			$args = array(
				'labels'             => $labels,
				'description'        => __( 'Description.', 'chi-mail-machine' ),
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'nav_menu_item'      => true,
				'query_var'          => true,
				'hierarchical'      =>  true,
				'rewrite'            => array('slug' => 'email/%category%'),
				'capability_type'    => 'post',
				'has_archive'        => 'email',
				'hierarchical'       => true,
				'menu_position'      => 2,
				'menu_icon'          => CHI_MAIL_BASE_URL . '/logo.svg',
				'supports'           => array( 'title', 'editor', 'revisions', ),
				'taxonomies'          => array( 'category' ),
			);

			register_post_type( 'chi_email', $args );
		}


		/**
		 * Filter content for CPT: CHI Email
		 */
		public function content_single_email( $the_content ) {

			// filter just for CHI email CPT
			if ( in_the_loop() && is_singular( 'chi_email' ) ) {

				ob_start();
				include CHI_MAIL_BASE_DIR . 'templates/email-content.php';

				return ob_get_clean();
			}

			return $the_content;

		}

		/**
		 * Single Template for CPT: email
		 */
		public function single_template_email( $template ) {

			$cats = get_the_category( get_the_ID() );
			echo '<pre>';
			print_r( $cats );
			echo '</pre>';

			if ( is_singular( 'chi_email' ) ) {

				// Template for CPT CHI Email
				require_once CHI_MAIL_BASE_DIR . 'public/class-chi-mail-machine-template-loader.php';

				$template_loader = new Chi_Mail_Machine_Template_Loader();

				return $template_loader->get_template_part( 'single', 'chi_email', false );
			}

			return $template;
		}

	}
