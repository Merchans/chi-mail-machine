<?php

	/**
	 * The plugin bootstrap file
	 *
	 * This file is read by WordPress to generate the plugin information in the plugin
	 * admin area. This file also includes all of the dependencies used by the plugin,
	 * registers the activation and deactivation functions, and defines a function
	 * that starts the plugin.
	 *
	 * @link              https://www.facebook.com/markovic.richard
	 * @since             1.0.0
	 * @package           Chi_Mail_Machine
	 *
	 * @wordpress-plugin
	 * Plugin Name:       CHI Mail Machine
	 * Plugin URI:        https://github.com/Merchans/chi-mail-machine.git
	 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
	 * Version:           1.0.0
	 * Author:            Richard Markovič
	 * Author URI:        https://www.facebook.com/markovic.richard
	 * License:           GPL-2.0+
	 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
	 * Text Domain:       chi-mail-machine
	 * Domain Path:       /languages
	 */

	// If this file is called directly, abort.
	if ( ! defined( 'WPINC' ) ) {
		die;
	}

	/**
	 * Currently plugin version.
	 * Start at version 1.0.0 and use SemVer - https://semver.org
	 * Rename this for your plugin and update it as you release new versions.
	 */
	define( 'CHI_MAIL_MACHINE_VERSION', '1.0.0' );

	/**
	 * Currently plugin text domain.
	 * Start at version 1.0.0 and use SemVer - https://semver.org
	 */
	define( 'CHI_MAIL_MACHINE_NAME', 'chi-mail-machine' );

	/**
	 * Plugin dir URL
	 *
	 */
	define( 'CHI_MAIL_BASE_DIR', plugin_dir_path( __FILE__ ) );

	/**
	 * Plugin dir PATH
	 * Use to acces assetst like css/ js/ img/ etc.
	 */
	define( 'CHI_MAIL_BASE_URL', plugin_dir_url( __FILE__ ) );

	/**
	 * The code that runs during plugin activation.
	 * This action is documented in includes/class-chi-mail-machine-activator.php
	 */
	function activate_chi_mail_machine() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-chi-mail-machine-activator.php';
		Chi_Mail_Machine_Activator::activate();
	}

	/**
	 * The code that runs during plugin deactivation.
	 * This action is documented in includes/class-chi-mail-machine-deactivator.php
	 */
	function deactivate_chi_mail_machine() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-chi-mail-machine-deactivator.php';
		Chi_Mail_Machine_Deactivator::deactivate();
	}

	register_activation_hook( __FILE__, 'activate_chi_mail_machine' );
	register_deactivation_hook( __FILE__, 'deactivate_chi_mail_machine' );

	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and public-facing site hooks.
	 */
	require plugin_dir_path( __FILE__ ) . 'includes/class-chi-mail-machine.php';

	/**
	 * Begins execution of the plugin.
	 *
	 * Since everything within the plugin is registered via hooks,
	 * then kicking off the plugin from this point in the file does
	 * not affect the page life cycle.
	 *
	 * @since    1.0.0
	 */
	function run_chi_mail_machine() {

		$plugin = new Chi_Mail_Machine();
		$plugin->run();

	}

	run_chi_mail_machine();


	//	add_action( 'enqueue_block_editor_assets', 'gd_add_gutenberg_assets' );
	//	function gd_add_gutenberg_assets() {
	//		if ('chi_email' == get_post_type()) {
	//			wp_enqueue_style( 'chi-email-editor', plugin_dir_url( __FILE__ ) . 'admin/css/chi-editor.css' , false );
	//		}
	//	}

	// add 'Questions' column to admin table belonge to CPT 'theory'
	function chi_add_post_chi_email_columns( $columns ) {
		// Remove Date
		unset( $columns['date'] );

		$columns["author_completed"]           = __( "Author: has completed the email", "chi-mail-machine" );
		$columns["editor_completed"]           = __( "Editor: has completed the email", "chi-mail-machine" );
		$columns["admin_completed"]            = __( "Admin: sended the email", "chi-mail-machine" );
		$columns["externalcompany_statistics"] = __( "Statistics", "chi-mail-machine" );

		$columns['date'] = __( "Published on the web", "chi-mail-machine" );

		return $columns;

	}

	add_filter( 'manage_chi_email_posts_columns', 'chi_add_post_chi_email_columns' );

	function chi_add_post_chi_email_columns_data( $column, $post_id ) {
		if ( $column == "author_completed" ) {
			?>
            <input type="checkbox"
                   disabled <?php echo get_post_meta( $post_id, 'chi_email_author_state',
				true ) == 'on' ? 'checked' : '' ?> >
			<?php
		}
		if ( $column == "editor_completed" ) {
			?>
            <input type="checkbox"
                   disabled <?php echo get_post_meta( $post_id, 'chi_email_editor_state',
				true ) == 'on' ? 'checked' : '' ?> >
			<?php
		}
		if ( $column == "admin_completed" ) {
			?>
            <input type="checkbox"
                   disabled <?php echo get_post_meta( $post_id, 'chi_email_admin_state',
				true ) == 'on' ? 'checked' : '' ?> >
			<?php
		}
		if ( $column == "externalcompany_statistics" ) {
			?>
            <input class="statistic-url" type="url" id="text-area-for-statistics-<?php echo $post_id; ?>"
                   value="<?php echo $statistic_url = get_post_meta( $post_id,
				       'statistic_url' ) ? get_post_meta( $post_id, 'statistic_url', true ) : '' ?>">

            <input id="add-statistics-<?php echo $post_id; ?>" data-postid="<?php echo $post_id; ?>"
                   class="statistic-btn button-primary" type="submit" value="Add">
            <span class="spinner"></span>
            <div class="statistic-wrap">
				<?php if ( get_post_meta( $post_id, 'all_respondents', true ) && get_post_meta( $post_id,
						'all_open_email', true ) && get_post_meta( $post_id, 'all_web_opens', true ) ) : ?>
                    <span class="statistic-info">R: <?php echo get_post_meta( $post_id, 'all_respondents',
							true ) ?> O: <?php echo get_post_meta( $post_id, 'all_open_email',
							true ) ?> W: <?php echo get_post_meta( $post_id, 'all_web_opens', true ) ?>&nbsp;</span>
				<?php else : ?>
                    <span class="statistic-info">R: X O: X W: X&nbsp;</span>
				<?php endif ?>

            </div>
			<?php
		}
	}

	add_action( 'manage_chi_email_posts_custom_column', 'chi_add_post_chi_email_columns_data', 10, 2 );

	add_filter( 'manage_edit-chi_email_sortable_columns', 'my_sortable_cake_column' );
	function my_sortable_cake_column( $columns ) {

		$columns["author_completed"] = "author_completed";
		$columns["editor_completed"] = "editor_completed";
		$columns["admin_completed"]  = "admin_completed";

		return $columns;
	}

	add_action( 'pre_get_posts', 'mycpt_custom_orderby' );

	function mycpt_custom_orderby( $query ) {
		if ( ! is_admin() ) {
			return;
		}

		$orderby = $query->get( 'orderby' );

		if ( 'author_completed' == $orderby ) {

			$query->set( 'meta_key', 'chi_email_author_state' );
			$query->set( 'orderby', 'meta_value_num' );
		}
		if ( 'editor_completed' == $orderby ) {
			$query->set( 'meta_key', 'chi_email_editor_state' );
			$query->set( 'orderby', 'meta_value_num' );
		}
		if ( 'admin_completed' == $orderby ) {
			$query->set( 'meta_key', 'chi_email_admin_state' );
			$query->set( 'orderby', 'meta_value_num' );
		}
	}

	function ajax_script() { ?>
        <script>
            jQuery(document).ready(function ($) {
                $('.addSection').on('click', function () {
                    var selectedSection = $('#sections option:selected').text();
                    console.log(selectedSection);
                    $.post(ajaxurl, {action: 'addStructureBox', section: selectedSection}, function (data) {
                        $('#sections_meta_box').parent().append(data);
                    });
                });
            });
        </script>
		<?php
	}

