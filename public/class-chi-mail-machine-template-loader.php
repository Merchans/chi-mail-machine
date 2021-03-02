<?php


	if ( ! class_exists( 'Chi_Mail_Machine_Template_Loader' ) ) {
		if ( ! class_exists( 'Gamajo_Template_Loader' ) ) {
			require_once CHI_MAIL_BASE_DIR . 'vendor/class-gamajo-template-loader.php';
		}

		class Chi_Mail_Machine_Template_Loader extends Gamajo_Template_Loader {

			// Prefix for filter names.
			protected $filter_prefix = 'chi_mail_machine';

			// Directory name where custom templates for this plugin should be found in the theme.
			protected $theme_template_directory = 'chi-mail-machine';

			// Reference to the root directory path of this plugin.
			protected $plugin_directory = CHI_MAIL_BASE_DIR;


			// Directory name where templates are found in this plugin.
			protected $plugin_template_directory = 'templates';
		}
	}

