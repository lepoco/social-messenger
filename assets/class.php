<?php defined('ABSPATH') or die('No script kiddies please!');
/**
 * @package WordPress
 * @subpackage Live Chat (Messenger API)
 *
 * @author RapidDev | Polish technology company
 * @copyright Copyright (c) 2018-2019, RapidDev
 * @link https://www.rdev.cc/
 * @license https://opensource.org/licenses/MIT
 */
	//https://www.facebook.com/4GEEKCO/settings/?tab=messenger_platform
	/**
	*
	* RDEV_SOCIAL_MESSENGER
	*
	* @author   Leszek Pomianowski <https://rdev.cc>
	* @version  $Id: class.php;RDEV_SOCIAL_MESSENGER,v 2.3.2 2019/10/10
	* @access   public
	*/
	if(!class_exists('RDEV_SOCIAL_MESSENGER'))
	{
		class RDEV_SOCIAL_MESSENGER
		{

			/**
			* init
			* Registers class methods in WordPress without assigning to an object.
			*
			* @access   public
			*/
			public static function init()
			{
				return new RDEV_SOCIAL_MESSENGER();
			}

			/**
			* __construct
			* The constructor registers the language domain, actions, filters and other actions.
			*
			* @access   public
			*/
			public function __construct()
			{

				//Debug verify
				//update_option('rdev_social_messenger_verify', FALSE);


				add_action('plugins_loaded', function(){
					load_plugin_textdomain('social_messenger',FALSE,basename(RDEV_SOCIAL_MESSENGER_PATH).'/languages/');
				});

				if (is_admin())
				{
					add_filter('plugin_action_links_'.RDEV_SOCIAL_MESSENGER_BASENAME, function($data)
					{
						//Custom links in plugins list
						$data[] = '<a href="'.admin_url('/customize.php?autofocus[section]=social_messenger').'">'.__('Settings').'</a>';
						$data[] = '<a href="https://www.facebook.com/" rel="noopener" target="_blank">Facebook</a>';
						return $data;
					});
				}

				if (self::verify_integrity())
				{
					add_action('customize_register',array($this,'customizer'));

					if (get_theme_mod('social_messenger_enable','enable') == 'enable')
					{
						add_action('wp_head', array($this,'head'));
						add_action('wp_footer', array($this,'footer'));
					}
				}
			}

			/**
			* head
			* Additional styles and main script for the messenger chat.
			*
			* @access   public
			*/
			public function head()
			{
				//Single page mode
				$display = TRUE;
				$single_page_mode = get_theme_mod('social_messenger_pages', 0);
				if ($single_page_mode != 0)
					if($single_page_mode != get_queried_object_id())
						$display = FALSE;

				//Additional CSS depending on the selected chat position
				$html = NULL;
				switch (get_theme_mod('social_messenger_position', 'right'))
				{
					case 'left':
						$html .= '.fb_dialog, .fb-customerchat * > iframe {left:18pt !important;right: auto;}';
						break;
					case 'center':
						$html .= '.fb_dialog, .fb-customerchat * > iframe {margin: auto;left: 0;right: 0;}';
						break;
				}

				//Force hide chat on phones
				if (get_theme_mod('social_messenger_phones', 'disable') == 'enable')
					$html .= '@media(max-width:770px){.fb_dialog{display: none !important;}}';

				//If any html has been added, display styles
				if ($html != NULL)
					$html = '<style>'.$html.'</style>'.PHP_EOL;

				//Language
				$language = get_theme_mod('social_messenger_language', 'en_US');
				switch (get_theme_mod('social_messenger_integration', 'disable'))
				{
					case 'pl': //Polylang
						if (function_exists('pll_current_language'))
						{
							$language = pll_current_language('locale');
						}
						break;
					case 'wpml': //WPML
						if (defined('ICL_LANGUAGE_CODE'))
						{
							$language = ICL_LANGUAGE_CODE.'_'.strtoupper(ICL_LANGUAGE_CODE);
						}
						break;
				}

				$html .= '<script>';
				$html .= 'window.fbAsyncInit = function(){FB.init({xfbml:true,version:"v4.0"});};';
				$html .= '(function(d, s, id){var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = "https://connect.facebook.net/'.$language.'/sdk/xfbml.customerchat.js";fjs.parentNode.insertBefore(js, fjs);}(document, "script", "facebook-jssdk"));';
				$html .= '</script>'.PHP_EOL;

				if($display)
					echo $html;
			}

			/**
			* footer
			* HTML tags for chat.
			*
			* @access   public
			*/
			public function footer()
			{
				//Single page mode
				$display = TRUE;
				$single_page_mode = get_theme_mod('social_messenger_pages', 0);
				if ($single_page_mode != 0)
					if($single_page_mode != get_queried_object_id())
						$display = FALSE;

				//Additional webhook
				if (get_theme_mod('social_messenger_webhook', NULL) != NULL)
					$webhook = ' ref="'.$webhook.'"';
				else
					$webhook = '';

				//Additional minimized option
				switch (get_theme_mod('social_messenger_minimized', 'default'))
				{
					case 'enable':
						$minimized = ' minimized="true"';
						break;
					case 'disable':
						$minimized = ' minimized="false"';
						break;
					default:
						$minimized = '';
						break;
				}

				//Greeting text for logged in users
				$greeting_logged = get_theme_mod('social_messenger_hello_logged', '');
				$greeting_logged_option = get_option('social_messenger_hello_logged', '');
				if ($greeting_logged != '') {
					if (function_exists('pll_register_string') && function_exists('pll__')) {
						if ($greeting_logged_option != $greeting_logged) {
							update_option('social_messenger_hello_logged', $greeting_logged);
							pll_register_string('social_messenger', $greeting_logged);
						}
						$greeting_logged = ' logged_in_greeting="'.pll__($greeting_logged).'"';
					}else{
						$greeting_logged = ' logged_in_greeting="'.$greeting_logged.'"';
					}
				}else{
					$greeting_logged = '';
				}

				//Greeting text for logged out in users
				$greeting_unlogged = get_theme_mod('social_messenger_hello_unlogged', '');
				$greeting_unlogged_option = get_option('social_messenger_hello_unlogged', '');
				if ($greeting_unlogged != '') {
					if (function_exists('pll_register_string') && function_exists('pll__')) {
						if ($greeting_unlogged_option != $greeting_unlogged) {
							update_option('social_messenger_hello_unlogged', $greeting_unlogged);
							pll_register_string('social_messenger', $greeting_unlogged);
						}
						$greeting_unlogged = ' logged_out_greeting="'.pll__($greeting_unlogged).'"';
					}else{
						$greeting_unlogged = ' logged_out_greeting="'.$greeting_unlogged.'"';
					}
				}else{
					$greeting_unlogged = '';
				}

				$html = '<!-- Social Messenger Plugin for Facebook SDK by RapidDev - https://rdev.cc/social-messenger -->'.PHP_EOL;
				$html .= '<div id="fb-root"></div>'.PHP_EOL;
				$html .= '<div class="fb-customerchat" attribution=setup_tool page_id="'.get_theme_mod('social_messenger_page').'" theme_color="'.get_theme_mod('social_messenger_colors', '#4080FF').'"'.$greeting_logged.$greeting_unlogged.$minimized.$webhook.'></div>'.PHP_EOL;

				if ($display)
					echo $html;
			}

			/**
			* customizer
			* This method prepares a customizer menu based on an array.
			*
			* @access   public
			* @param	object $_c
			*/
			public function customizer($_c)
			{
				$options = array(
					'social_messenger_enable' => array('select','enable',__('Switch on the Facebook Messenger','social_messenger'),'',array('enable'=>__('Enabled','social_messenger'),'disable'=>__('Disabled','social_messenger'))),
					'social_messenger_minimized' => array('select','default',__('Minimized (optional)','social_messenger'),__('Specifies whether the plugin should be minimized or shown. Defaults to true on desktop and false on mobile browsers.','social_messenger'),array('default'=>__('Default','social_messenger'),'enable'=>__('Enabled','social_messenger'),'disable'=>__('Disabled','social_messenger'))),
					'social_messenger_phones' => array('select','disable',__('Turn off live chat on phones','social_messenger'),__('Forces hiding live chat with CSS.','social_messenger'),array('enable'=>__('Enabled','social_messenger'),'disable'=>__('Disabled','social_messenger'))),
					'social_messenger_position' => array('select','right',__('Chat position on the page','social_messenger'),__('Forces a change of position based on CSS.','social_messenger'),array('right'=>__('On the right side','social_messenger'),'left'=>__('On the left side','social_messenger'),'center'=>__('In the middle','social_messenger'))),
					'social_messenger_colors' => array('color','#4080FF', __('Theme color','social_messenger'),__('This option will change the color of the main button and chat color.','social_messenger')),
					'social_messenger_language' => array('select','en_GB',__('Language','social_messenger'),__('The list of languages has been established on the basis of Facebook Documentation.','social_messenger'),array('pl_PL'=>'Polish','af_ZA'=>'Afrikaans (SouthAfrica)','af_AF'=>'Afrikaans','ar_AR'=>'Arabic','bn_IN'=>'Bengali','my_MM'=>'Burmese','zh_CN'=>'Chinese (China)','zh_HK'=>'Chinese (HongKong)','zh_TW'=>'Chinese (Taiwan)','hr_HR'=>'Croatian','cs_CZ'=>'Czech','da_DK'=>'Danish','nl_NL'=>'Dutch','en_GB'=>'English (UnitedKingdom)','en_US'=>'English','fi_FI'=>'Finnish','fr_FR'=>'French','de_DE'=>'German','el_GR'=>'Greek','gu_IN'=>'Gujarati','he_IL'=>'Hebrew','hi_IN'=>'Hindi','hu_HU'=>'Hungarian','id_ID'=>'Indonesian','it_IT'=>'Italian','ja_JP'=>'Japanese','ko_KR'=>'Korean','cb_IQ'=>'Kurdish','ms_MY'=>'Malay','ml_IN'=>'Malayalam','mr_IN'=>'Marathi','nb_NO'=>'Norwegian','pt_BR'=>'Portuguese (Brazil)','pt_PT'=>'Portuguese','pa_IN'=>'Punjabi','ro_RO'=>'Romanian','ru_RU'=>'Russian','sk_SK'=>'Slovak','es_LA'=>'Spanish (LatinAmerica)','es_ES'=>'Spanish','sw_KE'=>'Swahili','sv_SE'=>'Swedish','tl_PH'=>'Tagalog','ta_IN'=>'Tamil','te_IN'=>'Telugu','th_TH'=>'Thai','tr_TR'=>'Turkish','ur_PK'=>'Urdu','vi_VN'=>'Vietnamese')),
					'social_messenger_integration' => array('select','disable',__('Integration','social_messenger'),__('Choose the multilingual plugin that you have installed. WPML does not always work [*sad pepe*]','social_messenger'),array('disable'=>__('Disabled','social_messenger'),'pl'=>'PolyLang','wpml'=>'WPML')),
					'social_messenger_hello_logged' => array('textarea',NULL,__('Greeting text (logged in users)','social_messenger'),__('Automatically registers as a PolyLang string, you can translate it in the settings.','social_messenger')),
					'social_messenger_hello_unlogged' => array('textarea',NULL,__('Greeting text (logged out users)','social_messenger'),__('Automatically registers as a PolyLang string, you can translate it in the settings.','social_messenger')),
					'social_messenger_pages' => array('dropdown-pages',0,__('Single page mode','social_messenger'),__('If you choose one of these options, the plugin will only be displayed on the selected page.','social_messenger')),
					'social_messenger_page' => array('text',NULL,__('Page ID','social_messenger'),__('Enter your numeric fanpage id here.','social_messenger'),__('e.g','social_messenger').': 1769853790702772'),
					'social_messenger_webhook' => array('text',NULL,__('Webhook (optional)','social_messenger'),__('Custom string passed to your webhook in messaging_postbacks and messaging_referrals events.','social_messenger'),''),
				);
				$_c->add_section('social_messenger',array('title'=>'Facebook Messenger','capability'=>'edit_theme_options','priority'=> 5));
				$priority = 1;
				foreach ($options as $name => $option) {
					$_c->add_setting($name,array('default'=> $option[1]));
					switch ($option[0]) {
						case 'select':
							$_c->add_control(new WP_Customize_Control($_c,$name,array('label'=>$option[2],'description'=>$option[3],'section'=>'social_messenger','type'=>'select','priority'=>$priority,'choices'=>$option[4])));
							break;
						case 'color':
							$_c->add_control(new WP_Customize_Color_Control($_c,$name,array('label'=>$option[2],'description'=>$option[3],'section'=>'social_messenger','priority'=>$priority)));
							break;
						default:
							if(!isset($option[4])){$option[4] = NULL;}
							$_c->add_control($name,array('label'=>$option[2],'description'=>$option[3],'section'=>'social_messenger','type'=>$option[0],'priority'=>$priority,'input_attrs'=>array('placeholder'=>$option[4])));
							break;
					}
					$priority++;
				}
			}

			/**
			* admin_notice
			* Defines an error code and display an alert on the WordPress admin page.
			*
			* @access   private
			* @param	int $id
			*/
			private function admin_notice($id = 0)
			{
				define('RDEV_SOCIAL_MESSENGER_ERROR', $id);
				add_action('admin_notices', function(){
					switch(RDEV_SOCIAL_MESSENGER_ERROR)
					{
						case 1:
							$message = str_replace('%s', RDEV_SOCIAL_MESSENGER_PHP_VERSION,__('Your PHP version is outdated. Please, upgrade your PHP to a higher or equal version than %s.', 'social_messenger'));
							break;
						case 2:
							$message = str_replace('%s', RDEV_SOCIAL_MESSENGER_WP_VERSION,__('Your WordPress version is outdated. Please, upgrade your WordPress to a higher or equal version than %s.', 'social_messenger'));
							break;
						default:
							$message = __('There was an unidentified error. We should look deeper...', 'social_messenger');
							break;
					}
					delete_option('rdev_social_messenger_verify');
					echo '<div class="error notice"><p><strong>'.RDEV_SOCIAL_MESSENGER_NAME.'</strong><br />'.$message.'</p><p><i>'.__('ERROR ID', 'social_messenger').': '.RDEV_SOCIAL_MESSENGER_ERROR.'</i></p></div>';
				});
			}

			/**
			* verify_integrity
			* Checks version compatibility.
			*
			* @access   private
			* @param	int $id
			*/
			private function verify_integrity()
			{
				if (get_option('rdev_social_messenger_verify', FALSE))
					return TRUE;
				
				//Check PHP
				$php = FALSE;
				if (version_compare(PHP_VERSION, RDEV_SOCIAL_MESSENGER_PHP_VERSION, '>='))
					$php = TRUE;
				
				//Check WordPress
				global $wp_version;
				$wp = FALSE;
				if (version_compare($wp_version, RDEV_SOCIAL_MESSENGER_WP_VERSION, '>='))
					$wp = TRUE;

				if ($php && $wp)
				{
					update_option('rdev_social_messenger_verify', TRUE);
					return TRUE;
				}
				else
				{
					if($wp)
						self::admin_notice(1);
					else
						self::admin_notice(2);
					return FALSE;					
				}
			}
		}
	}
?>