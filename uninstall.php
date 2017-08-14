<?php
/*
by Redcocker
Last modified: 2012/2/6
License: GPL v2
http://www.near-mint.com/blog/
*/

if (!defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN')) {exit();}
delete_option('ez_zenback_setting_opt');
delete_option('ez_zenback_updated');
delete_option('ez_zenback_checkver_stamp');
delete_option('ez_zenback_code');
delete_option('ez_zenback_exc');
delete_option('ez_zenback_style');
delete_option('ez_zenback_before_post');
delete_option('ez_zenback_after_post');
delete_option('widget_ezzenbackwidget');
delete_option('ez_zenback_position'); // For backward compatibility
delete_option('ez_zenback_single'); // For backward compatibility
delete_option('ez_zenback_page'); // For backward compatibility
?>
