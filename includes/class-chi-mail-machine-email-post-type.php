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
				'name'                  => _x( 'Email', 'Post type general name', ' chi-mail-machine' ),
				'singular_name'         => _x( 'Email', 'Post type singular name', ' chi-mail-machine' ),
				'menu_name'             => _x( 'Email Maker', 'Admin Menu text', ' chi-mail-machine' ),
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
				'featured_image'        => _x( 'Email Cover Image',
					'Overrides the “Featured Image” phrase for this post type. Added in 4.3', ' chi-mail-machine' ),
				'set_featured_image'    => _x( 'Set cover image',
					'Overrides the “Set featured image” phrase for this post type. Added in 4.3', ' chi-mail-machine' ),
				'remove_featured_image' => _x( 'Remove cover image',
					'Overrides the “Remove featured image” phrase for this post type. Added in 4.3',
					' chi-mail-machine' ),
				'use_featured_image'    => _x( 'Use as cover image',
					'Overrides the “Use as featured image” phrase for this post type. Added in 4.3',
					' chi-mail-machine' ),
				'archives'              => _x( 'Email archives',
					'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4',
					' chi-mail-machine' ),
				'insert_into_item'      => _x( 'Insert into email',
					'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4',
					' chi-mail-machine' ),
				'uploaded_to_this_item' => _x( 'Uploaded to this email',
					'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4',
					' chi-mail-machine' ),
				'filter_items_list'     => _x( 'Filter emails list',
					'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4',
					' chi-mail-machine' ),
				'items_list_navigation' => _x( 'Emails list navigation',
					'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4',
					' chi-mail-machine' ),
				'items_list'            => _x( 'Emails list',
					'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4',
					' chi-mail-machine' ),
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
				'capability_type'    => 'email',
				'map_meta_cap'       => true,
				'has_archive'        => 'email',
				'show_in_rest'       => true,
				'menu_position'      => 5,
				'menu_icon'          => 'data:image/svg+xml;base64,' . base64_encode( '<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 493.419 493.419" style="enable-background:new 0 0 493.419 493.419;" xml:space="preserve">
<g>
	<path d="M162.988,288.902c3.088-0.828,6.277-1.25,9.479-1.25c2.525,0,5.032,0.26,7.485,0.779
		c4.791-14.577,18.526-25.135,34.686-25.135h28.057c7.455,0,14.342,2.323,20.123,6.173c0.725-4.849,2.308-9.575,4.835-13.952
		l17.671-30.616c1.566-2.705,3.491-5.1,5.578-7.317l-30.452-25.021l12.628-11.143l32.328,26.549
		c1.291-0.496,2.544-1.096,3.899-1.462c3.329-0.894,6.771-1.349,10.226-1.349c4.846,0,9.647,0.893,14.145,2.624
		c2.98-18.857,19.336-33.313,39.012-33.313h18.16V65.835c0-16.453-13.344-29.796-29.805-29.796H29.804
		C13.343,36.039,0,49.381,0,65.835v200.703c0,16.461,13.343,29.804,29.804,29.804H148.98
		C153.031,292.914,157.734,290.299,162.988,288.902z M44.527,72.413c4.563-5.173,12.436-5.651,17.608-1.104l121.828,107.514
		c6.547,5.768,16.39,5.768,22.935,0L328.723,71.308c5.164-4.539,13.041-4.061,17.605,1.104c4.558,5.166,4.061,13.042-1.103,17.607
		L223.402,197.532c-7.969,7.034-17.973,10.55-27.971,10.55c-9.998,0-20.002-3.516-27.969-10.55L45.635,90.02
		C40.467,85.455,39.973,77.579,44.527,72.413z M43.998,263.525c-1.547,1.274-3.416,1.892-5.269,1.892
		c-2.403,0-4.792-1.04-6.433-3.037c-2.916-3.549-2.403-8.787,1.146-11.703l84.342-69.256l12.629,11.143L43.998,263.525z"/>
	<path d="M390.361,268.918c-20.424,0-37.047,16.623-37.047,37.047s16.623,37.049,37.047,37.049
		c20.423,0,37.049-16.625,37.049-37.049S410.784,268.918,390.361,268.918z"/>
	<path d="M486.139,324.05l-13.35-7.707c0.429-3.444,1.048-6.822,1.048-10.379c0-3.558-0.619-6.943-1.048-10.387l13.35-7.706
		c3.348-1.935,5.782-5.11,6.783-8.837c0.998-3.729,0.478-7.697-1.455-11.044l-17.67-30.601c-2.695-4.669-7.596-7.275-12.623-7.275
		c-2.468,0-4.967,0.624-7.258,1.948l-13.269,7.659c-5.58-4.24-11.518-8.017-18.063-10.762v-14.99
		c0-8.039-6.512-14.552-14.553-14.552h-35.344c-8.039,0-14.553,6.513-14.553,14.552v14.99c-6.543,2.745-12.48,6.521-18.052,10.762
		l-13.278-7.667c-2.232-1.291-4.74-1.948-7.273-1.948c-1.26,0-2.529,0.161-3.77,0.496c-3.727,0.998-6.904,3.435-8.838,6.78
		l-17.67,30.607c-4.02,6.959-1.633,15.86,5.328,19.881l7.008,4.042c0.982,0.514,1.918,1.049,2.85,1.65l3.492,2.014
		c-0.022,0.202-0.031,0.406-0.065,0.607c3.354,2.746,6.411,5.865,8.633,9.723l14.067,24.347c4.822,8.421,6.115,18.216,3.605,27.653
		c-1.51,5.626-4.279,10.693-8.064,14.91c1.452,1.631,2.702,3.401,3.833,5.237l10.135-5.856c5.578,4.247,11.506,8.023,18.059,10.767
		v14.993c0,8.039,6.514,14.552,14.553,14.552h35.344c8.041,0,14.553-6.513,14.553-14.552v-14.993
		c6.555-2.744,12.482-6.52,18.063-10.767l13.269,7.668c2.231,1.289,4.744,1.947,7.277,1.947c1.256,0,2.523-0.162,3.768-0.494
		c3.728-1,6.902-3.436,8.836-6.782l17.67-30.608C495.486,336.97,493.1,328.07,486.139,324.05z M390.361,359.646
		c-29.602,0-53.68-24.08-53.68-53.682c0-29.6,24.078-53.68,53.68-53.68c29.6,0,53.682,24.08,53.682,53.68
		C444.043,335.566,419.961,359.646,390.361,359.646z"/>
	<path d="M304.691,387.166l-10.598-6.115c0.342-2.736,0.83-5.415,0.83-8.241c0-2.817-0.488-5.507-0.83-8.243l10.598-6.115
		c2.655-1.535,4.589-4.053,5.385-7.017c0.787-2.964,0.373-6.107-1.154-8.771l-14.023-24.28c-2.145-3.713-6.033-5.783-10.022-5.783
		c-1.955,0-3.939,0.504-5.757,1.551l-10.533,6.083c-4.434-3.37-9.152-6.367-14.341-8.543v-11.898c0-6.383-5.173-11.548-11.55-11.548
		h-28.057c-6.377,0-11.549,5.165-11.549,11.548v11.898c-5.199,2.176-9.908,5.173-14.332,8.543l-10.543-6.09
		c-1.762-1.023-3.742-1.544-5.747-1.544c-1.007,0-2.024,0.13-3.017,0.397c-2.952,0.788-5.471,2.721-7.016,5.378l-14.024,24.288
		c-3.183,5.53-1.29,12.596,4.231,15.788l10.598,6.115c-0.342,2.736-0.826,5.426-0.826,8.243c0,2.826,0.484,5.505,0.826,8.233
		l-10.598,6.115c-5.521,3.191-7.414,10.258-4.231,15.779l14.024,24.305c1.545,2.648,4.063,4.582,7.016,5.378
		c0.992,0.267,2,0.397,2.998,0.397c2.008,0,4.004-0.528,5.766-1.551l10.533-6.082c4.434,3.369,9.143,6.366,14.342,8.543v11.904
		c0,6.375,5.172,11.549,11.549,11.549h28.057c6.377,0,11.55-5.174,11.55-11.549v-11.904c5.198-2.177,9.907-5.174,14.341-8.543
		l10.533,6.082c1.762,1.023,3.762,1.551,5.767,1.551c0.997,0,2.005-0.13,2.997-0.397c2.957-0.796,5.471-2.729,7.016-5.378
		l14.023-24.296C312.105,397.423,310.213,390.358,304.691,387.166z M228.662,404.66c-17.58,0-31.84-14.26-31.84-31.851
		c0-17.591,14.26-31.852,31.84-31.852c17.59,0,31.851,14.262,31.851,31.852C260.513,390.4,246.252,404.66,228.662,404.66z"/>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
</svg>' ),
				'supports'           => array(
					'title',
					'comments',
					'editor',
					'revisions',
					'excerpt',
					'author',
					'post-formats',
				),
			);


			register_post_type( 'chi_email', $args );


		}

		public function external_worker_remainder() {
			$post_id = ! isset( $_GET["post"] );
			if ( $post_id ) {
				return;
			}
			$post_id = $_GET["post"];

			if ( metadata_exists( 'post', $post_id, '_externalremainder' ) ) {
				$time = get_post_meta( $post_id, '_externalremainder', true );
				$d         = new DateTime( $time );
				$timestamp = $d->getTimestamp();
				$timestamp = strtotime( '+1 day', $timestamp );
				$format_time = date( 'Y-m-d', $timestamp );

				$now = new DateTime(  );
				$format_now_time = $now->format('Y-m-d');

				if ($format_time > $format_now_time) {
					return;
				}
				if ( ! metadata_exists( 'post', $post_id, '_externalremainder_send' ) ) {
					$args  = array(
						'role'    => 'contributor',
						'orderby' => 'user_nicename',
						'order'   => 'ASC'
					);
					$users = get_users( $args );
					$to[]  = "addmarkovic@gmail.com";
					foreach ( $users as $user ) {
						$to[] = $user->user_email;
					}
					$subject = 'Pridať štatistiku pre projekt' . get_the_category( $post_id )[0]->name;
					$content = 'Pridat štatistiku ' . '<a href="https://kongresonline.test/wp-admin/edit.php?s=' . get_the_title( $post_id ) . 'post_status=all&post_type=chi_email&action=-1&m=0&paged=1&action2=-1">zde</a>';

					$headers = array( 'Content-Type: text/html; charset=UTF-8' );
					if ( wp_mail( $to, $subject, $content, $headers ) ) {
						$agent = $_SERVER['HTTP_USER_AGENT'];
						$data  = array(
							'comment_post_ID'      => $post_id,
							'comment_author'       => 'system',
							'comment_author_email' => '',
							'comment_content'      => 'Žiadosť o štatistiku podaná',
							'comment_author_IP'    => get_the_user_ip(),
							'comment_agent'        => $agent,
							'comment_date'         => date( 'Y-m-d H:i:s' ),
							'comment_date_gmt'     => date( 'Y-m-d H:i:s' ),
							'comment_approved'     => 1,
						);
						wp_insert_comment( $data );
						add_post_meta( $post_id, '_externalremainder_send', 1 );
					}
				}
			}
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

		/**
		 * Adding meta box using CMB2 framework
		 */
		public function register_cmb2_metabox_chi_email() {
			$prefix  = 'chi_email';
			$metabox = new_cmb2_box( array(
				'id'           => 'chi_email_details',
				'title'        => __( 'Creating links', 'chi-mail-machine' ),
				'object_types' => array( 'chi_email' ),
				'context'      => 'normal',
				'priority'     => 'high',
			) );

			$metabox->add_field( array(
				'name'       => __( 'Choose related posts', 'chi-mail-machine' ),
				'id'         => $prefix . '_search_ajax_multiple',
				'type'       => 'post_search_ajax',
				'desc'       => __( 'Select the articles you want to have in the links', 'chi-mail-machine' ),
				// Optional :
				'limit'      => 10,       // Limit selection to X items only (default 1)
				'sortable'   => true,    // Allow selected items to be sortable (default false)
				'query_args' => array(
					'post_type'      => array( 'post', 'chi_video' ),
					'post_status'    => array( 'publish', 'pending' ),
					'posts_per_page' => - 1
				),

			) );

			$metabox->add_field( array(
				'name'           => __( 'Choose special', 'chi-mail-machine' ),
				'desc'           => __( 'Choose the special to which the email belongs', 'chi-mail-machine' ),
				'id'             => $prefix . '_taxonomy_select',
				'taxonomy'       => 'category', //Enter Taxonomy Slug
				'type'           => 'taxonomy_select',
				'remove_default' => 'true', // Removes the default metabox provided by WP core.

			) );

			$metabox->add_field( array(
				'name'        => __( 'Email in order', 'chi-mail-machine' ),
				'description' => __( 'Enter the email number following the previous email.', 'chi-mail-machine' ),
				'id'          => $prefix . '_special_number',
				'type'        => 'text',

			) );

			$metabox->add_field( array(
				'name'        => __( 'Email link parameters', 'chi-mail-machine' ),
				'description' => __( 'To add special parameters to links' ),
				'id'          => $prefix . '_special_parameters',
				'type'        => 'text',
				'repeatable'  => true,
			) );

			$metabox_checbox = new_cmb2_box( array(
				'id'           => $prefix . '_state',
				'title'        => __( 'State', 'chi-mail-machine' ),
				'object_types' => array( 'chi_email' ),
				'context'      => 'normal',
				'priority'     => 'high',
			) );

			$metabox_checbox->add_field( array(
				'name'          => __( 'Author: has completed the email', 'chi-mail-machine' ),
				'desc'          => __( 'If the author considers the e-mail is ready', 'chi-mail-machine' ),
				'id'            => $prefix . '_author_state',
				'type'          => 'checkbox',
				'capability'    => 'edit_posts',
				'show_on_cb'    => [ $this, 'cmb_show_meta_to_chosen_roles' ],
				'show_on_roles' => array( 'author', 'editor', 'administrator' ),
			) );

			$metabox_checbox->add_field( array(
				'name'          => __( 'Editor: has completed the email', 'chi-mail-machine' ),
				'desc'          => __( 'If the editor considers the e-mail is ready', 'chi-mail-machine' ),
				'id'            => $prefix . '_editor_state',
				'type'          => 'checkbox',
				'show_on_cb'    => [ $this, 'cmb_show_meta_to_chosen_roles' ],
				'show_on_roles' => array( 'editor', 'administrator' ),
			) );

			$metabox_checbox->add_field( array(
				'name'          => __( 'Admin: Email has been sent to an external company', 'chi-mail-machine' ),
				'desc'          => __( 'If the admin considers the e-mail is technically ready', 'chi-mail-machine' ),
				'id'            => $prefix . '_admin_state',
				'type'          => 'checkbox',
				'show_on_cb'    => [ $this, 'cmb_show_meta_to_chosen_roles' ],
				'show_on_roles' => array( 'administrator' ),
			) );


			$metabox_ad_section = new_cmb2_box( array(
				'id'           => $prefix . '_ad_details',
				'title'        => __( 'Email Ad Section', 'chi-mail-machine' ),
				'object_types' => array( 'chi_email' ),
				'context'      => 'normal',
				'priority'     => 'low',
			) );

			$metabox_ad_section->add_field( array(
				'name'       => __( 'Select the ad that belongs to the email', 'chi-mail-machine' ),
				'id'         => $prefix . '_ad_search_ajax_multiple',
				'type'       => 'post_search_ajax',
				'desc'       => __( 'Select the AD to you want to have in the Email', 'chi-mail-machine' ),
				// Optional :
				'limit'      => 10,       // Limit selection to X items only (default 1)
				'sortable'   => false,    // Allow selected items to be sortable (default false)
				'query_args' => array(
					'post_type'      => array( 'chi_email_ad' ),
					'post_status'    => array( 'publish', 'pending' ),
					'posts_per_page' => - 1
				),
			) );

			$metabox_ad_section->add_field( array(
				'name'    => __( 'Advertising information', 'chi-mail-machine' ),
				'id'      => $prefix . '_textarea',
				'type'    => 'textarea',
				'default' => '
Tento e-mail Vám byl zaslán jako obchodní sdělení společnosti
CZECH HEALTH INTERACTIVE, s.r.o., Národní 58/32, Praha 1 - Nové Město, 110 00

Distribuci tohoto sdělení zajišťuje IQVIA Technology Solutions s.r.o.
Nepřejete-li si dostávat tyto e-maily, klikněte prosím ZDE.',
				'options' => array(
					'tooltip-class' => 'fa-info-circle',
					'tooltip'       => 'This is info about this setting or field',
				),
			) );

		}

		public function cmb_show_meta_to_chosen_roles( $cmb ) {

			$roles = $cmb->prop( 'show_on_roles', array() );

			// Do not limit the box display unless the roles are defined.
			if ( empty( $roles ) ) {
				return true;
			}

			$user = wp_get_current_user();

			// No user found, return
			if ( empty( $user ) ) {
				return false;
			}

			$has_role = array_intersect( (array) $roles, $user->roles );

			// Will show the box if user has one of the defined roles.
			return ! empty( $has_role );
		}

		public function prefix_add_tooltip_to_label( $field_args, $field ) {
			// Get default label
			$label = $field->label();

			if ( $label && $field->options( 'tooltip' ) ) {
				// If label and tooltip exists, add it
				$label .= sprintf( '<span class="tip"><i class="fa %s"></i>%s</span>',
					$field->options( 'tooltip-class' ), $field->options( 'tooltip' ) );
			}

			return $label;
		}

	}

