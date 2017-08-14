<?php
/*
Plugin Name: EZ zenback
Plugin URI: http://www.near-mint.com/blog/software/ez-zenback
Description: The "<a href="http://zenback.jp/">zenback</a>" service analyzes Japanese posts and displays related keywords, related posts and mentioned tweets in your blog. It also provides social buttons such as Twitter, Faceboox, Google +1, Hatena bookmark, mixi check to your blog. This plugin will help you to install "zenback". No need to edit theme files to install "zenback" code. You can insert not only "zenback" code but also other HTML, JavaScripts into your posts or pages easily.
Version: 1.5.2.2
Author: redcocker
Author URI: http://www.near-mint.com/blog/
Text Domain: ez_zenback
Domain Path: /languages
*/
/*
Last modified: 2013/11/8
License: GPL v2
zenback is registered trademark of Six Apart, Ltd.
*/
/*  Copyright 2011 M. Sumitomo

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

load_plugin_textdomain('ez_zenback', false, dirname(plugin_basename(__FILE__)).'/languages');
$ez_zenback_plugin_url = plugin_dir_url(__FILE__);
$ez_zenback_ver = "1.5.2.1";
$ez_zenback_db_ver = "1.5.2";
$ez_zenback_allowed_str = "1";
$ez_zenback_setting_opt = get_option('ez_zenback_setting_opt');

// Create settings array
function ez_zenback_setting_array() {

	$ez_zenback_default_style = '.zenback {
	font-size:10px !important;
}
.zenback .zenback-heading{
	font-size:10.5px !important;
}';

	$ez_zenback_setting_opt = array(
		"position" => "before",
		"single" => "1",
		"page" => "1",
		"closed_comment" => "0",
		"accuracy" => "1",
		"style_enable" => "0",
		"before_post_home" => "0",
		"before_post_single" => "0",
		"before_post_page" => "0",
		"before_post_category" => "0",
		"before_post_search" => "0",
		"before_post_archive" => "0",
		"after_post_home" => "0",
		"after_post_single" => "0",
		"after_post_page" => "0",
		"after_post_category" => "0",
		"after_post_search" => "0",
		"after_post_archive" => "0",
		);
	add_option('ez_zenback_code', '');
	add_option('ez_zenback_exc', '');
	add_option('ez_zenback_style', $ez_zenback_default_style);
	add_option('ez_zenback_before_post', '');
	add_option('ez_zenback_after_post', '');
	add_option('ez_zenback_setting_opt', $ez_zenback_setting_opt);
	add_option('ez_zenback_updated', 'false');
	add_option('ez_zenback_position', 'before'); // For backward compatibility
	add_option('ez_zenback_single', '1'); // For backward compatibility
	add_option('ez_zenback_page', '1'); // For backward compatibility
}

// Check DB version and register settings
add_action('plugins_loaded', 'ez_zenback_check_db_ver');

function ez_zenback_check_db_ver(){
	global $ez_zenback_db_ver;
	$current_checkver_stamp = get_option('ez_zenback_checkver_stamp');

	if (!$current_checkver_stamp || version_compare($current_checkver_stamp, $ez_zenback_db_ver, "!=")) {
		$updated_count = 0;
		// For new installation, update from ver. 1.4.3 or older
		if (!$current_checkver_stamp || version_compare($current_checkver_stamp, "1.4.3", "<=")) {
			// Register array
			ez_zenback_setting_array();
			// Data migration when updated from ver.1.4.3 or older
			include_once('data-migration.php');
			// Delete options since ver.1.4 or older
			include_once('del-old-options.php');
			// Update settings
			$updated_count = $updated_count + 1;
		}
		// For update from ver. 1.5 or older
		if (!$current_checkver_stamp || version_compare($current_checkver_stamp, "1.4.5", "<=")) {
			add_option('ez_zenback_exc', '');
			// Update settings
			$updated_count = $updated_count + 1;
		}

		update_option('ez_zenback_checkver_stamp', $ez_zenback_db_ver);

		// Stamp for showing messages
		if ($updated_count != 0) {
			update_option('ez_zenback_updated', 'true');
		}
	}
}

// Add setting panel and hooks
add_action('admin_menu', 'ez_zenback_register_menu_item');

function ez_zenback_register_menu_item() {
	$ez_page_hook = add_options_page('EZ zenback Options', 'EZ zenback', 'manage_options', 'ez-zenback-options', 'ez_zenback_options_panel');
	if ($ez_page_hook != null) {
		$ez_page_hook = '-'.$ez_page_hook;
	}
	add_action('admin_print_scripts'.$ez_page_hook, 'ez_zenback_load_jscript_for_admin');
	if (get_option('ez_zenback_updated') == "true" && !(isset($_POST['EZ_ZENBACK_Setting_Submit']) && $_POST['ez_zenback_hidden_value'] == "true")) {
		add_action('admin_notices', 'ez_zenback_admin_updated_notice');
	}
}

// Message for admin when DB table updated
function ez_zenback_admin_updated_notice(){
	echo '<div id="message" class="updated"><p>'.__("EZ zenback has successfully created new DB table.<br />If you upgraded to this version, some setting options may be added or reset to the default values.<br />Go to the <a href=\"options-general.php?page=ez-zenback-options\">setting panel</a> and configure EZ zenback now. Once you save your settings, this message will be cleared.", "ez_zenback").'</p></div>';
}

// Load javascript in the setting panel
function ez_zenback_load_jscript_for_admin(){
	global $ez_zenback_plugin_url;
	wp_enqueue_script('rc_admin_js', $ez_zenback_plugin_url.'rc-admin-js.js', false, '1.1');
}

// Show plugin info in the footer on setting panel
function ez_zenback_add_admin_footer(){
	$plugin_data = get_plugin_data(__FILE__);
	printf('%1$s by %2$s<br />', $plugin_data['Title'].' '.$plugin_data['Version'], $plugin_data['Author']);
}

// Add link to the setting panel
add_filter('plugin_action_links', 'ez_zenback_setting_link', 10, 2);

function ez_zenback_setting_link($links, $file){
	static $this_plugin;
	if (! $this_plugin) $this_plugin = plugin_basename(__FILE__);
	if ($file == $this_plugin){
		$settings_link = '<a href="options-general.php?page=ez-zenback-options">'.__('Settings', 'ez_zenback').'</a>';
		array_unshift($links, $settings_link);
	}  
	return $links;
}

// Insert zenback tags
function ez_zenback_insert_zenback_tag($content) {
	global $post, $ez_zenback_setting_opt;
	$title = trim(wp_title('', false));
	$time = get_post_time('Y-m-d');
	$t_before = '<span style="display:none;"><!-- zenback_title_begin -->';
	$t_after = '<!-- zenback_title_end --></span>';
	$b_before = '<!-- zenback_body_begin -->';
	$b_after = '<!-- zenback_body_end --><!-- zenback_date '.$time. ' -->';

	// For single posts
	if (is_single()) {
		if ($ez_zenback_setting_opt['single'] == 1 && $ez_zenback_setting_opt['accuracy'] == 1) {
			// For shortcode
			if ($ez_zenback_setting_opt['position'] == 'shortcode' && strpos($content, "[zenback]") === false) {
				return $content;
			}
			// Exclusion posts/pages
			$ez_zenback_exc = get_option('ez_zenback_exc');
			if ($ez_zenback_exc != "") {
				$alt_content = $t_before.$title.$t_after.$b_before.$content.$b_after;
				$exclusion = explode(",", $ez_zenback_exc);
				foreach ($exclusion as $val) {
					if ($val == $post->ID) {
						$alt_content = $content;
					}
				}
				return $alt_content;
			} else {
				return $t_before.$title.$t_after.$b_before.$content.$b_after;
			}
		} else {
			return $content;
		}
	}
	// For pages
	if (is_page()) {
		if ($ez_zenback_setting_opt['page'] == 1 && $ez_zenback_setting_opt['accuracy'] == 1) {
			// For shortcode
			if ($ez_zenback_setting_opt['position'] == 'shortcode' && strpos($content, "[zenback]") === false) {
				return $content;
			}
			// Exclusion posts/pages
			$ez_zenback_exc = get_option('ez_zenback_exc');
			if ($ez_zenback_exc != "") {
				$alt_content = $t_before.$title.$t_after.$b_before.$content.$b_after;
				$exclusion = explode(",", $ez_zenback_exc);
				foreach ($exclusion as $val) {
					if ($val == $post->ID) {
						$alt_content = $content;
					}
				}
				return $alt_content;
			} else {
				return $t_before.$title.$t_after.$b_before.$content.$b_after;
			}
		} else {
			return $content;
		}
	}
	return $content;
}

// Insert zenback code
function ez_zenback_insert_zenback_code() {
	global $post, $ez_zenback_setting_opt;
	if ($ez_zenback_setting_opt['single'] == 1 || $ez_zenback_setting_opt['page'] == 1) {
		$zenback_code = ez_zenback_valid_code(get_option('ez_zenback_code'));
		if ($zenback_code == "invalid") {
			$zenback_code = "";
		}
		// For single posts
		if (is_single() && $ez_zenback_setting_opt['single'] == 1) {
			// Exclusion posts/pages
			$ez_zenback_exc = get_option('ez_zenback_exc');
			if ($ez_zenback_exc != "") {
				$alt_zenback_code = $zenback_code;
				$exclusion = explode(",", $ez_zenback_exc);
				foreach ($exclusion as $val) {
					if ($val == $post->ID) {
						$alt_zenback_code = "";
					}
				}
				echo $alt_zenback_code;
			} else {
				echo $zenback_code;
			}
		} else {
			echo "";
		}
		// For pages
		if (is_page() && $ez_zenback_setting_opt['page'] == 1) {
			// Exclusion posts/pages
			$ez_zenback_exc = get_option('ez_zenback_exc');
			if ($ez_zenback_exc != "") {
				$alt_zenback_code = $zenback_code;
				$exclusion = explode(",", $ez_zenback_exc);
				foreach ($exclusion as $val) {
					if ($val == $post->ID) {
						$alt_zenback_code = "";
					}
				}
				echo $alt_zenback_code;
			} else {
				echo $zenback_code;
			}
		} else {
			echo "";
		}
	} else {
		echo "";
	}
}

if ($ez_zenback_setting_opt['position'] == 'widget') {
	include_once('ez-zenback-widget.php');
}

if ($ez_zenback_setting_opt['position'] == 'shortcode') {
	include_once('ez-zenback-shortcode.php');
}

if ($ez_zenback_setting_opt['accuracy'] == 1) {
	add_filter('the_content', 'ez_zenback_insert_zenback_tag', 1);
}

if (version_compare(get_bloginfo('version'), "3.0", ">=") && !function_exists('dsq_options')) {
	if ($ez_zenback_setting_opt['position'] == 'before') {
		add_action('comment_form_before','ez_zenback_insert_zenback_code', 1);
	}
	if ($ez_zenback_setting_opt['position'] == 'after') {
		add_action('comment_form_after','ez_zenback_insert_zenback_code', 1);
	}
}

if (version_compare(get_bloginfo('version'), "3.0", ">=") && $ez_zenback_setting_opt['closed_comment'] == 1) {
	add_action('comment_form_comments_closed','ez_zenback_insert_zenback_code', 1);
}

// Add stylesheet for zenback
if ($ez_zenback_setting_opt['style_enable'] == 1) {
	add_action('wp_head', 'ez_zenback_load_style');
}

function ez_zenback_load_style(){
	global $ez_zenback_ver, $ez_zenback_setting_opt;
	if ($ez_zenback_setting_opt['style_enable'] == 1 &&
		(
			($ez_zenback_setting_opt['single'] == 1 &&
			is_single()) ||
			($ez_zenback_setting_opt['page'] == 1 && is_page())
		)
	) {
		$ez_zenback_style = ez_zenback_valid_css(strip_tags(get_option('ez_zenback_style')));
		if ($ez_zenback_style == "invalid") {
			$ez_zenback_style = "";
		}
		echo "\n<!-- EZ zenback Ver.".$ez_zenback_ver." CSS for zenback Begin -->\n";
		echo "<style type='text/css'>\n".$ez_zenback_style."\n</style>\n";
		echo "<!-- EZ zenback Ver.".$ez_zenback_ver." CSS for zenback End -->\n";
	}
}

// Insert user's own code into home
function ez_zenback_insert_into_home($content) {
	global $ez_zenback_allowed_str, $ez_zenback_setting_opt;
	if ($ez_zenback_setting_opt['before_post_home'] + $ez_zenback_setting_opt['after_post_home'] != 0) {
		$content_before_post = ez_zenback_valid_text(get_option('ez_zenback_before_post'), $ez_zenback_allowed_str);
		if ($content_before_post == "invalid") {
			$content_before_post = "";
		}
		$content_after_post = ez_zenback_valid_text(get_option('ez_zenback_after_post'), $ez_zenback_allowed_str);
		if ($content_after_post == "invalid") {
			$content_after_post = "";
		}
	}
	if (is_home() || is_front_page()) {
		if ($ez_zenback_setting_opt['before_post_home'] == 1 && $ez_zenback_setting_opt['after_post_home'] == 1) {
			return $content_before_post.$content.$content_after_post;
		} elseif ($ez_zenback_setting_opt['before_post_home'] == 1 && $ez_zenback_setting_opt['after_post_home'] == 0) {
			return $content_before_post.$content;
		} elseif ($ez_zenback_setting_opt['before_post_home'] == 0 && $ez_zenback_setting_opt['after_post_home'] == 1) {
			return $content.$content_after_post;
		} else {
			return $content;
		}
	}
	return $content;
}

// Insert user's own code into posts, pages
function ez_zenback_insert_into_post($content) {
	global $ez_zenback_allowed_str, $ez_zenback_setting_opt;

	$insert_content = $ez_zenback_setting_opt['before_post_single'] + $ez_zenback_setting_opt['before_post_page'] + $ez_zenback_setting_opt['after_post_single'] + $ez_zenback_setting_opt['after_post_page'];

	if ( $insert_content != 0) {
		$content_before_post = ez_zenback_valid_text(get_option('ez_zenback_before_post'), $ez_zenback_allowed_str);
		if ($content_before_post == "invalid") {
			$content_before_post = "";
		}
		$content_after_post = ez_zenback_valid_text(get_option('ez_zenback_after_post'), $ez_zenback_allowed_str);
		if ($content_after_post == "invalid") {
			$content_after_post = "";
		}
	}
	// For single posts
	if (is_single()) {
		if ($ez_zenback_setting_opt['before_post_single'] == 1 && $ez_zenback_setting_opt['after_post_single'] == 1) {
			return $content_before_post.$content.$content_after_post;
		} elseif ($ez_zenback_setting_opt['before_post_single'] == 1 && $ez_zenback_setting_opt['after_post_single'] == 0) {
			return $content_before_post.$content;
		} elseif ($ez_zenback_setting_opt['before_post_single'] == 0 && $ez_zenback_setting_opt['after_post_single'] == 1) {
			return $content.$content_after_post;
		} else {
			return $content;
		}
	}
	// For pages
	if (is_page()) {
		if ($ez_zenback_setting_opt['before_post_page'] == 1 && $ez_zenback_setting_opt['after_post_page'] == 1) {
			return $content_before_post.$content.$content_after_post;
		} elseif ($ez_zenback_setting_opt['before_post_page'] == 1 && $ez_zenback_setting_opt['after_post_page'] == 0) {
			return $content_before_post.$content;
		} elseif ($ez_zenback_setting_opt['before_post_page'] == 0 && $ez_zenback_setting_opt['after_post_page'] == 1) {
			return $content.$content_after_post;
		} else {
			return $content;
		}
	}
	return $content;
}

// Insert user's own code into the excerpts
function ez_zenback_insert_into_excerpt($excerpt) {
	global $ez_zenback_allowed_str, $ez_zenback_setting_opt;

	$insert_excerpt = $ez_zenback_setting_opt['before_post_category'] + $ez_zenback_setting_opt['before_post_search'] + $ez_zenback_setting_opt['before_post_archive'] + $ez_zenback_setting_opt['after_post_category'] + $ez_zenback_setting_opt['after_post_search'] + $ez_zenback_setting_opt['after_post_archive'];

	if ($insert_excerpt != 0) {
		$content_before_post = ez_zenback_valid_text(get_option('ez_zenback_before_post'), $ez_zenback_allowed_str);
		if ($content_before_post == "invalid") {
			$content_before_post = "";
		}
		$content_after_post = ez_zenback_valid_text(get_option('ez_zenback_after_post'), $ez_zenback_allowed_str);
		if ($content_after_post == "invalid") {
			$content_after_post = "";
		}
	}
	// For categories
	if (is_category()) {
		if ($ez_zenback_setting_opt['before_post_category'] == 1 && $ez_zenback_setting_opt['after_post_category'] == 1) {
			return $content_before_post.$excerpt.$content_after_post;
		} elseif ($ez_zenback_setting_opt['before_post_category'] == 1 && $ez_zenback_setting_opt['after_post_category'] == 0) {
			return $content_before_post.$excerpt;
		} elseif ($ez_zenback_setting_opt['before_post_category'] == 0 && $ez_zenback_setting_opt['after_post_category'] == 1) {
			return $excerpt.$content_after_post;
		} else {
			return $excerpt;
		}
	}
	// For search results
	if (is_search()) {
		if ($ez_zenback_setting_opt['before_post_search'] == 1 && $ez_zenback_setting_opt['after_post_search'] == 1) {
			return $content_before_post.$excerpt.$content_after_post;
		} elseif ($ez_zenback_setting_opt['before_post_search'] == 1 && $ez_zenback_setting_opt['after_post_search'] == 0) {
			return $content_before_post.$excerpt;
		} elseif ($ez_zenback_setting_opt['before_post_search'] == 0 && $ez_zenback_setting_opt['after_post_search'] == 1) {
			return $excerpt.$content_after_post;
		} else {
			return $excerpt;
		}
	}
	// For archives
	if (is_archive()) {
		if ($ez_zenback_setting_opt['before_post_archive'] == 1 && $ez_zenback_setting_opt['after_post_archive'] == 1) {
			return $content_before_post.$excerpt.$content_after_post;
		} elseif ($ez_zenback_setting_opt['before_post_archive'] == 1 && $ez_zenback_setting_opt['after_post_archive'] == 0) {
			return $content_before_post.$excerpt;
		} elseif ($ez_zenback_setting_opt['before_post_archive'] == 0 && $ez_zenback_setting_opt['after_post_archive'] == 1) {
			return $excerpt.$content_after_post;
		} else {
			return $excerpt;
		}
	}
	return $excerpt;
}

if (get_option('ez_zenback_before_post') != "" || get_option('ez_zenback_after_post') != "") {
	add_filter('the_content', 'ez_zenback_insert_into_home', 10);
	add_filter('the_excerpt', 'ez_zenback_insert_into_home', 10);
	add_filter('the_content', 'ez_zenback_insert_into_post', 10);
	add_filter('the_content', 'ez_zenback_insert_into_excerpt', 10);
	add_filter('the_excerpt', 'ez_zenback_insert_into_excerpt', 10);
}

// Validate zenback code
function ez_zenback_valid_code($code) {
	if (preg_match("|^<\!-- X:S ZenBackWidget -->.*?</script>[^<]*?<\!-- X:E ZenBackWidget -->$|is", $code) || $code == "") {
		return $code;
	} else {
		return "invalid";
	}
}

// Validate css format
function ez_zenback_valid_css($css) {
	if (
		preg_match("/(http|https):\/\/.*?\.js/is", $css) ||
		preg_match("/src=['\"][^(http)(https)][^'\"]*?['\"]/is", $css) ||
		preg_match("/((java|vb)script:|about:)/is", $css) ||
		preg_match("/@i[^;]*?;/is", $css) ||
		preg_match("/(expression|behavi(o|ou)r|-moz-binding|include-source)/is", $css) ||
		preg_match("/document\.cookie/i", $css) ||
		preg_match("/eval\([^\)]*?\)/i", $css) ||
		preg_match("/on.{4,}?=/is", $css) ||
		preg_match("/&\{[^\}]*?\}/i", $css) ||
		preg_match("/\xhh/i", $css) ||
		preg_match("/\\\\[^'\"\{\};:\(\)#A\*]/i", $css)
	) {
		return "invalid";
	} else {
		$css = preg_replace(array("|\*/([^ ].?)|"), "*/  $1", $css);
		return $css;
	}
}

