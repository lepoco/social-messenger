<?php defined('ABSPATH') or die('No script kiddies please!');
/**
 * @package WordPress
 * @subpackage Live Chat (Messenger API)
 *
 * @author RapidDev | Polish technology company
 * @copyright Copyright (c) 2018-2020, RapidDev
 * @link https://www.rdev.cc/
 * @license https://opensource.org/licenses/MIT
 */

	if(class_exists('WP_Customize_Control') && ! class_exists('WP_Spectrum_HTML'))
	{
		class WP_Spectrum_HTML extends WP_Customize_Control
		{
			public $content = '';
			public function render_content()
			{
				if (isset($this->label))
				{
					echo '<span class="customize-control-title">'.$this->label.'</span>';
				}
				
				if(isset($this->description))
				{
					echo '<span class="description customize-control-description">'.$this->description.'</span>';
				}

				if(isset($this->content))
				{
					echo $this->content;
				}
			}
		}
	}
