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
define( 'CHI_MAIL_BASE_DIR', plugin_dir_path(__FILE__) );

/**
 * Plugin dir PATH
 * Use to acces assetst like css/ js/ img/ etc.
 */
define( 'CHI_MAIL_BASE_URL', plugin_dir_url(__FILE__) );

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
