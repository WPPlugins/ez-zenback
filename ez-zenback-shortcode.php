<?php
/*
Shortcode
by Redcocker
Last modified: 2012/1/4
License: GPL v2
http://www.near-mint.com/blog/
*/

add_shortcode('zenback', 'ez_zenback_shortcode_handler');

// Shortcode handler
function ez_zenback_shortcode_handler() {
	$ez_zenback_code = ez_zenback_valid_code(get_option('ez_zenback_code'));
	if ($ez_zenback_code == "invalid") {
		$ez_zenback_code = "";
	}
	return $ez_zenback_code;
}

// For widget
add_filter('widget_text', 'do_shortcode');

?>