?>

<?php

//	add_action( 'wp_ajax_add_myfunc', 'prefix_ajax_add_myfunc' );
	//	add_action( 'wp_ajax_nopriv_add_myfunc', 'prefix_ajax_add_myfunc' );

	function prefix_ajax_add_myfunc() {
		// Handle request then generate response using WP_Ajax_Response
		add_action( 'save_post', function ( $post_id ) {
			# Ignore autosaves
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			# Only enabled for one post type
			# Remove this if statement if you want to enable for all post types
			if ( $_POST['post_type'] === 'chi_email' ) {
				# Send JSON response
				# NOTE: We use ==, not ===, because the value may be String("true")
				if ( isset( $_POST['save_post_ajax'] ) && $_POST['save_post_ajax'] == true ) {
					wp_send_json_success();
				}
				echo '<pre>';
				print_r( $post_id );
				echo '</pre>';
			}
		} );

	}


	// Saving the post via AJAX
	add_action( 'save_post', function ( $post_id ) {
		# Ignore autosaves
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		# Only enabled for one post type
		# Remove this if statement if you want to enable for all post types
		if ( $_POST['post_type'] === 'chi_email' ) {
			# Send JSON response
			# NOTE: We use ==, not ===, because the value may be String("true")
			if ( isset( $_POST['save_post_ajax'] ) && $_POST['save_post_ajax'] == true ) {
				wp_send_json_success();
			}
		}
	} );

	add_filter( 'allowed_block_types', 'chi_allowed_block_types' );

	function chi_allowed_block_types( $allowed_blocks ) {
		if ( 'chi_email' != get_post_type() ) {
			return;
		}

		return array(
			'core/image',
			'core/paragraph',
			'core/heading',
			'core/list',
			'chi-mail-machine/blocks'
		);

	}

	remove_role( 'guest_author' );
	function wporg_simple_role() {
		add_role(
			'chi_external_worker',
			'IQUE External Worker',
			array(
				'read'         => true,
				'edit_posts'   => false,
				'upload_files' => false,
			),
		);
	}
