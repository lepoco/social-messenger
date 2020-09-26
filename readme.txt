=== Live Chat (Messenger API) + PolyLang ===
Contributors: RapidDev
Donate link: https://paypal.me/rapiddev
Tags: facebook, messenger, chat, polylang, chatbox, livechat, wpml, plugin, rapiddev, rdev, developing, website, live, support, chatbot, adjust, size, responsize, customizer, phone, disable, integration, color
Requires at least: 4.9.0
Tested up to: 5.5.1
Requires PHP: 5.6.0
Stable tag: social-messenger
License: MIT
License URI: https://opensource.org/licenses/MIT

Facebook Messenger on your website. Modify colors, choose languages, integrate with PolyLang, change positions and much more... It's easy!

== Description ==

Messenger custom chat on your website for free. Modify colors, choose languages, integrate with PolyLang, change positions and much more... It's easy!
Live Chat (Messenger API) is an easy-to-use plugin that helps ordinary users to start Messenger customer chat on their site.

All you have to do is add the ID of your fanpage, which you can find in the Information tab.

== Installation ==

= Minimum Requirements =

* PHP version 5.4.0 or greater (PHP 7.4 or greater is recommended)
* MySQL version 5.0 or greater (MySQL 5.6 or greater is recommended)
* WordPress version 4.9.0 or greater (WordPress 5.5.1 or greater is recommended)

= Automatic installation =

Automatic installation is the easiest option as WordPress handles the file transfers itself and you don’t need to leave your web browser. To do an automatic install of our plugin, log in to your WordPress dashboard, navigate to the Plugins menu and click Add New.

In the search field type Live Chat (Messenger API) and click Search Plugins. Once you’ve found our plugin you can view details about it such as the point release, rating and description. Most importantly of course, you can install it by simply clicking “Install Now”.

= Manual installation =

