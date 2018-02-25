=== Cookie Monster ===
Contributors: gsmith
Donate link: http://www.z-car.com/blog/2009/12/05/cookie-monster-wordpress-url-parameter-utility
Tags: cookie, URL parameter, shortcode
Requires at least: 4.0
Tested up to: 4.7
Stable tag: 1.51

License: GPLv2 or later

Define which URL parameters should be captured, and then creates a shortcode so that the value can be used in your Posts. 

== Description ==

I recently had a situation in which I needed to pass a URL parameter into WordPress so that it could be inserted into all links off of a blog page.  For example, a partner would pass traffic to a blog using the format http://www.myblog.com?refcode=joe.  All links embedded in the post would need to pass the value of refcode if it existed, even if the visitor requested multiple pages after the initial visit.

I created a Plugin (Cookie Monster) that will allow a Blog Admin to define which URL parameters should be captured, and then creates a shortcode so that the value can be used in your Posts and Pages.  A WordPress shortcode is a macro code that is embedded in your content.

In the example above, if you define refcode in the Cookie Monster Admin Settings, and if that URL parameter refcode contains a value in the querystring, it will automatically be saved into a cookie in the visitors browser. Anywhere that you place the shortcode jimmy in your Post, Cookie Monster will insert the querystring value into your Post.  The cookie value will persist across browser sessions.

== Installation ==


1. Upload `cookie.php` to the `/wp-content/plugins/cookiemonster` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place [shortcodes] in your templates that you have defined in the setup menu

== Frequently Asked Questions ==

Why would I use this?
So that you can pass info from the querystring to all links on your site.  For example, perhaps you have an arrangement where you pay anyone who links to your blog a split of a commision you make on a sale.  If they pass you a value on the querystring, for example refcode=affpartner1, you can then pass that into your affiliate links so that you can share commisions.


== Screenshots == 

None currently

== Support ==
website : http://www.z-car.com/blog/programming/cookie-monster-wordpress-url-parameter-utility
email : cookiemonster@pcorner.com

== Changelog ==

= 1.0 =
* First version
= 1.1 =
* Fixed to work with WordPress 3.0  Thanks to BronStar!
= 1.2 =
* Updating SVN
= 1.3 =
* Added ability to change cookie expiration which also allows setting to 0 to act as a session cookie.  Other minor changes and error handling.  This version will require you to recreate all of your tracking cookie parameters due to some internal changes.
= 1.4 =
* Fixed deprecated call error
= 1.5 =
* Resolved issue with plugin breaking some themes
= 1.51 =
* Fix version issue



== Upgrade Notice ==
= 1.4 =
* Resolves errors when debug turned on
= 1.5 =
* Resolved issue with plugin breaking some themes
