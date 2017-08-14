<?php
/*
For dashboard
by Redcocker
Last modified: 2012/3/4
License: GPL v2
http://www.near-mint.com/blog/
*/

// Setting panel
function ez_zenback_options_panel(){
	global $ez_zenback_plugin_url, $ez_zenback_allowed_str, $ez_zenback_setting_opt;
	if(!function_exists('current_user_can') || !current_user_can('manage_options')){
			die(__('Cheatin&#8217; uh?'));
	} 
	add_action('in_admin_footer', 'ez_zenback_add_admin_footer');

	// Update setting options
	if (isset($_POST['EZ_ZENBACK_Setting_Submit']) && $_POST['ez_zenback_hidden_value'] == "true" && check_admin_referer("ez_zenback_update_options", "_wpnonce_update_options")) {
		$ez_zenback_code = stripslashes($_POST['ez_zenback_code']);
		$ez_zenback_setting_opt['position'] = $_POST['position'];
		if ($_POST['single'] == "1") {
			$ez_zenback_setting_opt['single'] = "1";
		} else {
			$ez_zenback_setting_opt['single'] = "0";
		}
		if ($_POST['page'] == "1") {
			$ez_zenback_setting_opt['page'] = "1";
		} else {
			$ez_zenback_setting_opt['page'] = "0";
		}
		if ($_POST['closed_comment'] == "1") {
			$ez_zenback_setting_opt['closed_comment'] = "1";
		} else {
			$ez_zenback_setting_opt['closed_comment'] = "0";
		}
		$ez_zenback_exc = stripslashes($_POST['ez_zenback_exc']);
		if ($_POST['accuracy'] == "1") {
			$ez_zenback_setting_opt['accuracy'] = "1";
		} else {
			$ez_zenback_setting_opt['accuracy'] = "0";
		}
		if ($_POST['style_enable'] == "1") {
			$ez_zenback_setting_opt['style_enable'] = "1";
		} else {
			$ez_zenback_setting_opt['style_enable'] = "0";
		}
		$ez_zenback_style = stripslashes($_POST['ez_zenback_style']);
		$ez_zenback_before_post = stripslashes($_POST['ez_zenback_before_post']);
		if ($_POST['before_post_home'] == "1") {
			$ez_zenback_setting_opt['before_post_home'] = "1";
		} else {
			$ez_zenback_setting_opt['before_post_home'] = "0";
		}
		if ($_POST['before_post_single'] == "1") {
			$ez_zenback_setting_opt['before_post_single'] = "1";
		} else {
			$ez_zenback_setting_opt['before_post_single'] = "0";
		}
		if ($_POST['before_post_page'] == "1") {
			$ez_zenback_setting_opt['before_post_page'] = "1";
		} else {
			$ez_zenback_setting_opt['before_post_page'] = "0";
		}
		if ($_POST['before_post_category'] == "1") {
			$ez_zenback_setting_opt['before_post_category'] = "1";
		} else {
			$ez_zenback_setting_opt['before_post_category'] = "0";
		}
		if ($_POST['before_post_search'] == "1") {
			$ez_zenback_setting_opt['before_post_search'] = "1";
		} else {
			$ez_zenback_setting_opt['before_post_search'] = "0";
		}
		if ($_POST['before_post_archive'] == "1") {
			$ez_zenback_setting_opt['before_post_archive'] = "1";
		} else {
			$ez_zenback_setting_opt['before_post_archive'] = "0";
		}
		$ez_zenback_after_post = stripslashes($_POST['ez_zenback_after_post']);
		if ($_POST['after_post_home'] == "1") {
			$ez_zenback_setting_opt['after_post_home'] = "1";
		} else {
			$ez_zenback_setting_opt['after_post_home'] = "0";
		}
		if ($_POST['after_post_single'] == "1") {
			$ez_zenback_setting_opt['after_post_single'] = "1";
		} else {
			$ez_zenback_setting_opt['after_post_single'] = "0";
		}
		if ($_POST['after_post_page'] == "1") {
			$ez_zenback_setting_opt['after_post_page'] = "1";
		} else {
			$ez_zenback_setting_opt['after_post_page'] = "0";
		}
		if ($_POST['after_post_category'] == "1") {
			$ez_zenback_setting_opt['after_post_category'] = "1";
		} else {
			$ez_zenback_setting_opt['after_post_category'] = "0";
		}
		if ($_POST['after_post_search'] == "1") {
			$ez_zenback_setting_opt['after_post_search'] = "1";
		} else {
			$ez_zenback_setting_opt['after_post_search'] = "0";
		}
		if ($_POST['after_post_archive'] == "1") {
			$ez_zenback_setting_opt['after_post_archive'] = "1";
		} else {
			$ez_zenback_setting_opt['after_post_archive'] = "0";
		}
		// Transforming before validation
		$ez_zenback_exc = preg_replace("/,\s+?([0-9]+?)/", ",$1", $ez_zenback_exc);
		$ez_zenback_style = strip_tags($ez_zenback_style);
		// Validate values
		if (ez_zenback_valid_code($ez_zenback_code, $ez_zenback_allowed_str) == "invalid") {
			wp_die(__('Invalid zenback code. Settings could not be saved.<br />Please copy zenback code from your <a href="http://zenback.jp/">zenback control panel</a> and paste it.', 'ez_zenback'));
		}
		if ($ez_zenback_exc != "" && !preg_match("/^([0-9]+?,)*?[0-9]+?$/i", $ez_zenback_exc)) {
			wp_die(__('Invalid value. Settings could not be saved.<br />Your "Exclusion" contains some character strings that are not allowed to use.', 'ez_zenback'));
		}
		if (ez_zenback_valid_css($ez_zenback_style, $ez_zenback_allowed_str) == "invalid") {
			wp_die(__('Invalid value. Settings could not be saved.<br />Your "Style Sheet" contains some character strings that are not allowed to use.', 'ez_zenback'));
		} else {
			$ez_zenback_style = ez_zenback_valid_css($ez_zenback_style, $ez_zenback_allowed_str);
		}
		if (ez_zenback_valid_text($ez_zenback_before_post, $ez_zenback_allowed_str) == "invalid") {
			wp_die(__('Invalid value. Settings could not be saved.<br />Your "Before the post content block" contains some character strings that are not allowed to use.', 'ez_zenback'));
		} else {
			$ez_zenback_before_post = ez_zenback_valid_text($ez_zenback_before_post, $ez_zenback_allowed_str);
		}
		if (ez_zenback_valid_text($ez_zenback_after_post, $ez_zenback_allowed_str) == "invalid") {
			wp_die(__('Invalid value. Settings could not be saved.<br />Your "After the post content block" contains some character strings that are not allowed to use.', 'ez_zenback'));
		} else {
			$ez_zenback_after_post = ez_zenback_valid_text($ez_zenback_after_post, $ez_zenback_allowed_str);
		}
		// Store in DB
		update_option('ez_zenback_setting_opt', $ez_zenback_setting_opt);
		update_option('ez_zenback_code', $ez_zenback_code);
		update_option('ez_zenback_exc', $ez_zenback_exc);
		update_option('ez_zenback_style', $ez_zenback_style);
		update_option('ez_zenback_before_post', $ez_zenback_before_post);
		update_option('ez_zenback_after_post', $ez_zenback_after_post);
		update_option('ez_zenback_position', $ez_zenback_setting_opt['position']); // For backward compatibility
		update_option('ez_zenback_single', $ez_zenback_setting_opt['single']); // For backward compatibility
		update_option('ez_zenback_page', $ez_zenback_setting_opt['page']); // For backward compatibility
		update_option('ez_zenback_updated', 'false');
		// Show message for admin
		echo "<div id='setting-error-settings_updated' class='updated fade'><p><strong>".__("Settings saved.","ez_zenback")."</strong></p></div>";
	}

	?> 
	<div class="wrap">
	<?php screen_icon(); ?>
	<h2>EZ Zenback</h2>
	<h3><?php _e("Settings for zenback", 'ez_zenback') ?></h3>
	<form method="post" action="">
	<?php wp_nonce_field("ez_zenback_update_options", "_wpnonce_update_options"); ?>
	<input type="hidden" name="ez_zenback_hidden_value" value="true" />
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('zenback code', 'ez_zenback') ?></th> 
				<td>
					<textarea name="ez_zenback_code" rows="8" style="width:500px"><?php echo esc_html(ez_zenback_valid_code(get_option('ez_zenback_code'))); ?></textarea>
				<p><small><?php _e('Get your "<a href="http://zenback.jp/">zenback code</a>" now. zenback is registered trademark of Six Apart, Ltd.', "ez_zenback") ?></small></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Position', 'ez_zenback') ?></th> 
				<td>
					<input type="radio" name="position" value="before" <?php if ($ez_zenback_setting_opt['position'] == "before") { echo 'checked="checked"';} ?>/><?php _e('Before comment block', 'ez_zenback') ?> <input type="radio" name="position" value="after" <?php if ($ez_zenback_setting_opt['position'] == "after") { echo 'checked="checked"';} ?>/><?php _e('After comment block', 'ez_zenback') ?> <input type="radio" name="position" value="widget" <?php if ($ez_zenback_setting_opt['position'] == "widget") { echo 'checked="checked"';} ?>/><?php _e('Widget', 'ez_zenback') ?><input type="radio" name="position" value="shortcode" <?php if ($ez_zenback_setting_opt['position'] == "shortcode") { echo 'checked="checked"';} ?>/><?php _e('Shortcode', 'ez_zenback') ?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Insert into', 'ez_zenback') ?></th> 
				<td>
					<input type="checkbox" name="single" value="1"<?php if ($ez_zenback_setting_opt['single'] == "1") {echo ' checked="checked"';} ?> /><?php _e('Posts', 'ez_zenback') ?> <input type="checkbox" name="page" value="1"<?php if ($ez_zenback_setting_opt['page'] == "1") {echo ' checked="checked"';} ?> /><?php _e('Pages', 'ez_zenback') ?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('If you close comment form', 'ez_zenback') ?></th> 
				<td>
					<input type="checkbox" name="closed_comment" value="1"<?php if ($ez_zenback_setting_opt['closed_comment'] == "1") {echo ' checked="checked"';} ?> /><?php _e('Display zenback on the posts and pages closing comment form', 'ez_zenback') ?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Exclusion', 'ez_zenback') ?></th>
				<td>
					<input type="text" name="ez_zenback_exc" size="80" value="<?php echo esc_html(get_option('ez_zenback_exc')); ?>" /><br />
					<p><small><?php _e("Enter comma-separated Post_id(s).<br />The zenback will not be shown on Posts or Pages with enterd Post_id.", "ez_zenback") ?></small></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Improve the accuracy of zenback', 'ez_zenback') ?></th> 
				<td>
					<input type="checkbox" name="accuracy" value="1"<?php if ($ez_zenback_setting_opt['accuracy'] == "1") {echo ' checked="checked"';} ?> />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Style Sheet', 'ez_zenback') ?></th>
				<td>
					<input type="checkbox" name="style_enable" value="1"<?php if ($ez_zenback_setting_opt['style_enable'] == "1") {echo ' checked="checked"';} ?> /> <?php _e('Use additional CSS', 'ez_zenback') ?><br />
					<textarea name="ez_zenback_style"  rows="8" style="width:500px"><?php echo ez_zenback_valid_css(strip_tags(get_option('ez_zenback_style'))); ?></textarea>
				</td>
			</tr>
		</table>
	<h3><?php _e("Settings for Inserting HTML, JavaScripts into your posts", 'ez_zenback') ?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Before the post content block', 'ez_zenback') ?></th> 
				<td>
					<textarea name="ez_zenback_before_post"  rows="8" style="width:500px"><?php echo esc_html(ez_zenback_valid_text(get_option('ez_zenback_before_post'), $ez_zenback_allowed_str)); ?></textarea>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Insert into', 'ez_zenback') ?></th> 
				<td>
					<input type="checkbox" name="before_post_home" value="1"<?php if ($ez_zenback_setting_opt['before_post_home'] == "1") {echo ' checked="checked"';} ?> /><?php _e('Home', 'ez_zenback') ?> <input type="checkbox" name="before_post_single" value="1"<?php if ($ez_zenback_setting_opt['before_post_single'] == "1") {echo ' checked="checked"';} ?> /><?php _e('Post', 'ez_zenback') ?> <input type="checkbox" name="before_post_page" value="1"<?php if ($ez_zenback_setting_opt['before_post_page'] == "1") {echo ' checked="checked"';} ?> /><?php _e('Page', 'ez_zenback') ?> <input type="checkbox" name="before_post_category" value="1"<?php if ($ez_zenback_setting_opt['before_post_category'] == "1") {echo ' checked="checked"';} ?> /><?php _e('Category', 'ez_zenback') ?> <input type="checkbox" name="before_post_search" value="1"<?php if ($ez_zenback_setting_opt['before_post_search'] == "1") {echo ' checked="checked"';} ?> /><?php _e('Search', 'ez_zenback') ?> <input type="checkbox" name="before_post_archive" value="1"<?php if ($ez_zenback_setting_opt['before_post_archive'] == "1") {echo ' checked="checked"';} ?> /><?php _e('Archives', 'ez_zenback') ?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('After the post content block', 'ez_zenback') ?></th> 
				<td>
					<textarea name="ez_zenback_after_post"  rows="8" style="width:500px"><?php echo esc_html(ez_zenback_valid_text(get_option('ez_zenback_after_post'), $ez_zenback_allowed_str)); ?></textarea>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Insert into', 'ez_zenback') ?></th>
				<td>
					<input type="checkbox" name="after_post_home" value="1"<?php if ($ez_zenback_setting_opt['after_post_home'] == "1") {echo ' checked="checked"';} ?> /><?php _e('Home', 'ez_zenback') ?> <input type="checkbox" name="after_post_single" value="1"<?php if ($ez_zenback_setting_opt['after_post_single'] == "1") {echo ' checked="checked"';} ?> /><?php _e('Post', 'ez_zenback') ?> <input type="checkbox" name="after_post_page" value="1"<?php if ($ez_zenback_setting_opt['after_post_page'] == "1") {echo ' checked="checked"';} ?> /><?php _e('Page', 'ez_zenback') ?> <input type="checkbox" name="after_post_category" value="1"<?php if ($ez_zenback_setting_opt['after_post_category'] == "1") {echo ' checked="checked"';} ?> /><?php _e('Category', 'ez_zenback') ?> <input type="checkbox" name="after_post_search" value="1"<?php if ($ez_zenback_setting_opt['after_post_search'] == "1") {echo ' checked="checked"';} ?> /><?php _e('Search', 'ez_zenback') ?> <input type="checkbox" name="after_post_archive" value="1"<?php if ($ez_zenback_setting_opt['after_post_archive'] == "1") {echo ' checked="checked"';} ?> /><?php _e('Archives', 'ez_zenback') ?>
				</td>
			</tr>
		 </table>
		<p class="submit">
		  <input type="submit" name="EZ_ZENBACK_Setting_Submit" value="<?php _e('Save Changes', 'ez_zenback') ?>" />
		</p>
	</form>
	<h3><?php _e('Settings for zenback', 'ez_zenback') ?></h3> 	
	<ol> 
	<li><?php _e('This plugin will help you to install "<a href="http://zenback.jp/">zenback</a>".', 'ez_zenback') ?>
	</li>
	<li>
	<?php _e('To insert "zenback" code into your posts or pages, At first, Enter your zenback code in "zenback code".', 'ez_zenback') ?>
	</li>
	<li>
	<?php _e('Choose display position of "zenback", You can insert "zenback" before or after comment block.<br />You can also add zenback as a widget.<br />After you choose "widget", go to "Widgets" section under "Appearance" menu in WordPress and add the "EZ zenback Widget" in your sidebar.<br />If you choose "shortcode", you use following "shortcode" in your posts, pages or widget to insert "zenback".<br />Shortcode: <code>[zenback]</code>', 'ez_zenback') ?>
	</li> 
	<li><?php _e('Choose contents which "zenback" will install to. You can install "zenback" to your posts, pages or both.<br />If you choose "shortcode", this option will be invalid.', 'ez_zenback') ?>
	</li>
	<li><?php _e('Even if you close comment form on the all posts and pages or a part of posts and pages,<br />you can enable "Display zenback on the posts and pages closing comment form" to insert "zenback" into these posts and pages.', 'ez_zenback') ?>
	</li> 
	<li><?php _e('When you enable "Improve the accuracy of zenback",<br /><a href="http://zenback.typepad.jp/blog/2010/07/%E9%96%A2%E9%80%A3%E8%A8%98%E4%BA%8B%E3%81%AE%E7%B2%BE%E5%BA%A6%E3%82%92%E4%B8%8A%E3%81%92%E3%82%8Bzenback%E3%82%BF%E3%82%B0.html">Special tags</a> will be insert your posts or pages to improve the accuracy of analysing related posts.', 'ez_zenback') ?>
	</li>
	<li><?php _e('If you need you can add your own stylesheet for zenback. <a href="http://blog.zenback.jp/2010/07/%E3%83%96%E3%83%AD%E3%82%B0%E3%83%91%E3%83%BC%E3%83%84%E3%81%AEidclass%E6%A7%8B%E9%80%A0%E3%81%AB%E3%81%A4%E3%81%84%E3%81%A6.html">ブログパーツのid／class構造とcssについて</a>', 'ez_zenback') ?>
	</li> 
	</ol>
	<h3><?php _e('Settings for Inserting HTML, JavaScripts into your posts', 'ez_zenback') ?></h3> 	
	<ol> 
	<li><?php _e('You can also insert your own HTML or JavaScripts before or after your posts, pages easily.', 'ez_zenback') ?>
	</li>
	<li>
	<?php _e('Enter your HTML or JavaScripts in "Before the Post content block", "After the Post content block" or both.', 'ez_zenback') ?>
	</li>
	<li>
	<?php _e('Choose contents which your HTML or JavaScripts will be inserted into.', 'ez_zenback') ?>
	<br />
	<?php _e('When you activate "Archives", your HTML or JavaScripts will be inserted into "Year", "Month", "Date", "Time" and "Tag" based archives pages.', 'ez_zenback') ?>
	</li> 
	</ol>
	<h3><?php _e('Notes', 'ez_zenback') ?></h3> 	
	<ol> 
	<li><?php _e('This plugin depends on your using wordpress theme.', 'ez_zenback') ?>
	<br />
	<?php _e('In some wordpress themes, this plugin will not work normally.', 'ez_zenback') ?>
	<li><?php _e('You need to use this plugin with default comment system.', 'ez_zenback') ?>
	<br />
	<?php _e('When default comment system is replaced by other comment system, "zenback" will not be shown.', 'ez_zenback') ?>
	<br />
	<?php _e('If you have used "<a href="http://disqus.com/">DISQUS</a>" as your comment system or you want to use "DISQUS",<br />Use "<a href="http://www.near-mint.com/blog/software/disqus-comment-system-for-ez-zenback">Disqus Comment System for EZ zenback</a>" plugin instead of <a href="http://wordpress.org/extend/plugins/disqus-comment-system/">Disqus Comment System</a> plugin.', 'ez_zenback') ?>
	</li>
	</ol>
	<h3><a href="javascript:showhide('id1');" name="system_info"><?php _e("Show Your System Info", 'ez_zenback') ?></a></h3>
	<div id="id1" style="display:none; margin-left:20px">
	<p>
	<?php _e('Server OS:', 'ez_zenback') ?> <?php echo php_uname('s').' '.php_uname('r'); ?><br />
	<?php _e('PHP version:', 'ez_zenback') ?> <?php echo phpversion(); ?><br />
	<?php _e('MySQL version:', 'ez_zenback') ?> <?php echo mysql_get_server_info(); ?><br />
	<?php _e('WordPress version:', 'ez_zenback') ?> <?php bloginfo("version"); ?><br />
	<?php _e('Site URL:', 'ez_zenback') ?> <?php if(function_exists("home_url")) { echo home_url(); } else { echo get_option('home'); } ?><br />
	<?php _e('WordPress URL:', 'ez_zenback') ?> <?php echo site_url(); ?><br />
	<?php _e('WordPress language:', 'ez_zenback') ?> <?php bloginfo("language"); ?><br />
	<?php _e('WordPress character set:', 'ez_zenback') ?> <?php bloginfo("charset"); ?><br />
	<?php _e('WordPress theme:', 'ez_zenback') ?> <?php $ez_theme = get_theme(get_current_theme()); echo $ez_theme['Name'].' '.$ez_theme['Version']; ?><br />
	<?php _e('EZ zenback version:', 'ez_zenback') ?> <?php global $ez_zenback_ver; echo $ez_zenback_ver; ?><br />
	<?php _e('EZ zenback URL:', 'ez_zenback') ?> <?php echo $ez_zenback_plugin_url; ?><br />
	<?php _e('Your browser:', 'ez_zenback') ?> <?php echo esc_html($_SERVER['HTTP_USER_AGENT']); ?>
	</p>
	</div>
	<p>
	<?php _e("To report a bug ,submit requests and feedback, ", 'ez_zenback') ?><?php _e('Use <a href="http://wordpress.org/tags/ez-zenback?forum_id=10">Forum</a> or <a href="http://www.near-mint.com/blog/contact">Mail From</a>', 'ez_zenback') ?>
	</p>
	</div>
<?php }
?>