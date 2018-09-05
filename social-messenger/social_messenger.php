<?php
/*
Plugin Name: Facebook Messenger (Live Chat)
Plugin URI: http://wordpress.org/plugins/social-messenger/
Description: Facebook Messenger on your website. Modify colors, choose languages, integrate with PolyLang, change positions and much more... It's easy!
Author: RapidDev | Polish technology company
Author URI: https://rapiddev.pl/
License: MIT
License URI: https://opensource.org/licenses/MIT
Version: 2.2.2
Text Domain: social_messenger
Domain Path: /languages
*/
/**
 * @package WordPress
 * @subpackage Facebook Messenger (Live Chat)
 *
 * @author RapidDev | Polish technology company
 * @copyright Copyright (c) 2018, RapidDev
 * @link https://www.rapiddev.pl/en/social-messenger
 * @license https://opensource.org/licenses/MIT
 */

/* ====================================================================
 * Constant
 * ==================================================================*/
	define('RAPIDDEV_SOCIAL_MESSENGER_NAME', 'Facebook Messenger (Live Chat)');
	define('RAPIDDEV_SOCIAL_MESSENGER_PATH', plugin_dir_path(__FILE__));
	define('RAPIDDEV_SOCIAL_MESSENGER_BASENAME', plugin_basename(__FILE__));
	define('RAPIDDEV_SOCIAL_MESSENGER_WP_VERSION', '4.9.0');
	define('RAPIDDEV_SOCIAL_MESSENGER_PHP_VERSION', '5.4.0');

/* ====================================================================
 * Plugin class
 * ==================================================================*/
	if (is_file(RAPIDDEV_SOCIAL_MESSENGER_PATH.'assets/class.php')) {
		include(RAPIDDEV_SOCIAL_MESSENGER_PATH.'assets/class.php');
		RAPIDDEV_SOCIAL_MESSENGER::init();
	}
?>