<?php defined('ABSPATH') or die('No script kiddies please!');
/**
 * @package WordPress
 * @subpackage Facebook Messenger (Live Chat)
 *
 * @author RapidDev | Polish technology company
 * @copyright Copyright (c) 2017, RapidDev
 * @link https://www.rapiddev.pl/en/social-messenger
 * @license https://opensource.org/licenses/MIT
 */

	if(!class_exists('RAPIDDEV_SOCIAL_MESSENGER'))
	{
		class RAPIDDEV_SOCIAL_MESSENGER
		{
			public static function init()
			{
				return new RAPIDDEV_SOCIAL_MESSENGER();
			}

			public function __construct()
			{
				add_action('plugins_loaded', array($this,'languages'));

				if (self::check_versions())
				{
					add_action('customize_register',array($this,'customizer'));

					if (get_theme_mod('social_messenger_enable','enable') == 'enable')
					{
						add_action('wp_head', array($this,'css'));
						add_action('wp_footer', array($this,'javascript'));
					}
					if (is_admin())
					{
						add_filter('plugin_action_links_'.RAPIDDEV_SOCIAL_MESSENGER_BASENAME,array($this,'settings_url'));
					}
				}
			}

			public function languages()
			{
				load_plugin_textdomain('social_messenger',FALSE,basename(RAPIDDEV_SOCIAL_MESSENGER_PATH).'/languages/');
			}

			public function css()
			{
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

				if (get_theme_mod('social_messenger_phones', 'disable') == 'enable') {
					$html .= '@media(max-width:770px){.fb_dialog{display: none !important;}}';
				}

				if ($html != NULL)
				{
					echo '<style>'.$html.'</style>';
				}
			}

			public function javascript()
			{
				$display = TRUE;

				//Single page mode
				$single_page_mode = get_theme_mod('social_messenger_pages', 0);
				if ($single_page_mode != 0)
				{
					if ($single_page_mode != get_queried_object_id())
					{
						$display = FALSE;
					}
				}
				//Additional webhook
				$webhook = get_theme_mod('social_messenger_webhook', NULL);
				if ($webhook != NULL)
				{
					$webhook = ' ref="'.$webhook.'"';
				}
				else
				{
					$webhook = '';
				}
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
				//Additional minimized option
				switch (get_theme_mod('social_messenger_minimized', 'default'))
				{
					case 'enable':
						$minimized = 'minimized="true" ';
						break;
					case 'disable':
						$minimized = 'minimized="false" ';
						break;
					default:
						$minimized = '';
						break;
				}
				//JavaScript output
				$html = '<div class="fb-customerchat" page_id="'.get_theme_mod('social_messenger_page').'"'.$minimized.''.$webhook.' theme_color="'.get_theme_mod('social_messenger_colors', '#4080FF').'"></div><script async="async" defer="defer">window.fbAsyncInit = function() {FB.init({appId : "'.get_theme_mod('social_messenger_api').'",xfbml : true,version : "v2.11"});FB.AppEvents.logPageView();};(function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if (d.getElementById(id)) {return;}js = d.createElement(s); js.id = id;js.src = "https://connect.facebook.net/'.$language.'/sdk.js";fjs.parentNode.insertBefore(js, fjs);}(document,"script","facebook-jssdk"));</script>';
				if ($display) {
					echo $html;
				}
			}

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
					'social_messenger_pages' => array('dropdown-pages',0,__('Single page mode','social_messenger'),__('If you choose one of these options, the plugin will only be displayed on the selected page.','social_messenger')),
					'social_messenger_api' => array('text',NULL,__('Api ID','social_messenger'),__('Enter your application id here.','social_messenger'),__('e.g','social_messenger').': 120557035300037'),
					'social_messenger_page' => array('text',NULL,__('Page ID','social_messenger'),__('Enter your numeric fanpage id here.','social_messenger'),__('e.g','social_messenger').': 1769853790702772'),
					'social_messenger_webhook' => array('text',NULL,__('Webhook (optional)','social_messenger'),__('Custom string passed to your webhook in messaging_postbacks and messaging_referrals events.','social_messenger'),''),
				);
				$_c->add_section('social_messenger',array('title'=>'Facebook Messenger','capability'=>'edit_theme_options','priority'=> 5));
				$priority = 1;
				foreach ($options as $name => $option) {
					$_c->add_setting($name,array('default'=> $option[1],'transport'=>'refresh'));
					switch ($option[0]) {
						case 'select':
							$_c->add_control(new WP_Customize_Control($_c,$name,array('label'=>$option[2],'description'=>$option[3],'section'=>'social_messenger','type'=>'select','priority'=>$priority,'choices'=>$option[4])));
							break;
						case 'color':
							$_c->add_control(new WP_Customize_Color_Control($_c,$name,array('label'=>$option[2],'description'=>$option[3],'section'=>'social_messenger','priority'=>$priority)));
							break;
						default:
							$_c->add_control($name,array('label'=>$option[2],'description'=>$option[3],'section'=>'social_messenger','type'=>$option[0],'priority'=>$priority,'input_attrs'=>array('placeholder'=>$option[4])));
							break;
					}
					$priority++;
				}
			}

			public function settings_url($data)
			{
				//Custom links in plugins list
				array_push($data,'<a href="'.admin_url('/customize.php?autofocus[section]=social_messenger').'">'.__('Settings').'</a>');
				array_push($data,'<a target="_blank" rel="noopener nofollow" href="https://developers.facebook.com/">Facebook Developers</a>');
				return $data;
			}

			public function admin_alert()
			{
				switch(RAPIDDEV_SOCIAL_MESSENGER_ERROR)
				{
					case 1:
						$message = str_replace('%s', RAPIDDEV_SOCIAL_MESSENGER_PHP_VERSION,__('Your PHP version is outdated. Please, upgrade your PHP to a higher or equal version than %s.', 'social_messenger'));
						break;
					case 2:
						$message = str_replace('%s', RAPIDDEV_SOCIAL_MESSENGER_WP_VERSION,__('Your WordPress version is outdated. Please, upgrade your WordPress to a higher or equal version than %s.', 'social_messenger'));
						break;
					default:
						$message = __('There was an unidentified error. We should look deeper...', 'social_messenger');
						break;
				}
				remove_option('social_messenger_versions');
				echo '<div class="error notice"><p><strong>'.RAPIDDEV_SOCIAL_MESSENGER_NAME.'</strong><br />'.$message.'</p><p><i>ERROR ID: '.RAPIDDEV_SOCIAL_MESSENGER_ERROR.'</i></p></div>';
			}

			private function admin_notice($id = 0)
			{
				define('RAPIDDEV_SOCIAL_MESSENGER_ERROR', $id);
				add_action('admin_notices', array($this, 'admin_alert'));
			}

			private function check_versions()
			{
				$compatibility = get_option('social_messenger_versions', FALSE);

				if ($compatibility)
				{
					return TRUE;
				}
				else
				{
					$php = FALSE;$wp = FALSE;
					//Check PHP
					if (version_compare(PHP_VERSION, RAPIDDEV_TRACKING_EMAIL_PHP_VERSION, '>=')){$php = TRUE;}
					//Check WordPress
					global $wp_version;
					if (version_compare($wp_version, RAPIDDEV_TRACKING_EMAIL_WP_VERSION, '>=')){$wp = TRUE;}

					if ($php && $wp) {
						update_option('social_messenger_versions', TRUE);
						return TRUE;
					}
					else
					{
						if($wp)
						{
							self::admin_notice(1);
						}
						else
						{
							self::admin_notice(2);
						}
						return FALSE;
					}					
				}
			}
		}
	}
?>