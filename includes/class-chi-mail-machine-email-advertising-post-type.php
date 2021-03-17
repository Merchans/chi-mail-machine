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
	class Chi_Mail_Machine_Email_Ad_Post_Type {

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
		protected $template_loader;

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

//			$this->template_loader = $this->get_template_loader();

		}

		/**
		 * hooked into 'init' action
		 * @return Chi_Mail_Machine_Loader
		 */
		public function init() {
			$this->register_cpt_chi_email_ad();
		}

		/**
		 * Registering Post Type: CHI Email
		 */
		public function register_cpt_chi_email_ad() {
			$labels = array(
				'name'                  => _x( 'Email Ads', 'Post type general name', ' chi-mail-machine' ),
				'singular_name'         => _x( 'Email Ad', 'Post type singular name', ' chi-mail-machine' ),
				'menu_name'             => _x( 'Email Ads', 'Admin Menu text', ' chi-mail-machine' ),
				'name_admin_bar'        => _x( 'Email Ad', 'Add New on Toolbar', ' chi-mail-machine' ),
				'add_new'               => __( 'Add New', ' chi-mail-machine' ),
				'add_new_item'          => __( 'Add New Email Ad', ' chi-mail-machine' ),
				'new_item'              => __( 'New Email Ad', ' chi-mail-machine' ),
				'edit_item'             => __( 'Edit Email Ad', ' chi-mail-machine' ),
				'view_item'             => __( 'View Email Ad', ' chi-mail-machine' ),
				'all_items'             => __( 'All Email Ads', ' chi-mail-machine' ),
				'search_items'          => __( 'Search Email Ads', ' chi-mail-machine' ),
				'parent_item_colon'     => __( 'Parent Email Ads:', ' chi-mail-machine' ),
				'not_found'             => __( 'No mails found.', ' chi-mail-machine' ),
				'not_found_in_trash'    => __( 'No mails found in Trash.', ' chi-mail-machine' ),
				'featured_image'        => _x( 'Email Ad Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', ' chi-mail-machine' ),
				'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', ' chi-mail-machine' ),
				'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', ' chi-mail-machine' ),
				'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', ' chi-mail-machine' ),
				'archives'              => _x( 'Email Ad archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', ' chi-mail-machine' ),
				'insert_into_item'      => _x( 'Insert into email ad', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', ' chi-mail-machine' ),
				'uploaded_to_this_item' => _x( 'Uploaded to this email', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', ' chi-mail-machine' ),
				'filter_items_list'     => _x( 'Filter emails list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', ' chi-mail-machine' ),
				'items_list_navigation' => _x( 'Email Ads list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', ' chi-mail-machine' ),
				'items_list'            => _x( 'Email Ads list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', ' chi-mail-machine' ),
			);

			$args = array(
				'labels'              => $labels,
				'description'         => __( 'Email Ad Custom Post Type for making email advertise', 'chi-mail-machine' ),
				'exclude_from_search' => true,
				'public'              => false,
				'publicly_queryable'  => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'query_var'           => true,
				'rewrite'             => array( 'slug' => 'chi_email_ad' ),
				'capability_type'     => 'post',
				'has_archive'         => false,
				'hierarchical'        => false,
				'menu_position'       => 4,
				'menu_icon'           => 'dashicons-info',
				'supports'            => array( 'title', 'editor', 'revisions' ),
			);


			register_post_type( 'chi_email_ad', $args );


		}

	}


