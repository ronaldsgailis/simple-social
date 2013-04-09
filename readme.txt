=== Simple Social ===
Contributors: ronaldsg
Tags: social, share, buttons
Requires at least: 3.0
Tested up to: 3.5.1
Stable tag: 0.1

Adds social share buttons to posts without loading remote javascript libraries.

== Description ==

Most plugins, that add social buttons use default Facebook and Twitter javascript libraries, slowing down your site. This plugin doesn't use those libraries, instead it uses option to load share/tweet page via url. It opens this page in popup or in new tab(if on mobile), only when user clicks the button, therefore eliminating unnecessary network requests.

Social share buttons curently supported are:

* Facebook like;
* Twitter tweet.

== Installation ==

1. Upload simple-social folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the `Plugins` menu in WordPress
3. Fill in your Facebook app ID and Twitter username in plugin settings under `Plugins > Simple Social`

== Frequently Asked Questions ==

= Why aren't more buttons supported? =

I'm working on adding more sharing buttons for next version.

= How can I change button background images? =

Currently there's no clean way to that. Option to change images is planned for next release.

= Will this plugin work without Facebook app ID? =

NO, app ID is required by Facebook API and can't be skipped.

= Will it work without twitter username? =

YES, but in that case tweets will not containt `via @username` part.

== Changelog ==

= 0.1 =

* Initial release.
