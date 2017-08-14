<?php
/*
EZ zenback
Last modified: 2011/10/8
License: GPL v2
http://www.near-mint.com/blog/
*/

class EZzenbackWidget extends WP_Widget {

	function EZzenbackWidget() {
		$widget_ops = array('classname' => 'EZzenbackWidget', 'description' => __("EZzenback Widget shows zenback.", "ez_zenback"));
		parent::WP_Widget(false, $name = __("EZ zenback Widget", "ez_zenback"), $widget_ops);	
	}

	function widget($args, $instance) {
		global $ez_zenback_setting_opt;		
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		?>
			<?php
			if (($ez_zenback_setting_opt['single'] == 1 && is_single()) || ($ez_zenback_setting_opt['page'] == 1 && is_page())) {
				echo $before_widget;
				if ($title){
						echo $before_title . $title . $after_title;
				}
				$ez_zenback_code = ez_zenback_valid_code(get_option('ez_zenback_code'));
				if ($ez_zenback_code == "invalid") {
					$ez_zenback_code = "";
				}
				echo $ez_zenback_code;
				echo $after_widget;
			}
			?>
		<?php
	}

	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	function form($instance) {				
		$title = esc_attr($instance['title']);
		?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e("Title:"); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
		<?php 
	}

}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("EZzenbackWidget");'));

?>