// Validate free style text data
function ez_zenback_valid_text($text, $level) {
	global $allowedposttags, $allowedtags;
	if ($level == "0") {
		return $text;
	} elseif ($level == "1") {
		if (
			preg_match("/<meta[^>]*?>/is", $text) ||
			preg_match("/<title[^>]*?>/is", $text) ||
			preg_match("/<plaintext[^>]*?>/is", $text) ||
			preg_match("/<marquee[^>]*?>/is", $text) ||
			preg_match("/<isindex[^>]*?>/is", $text) ||
			preg_match("/<xmp[^>]*?>/is", $text) ||
			preg_match("/<listing[^>]*?>/is", $text)
		) {
			return "invalid";
		} else {
			return $text;
		}
	} elseif ($level == "2") {
		if (
			preg_match("/<script[^>]*?>/is", $text) ||
			preg_match("/<input[^>]*?>/is", $text) ||
			preg_match("/<textarea[^>]*?>/is", $text) ||
			preg_match("/<\/textarea>/is", $text) ||
			preg_match("/<object[^>]*?>/is", $text) ||
			preg_match("/<applet[^>]*?>/is", $text) ||
			preg_match("/<embed[^>]*?>/i", $text) ||
			preg_match("/<table[^>]*?>/is", $text) ||
			preg_match("/<form[^>]*?>/is", $text) ||
			preg_match("/<meta[^>]*?>/is", $text) ||
			preg_match("/<title[^>]*?>/is", $text) ||
			preg_match("/<frame[^>]*?>/is", $text) ||
			preg_match("/<plaintext[^>]*?>/is", $text) ||
			preg_match("/<marquee[^>]*?>/is", $text) ||
			preg_match("/<isindex[^>]*?>/is", $text) ||
			preg_match("/<xmp[^>]*?>/is", $text) ||
			preg_match("/<listing[^>]*?>/is", $text) ||
			preg_match("/<body[^>]*?>/is", $text) ||
			preg_match("/<style[^>]*?>/is", $text) ||
			preg_match("/<link[^>]*?>/is", $text) ||
			preg_match("/on.{4,}?=/is", $text) ||
			preg_match("/background[^=]*?=/is", $text) ||
			preg_match("/(http|https):\/\/.*?\.js/is", $text)
		) {
			return "invalid";
		} else {
			return $text;
		}
	} elseif ($level == "3") {
		$filtered_text = wp_kses($text, $allowedposttags);
		if ($text != $filtered_text) {
			return "invalid";
		} else {
			return $filtered_text;
		}
	} elseif ($level == "4") {
		$filtered_text = wp_kses($text, $allowedtags);
		if ($text != $filtered_text) {
			return "invalid";
		} else {
			return $filtered_text;
		}
	} elseif ($level == "5") {
		$text = esc_html($text);
		return $text;
	} else {
		return $text;
	}
}

// Load setting panel
if (is_admin()) {
	include_once('ez-zenback-admin.php');
}

?>