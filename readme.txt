=== EZ zenback ===
Contributors: redcocker
Donate link: http://www.near-mint.com/blog/donate
Tags: zenback, japanese, related, post, link, social, button, google, facebook, twitter, hatena, mixi
Requires at least: 3.0
Tested up to: 3.3.1
Stable tag: 1.5.2.2

"EZ zenback" will help you to install "zenback".

== Description ==

The "[zenback](http://zenback.jp/ "zenback")" service analyzes Japanese posts and displays related keywords, related posts and mentioned tweets in your blog. It also provides social buttons such as Twitter, Faceboox, Google +1, Hatena bookmark, mixi check to your blog.

"EZ zenback" will help you to install "zenback". No need to edit theme files to install "zenback" code. You can insert not only "zenback" code but also other HTML, JavaScripts into your posts or pages easily.

zenback is registered trademark of Six Apart, Ltd.

= Features =

* Easy to install "zenback" code or other HTML, JavaScripts.
* You can insert "zenback" before comment block, after comment block or as a widget.
* Also support shortcode to insert "zenback".
* Additional stylesheet for zenback.
* Localization: English(Default), 日本語(Japanese, UTF-8).

= Notes =

* This plugin depends on your using wordpress theme.
* You need to use this plugin with default comment system. Even if comment form is closed, zenback can be displayed. However, when default comment system is replaced by other comment system, "zenback" will not be displayed.
* If you have used "[DISQUS](http://disqus.com/ "DISQUS")" as your comment system or you want to use "DISQUS", Use "[Disqus Comment System for EZ zenback](http://www.near-mint.com/blog/software/disqus-comment-system-for-ez-zenback "Disqus Comment System for EZ zenback")" plugin instead of "[Disqus Comment System](http://wordpress.org/extend/plugins/disqus-comment-system/ "Disqus Comment System")" plugin.

= System Requirements =

* WordPress 3.0 or higher

or

* WordPress 2.8 or higher + Disqus Comment System for EZ zenback

== Installation ==

= Installation =

1. Upload plugin folder to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Go to Settings -> EZ zenback to configure.

zenback is registered trademark of Six Apart, Ltd.

== Screenshots ==

1. This is setting panel.

== Changelog ==

= 1.5.2.2 =
* Support new zenback tag.

= 1.5.2.1 =
* Fix a bug: EZ zenback version doesn't be shown in "Show Your System Info" setting section.

= 1.5.2 =
* Added new setting option to excluded some posts/pages as posts/pages without zenback.
* Support zenback tag, when shortcode is selected.

= 1.5 =
* Support shortcode.
* Fix a bug: Lost unofficial compatibility with WordPress 2.9.x or 2.8.x.

= 1.4.5 =
* Changed validation process.
* Rewritten the codes for array definition.
* Changed setting data migration process.
* Splited the main php file in order to reduce file size.
* Fix a bug: Using bloginfo() in the wrong way.

= 1.4.3.1 =
* Fix a bug: The setting data migration processing can't work concurrently with auto-update.

= 1.4.3 =
* Most of setting parameters are stored as associative arrays in SQL.
* Setting data migration when updated.
* Validating the setting values more closely.
* Added the icon before title block on the setting panel.
* Fix a bug: When using some themes, inserted HTML or JavaScripts sometimes can't be shown on Category, Archives and Search results.

= 1.4 =
* "zenback" can be displayed even if comment form is closed.
* Fix a bug: When "Improve the accuracy of zenback" isn't activated, "zenback" can't be displayed with the default comment system.
* Fix a bug: add_filter() was used incorrectly.
* Changed the default values of setting parameters.
* Added "delete_option('widget_ezzenbackwidget');" into "uninstall.php".

= 1.3 =
* Added a widget that shows "zenback".
* Added new setting option to define addtional stylesheet.
* Redesigned setting panel.
* Using dirname() and plugin_basename() instead of hardcoded directory name.
* Changed directory name stored translation files.

= 1.2.2 =
* Sorry, It is the missing important thing, Add trademark notice.

= 1.2.1 =
* Created new conditional branching for older version of WordPress.
* Changed the method to add javascript into setting panel.

= 1.2 =
* Fix "Notice: has_cap was called with an argument that is deprecated since version 2.0! Usage of user levels by plugins and themes is deprecated. Use roles and capabilities instead." when "WP_DEBUG" is turned on.
* Fix a bug: Depending on the setting, excerpts do not be shown in archive pages correctly.
* Change: Remove deprecated argument and rewrite load_plugin_textdomain().
* Added "System Info" in setting panel.

= 1.1 =
* Fix a bug: zenback tag does not insert correctly.
* Changed layout of setting panel.

= 1.0 =
* This is the initial release.

== Upgrade Notice ==

= 1.5.2.1 =
This version has a bug fix.

= 1.5.2 =
This version has new features.

= 1.5 =
This version has a new feature and bug fix.

= 1.4.5 =
This version has some changes and a bug fix.

= 1.4.3.1 =
This version has a bug fix.

= 1.4.3 =
This version has some changes.

= 1.4 =
This version has new feature and bug fixes.

= 1.3 =
This version has some new features and changes.

= 1.2.2 =
This version has a change.

= 1.2.1 =
This version has some changes.

= 1.2 =
This version has some changes and bug fix.

= 1.1 =
This version has a bug fix.

= 1.0 =
This is the initial release.
