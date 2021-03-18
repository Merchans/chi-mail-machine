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

		$columns["author_completed"] = __( "Author: has completed the email", "chi-mail-machine" );
		$columns["editor_completed"] = __( "Editor: has completed the email", "chi-mail-machine" );
		$columns["admin_completed"]  = __( "Admin: sended the email", "chi-mail-machine" );

		$columns['date'] = __( "Published on the web", "chi-mail-machine" );

		return $columns;

	}

	add_filter( 'manage_chi_email_posts_columns', 'chi_add_post_chi_email_columns' );

	function chi_add_post_chi_email_columns_data( $column, $post_id ) {
		if ( $column == "author_completed" ) {
			?>
			<input type="checkbox"
				   disabled <?php echo get_post_meta( $post_id, 'chi_email_author_state', true ) == 'on' ? 'checked' : '' ?> >
			<?php
		}
		if ( $column == "editor_completed" ) {
			?>
			<input type="checkbox"
				   disabled <?php echo get_post_meta( $post_id, 'chi_email_editor_state', true ) == 'on' ? 'checked' : '' ?> >
			<?php
		}
		if ( $column == "admin_completed" ) {
			?>
			<input type="checkbox"
				   disabled <?php echo get_post_meta( $post_id, 'chi_email_admin_state', true ) == 'on' ? 'checked' : '' ?> >
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

//	function cmb2_render_callback_for_text_test( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {
//		echo '<form class="cmb-form" method="post"><input type="submit" name="submit-cmb" value="' . __( 'Save Settings', 'give' ) . '" class="button-primary"></div></form>';
//	}
//	add_action( 'cmb2_render_text_test', 'cmb2_render_callback_for_text_test', 10, 5 );

//	add_filter( 'cmb2_get_metabox_form_format', 'give_modify_cmb2_form_output' );
//
//	function give_modify_cmb2_form_output( $args ) {
//
//		return '<form class="cmb-form" method="post" id="%1$s" enctype="multipart/form-data" encoding="multipart/form-data"><input type="hidden" name="object_id" value="%2$s">%3$s<div class="submit-wrap"><input type="submit" name="submit-cmb" value="' . __( 'Save Settings', 'give' ) . '" class="button-primary"></div></form>';
//
//	}

////Add default meta box
//	add_action( 'add_meta_boxes_chi_email', 'add_custom_meta_box_chi_email' );
//	function add_custom_meta_box_chi_email( $post ) {
//		add_meta_box( 'sections_meta_box', 'Add Section', 'show_custom_meta_box' );
//	}
//
//	function show_custom_meta_box() {
//		//In your case you can use your html::functions
//		//Your html for select box
//		$sections = array( 'section1', 'section2' );
//		$html     = '<select id="sections" name="item[]">';
//		foreach ( $sections as $key => $section ) {
//			$html .= '<option value="' . $key . '">' . $section . '</option>';
//		}
//		$html .= '</select><br><br>';
//		$html .= '<input  class="addSection" type="button" value="Add Section">';
//		echo $html;
//	}
//
////Our custom meta box will be loaded on ajax
//	function add_custom_meta_box( $post_name ) {
//		echo '<pre>';
//		print_r( get_post_meta(
//				9945,
//				'chi_email_subject',
//				true
//		) );
//		echo '</pre>';
//		echo '<pre>';
//		print_r(get_the_category( 9945
//		) );
//		echo '</pre>';
//		echo '<div id="sections_structure_box" class="postbox ">
//        <div class="handlediv" title="Click to toggle"><br></div><h3 class="hndle ui-sortable-handle"><span>Section Structure</span></h3>
//        <div class="inside">
//            Done
//        </div>';
//	}
//
////Call ajax
//	add_action( 'wp_ajax_addStructureBox', 'addStructureBox' );
////add_action('wp_ajax_noprev_addStructureBox', 'addStructureBox');
//	function addStructureBox() {
//		add_custom_meta_box( $_POST['section'] );
//		exit;
//	}
//
////In your case you can add script in your style
////Add script
//	add_action( 'admin_head', 'ajax_script' );
//	function ajax_script() { ?>
<!--		<script>-->
<!--			jQuery(document).ready(function ($) {-->
<!--				$('.addSection').on('click', function () {-->
<!--					var selectedSection = $('#sections option:selected').text();-->
<!--					console.log(selectedSection);-->
<!--					$.post(ajaxurl, {action: 'addStructureBox', section: selectedSection}, function (data) {-->
<!--						$('#sections_meta_box').parent().append(data);-->
<!--					});-->
<!--				});-->
<!--			});-->
<!--		</script>-->
<!--		--><?php
//	}
