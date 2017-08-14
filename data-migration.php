<?php
$ez_zenback_setting_opt = get_option('ez_zenback_setting_opt');

// Data migration for ver. 1.4 or older
if (!$current_checkver_stamp || version_compare($current_checkver_stamp, "1.4.3", "<")) {
	$ez_zenback_setting_opt['position'] = get_option('ez_zenback_position');
	if (get_option('ez_zenback_single') == 1) {
		$ez_zenback_setting_opt['single'] = "1";
	}
	if (get_option('ez_zenback_page') == 1) {
		$ez_zenback_setting_opt['page'] = "1";
	}
	if (get_option('ez_zenback_closed_comment') == 1) {
		// Since ver. 1.4
		$ez_zenback_setting_opt['closed_comment'] = "1";
	}
	if (get_option('ez_zenback_accuracy') == 1) {
		$ez_zenback_setting_opt['accuracy'] == "1" ;
	}
	if (get_option('ez_zenback_style_enable') == 1) {
		// Since ver. 1.4
		$ez_zenback_setting_opt['style_enable'] = "1";
	}
	update_option('ez_zenback_before_post', get_option('ez_before_post'));
	if (get_option('ez_before_post_home') == 1) {
		$ez_zenback_setting_opt['before_post_home'] = "1";
	}
	if (get_option('ez_before_post_single') == 1) {
		$ez_zenback_setting_opt['before_post_single'] = "1";
	}
	if (get_option('ez_before_post_page') == 1) {
		$ez_zenback_setting_opt['before_post_page'] = "1";
	}
	if (get_option('ez_before_post_category') == 1) {
		$ez_zenback_setting_opt['before_post_category'] = "1";
	}
	if (get_option('ez_before_post_search') == 1) {
		$ez_zenback_setting_opt['before_post_search'] = "1";
	}
	if (get_option('ez_before_post_archive') == 1) {
		$ez_zenback_setting_opt['before_post_archive'] = "1";
	}
	update_option('ez_zenback_after_post', get_option('ez_after_post'));
	if (get_option('ez_after_post_home') == 1) {
		$ez_zenback_setting_opt['after_post_home'] = "1";
	}
	if (get_option('ez_after_post_single') == 1) {
		$ez_zenback_setting_opt['after_post_single'] = "1";
	}
	if (get_option('ez_after_post_page') == 1) {
		$ez_zenback_setting_opt['after_post_page'] = "1";
	}
	if (get_option('ez_after_post_category') == 1) {
		$ez_zenback_setting_opt['after_post_category'] = "1";
	}
	if (get_option('ez_after_post_search') == 1) {
		$ez_zenback_setting_opt['after_post_search'] = "1";
	}
	if (get_option('ez_after_post_archive') == 1) {
		$ez_zenback_setting_opt['after_post_archive'] = "1";
	}
}

// Data migration for ver. 1.4.3.1 and 1.4.3
if (version_compare($current_checkver_stamp, "1.4.3", "=")) {
	foreach ($ez_zenback_setting_opt as $key => $val) {
		$newkey = str_replace('ez_zenback_', '', $key);
		$ez_zenback_setting_opt[$newkey] = $val;
		unset($ez_zenback_setting_opt[$key]);
	}
}

update_option('ez_zenback_setting_opt', $ez_zenback_setting_opt);
?>