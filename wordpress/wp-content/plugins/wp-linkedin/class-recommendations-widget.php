<?php

class WP_LinkedIn_Recommendations_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct('wp-linkedin-recommendation-widget', __('LinkedIn Recommendations', 'wp-linkedin'),
				array('description' => __('A slider with your LinkedIn recommendations', 'wp-linkedin')));
	}

	public function widget($args, $instance) {
		extract($args);
		$options = wp_parse_args((array) get_option('recommendations_widget_options'), array(
				'title' => '',
				'width' => 480,
				'length' => 200,
				'interval' => 1000
			));

		$instance = wp_parse_args((array) $instance, $options);
		$recommendations = wp_linkedin_recommendations($instance);

		if (!empty($recommendations)) {
			$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

			echo $before_widget;
			if ($title) echo $before_title . $title . $after_title;
			echo $recommendations;
			echo $after_widget;
		}
	}

	public function form($instance) {
		$options = wp_parse_args((array) get_option('recommendations_widget_options'), array(
				'title' => '',
				'width' => 480,
				'length' => 200,
				'interval' => 1000
			));

		$instance = wp_parse_args((array) $instance, $options);
		$title = esc_attr($instance['title']);

?>
<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Width of widget (in px):', 'wp-linkedin'); ?></label>
	<input id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo $instance['width']; ?>" size="4" />
	<br/><small><em><?php _e('You can also specify \'auto\' to let javascript automatically compute the width or \'css\' to set it yourself using your theme\'s stylesheet.', 'wp-linkedin'); ?></em></small>
</p>
<p>
	<label for="<?php echo $this->get_field_id('length'); ?>"><?php _e('Length of recommendations (in char):', 'wp-linkedin'); ?></label>
	<input id="<?php echo $this->get_field_id('length'); ?>" name="<?php echo $this->get_field_name('length'); ?>" type="text" value="<?php echo $instance['length']; ?>" size="4" />
</p>
<p>
	<label for="<?php echo $this->get_field_id('interval'); ?>"><?php _e('Scroller\'s speed:', 'wp-linkedin'); ?></label>
	<input id="<?php echo $this->get_field_id('interval'); ?>" name="<?php echo $this->get_field_name('interval'); ?>" type="text" value="<?php echo $instance['interval']; ?>" size="4" />
</p>
<?php
}

	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['width'] = $new_instance['width'];
		$instance['length'] = (int) $new_instance['length'];
		$instance['interval'] = (int) $new_instance['interval'];
		return $instance;
	}

}
