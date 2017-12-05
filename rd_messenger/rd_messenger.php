<?php
/*
Plugin Name: Facebook Messenger
Plugin URI: http://wordpress.org/plugins/rd_messenger/
Description: A very simple plug-in that facilitates the process of adding facebook messenger to your website
Author: Leszek Pomianowski
Author URI: https://rapiddev.pl/
License: MIT
License URI: https://rapiddev.pl/license
Version: 1.1.0
Text Domain: rd_messenger
Domain Path: /languages
*/
/**
 * @package WordPress
 * @subpackage Facebook Messenger
 *
 * @author Leszek Pomianowski
 * @copyright Copyright (c) 2017, RapidDev
 * @link https://www.rapiddev.pl/rd_messenger
 * @license https://www.rapiddev.pl/license
 */

/* ====================================================================
 * Constant
 * ==================================================================*/
	define('RD_MESSENGER_VERSION', '1.1.0');
	define('RD_MESSENGER_PATH', plugin_dir_path( __FILE__ ));

/* ====================================================================
 * Define language files
 * ==================================================================*/
	function rd_messenger_languages()
	{
		load_theme_textdomain('rd_messenger', plugin_dir_path( __FILE__ ).'languages');
	}
	add_action('plugins_loaded', 'rd_messenger_languages');

