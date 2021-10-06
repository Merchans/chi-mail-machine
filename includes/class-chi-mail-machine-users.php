<?php

	/**
	 * Plugin shortcode functionality
	 *
	 * @link       https://www.facebook.com/markovic.richard
	 * @since      1.0.0
	 *
	 * @package    Chi_Mail_Machine
	 * @subpackage Chi_Mail_Machine_Users/includes
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
	 * @subpackage Chi_Mail_Machine_Users/includes
	 * @author     Richard Markovič <addmarkovic@gmail.com>
	 */
	class Chi_Mail_Machine_Users {


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
		 * Make a new WP custom role
		 */
		public function remove_specifc_postype_for_external_worker() {
			$user = wp_get_current_user();

			if ( $user->roles[0] === 'contributor' ) {

				remove_menu_page( 'index.php' );
				remove_submenu_page( 'index.php', 'update-core.php' );


				remove_menu_page( 'edit.php' );
				remove_menu_page( 'edit.php?post_type=page' );
				remove_menu_page( 'edit.php?post_type=chi_video' );
				remove_menu_page( 'edit.php?post_type=chi_inzerce' );
				remove_menu_page( 'edit.php?post_type=chi_email_ad' );

				remove_menu_page( 'questionnaire-manager' );

				remove_submenu_page( 'admin.php', '?page=automat-nbsp' );

				remove_menu_page( 'edit.php?post_type=chi_doctor' );

				remove_menu_page( 'tools.php' );
				remove_menu_page( 'edit-comments.php' );
				remove_menu_page( 'profile.php' );
				remove_menu_page( 'admin.php?page=automat-nbsp' );

				global $submenu;

				unset( $submenu['questionnaire-manager'] ); //remove top level menu index.php (dashboard menu - Home menu )
				unset( $submenu['edit.php?post_type=chi_email'][10] );

			}
		}

		public function redirect() {
			$user = wp_get_current_user();
			global $pagenow, $typenow;

			if ( isset( $user->roles[0] ) && $user->roles[0] === 'contributor' ) {
				if ( $pagenow != "edit.php" && $typenow != "chi_email" ) {
					$admin_url = get_admin_url() . 'edit.php?post_type=chi_email';
					wp_redirect( $admin_url );
				}
			}
		}

		public function change_role_name() {
			global $wp_roles;

			if ( ! isset( $wp_roles ) ) {
				$wp_roles = new WP_Roles();
			}

			$wp_roles->roles['contributor']['name'] = 'External Worker';
			$wp_roles->role_names['contributor']    = 'External Worker';
		}

	}
