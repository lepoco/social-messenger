<?php defined('ABSPATH') or die('No script kiddies please!');
/*
Plugin Name: Live Chat (Messenger API) + PolyLang
Plugin URI: http://wordpress.org/plugins/social-messenger/
Description: Facebook Messenger on your website. Modify colors, choose languages, integrate with PolyLang, change positions and much more... It's easy!
Author: RapidDev
Author URI: https://rdev.cc/
License: MIT
License URI: https://opensource.org/licenses/MIT
Version: 2.4.6
Text Domain: social_messenger
Domain Path: /languages
*/
/**
 * @package WordPress
 * @subpackage Live Chat (Messenger API)
 *
 * @author RapidDev | Polish technology company
 * @copyright Copyright (c) 2018-2020, RapidDev
 * @link https://www.rdev.cc/
 * @license https://opensource.org/licenses/MIT
 */

/* ====================================================================
 * Constant
 * ==================================================================*/
	define('RDEV_SOCIAL_MESSENGER_NAME', 'Live Chat (Messenger API) + PolyLang');
	define('RDEV_SOCIAL_MESSENGER_PATH', plugin_dir_path(__FILE__));
	define('RDEV_SOCIAL_MESSENGER_BASENAME', plugin_basename(__FILE__));
	define('RDEV_SOCIAL_MESSENGER_WP_VERSION', '4.9.0');
	define('RDEV_SOCIAL_MESSENGER_PHP_VERSION', '5.4.0');

/* ====================================================================
 * Plugin class
 * ==================================================================*/
	require_once RDEV_SOCIAL_MESSENGER_PATH.'assets/class.php';
	new RDEV_SOCIAL_MESSENGER();
