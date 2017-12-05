=== Spectrum Engine ===
Contributors: RapidDev
Donate link: https://paypal.me/rapiddev
Tags: rapiddev, rapid, developing, facebook, messenger, chat, plugin, website, live, support, chatbot
Requires at least: 4.5.0
Tested up to: 4.9.1
Requires PHP: 5.6.0
Stable tag: rd_messenger
License: MIT
License URI: https://rapiddev.pl/license/

A very simple plug-in that facilitates the process of adding facebook messenger to your website

== Description ==

Spectrum Engine is a simple but very life-enhancing plugin for developers. With it you can quickly create custom Customizer menu and add your own options to it.
With one `spectrum()` function, you have access to both modified and not yet edited options.
You can add the spectrum as an element of your WordPress Theme and dramatically speed up your work.
Spectrum Engine ready for theme is available at:
https://github.com/rapiddtc

Note, the plugin includes an optional option, which is Google Fonts.
If you do not remove this option, you must accept Google's terms and privacy policy.
https://www.google.com/policies/privacy/
https://developers.google.com/terms/

== Installation ==

1. Upload `rd_messenger` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add your APP ID and Facebook page ID in Customizer

== Frequently asked questions ==

= What types of options are available? =

You can now use: HTML, CHECKBOX, URL, TEXT, TEXTAREA, SELECT, COLOR, IMG, PAGE, MULTIPAGE, DROPDOWN, MULTISELECT

= Where are my options kept? =

Options and menu layout are in `spectrum_engine/_options.php` file

= How to add my own option? =

You need to add an option to the matching section, as shown below:
$options = [
  ['section_id'] =>
    [
      ['option_id', 'default_value', 'type', 'label', 'description', 'additional options']
    ]
];

= How create my own menu? =

You need to create a menu according to the scheme below:
$customization = [
  ['section_id'] =>
    [
      'Title',
      'Description'
    ],
  ['panel_id'] =>
    'Title',
    'Description',
    [
      ['section_id', 'label', 'description']
    ]
];

== Screenshots ==

1. This is the file with options
2. Dashboard with view of active options and menus
3. Google fonts
4. Available types of options

== Changelog ==

= 2.2.4 =
1. Fixed an error when the main section has no description
2. Fixed an error when the subsection has no description

= 2.2.3 =
1. Fixed issue with Google fonts during customization

= 2.2.2 =
1. Bug fixes

= 2.2.1 =
1. Bug fixes

= 2.2.1 =
1. Improved connectivity with files
2. Bug fixes

= 2.1.0 =
1. `spectrum()` function stores settings, works in personalization, and does not require so many database connections

= 2.0.0 =
1. Completely rewritten engine revamp for Spectrum theme

= 1.3.0 =
1. Bug fixes
2. Added `cc("option_id")` functions as storing settings

= 1.2.0 =
1. Bug fixes
2. Added `global $cc;` as a variable storing settings

= 1.1.0 =
1. Bug fixes
2. Added support for PAGE, MULTIPAGE, DROPDOWN, MULTISELECT

= 1.0.0 =
1. CCreation Engine was created for the CCreation theme
2. Added support for HTML, CHECKBOX, URL, TEXT, TEXTAREA, SELECT, COLOR, IMG

== Upgrade notice ==
The latest `spectrum()` functions works in personalization. Added support for Google fonts


== License ==

Copyright 2017 RapidDev Leszek Pomianowski

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.