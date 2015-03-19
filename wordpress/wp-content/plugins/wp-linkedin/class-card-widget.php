<?php

class WP_LinkedIn_Card_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct('wp-linkedin-card-widget', __('LinkedIn Card', 'wp-linkedin'),
				array('description' => __('A widget displaying your LinkedIn card', 'wp-linkedin')));
	}

	public function widget($args, $instance) {
		extract($args);
		$instance = wp_parse_args((array) $instance, array(
				'title' => '',
				'picture_width' => 50,
				'summary_length' => 200
			));

		$card = wp_linkedin_card($instance);

		if (!empty($card)) {
			$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

			echo $before_widget;
			if ($title) echo $before_title . $title . $after_title;
			echo $card;
			echo $after_widget;
		}
	}

	public function form($instance) {
		$instance = wp_parse_args((array) $instance, array(
				'title' => '',
				'picture_width' => 50,
				'summary_length' => 200
			));
		$title = esc_attr($instance['title']);

?>
<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id('picture_width'); ?>"><?php _e('Width of picture (in px):', 'wp-linkedin'); ?></label>
	<input id="<?php echo $this->get_field_id('picture_width'); ?>" name="<?php echo $this->get_field_name('picture_width'); ?>" type="text" value="<?php echo $instance['picture_width']; ?>" size="3" />
</p>
<p>
	<label for="<?php echo $this->get_field_id('summary_length'); ?>"><?php _e('Max length of summary (in char):', 'wp-linkedin'); ?></label>
	<input id="<?php echo $this->get_field_id('summary_length'); ?>" name="<?php echo $this->get_field_name('summary_length'); ?>" type="text" value="<?php echo $instance['summary_length']; ?>" size="3" />
	<br/><small><em><?php _e('Specify \'0\' to hide the summary.', 'wp-linkedin'); ?></em></small>
</p>
<?php
	}

	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['picture_width'] = (int) $new_instance['picture_width'];
		$instance['summary_length'] = (int) $new_instance['summary_length'];
		return $instance;
	}

}