The manual installation method involves downloading our plugin and uploading it to your webserver via your favourite FTP application. The WordPress codex contains [instructions on how to do this here](https://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

= Updating =

Automatic updates should work like a charm; as always though, ensure you backup your site just in case.


== Frequently asked questions ==

= Can I do more with this plug than with the official one? =

Yes of course! You can easily change languages, colors, positions, and quickly adjust all settings from the Customizer, and keep watching how settings affect the chat's appearance.

= Can I hide or delay my chat? =

Yes! With the help of the built-in options, you can hide it by default - or show it after a few seconds.

= Can I open chat with the button or javascript? =

You can use the built-in functions! If you add one of the classes to your button/href:
'socialmessenger-show',
'socialmessenger-hide',
'socialmessenger-showDialog'
'socialmessenger-hideDialog'

you can use them to open and close the chat. [jQuery required]

= What are the most common problems? =

1. We found out that if there is another Facebook plugin on your site that uses, for example, an SDK for comments, then the chat will not display properly.
2. Facebook blocked preview of changes live when we're in Customizer (iframe). (In the latest version it probably works again)

= Can I change the chat color? =

Yes, you can change the color of your chat using the plug-in settings

= Can I change the chat language? =

Yes, all available languages offered by Facebook are available (I think)

= Does the plugin support multilingual websites? =

You can integrate with PolyLang with one click

= Does the plugin support many languages? =

This plugin contains a full translation into Polish and English.

= Where can I find the ID of my fanpage? =

The code of your fanpage is at the bottom of the Information (about) section, the link to this section looks like this:
facebook.com/rapiddev/about/

= How can I add my page to trusted by my fanpage? =

You can add pages to trusted in messenger platform settings. Address should look like this:
facebook.com/rapiddev/settings/?tab=messenger_platform

About halfway through, you'll find the "Whitelisted Domains" section.
Add your website in format like this:
https://rdev.cc/
https://www.rdev.cc/

= Do the creators of the plugin collect any information about me? =

No, the chat only works on your site.

= Do I have to take any more steps? =

You must add your site to trusted in the settings of your fanpage.

== Screenshots ==

1. An application that works on the site
2. This is how the Customizer menu looks like

== Changelog ==

= 2.4.6 =
1. Improved display methods according to Facebook documentation
2. Adding a new option - delay the chat display
3. Fixes in the code
4. Class methods separation for greater readability

= 2.4.5 =
1. Hide chat on selected page

= 2.4.4 =
1. Improve hiding on phones
2. New control classes allow you to open and close a chat using buttons and links that have the appropriate css

= 2.4.3 =
1. Fixed preload value

= 2.4.2 =
1. Fixed bug with welcome message

= 2.4.1 =
1. Improved display on the left side and on the center

= 2.4.0 =
1. Preconnect and DNS-Prefetch meta functions have been added.

= 2.3.41 =
1. Hotfix

= 2.3.40 =
1. Tested with WordPress 5.4.0
2. PolyLang for welcome messages finally works!
3. Corrections in classes and code in general
4. Added more bugs to fix later

= 2.3.30 =
1. Tested with WordPress 5.3.1

= 2.3.22 =
1. Hotfix

= 2.3.21 =
1. Hotfix

= 2.3.2 =
1. Small bug fixes
2. Preview works again in Customizer
3. Moving from SDK 3.2 to 4.0
4. Improving class readability
5. Correction of error in detecting compatibility of PHP and WordPress versions
6. Changing some functions to inline
7. Improved error display function in the WordPress dashboard
8. Testing with WordPress version 5.2.3

= 2.3.1 =
1. An error with the display of the default greeting in Polish has been fixed

= 2.3.0 =
1. Repairing old mistakes
2. Integration with a newer version of the messenger sdk
3. Bug fixes
4. Api key no longer needed

= 2.2.8 =
1. Bug fixes

= 2.2.7 =
1. Update of Facebook SDK

= 2.2.6 =
1. Facebug again accuses us of unlawfully using their name in the banner, so we change it.

= 2.2.5 =
1. Bug fixes

= 2.2.4 =
1. Facebug copyright update

= 2.2.3 =
1. Facebug copyright update

= 2.2.2 =
1. Bug fixes

= 2.2.1 =
1. Bug fixes

= 2.2.0 =
1. Cosmetic class improvement
2. Improved detection of WordPress and PHP versions
3. A completely new customizer registration system
4. A new way to initialize the plugin
5. Corrections in translations
6. Bug fixes

= 2.1.2 =
1. Bug fixes

= 2.1.1 =
1. Bug fixes

= 2.1.0 =
1. Bug fixes

= 2.0.0 =
1. The entire plugin has been rewritten
2. The use of OOP techniques
3. Unnecessary classes have been removed
4. New error detection method
5. A new way of displaying error messages for the administrator
6. The additional 'minimized' option has been improved

= 1.4.0 =
1. Chat color have been added
2. FindMyFBId was removed and the tutorial to find the fanpage code was corrected
3. The way of declaring languages has been changed
4. Translations have been improved
5. The definition of some functions has been changed
6. The identification of errors has been improved

= 1.3.6 =
1. 'Settings' link has been added on the plugins list page

= 1.3.5 =
1. Bug fixes

= 1.3.4 =
1. Bug fixes

= 1.3.3 =
1. Bug fixes
2. Translations have been improved
3. Change slug and name of the plugin

= 1.3.2 =
1. Bug fixes
2. Translations have been improved

= 1.3.1 =
1. Bug fixes
2. The way of displaying the options has been changed

= 1.3.0 =
1. A new Customizer class has been added
2. Added support for PolyLang
3. The ability to change the live chat language has been added
4. The ability to hide chat on phones has been added
5. The ability to change the chat position live has been added

= 1.2.0 =
1. Bug fixes
2. Addition of new translations

= 1.1.0 =
1. Bug fixes

= 1.0.0 =
1. The plugin was created

== Upgrade notice ==

= 2.4.1 =
1. Improved display on the left side and on the center