/* ====================================================================
 * PHP Version verification
 * ==================================================================*/
	if (version_compare(PHP_VERSION, '5.4.0') >= 0)
	{

/* ====================================================================
 * WordPress Version check
 * ==================================================================*/
	global $wp_version;
	if (version_compare($wp_version, '4.5.0', '>='))
	{

/* ====================================================================
 * Add customization options
 * ==================================================================*/
		function rd_messenger_customizer($wp_customize)
		{
			#HTML Class
			if(class_exists('WP_Customize_Control') && ! class_exists('rd_messenger_html')){
				class rd_messenger_html extends WP_Customize_Control {
					public $content = '';
					public function render_content(){
						if (isset($this->label)){
							echo '<span class="customize-control-title">'.$this->label.'</span>';
						}
						if(isset($this->description)){
							echo '<span class="description customize-control-description">'.$this->description.'</span>';
						}
						if(isset($this->content)){
							echo $this->content;
						}
					}
				}
			}
			#Add section
			$wp_customize->add_section('rd_messenger',array('title'=>'Facebook Messenger','capability'=>'edit_theme_options','priority'=> 5));
			#Add enable checkbox setting
			$wp_customize->add_setting('rd_messenger_enable',array('default'=> false,'type'=>'theme_mod','capability'=>'edit_theme_options','transport'=>'refresh'));
			$wp_customize->add_control('rd_messenger_enable',array('type'=>'checkbox','priority'=>1,'section'=>'rd_messenger','label'=>__('Switch on the Facebook Messenger','rd_messenger')));
			#Add minimized checkbox setting
			$wp_customize->add_setting('rd_messenger_minimized',array('default'=> false,'type'=>'theme_mod','capability'=>'edit_theme_options','transport'=>'refresh'));
			$wp_customize->add_control('rd_messenger_minimized',array('type'=>'checkbox','priority'=>2,'section'=>'rd_messenger','label'=>__('Minimized (optional)','rd_messenger'),'description'=>__('Specifies whether the plugin should be minimized or shown. Defaults to true on desktop and false on mobile browsers.', 'rd_messenger')));
			#Add api key setting
			$wp_customize->add_setting('rd_messenger_api',array('default'=>null,'type'=>'theme_mod','capability'=>'edit_theme_options','transport'=>'refresh'));
			$wp_customize->add_control('rd_messenger_api',array('type'=>'text','priority'=> 3,'section'=>'rd_messenger','label' => __('API key','rd_messenger'),'description'=>__('Enter your application key here','rd_messenger')));
			#Add page id setting
			$wp_customize->add_setting('rd_messenger_page',array('default'=> null,'type'=>'theme_mod','capability'=>'edit_theme_options','transport'=>'refresh'));
			$wp_customize->add_control('rd_messenger_page',array('type'=>'text','priority'=>4,'section'=>'rd_messenger','label'=>__('Page ID','rd_messenger'),'description'=>__('Enter your numeric page id here','rd_messenger')));
			#Add webhook setting
			$wp_customize->add_setting('rd_messenger_webhook',array('default'=>null,'type'=>'theme_mod','capability'=>'edit_theme_options','transport'=>'refresh'));
			$wp_customize->add_control('rd_messenger_webhook',array('type'=>'text','priority'=> 5,'section'=>'rd_messenger','label' => __('Webhook (optional)','rd_messenger'),'description'=>__('Custom string passed to your webhook in messaging_postbacks and messaging_referrals events','rd_messenger')));
			#Description
			$wp_customize->add_setting('rd_messenger_html',array('transport' => 'refresh'));
			$wp_customize->add_control(new rd_messenger_html($wp_customize,'rd_messenger_html',array('section' => 'rd_messenger','priority' => 6,'content' =>
				'<hr /><a class="button button-secondary" style="width:100%;text-align:center" href="https://developers.facebook.com/docs/messenger-platform/reference/web-plugins/#customer_chat" target="_blank">Facebook Developers</a><p><small>'.__('Facebook and Facebook Messenger are registered trademarks of Facebook Inc.', 'rd_messenger').'</small></p>'
			)));
		}
		add_action('customize_register', 'rd_messenger_customizer');

/* ====================================================================
 * Footer action
 * ==================================================================*/
		function rd_messenger_footer()
		{
			$minimized = get_theme_mod('rd_messenger_minimized');
			$webhook = get_theme_mod('rd_messenger_webhook');
			if($minimized){$min = 'true';}else{$min = 'false';}
			if($webhook!=null){$web=' ref="'.$webhook.'"';}else{$web=null;}
?>
<div class="fb-customerchat" page_id="<?php echo get_theme_mod('rd_messenger_page') ?>" minimized="<?php echo $min; ?>"<?php echo $web; ?>></div><script async="async" defer="defer">window.fbAsyncInit = function() {FB.init({appId : '<?php echo get_theme_mod('rd_messenger_api') ?>',xfbml : true,version : 'v2.11'});FB.AppEvents.logPageView();};(function(d, s, id){var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) {return;}js = d.createElement(s); js.id = id;js.src = "https://connect.facebook.net/en_US/sdk.js";fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script>
<?php
		}
		if (get_theme_mod('rd_messenger_enable'))
		{
			add_action('wp_footer', 'rd_messenger_footer');
		}

/* ====================================================================
 * WordPress <4.5.0 error
 * ==================================================================*/
	}else{
		if (!function_exists('rd_messenger_wordpress_error'))
		{
			function rd_messenger_wordpress_error()
			{
				?>
				<div class="notice notice-error">
					<p>
						<strong><?php _e('CRITICAL ERROR', 'rd_messenger') ?>!</strong>
						<br />
						<?php _e('The', 'rd_messenger'); ?> <i>Facebook Messenger</i> <?php _e('requires at least', 'rd_messenger') ?> WordPress 4.5.0
						<br />
						<?php _e('You need to update your WordPress site', 'rd_messenger') ?>.
						<br />
						<small><i><?php _e('ERROR ID', 'rd_messenger') ?>: 2</i></small>
					</p>
				</div>
				<?php
			}
			add_action('admin_notices', 'rd_messenger_wordpress_error');
		}
	}

/* ====================================================================
 * PHP <5.4.0 error
 * ==================================================================*/
	}else{
		if (!function_exists('rd_messenger_php_error'))
		{
			function rd_messenger_php_error()
			{
				?>
				<div class="notice notice-error">
					<p>
						<strong><?php _e('CRITICAL ERROR', 'rd_messenger') ?>!</strong>
						<br />
						<?php _e('The', 'rd_messenger'); ?> <i>Facebook Messenger</i> <?php _e('requires at least', 'rd_messenger') ?> PHP 5.4.0
						<br />
						<?php _e('You need to update your server', 'rd_messenger') ?>.
						<br />
						<small><i><?php _e('ERROR ID', 'rd_messenger') ?>: 1</i></small>
					</p>
				</div>
				<?php
			}
			add_action('admin_notices', 'rd_messenger_php_error');
		}
	}
?>