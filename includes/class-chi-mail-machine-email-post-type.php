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
				'description'        => __( 'Email Custom Post Type for making email', 'chi-mail-machine' ),
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'nav_menu_item'      => true,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => 'email/%category%' ),
				'capability_type'    => 'post',
				'has_archive'        => 'email',
				'show_in_rest'       => true,
				'menu_position'      => 2,
				'menu_icon'          => CHI_MAIL_BASE_URL . '/logo.svg',
				'supports'           => array( 'title', 'editor', 'revisions', 'excerpt' ),
				'taxonomies'         => array( 'category' ),
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

			if ( is_singular( 'chi_email' ) ) {
				return $this->get_template_loader();
			}

			return $template;
		}

		/**
		 * Archive Template for CPT: email
		 */
		public function archive_template_email( $template ) {

			if ( is_archive( 'chi_email' ) ) {
				return $this->get_template_loader();
			}

			return $template;
		}

		public function single_filter_post_type_link( $link, $post ) {
			if ( $post->post_type != 'chi_email' ) {
				return $link;
			}

			if ( $cats = get_the_terms( $post->ID, 'category' ) ) {
				$link = str_replace( '%category%', array_pop( $cats )->slug, $link );
			}

			return $link;
		}

		public function get_template_loader() {

			// Get all informacion about categories
			$cats = get_the_category( get_the_ID() );

			// Template for CPT CHI Email
			require_once CHI_MAIL_BASE_DIR . 'public/class-chi-mail-machine-template-loader.php';

			$template_loader = new Chi_Mail_Machine_Template_Loader();


			if ( is_archive( 'chi_email' ) ) {

				if ( file_exists( CHI_MAIL_BASE_DIR . "templates/archive-chi_email-" . $cats[0]->slug . ".php" ) ) {

					require_once CHI_MAIL_BASE_DIR . "templates/archive-chi_email-" . $cats[0]->slug . ".php";

					return $template_loader->get_template_part( 'archive', 'chi_email-' . $cats[0]->slug . '', false );
				}

				return $template_loader->get_template_part( 'archive', 'chi_email', false );
			}

			if ( is_singular( 'chi_email' ) ) {

				if ( file_exists( CHI_MAIL_BASE_DIR . "templates/single-chi_email-" . $cats[0]->slug . ".php" ) ) {

					return $template_loader->get_template_part( 'single', 'chi_email-' . $cats[0]->slug . '', false );
				}


				return $template_loader->get_template_part( 'single', 'chi_email', false );
			}

		}

		/**
		 * Adding meta box using CMB2 framework
		 */
		public function register_cmb2_metabox_chi_email() {

			$metabox = new_cmb2_box( array(
				'id'           => 'chi_email_details',
				'title'        => __( 'Creating links', 'chi-mail-machine' ),
				'object_types' => array( 'chi_email' ),
				'context'      => 'side',
				'priority'     => 'high',
			) );

			$metabox->add_field( array(
				'name'       => __( 'Example Multiple', 'chi-mail-machine' ),
				'id'         => 'chi_email_post_search_ajax_multiple',
				'type'       => 'post_search_ajax',
				'desc'       => __( '(Start typing post title)', 'chi-mail-machine' ),
				// Optional :
				'limit'      => 10,        // Limit selection to X items only (default 1)
				'sortable'   => true,    // Allow selected items to be sortable (default false)
				'query_args' => array(
					'post_type'      => array( 'post' ),
					'post_status'    => array( 'publish' ),
					'posts_per_page' => - 1
				)
			) );

			$metabox->add_field( array( 'name'        => __( 'Email in order', 'chi-mail-machine' ),
			                            'description' => __( 'Enter the email number following the previous email.', 'chi-mail-machine' ),
			                            'id'    => 'chi_email_special_number',
			                            'type'        => 'text'
			) );




		}

//		public function cmb2_post_search_ajax_metaboxes_example() {
//
//			$example_meta = new_cmb2_box( array(
//				'id'           => 'cmb2_post_search_ajax_field',
//				'title'        => __( 'Related Posts', 'cmb2' ),
//				'object_types' => array( 'chi_email' ), // Post type
//				'context'      => 'normal',
//				'priority'     => 'high',
//				'show_names'   => true, // Show field names on the left
//			) );
//
//			$example_meta->add_field( array(
//				'name'       => __( 'Example Multiple', 'cmb2' ),
//				'id'         => 'cmb2_post_search_ajax_demo_multiple',
//				'type'       => 'post_search_ajax',
//				'desc'       => __( '(Start typing post title)', 'cmb2' ),
//				// Optional :
//				'limit'      => 10,        // Limit selection to X items only (default 1)
//				'sortable'   => true,    // Allow selected items to be sortable (default false)
//				'query_args' => array(
//					'post_type'      => array( 'post' ),
//					'post_status'    => array( 'publish' ),
//					'posts_per_page' => - 1
//				)
//			) );
//
//			$example_meta->add_field( array(
//				'name'        => __( 'Test user multiple', 'cmb2' ),
//				'id'          => 'cmb2_post_search_ajax_demo_user_multiple',
//				'type'        => 'post_search_ajax',
//				'desc'        => __( '(Start typing post title)', 'cmb2' ),
//				// Optional :
//				'limit'       => 10,        // Limit selection to X items only (default 1)
//				'sortable'    => true,    // Allow selected items to be sortable (default false)
//				'object_type' => 'user',    // Define queried object type (Available : post, user, term - Default : post)
//				'query_args'  => array(
//					'blog_id' => '1',
//				)
//			) );
//
//			$example_meta->add_field( array(
//				'name'        => __( 'Test user single', 'cmb2' ),
//				'id'          => 'cmb2_post_search_ajax_demo_user_single',
//				'type'        => 'post_search_ajax',
//				'desc'        => __( '(Start typing post title)', 'cmb2' ),
//				// Optional :
//				'limit'       => 1,        // Limit selection to X items only (default 1)
//				'sortable'    => false,    // Allow selected items to be sortable (default false)
//				'object_type' => 'user',    // Define queried object type (Available : post, user, term - Default : post)
//				'query_args'  => array(
//					'role' => 'Administrator'
//				)
//			) );
//
//		}

	}


