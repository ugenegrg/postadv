=== Postadv ===
Contributors: ugene
Donate link: #
Tags: Google Adsense, google, plugin, adsense, insert adsense, adsense ad, ad code, adsense shortcode, insert ad, ads, adsense plugin, advertising
Requires at least: 4.5
Tested up to: 4.7.2
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A simple WordPress plugin that helps you to add the AdSense script in your desired location as post content using shortcode and latency option.

== Description ==
PostAdv is a plugin that lets you add AdSense script anywhere in the post content. It also has one additional latency option to delay the adv from showing up on published posts for the first n days after they are published.

Usages
Backend

	1. After installing the plugin, you will find a Postadv menu under Settngs
	2. The page has basic settings like
		a. textarea for adding script.
		b. enabling/disabling latency
		c. if enabled, num field to add days in number
	3. It also adds a meta box in each post for adding script. This has higher priority than the one in the setting page.

Frontend

	1. Shortcode: To use in the frontend, you have to add [postadv] shortcode in the editor, your desired location.
	2. Parameters: There are few paramteres that can be used according to your requirement
		a. [postadv latency="on/off"]
		b. [postadv latency="on" latency_day="n"], where n is the integer 1,2,3, ......n
		Note: Use these options only if you want to override the ones from the settings page.

= Notes =
1. Disabling latency means, the AdSense will simply display without any condition where the shortcode is used. 
2. Enabling latency means, the AdSense will dispaly on the defined latency day from the day the post was published.


== Installation ==
1. Download and copy paste the files in the plugin folder of your WordPress.

== Frequently Asked Questions ==
= Do I have to use shortcode? =
Yes, it is all based on the shortcode and it has to be used.

== Screenshots ==
1. Backend Settings page
2. Backend Post meta

== Changelog ==
= 1.0.0 =
First Version

