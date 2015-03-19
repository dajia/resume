<?php

class WP_LinkedIn_Profile_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct('wp-linkedin-profile-widget', __('LinkedIn Profile', 'wp-linkedin'),
				array('description' => __('A widget displaying your LinkedIn profile using the LinkedIn Javascript API', 'wp-linkedin')));
	}

	public function widget($args, $instance) {
		extract($args);
		$instance = wp_parse_args((array) $instance, array(
				'title' => '',
				'show_connections' => true
			));

		$profile = wp_linkedin_get_profile('publicProfileUrl');
		if ($profile !== false) {
			$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
			$show_connections = ($instance['show_connections']) ? 'true' : 'false';

			echo $before_widget;
			if ($title) echo $before_title . $title . $after_title;
			if (is_wp_error($profile)) {
				echo wp_linkedin_error($profile->get_error_message());
			} else {
				echo '<script src="//platform.linkedin.com/in.js" type="text/javascript"></script>';
				echo '<script type="IN/MemberProfile" data-id="' . $profile->publicProfileUrl;
				echo '" data-format="inline" data-related="' . $show_connections . '"></script>';
			}
			echo $after_widget;
		}
	}

	public function form($instance) {
		$instance = wp_parse_args((array) $instance, array(
				'title' => '',
				'show_connections' => true
			));
		$title = esc_attr($instance['title']);

?>
<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
</p>
<p>
	<label><input id="<?php echo $this->get_field_id('show_connections'); ?>" name="<?php echo $this->get_field_name('show_connections'); ?>"
		type="checkbox" <?php checked($instance['show_connections']); ?>" /> <?php _e('Show connections', 'wp-linkedin'); ?></label>
</p>
<?php
	}

	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['show_connections'] = (bool) $new_instance['show_connections'];
		return $instance;
	}

}
