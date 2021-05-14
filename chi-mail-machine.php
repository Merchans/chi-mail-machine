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

	/**
	 * Generated by the WordPress Meta Box Generator
	 * https://jeremyhixon.com/tool/wordpress-meta-box-generator/
	 *
	 * Retrieving the values:
	 * Date the email was sent = get_post_meta( get_the_ID(), 'chi_emaildate-the-email-was-sent', true )
	 * Time the email was sent = get_post_meta( get_the_ID(), 'chi_emailtime-the-email-was-sent', true )
	 * For = get_post_meta( get_the_ID(), 'chi_emailfor', true )
	 *  Notes on the text = get_post_meta( get_the_ID(), 'chi_emailnotes-on-the-text', true )
	 */
	class CHI_EMAIL_SENDER_2 {
		private $config = '{"title":"Comments to E-mail","description":"If there are any comments on the email, please contact the author","prefix":"chi_email","domain":"chi-mail-machine","class_name":"CHI_EMAIL_SENDER","post-type":["post"],"context":"normal","priority":"low","cpt":"chi_email","fields":[{"type":"date","label":"Date the email was sent","id":"chi_emaildate-the-email-was-sent"},{"type":"time","label":"Time the email was sent","id":"chi_emailtime-the-email-was-sent"},{"type":"email","label":"For","id":"chi_emailfor"},{"type":"text","label":"Email Subject","id":"chi_emailemail-subject"},{"type":"textarea","label":" Notes on the text","id":"chi_emailnotes-on-the-text"}]}';

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

			// Stop WP from clearing custom fields on autosave
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			// Prevent quick edit from clearing custom fields
			if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
				return;
			}

			if ( isset( $_POST['chi_emailchoose-option'] ) ) {

				if ( $_POST['chi_emailchoose-option'] == '1' ) {

					foreach ( $this->config['fields'] as $field ) {


						$sanitized = sanitize_text_field( $_POST[ $field['id'] ] );

						switch ( $field['id'] ) {
							case 'chi_emailnotes-on-the-text':

								if ( isset( $_POST[ $field['id'] ] ) ) {

									if ( empty( $_POST[ $field['id'] ] ) ) {
										break;
									}

									$author_id = get_current_user_id();

									$agent = $_SERVER['HTTP_USER_AGENT'];
									$data  = array(
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

									wp_insert_comment( $data );
								}
								break;
							default:
								$user = wp_get_current_user();
								if ( ! ( in_array( 'administrator', (array) $user->roles ) ) ) {
									break;
								}
								update_post_meta( $post_id, $field['id'], $sanitized );
								break;

						}
					}
				}
				if ( $_POST['chi_emailchoose-option'] == '2' ) {
					foreach ( $this->config['fields'] as $field ) {

						$sanitized = sanitize_text_field( $_POST[ $field['id'] ] );

						//RespiroNews - Newsletter č. 32R - rozesílka 8.4.2021 06:00
						//						Dobrý deň,
						//
						//						poprosil by som Vás o nastavenie emailu 32R pre projekt RespiroNews
						//						na zajtra tj. 8.4.2020 o 6h.
						//
						//						Predmet: Plicní embolie při COVID-19 – co je pro ni charakteristické?
						//
						//						Za skorú odpoveď
						//						Ďakujem

						if ( isset( $_POST['chi_email_taxonomy_select'] ) &&
							 isset( $_POST['chi_email_special_number'] ) &&
							 isset( $_POST['chi_emailfor'] ) &&
							 isset( $_POST['chi_emailemail-subject'] ) &&
							 isset( $_POST['chi_emaildate-the-email-was-sent'] ) &&
							 isset( $_POST['chi_emailtime-the-email-was-sent'] ) &&
							 isset( $_POST['chi_emailnotes-on-the-text'] ) ) {


							$subject_data = ucwords( $_POST['chi_email_taxonomy_select'] ) . ' - Newsletter č. ' . $_POST['chi_email_special_number'] . ' - rozesílka ' . $_POST['chi_emaildate-the-email-was-sent'] . ' ' . $_POST['chi_emailtime-the-email-was-sent'];

							$subject = sanitize_text_field( $subject_data );

							$message = nl2br( 'Dobrý deň,<br><br>Poprosil by som Vás o nastavenie emailu č. <strong>' . $_POST['chi_email_special_number'] . '</strong> pre projekt <strong>' . ucwords( $_POST['chi_email_taxonomy_select'] ) . '</strong> na <strong>' . $_POST['chi_emaildate-the-email-was-sent'] . '</strong> o <strong>' . $_POST['chi_emailtime-the-email-was-sent'] . '</strong>.<br><br>Predmet: <strong>' . get_the_title() . '</strong><br><br>Za skorú odpoveď<br>Ďakujem', true );

						}
						// chi_email_taxonomy_select
						// chi_email_special_number
						// chi_emailfor
						// chi_emailemail-subject
						// chi_emaildate-the-email-was-sent
						// chi_emailtime-the-email-was-sent
						// chi_emailnotes-on-the-text

						switch ( $field['id'] ) {
							case 'chi_emailnotes-on-the-text':
								if ( isset( $_POST[ $field['id'] ] ) ) {

									if ( ! empty( $_POST[ $field['id'] ] ) ) {
										break;
									}

									$author_id = get_current_user_id();

									$agent = $_SERVER['HTTP_USER_AGENT'];
									$data  = array(
											'comment_post_ID'      => $post_id,
											'comment_author'       => get_the_author_meta( 'nickname', $author_id ),
											'comment_author_email' => get_the_author_meta( 'user_email', $author_id ),
											'comment_content'      => $message,
											'comment_author_IP'    => get_the_user_ip(),
											'comment_agent'        => $agent,
											'comment_date'         => date( 'Y-m-d H:i:s' ),
											'comment_date_gmt'     => date( 'Y-m-d H:i:s' ),
											'comment_approved'     => 1,
									);

									$comment_id = wp_insert_comment( $data );
									add_comment_meta( $comment_id, 'subject', $subject );

								}
								break;
							default:
								$user = wp_get_current_user();
								if ( ! ( in_array( 'administrator', (array) $user->roles ) ) ) {
									break;
								}
								update_post_meta( $post_id, $field['id'], $sanitized );
								break;

						}
					}
				}
				if ( $_POST['chi_emailchoose-option'] == '3' ) {
					foreach ( $this->config['fields'] as $field ) {

						$sanitized = sanitize_text_field( $_POST[ $field['id'] ] );

						if ( isset( $_POST['chi_emailfor'] ) &&
							 isset( $_POST['chi_emailemail-subject'] ) &&
							 isset( $_POST['chi_emailnotes-on-the-text'] ) ) {


							$subject = sanitize_text_field( $_POST['chi_emailemail-subject'] );
							$message = sanitize_text_field( $_POST['chi_emailnotes-on-the-text'] );

						}

						switch ( $field['id'] ) {
							case 'chi_emailnotes-on-the-text':
								if ( isset( $_POST[ $field['id'] ] ) ) {

									if ( empty( $_POST[ $field['id'] ] ) ) {
										break;
									}

									$author_id = get_current_user_id();

									$agent = $_SERVER['HTTP_USER_AGENT'];
									$data  = array(
											'comment_post_ID'      => $post_id,
											'comment_author'       => get_the_author_meta( 'nickname', $author_id ),
											'comment_author_email' => get_the_author_meta( 'user_email', $author_id ),
											'comment_content'      => $message,
											'comment_author_IP'    => get_the_user_ip(),
											'comment_agent'        => $agent,
											'comment_date'         => date( 'Y-m-d H:i:s' ),
											'comment_date_gmt'     => date( 'Y-m-d H:i:s' ),
											'comment_approved'     => 1,
									);

									$comment_id = wp_insert_comment( $data );
									add_comment_meta( $comment_id, 'subject', $subject );

								}
								break;
							default:
								$user = wp_get_current_user();
								if ( ! ( in_array( 'administrator', (array) $user->roles ) ) ) {
									break;
								}
								update_post_meta( $post_id, $field['id'], $sanitized );
								break;

						}
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
						<div class="note_content <?php echo( get_comment_meta( $comment->comment_ID, 'subject', true ) ? 'note_content--info' : '' ) ?>">
							<?php if ( get_comment_meta( $comment->comment_ID, 'subject', true ) ) : ?>
								<p>Predmet emailu:
									<strong><?php echo get_comment_meta( $comment->comment_ID, 'subject', true ) ?></strong>
								</p>
							<?php endif ?>
							<p><?php echo $comment->comment_content; ?></p>
						</div>
						<p class="meta">
							<abbr class="exact-date" title="<?php echo $comment->comment_date_gmt ?>">
								<?php echo $comment->comment_date; ?></abbr>
							<?php echo $comment->comment_author; ?>
							<a href="<?php echo admin_url( '/comment.php?action=editcomment&c=' . $comment->comment_ID . '' ); ?>"
							   class="vim-q comment-inline button-link" role="button">Edit note</a> |
							<?php
								$del_nonce = esc_html( '_wpnonce=' . wp_create_nonce( "delete-comment_$comment->comment_ID" ) );
								$trash_url = $trash_url = esc_url( "comment.php?action=trashcomment&p=$comment->comment_post_ID&c=$comment->comment_ID&$del_nonce&reason=1" );
							?>
							<a href="<?php echo $trash_url ?>"
							   onclick="return confirm('Are you sure?')" class="delete_note" role="button">Delete
								note</a>
						</p>
					</li>
				<?php endforeach ?>
			</ul>
			<table class="form-table" role="presentation">
				<tbody><?php
					foreach ( $this->config['fields'] as $field ) {
						?>
					<tr class="tr-<?php echo $field['id'] ?>">
						<th scope="row"><?php $this->label( $field ); ?></th>
						<td><?php $this->field( $field ); ?></td>
						</tr><?php
					}
				?>
				<tr>
					<th scope="row">
						<label for="<?php echo $this->config['prefix'] ?>choose-option">Choose an option:</label>
					</th>
					<td>
						<select name="<?php echo $this->config['prefix'] ?>choose-option"
								id="<?php echo $this->config['prefix'] ?>choose-option">
							<option value="1">Email note</option>
							<?php if ( ( in_array( 'administrator', (array) wp_get_current_user()->roles ) ) ) : ?>
								<option value="2">Sending an email to an external company</option>
								<option value="3">Edit email</option>
							<?php endif ?>
						</select>
						<input id="publishComment" class="button-primary" type="submit" value="Send" accesskey="p"
							   tabindex="5"
							   name="Send">
						<span class="spinner"></span>
					</td>
				</tr>
				</tbody>
			</table>
			<script>
				(function ($) {

					function deleteNote() {
						return confirm('Do you really want to submit the form?');
					}

					$(function () {
						// Code goes here
						function nodeChangeLog() {
							if ($('#chi_emailchoose-option').val() == "1") {
								$('tr.tr-chi_emaildate-the-email-was-sent').fadeOut();
								$('tr.tr-chi_emailtime-the-email-was-sent').fadeOut();
								$('tr.tr-chi_emailfor').fadeOut();
								$('tr.tr-chi_emailemail-subject').fadeOut();
								$('tr.tr-chi_emailnotes-on-the-text').fadeIn();
							}
							if ($('#chi_emailchoose-option').val() == "2") {
								$('tr.tr-chi_emaildate-the-email-was-sent').fadeIn();
								$('tr.tr-chi_emailtime-the-email-was-sent').fadeIn();
								$('tr.tr-chi_emailnotes-on-the-text').fadeOut(600);
								$('tr.tr-chi_emailfor').fadeOut();
								$('tr.tr-chi_emailemail-subject').fadeOut();
							}
							if ($('#chi_emailchoose-option').val() == "3") {
								$('tr.tr-chi_emaildate-the-email-was-sent').fadeIn();
								$('tr.tr-chi_emailtime-the-email-was-sent').fadeIn();
								$('tr.tr-chi_emailfor').fadeIn();
								$('tr.tr-chi_emailnotes-on-the-text').fadeIn();
								$('tr.tr-chi_emailemail-subject').fadeIn();
							}
						}

						nodeChangeLog();
						$('#chi_emailchoose-option').on('change', function () {
							nodeChangeLog();
						});

					});
				})(jQuery);
			</script>
			<script>
				(function ($) {
					console.log("ready");

					$('#publishComment').on('click', function (e) {
						e.preventDefault();
						console.log("click");
						$.post(
								ajaxurl,
								{
									'action': 'add_myfunc',
									'data': 'foobarid',
								},
								function (response) {

									console.log(response);
								}
						);
					});
				})(jQuery);
			</script>
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
				case 'date':
				case 'time':
					$this->input_minmax( $field );
					break;
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

		private function input_minmax( $field ) {
			printf(
					'<input class="regular-text" id="%s" %s %s name="%s" %s type="%s" value="%s">',
					$field['id'],
					isset( $field['max'] ) ? "max='{$field['max']}'" : '',
					isset( $field['min'] ) ? "min='{$field['min']}'" : '',
					$field['id'],
					isset( $field['step'] ) ? "step='{$field['step']}'" : '',
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

	new CHI_EMAIL_SENDER_2;

?>
<?php

	add_action( 'wp_ajax_add_myfunc', 'prefix_ajax_add_myfunc' );
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


	function my_post_type_xhr() {
		# Only for one post type.
		if ( get_post_type() === 'chi_email' ) {

			?>
			<script>
				// Avoid collisions with other libraries
				(function ($) {
					// Make sure the document is ready
					$(document).ready(function () {

						var btn = $('#publishComment');
						btn.on('click', function (e) {
							console.log('clicked');
							$('.spinner').addClass('is-active');
							e.preventDefault()

							// This is the post.php url we localized (via php) above
							var url = '<?= admin_url( 'post.php' ) ?>'
							// Serialize form data
							var data = $('form#post').serializeArray()
							// Tell PHP what we're doing
							// NOTE: "name" and "value" are the array keys. This is important. I use int(1) for the value to make sure we don't get a string server-side.
							data.push({name: 'save_post_ajax', value: 1})

							// Replaces wp.autosave.initialCompareString
							var ajax_updated = false

							/**
							 * Supercede the WP beforeunload function to remove
							 * the confirm dialog when leaving the page (if we saved via ajax)
							 *
							 * The following line of code SHOULD work in $.post.done(), but
							 *     for some reason, wp.autosave.initialCompareString isn't changed
							 *     when called from wp-includes/js/autosave.js
							 * wp.autosave.initialCompareString = wp.autosave.getCompareString();
							 */
							$(window).unbind('beforeunload.edit-post')
							$(window).on('beforeunload.edit-post', function () {
								var editor = typeof tinymce !== 'undefined' && tinymce.get('content')

								// Use our "ajax_updated" var instead of wp.autosave.initialCompareString
								if ((editor && !editor.isHidden() && editor.isDirty()) ||
										(wp.autosave && wp.autosave.getCompareString() !== ajax_updated)) {
									return postL10n.saveAlert
								}
							})


							// Post it
							$.post(url, data, function (response) {
								// Validate response
								if (response.success) {
									// Mark TinyMCE as saved
									if (typeof tinyMCE !== 'undefined') {
										for (id in tinyMCE.editors) {
											if (tinyMCE.get(id))
												tinyMCE.get(id).setDirty(false)
										}
									}
									// Update the saved content for the beforeunload check
									ajax_updated = wp.autosave.getCompareString()

									console.log('Saved post successfully')
								} else {
									console.log('ERROR: Server returned false. ', response)
								}
							}).fail(function (response) {
								console.log('ERROR: Could not contact server. ', response)
							}).done(function () {
								if (wp.autosave) {
									wp.autosave.enableButtons();
								}

								$('.spinner').removeClass('is-active');
							})

							return false
						})
					})
				})(jQuery)
			</script>
			<?php
		}
	}

	add_action( 'admin_footer-post.php', 'my_post_type_xhr', 999 );
	add_action( 'admin_footer-post-new.php', 'my_post_type_xhr', 999 );
