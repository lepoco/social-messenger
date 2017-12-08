<?php
/*
Plugin Name: Social Messenger
Plugin URI: http://wordpress.org/plugins/social_messenger/
Description: A very simple plug-in that facilitates the process of adding Facebook Messenger to your website
Author: Leszek Pomianowski
Author URI: https://rapiddev.pl/
License: MIT
License URI: https://rapiddev.pl/license
Version: 1.3.3
Text Domain: social_messenger
Domain Path: /languages
*/
/**
 * @package WordPress
 * @subpackage Facebook Messenger
 *
 * @author Leszek Pomianowski
 * @copyright Copyright (c) 2017, RapidDev
 * @link https://www.rapiddev.pl/social_messenger
 * @license https://www.rapiddev.pl/license
 */

/* ====================================================================
 * Constant
 * ==================================================================*/
	define('social_messenger_VERSION', '1.3.3');
	define('social_messenger_PATH', plugin_dir_path( __FILE__ ));

/* ====================================================================
 * Define language files
 * ==================================================================*/
	function social_messenger_languages()
	{
		load_theme_textdomain('social_messenger', plugin_dir_path( __FILE__ ).'languages');
	}
	add_action('plugins_loaded', 'social_messenger_languages');

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
		function social_messenger_customizer($wp_customize)
		{
			#HTML Class
			if(class_exists('WP_Customize_Control') && ! class_exists('social_messenger_html')){
				class social_messenger_html extends WP_Customize_Control {
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
			#Dropdown class
			if(class_exists('WP_Customize_Control') && ! class_exists('social_messenger_dropdown')){
				class social_messenger_dropdown extends WP_Customize_Control {
					public $type = 'dropdown-select';
					public function render_content(){
						if(empty($this->choices)) return;
?><label>
	<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
	<select autocomplete="off" <?php $this->link(); ?> style="width: 100%;">
		<?php
		foreach($this->choices as $value => $label){
			$selected = ($value == $this->value()) ? selected( 1, 1, false ): '';if($selected != 0){$selected = ' selected ';}echo '<option value="' . esc_attr( $value ) . '"' . $selected . '>' . $label . '</option>';
		} ?>
	</select>
</label><?php
					}
				}
			}
			#Add section
			$wp_customize->add_section('social_messenger',array('title'=>'Facebook Messenger','capability'=>'edit_theme_options','priority'=> 5));
			#Add enable dropdown setting
			$wp_customize->add_setting('social_messenger_enable',array('default' => 1,'transport'  =>  'refresh'));
			$wp_customize->add_control(new social_messenger_dropdown($wp_customize,'social_messenger_enable',array('settings' => 'social_messenger_enable','label' => __('Switch on the Facebook Messenger','social_messenger'),'section' => 'social_messenger','type' => 'dropdown-select','priority' => 1,'choices'  => array(1 => __('Enabled', 'social_messenger'), 2 => __('Disabled', 'social_messenger')))));
			#Add minimized dropdown setting
			$wp_customize->add_setting('social_messenger_minimized',array('default' => 2,'transport'  =>  'refresh'));
			$wp_customize->add_control(new social_messenger_dropdown($wp_customize,'social_messenger_minimized',array('settings' => 'social_messenger_minimized','description'=>__('Specifies whether the plugin should be minimized or shown. Defaults to true on desktop and false on mobile browsers', 'social_messenger'),'label' => __('Minimized (optional)','social_messenger'),'section' => 'social_messenger','type' => 'dropdown-select','priority' => 2,'choices'  => array(1 => __('Enabled', 'social_messenger'), 2 => __('Disabled', 'social_messenger')))));
			#Add hide on mobile dropdown setting
			$wp_customize->add_setting('social_messenger_hidemobile',array('default' => 2,'transport'  =>  'refresh'));
			$wp_customize->add_control(new social_messenger_dropdown($wp_customize,'social_messenger_hidemobile',array('settings' => 'social_messenger_hidemobile','label' => __('Turn off live chat on phones','social_messenger'),'description'=>__('Forces hiding live chat with CSS', 'social_messenger'),'section' => 'social_messenger','type' => 'dropdown-select','priority' => 3,'choices'  => array(1 => __('Enabled', 'social_messenger'), 2 => __('Disabled', 'social_messenger')))));
			#Add polylang dropdown setting
			$wp_customize->add_setting('social_messenger_polylang',array('default' => 2,'transport'  =>  'refresh'));
			$wp_customize->add_control(new social_messenger_dropdown($wp_customize,'social_messenger_polylang',array('settings' => 'social_messenger_polylang','label' => __('Integration with PolyLang','social_messenger'),'description'=>__('If integration is enabled, it will work regardless of the language setting below', 'social_messenger'),'section' => 'social_messenger','type' => 'dropdown-select','priority' => 4,'choices'  => array(1 => __('Enabled', 'social_messenger'), 2 => __('Disabled', 'social_messenger')))));
			#Add language settings
			$wp_customize->add_setting('social_messenger_language',array('default' => 'en_US','transport'  =>  'refresh'));
			$wp_customize->add_control(new social_messenger_dropdown($wp_customize,'social_messenger_language',array('settings' => 'social_messenger_language','label' => __('Language','social_messenger'),'description'=>__('The list of languages has been established on the basis of Facebook Documentation', 'social_messenger'),'section' => 'social_messenger','type' => 'dropdown-select','priority' => 5,'choices'  => array('pl_PL' => 'Polish','af_ZA' => 'Afrikaans (South Africa)','af_AF' => 'Afrikaans','ar_AR' => 'Arabic'	,'bn_IN' => 'Bengali','my_MM' => 'Burmese','zh_CN' => 'Chinese (China)','zh_HK' => 'Chinese (Hong Kong)','zh_TW' => 'Chinese (Taiwan)','hr_HR' => 'Croatian','cs_CZ' => 'Czech','da_DK' => 'Danish','nl_NL' =>	'Dutch','en_GB' => 'English (United Kingdom)','en_US' => 'English','fi_FI' => 'Finnish','fr_FR' => 'French','de_DE' => 'German','el_GR' => 'Greek','gu_IN' => 'Gujarati','he_IL' => 'Hebrew','hi_IN' => 'Hindi','hu_HU' => 'Hungarian','id_ID' => 'Indonesian','it_IT' => 'Italian','ja_JP' => 'Japanese','ko_KR' => 'Korean','cb_IQ' => 'Kurdish','ms_MY' => 'Malay','ml_IN' => 'Malayalam','mr_IN' => 'Marathi','nb_NO' => 'Norwegian','pt_BR' => 'Portuguese (Brazil)','pt_PT' => 'Portuguese','pa_IN' => 'Punjabi','ro_RO' => 'Romanian','ru_RU' => 'Russian','sk_SK' => 'Slovak','es_LA' => 'Spanish (Latin America)','es_ES' => 'Spanish','sw_KE' => 'Swahili','sv_SE' => 'Swedish','tl_PH' => 'Tagalog','ta_IN' => 'Tamil','te_IN' => 'Telugu','th_TH' => 'Thai','tr_TR' => 'Turkish','ur_PK' => 'Urdu','vi_VN' => 'Vietnamese'))));
			#Add poistion dropdown setting
			$wp_customize->add_setting('social_messenger_position',array('default' => 'right','transport'  =>  'refresh'));
			$wp_customize->add_control(new social_messenger_dropdown($wp_customize,'social_messenger_position',array('settings' => 'social_messenger_position','label' => __('Chat position on the page','social_messenger'),'description'=>__('Forces a change of position based on CSS', 'social_messenger'),'section' => 'social_messenger','type' => 'dropdown-select','priority' => 6,'choices'  => array('right' => __('On the right side', 'social_messenger'), 'left' => __('On the left side', 'social_messenger'), 'center' => __('In the middle', 'social_messenger')))));
			#Add api key setting
			$wp_customize->add_setting('social_messenger_api',array('default'=>null,'type'=>'theme_mod','capability'=>'edit_theme_options','transport'=>'refresh'));
			$wp_customize->add_control('social_messenger_api',array('type'=>'text','priority'=> 7,'section'=>'social_messenger','label' => __('Api ID','social_messenger'),'description'=>__('Enter your application id here','social_messenger')));
			#Add page id setting
			$wp_customize->add_setting('social_messenger_page',array('default'=> null,'type'=>'theme_mod','capability'=>'edit_theme_options','transport'=>'refresh'));
			$wp_customize->add_control('social_messenger_page',array('type'=>'text','priority'=>8,'section'=>'social_messenger','label'=>__('Page ID','social_messenger'),'description'=>__('Enter your numeric page id here','social_messenger')));
			#Add webhook setting
			$wp_customize->add_setting('social_messenger_webhook',array('default'=>null,'type'=>'theme_mod','capability'=>'edit_theme_options','transport'=>'refresh'));
			$wp_customize->add_control('social_messenger_webhook',array('type'=>'text','priority'=> 9,'section'=>'social_messenger','label' => __('Webhook (optional)','social_messenger'),'description'=>__('Custom string passed to your webhook in messaging_postbacks and messaging_referrals events','social_messenger')));
			#Description
			$wp_customize->add_setting('social_messenger_html',array('transport' => 'refresh'));
			$wp_customize->add_control(new social_messenger_html($wp_customize,'social_messenger_html',array('priority' => 10,'section' => 'social_messenger','content' =>'<hr /><p><strong>'.__('Important informations', 'social_messenger').'</strong><br />'.__('You need to add your website to trusted on your fanpage. You can do this in the Messenger Platform tab in the Whitelisted Domains card (fanpage settings page)', 'social_messenger').'</p><hr /><p><strong>'.__('Where can I get my api key?','social_messenger').'</strong><br/>'.__('To receive or create an application key you must','social_messenger').':<ol><li>'.__('Log into', 'social_messenger').' <a href="https://developers.facebook.com/" target="_blank">Facebook Developers</a></li><li>'.__('Open or create a new application', 'social_messenger').'</li><li>'.__('On the Settings page you will find your App ID', 'social_messenger').'</li><li>'.__("Now click the button below 'Add Platform'", 'social_messenger').'</li><li>'.__("Select 'Website' and then enter the address of this page", 'social_messenger').'</li></ol></p><hr /><p><strong>'.__('Where can I get my page id?','social_messenger').'</strong><br/>'.__('To receive your page id you must','social_messenger').': '.__('Go to your fanpage, ex', 'social_messenger').': <i><a href="https://fb.com/rapiddev">https://fb.com/rapiddev</a></i> '.__('and try to find it in settings', 'social_messenger').' '.__('or just', 'social_messenger').' <a href="https://findmyfbid.com/" target="_blank">'.__('use this tool', 'social_messenger').'</a></p><hr /><p><a class="button button-primary" style="width:100%;text-align:center" href="https://developers.facebook.com/" target="_blank">Facebook Developers</a></p><p><a class="button button-secondary" style="width:100%;text-align:center" href="https://developers.facebook.com/docs/messenger-platform/reference/web-plugins/#customer_chat" target="_blank">'.__('Documentation Facebook Messenger Site Plugin', 'social_messenger').'</a><a class="button button-secondary" style="width:100%;text-align:center" href="https://rapiddev.pl/" target="_blank">'.__('The website of the creators of the plugin', 'social_messenger').'</a></p><p><small>'.__('Facebook and Facebook Messenger are registered trademarks of Facebook Inc.', 'social_messenger').'</small></p>')));
		}
		add_action('customize_register', 'social_messenger_customizer');

/* ====================================================================
 * Footer action
 * ==================================================================*/
		function social_messenger_footer()
		{
			$minimized = get_theme_mod('social_messenger_minimized');
			$webhook = get_theme_mod('social_messenger_webhook');
			if($minimized == 1){$min = 'true';}else{$min = 'false';}
			if($webhook!=null){$web=' ref="'.$webhook.'"';}else{$web=null;}
			$lang = get_theme_mod('social_messenger_language', 'en_US');
			if (get_theme_mod('social_messenger_polylang') == 1) {
				if (function_exists('pll_current_language')) {
					$lang = pll_current_language('locale');
				}
			}
?>
<div class="fb-customerchat" page_id="<?php echo get_theme_mod('social_messenger_page') ?>" minimized="<?php echo $min; ?>"<?php echo $web; ?>></div><script async="async" defer="defer">window.fbAsyncInit = function() {FB.init({appId : '<?php echo get_theme_mod('social_messenger_api') ?>',xfbml : true,version : 'v2.11'});FB.AppEvents.logPageView();};(function(d, s, id){var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) {return;}js = d.createElement(s); js.id = id;js.src = "https://connect.facebook.net/<?php echo $lang; ?>/sdk.js";fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script>
<?php
		}
		if (get_theme_mod('social_messenger_enable', 1) == 1)
		{
			add_action('wp_footer', 'social_messenger_footer');
		}

/* ====================================================================
 * Header action
 * ==================================================================*/
		function social_messenger_header()
		{
			$return = null;
			$position = get_theme_mod('social_messenger_position');
			if ($position == 'left') {
				$return .= '.fb_dialog, .fb-customerchat * > iframe {left:18pt !important;right: auto;}';
			}else if ($position == 'center') {
				$return .= '.fb_dialog, .fb-customerchat * > iframe {margin: auto;left: 0;right: 0;}';
			}
			if (get_theme_mod('social_messenger_hidemobile') == 1) {
				$return .= '@media(max-width: 765px){#fb-root {display: none !important}}';
			}

			if ($return != null) {
				echo '<style>'.$return.'</style>';
			}
		}
		add_action('wp_head', 'social_messenger_header');

/* ====================================================================
 * WordPress <4.5.0 error
 * ==================================================================*/
	}else{
		if (!function_exists('social_messenger_wordpress_error'))
		{
			function social_messenger_wordpress_error()
			{
				?>
				<div class="notice notice-error">
					<p>
						<strong><?php _e('CRITICAL ERROR', 'social_messenger') ?>!</strong>
						<br />
						<?php _e('The', 'social_messenger'); ?> <i>Facebook Messenger</i> <?php _e('requires at least', 'social_messenger') ?> WordPress 4.5.0
						<br />
						<?php _e('You need to update your WordPress site', 'social_messenger') ?>.
						<br />
						<small><i><?php _e('ERROR ID', 'social_messenger') ?>: 2</i></small>
					</p>
				</div>
				<?php
			}
			add_action('admin_notices', 'social_messenger_wordpress_error');
		}
	}

/* ====================================================================
 * PHP <5.4.0 error
 * ==================================================================*/
	}else{
		if (!function_exists('social_messenger_php_error'))
		{
			function social_messenger_php_error()
			{
				?>
				<div class="notice notice-error">
					<p>
						<strong><?php _e('CRITICAL ERROR', 'social_messenger') ?>!</strong>
						<br />
						<?php _e('The', 'social_messenger'); ?> <i>Facebook Messenger</i> <?php _e('requires at least', 'social_messenger') ?> PHP 5.4.0
						<br />
						<?php _e('You need to update your server', 'social_messenger') ?>.
						<br />
						<small><i><?php _e('ERROR ID', 'social_messenger') ?>: 1</i></small>
					</p>
				</div>
				<?php
			}
			add_action('admin_notices', 'social_messenger_php_error');
		}
	}
?>