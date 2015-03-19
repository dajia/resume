<?php

class WP_LinkedIn_Updates_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct('wp-linkedin-updates-widget', __('LinkedIn Network Updates', 'wp-linkedin'),
				array('description' => __('A widget displaying your LinkedIn network updates', 'wp-linkedin')));
	}

	public function widget($args, $instance) {
		extract($args);
		$instance = wp_parse_args((array) $instance, array(
				'title' => '',
				'count' => 50,
				'only_self' => true
			));

		$updates = wp_linkedin_updates($instance);

		if (!empty($updates)) {
			$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
			echo $before_widget;
			if ($title) echo $before_title . $title . $after_title;
			echo $updates;
			echo $after_widget;
		}
	}

	public function form($instance) {
		$instance = wp_parse_args((array) $instance, array(
				'title' => '',
				'count' => 50,
				'only_self' => true
		));
		$title = esc_attr($instance['title']);

?>
<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Number of updates to show:', 'wp-linkedin'); ?></label>
	<input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $instance['count']; ?>" size="3" />
</p>
<p>
	<label><input id="<?php echo $this->get_field_id('only_self'); ?>" name="<?php echo $this->get_field_name('only_self'); ?>"
		type="checkbox" <?php checked($instance['only_self']); ?>" /> <?php _e('Show my updates only', 'wp-linkedin'); ?></label>
</p>
<?php
	}

	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['count'] = (int) $new_instance['count'];
		$instance['only_self'] = (bool) $new_instance['only_self'];
		return $instance;
	}

}
