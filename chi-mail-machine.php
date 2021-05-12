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

	add_action( 'admin_menu', 'custom_mail_menu' );
	function custom_mail_menu() {

//create new top-level menu
		add_options_page( 'Custom Mail Settings', 'Custom Mail Settings', 'administrator', __FILE__, 'custom_mail_settings_page' );

//call register settings function
		add_action( 'admin_init', 'custom_mail_settings' );
	}


	function custom_mail_settings() {
//register our settings
		register_setting( 'custom-mail-settings-group-15167', 'custom_mail_to' );
		register_setting( 'custom-mail-settings-group-15167', 'custom_mail_from' );
		register_setting( 'custom-mail-settings-group-15167', 'custom_mail_sub' );
		register_setting( 'custom-mail-settings-group-15167', 'custom_mail_message' );
	}

	function sendMail() {
		if ( $_POST['send'] ) {
			$sendto   = esc_attr( get_option( 'custom_mail_to' ) );
			$sendfrom = esc_attr( get_option( 'custom_mail_from' ) );
			$sendsub  = esc_attr( get_option( 'custom_mail_sub' ) );
			$sendmess = esc_attr( get_option( 'custom_mail_message' ) );
			$headers  = "From: Wordpress <" . $sendfrom . ">";
			wp_mail( $sendto, $sendsub, $sendmess, $headers );
		}
	}

	function custom_mail_settings_page() {

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have sufficient pilchards to access this page.' ) );
		}


		?>
		<div class="wrap">
			<h2>Custom Mail Settings</h2>

			<form method="post" action="">
				<?php settings_fields( 'custom-mail-settings-group-15167' ); ?>
				<?php do_settings_sections( 'custom-mail-settings-group-15167' ); ?>
				<table class="form-table" style="width: 50%">
					<tr valign="top">
						<th scope="row">To</th>
						<td>
							<input style="width: 100%" type="text" name="custom_mail_to"
								   value="<?php echo esc_attr( get_option( 'custom_mail_to' ) ); ?>"/>
						</td>
					</tr>

					<tr valign="top">
						<th scope="row">From</th>
						<td>
							<input style="width: 100%" type="text" name="custom_mail_from"
								   value="<?php echo esc_attr( get_option( 'custom_mail_from' ) ); ?>"/>
						</td>
					</tr>

					<tr valign="top">
						<th scope="row">Subject</th>
						<td>
							<input style="width: 100%" type="text" name="custom_mail_sub"
								   value="<?php echo esc_attr( get_option( 'custom_mail_sub' ) ); ?>"/>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">Message</th>
						<!-- <td><input type="text" name="custom_mail_message" value="?php echo esc_attr( get_option('custom_mail_message') ); ?>" /></td> /-->
						<td>
					<textarea style="text-align: left;" name="custom_mail_message" rows="10"
							  cols="62"><?php echo esc_attr( get_option( 'custom_mail_message' ) ); ?></textarea>
						</td>
					</tr>
					<tr>
						<td></td>
						<td><?php submit_button( 'Send', 'primary', 'send' ); ?></td>
						</td>

					</tr>
				</table>
			</form>
		</div>
	<?php }


	/**
	 * Generated by the WordPress Meta Box Generator
	 * https://jeremyhixon.com/tool/wordpress-meta-box-generator/
	 *
	 * Retrieving the values:
	 * Notes on the text = get_post_meta( get_the_ID(), 'send_email_notes-on-the-text', true )
	 */
	class CHI_EMAIL_SENDER {
		private $config = '{"title":"Comments to E-mail","description":"If there are any comments on the email, please contact the author","prefix":"send_email_","domain":"chi-mail-machine","class_name":"CHI_EMAIL_SENDER","post-type":["post"],"context":"normal","priority":"low","cpt":"chi_email","fields":[{"type":"textarea","label":"Notes on the text","id":"send_email_notes-on-the-text"}]}';

		public function __construct() {
			$this->config = json_decode( $this->config, true );
			$this->process_cpts();
			add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
			add_action( 'admin_head', [ $this, 'admin_head' ] );
			add_action( 'save_post', [ $this, 'save_post' ] );
		}

		public function process_cpts() {
			if ( ! empty( $this->config['cpt'] ) ) {
				if ( empty( $this->config['post-type'] ) ) {
					$this->config['post-type'] = [];
				}
				$parts                     = explode( ',', $this->config['cpt'] );
				$parts                     = array_map( 'trim', $parts );
				$this->config['post-type'] = array_merge( $this->config['post-type'], $parts );
			}
		}

		public function add_meta_boxes() {
			foreach ( $this->config['post-type'] as $screen ) {
				add_meta_box(
						sanitize_title( $this->config['title'] ),
						$this->config['title'],
						[ $this, 'add_meta_box_callback' ],
						$screen,
						$this->config['context'],
						$this->config['priority']
				);
			}
		}

		public function admin_head() {
			global $typenow;
			if ( in_array( $typenow, $this->config['post-type'] ) ) {
				?><?php
			}
		}

		public function save_post( $post_id ) {

			foreach ( $this->config['fields'] as $field ) {
				switch ( $field['type'] ) {
					default:
						if ( isset( $_POST[ $field['id'] ] ) ) {

							if ( empty( $_POST[ $field['id'] ] ) ) {
								return;
							}

							$sanitized = sanitize_text_field( $_POST[ $field['id'] ] );

							$author_id = get_post_field( 'post_author', $post_id );
							$agent     = $_SERVER['HTTP_USER_AGENT'];
							$data      = array(
									'comment_post_ID'      => $post_id,
									'comment_author'       => get_the_author_meta( 'nickname', $author_id ),
									'comment_author_email' => get_the_author_meta( 'user_email', $author_id ),
									'comment_content'      => $sanitized,
									'comment_author_IP'    => get_the_user_ip(),
									'comment_agent'        => $agent,
									'comment_date'         => date( 'Y-m-d H:i:s' ),
									'comment_date_gmt'     => date( 'Y-m-d H:i:s' ),
									'comment_approved'     => 1,
							);

//							update_post_meta( $post_id, $field['id'], $sanitized );
							wp_insert_comment( $data );
						}
				}
			}
		}

		public function add_meta_box_callback() {
			echo '<div class="rwp-description">' . $this->config['description'] . '</div>';
			$this->fields_table();
		}

		private function fields_table() {

			$args     = array(
					'post_id' => get_the_ID(),   // Use post_id, not post_ID
			);
			$comments = get_comments( $args );
			?>
			<ul class="order_notes">
				<?php foreach ( $comments as $comment ) : ?>
					<li rel="<?php $comment->comment_ID; ?>" class="note">
						<div class="note_content">
							<p><?php echo $comment->comment_content; ?></p>
						</div>
						<p class="meta">
							<abbr class="exact-date" title="<?php echo $comment->comment_date_gmt ?>">
								<?php echo $comment->comment_date; ?></abbr>
							<?php echo $comment->comment_author; ?>
							<a href="<?php echo admin_url( '/comment.php?action=editcomment&c=28' ); ?>"
							   class="vim-q comment-inline button-link" role="button">Edit note</a> |
							<a href="<?php echo admin_url( '/comment.php?action=trashcomment&c=28' ); ?>"
							   class="delete_note" role="button">Delete note</a>
						</p>
					</li>
				<?php endforeach ?>
			</ul>
			<table class="form-table" role="presentation">
				<tbody><?php
					foreach ( $this->config['fields'] as $field ) {
						?>
						<tr>
						<th scope="row"><?php $this->label( $field ); ?></th>
						<td><?php $this->field( $field ); ?></td>
						</tr><?php
					}
				?></tbody>
			</table>
			<div style="text-align: right">
				<input id="publish" class="button-primary" type="submit" value="Save" accesskey="p" tabindex="5"
					   name="save">
			</div>
			<?php
		}

		private function label( $field ) {
			switch ( $field['type'] ) {
				default:
					printf(
							'<label class="" for="%s">%s</label>',
							$field['id'], $field['label']
					);
			}
		}

		private function field( $field ) {
			switch ( $field['type'] ) {
				case 'textarea':
					$this->textarea( $field );
					break;
				default:
					$this->input( $field );
			}
		}

		private function input( $field ) {
			printf(
					'<input class="regular-text %s" id="%s" name="%s" %s type="%s" value="%s">',
					isset( $field['class'] ) ? $field['class'] : '',
					$field['id'], $field['id'],
					isset( $field['pattern'] ) ? "pattern='{$field['pattern']}'" : '',
					$field['type'],
					$this->value( $field )
			);
		}

		private function textarea( $field ) {
			printf(
					'<textarea class="regular-text" id="%s" name="%s" rows="%d">%s</textarea>',
					$field['id'], $field['id'],
					isset( $field['rows'] ) ? $field['rows'] : 5,
					$this->value( $field )
			);
		}

		private function value( $field ) {
			global $post;
			if ( metadata_exists( 'post', $post->ID, $field['id'] ) ) {
				$value = get_post_meta( $post->ID, $field['id'], true );
			} else if ( isset( $field['default'] ) ) {
				$value = $field['default'];
			} else {
				return '';
			}

			return str_replace( '\u0027', "'", $value );
		}

	}

	new CHI_EMAIL_SENDER;

	function get_the_user_ip() {

		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {

//check ip from share internet

			$ip = $_SERVER['HTTP_CLIENT_IP'];

		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {

//to check ip is pass from proxy

			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

		} else {

			$ip = $_SERVER['REMOTE_ADDR'];

		}

		return apply_filters( 'wpb_get_ip', $ip );

	}

	add_shortcode( 'display_ip', 'get_the_user_ip' );
