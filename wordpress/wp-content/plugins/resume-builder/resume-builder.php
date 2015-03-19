<?php
/**
 * Plugin Name: Resume Builder
 * Plugin URI: http://demo.boxystudio.com/resume-builder/
 * Description: A WordPress plugin to build out your resume along with contact information and related skills
 * Version: 1.1.75
 * Author: Boxy Studio
 * Author URI: http://boxystudio.com
 * License: GPL2
 */
 
/*  Copyright 2014 Boxy Studio  (email : justin@boxystudio.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

# Load Framework
if ( !class_exists('Carbon_Field') ) {
	require_once dirname(__FILE__) . '/carbon-fields/carbon-fields.php';
}

# Post Thumbnails Support
if ( !current_theme_supports('post-thumbnails') ) {
	add_theme_support('post-thumbnails');
}

# Custom Image Sizes
add_image_size('rb-resume-thumbnail', 474, 606, true);

/**
 * Register Resume CPT
 */
add_action('init', 'rb_register_post_type_resume');
function rb_register_post_type_resume() {
	# Resumes
	register_post_type('rb_resume', array(
		'labels' => array(
			'name'	             => __('Resumes', 'resume-builder'),
			'singular_name'      => __('Resume', 'resume-builder'),
			'add_new'            => __('Add New', 'resume-builder'),
			'add_new_item'       => __('Add new Resume', 'resume-builder'),
			'view_item'          => __('View Resume', 'resume-builder'),
			'edit_item'          => __('Edit Resume', 'resume-builder'),
			'new_item'           => __('New Resume', 'resume-builder'),
			'view_item'          => __('View Resume', 'resume-builder'),
			'search_items'       => __('Search Resumes', 'resume-builder'),
			'not_found'          => __('No Resumes found', 'resume-builder'),
			'not_found_in_trash' => __('No Resumes found in Trash', 'resume-builder'),
		),
		'public'              => true,
		'exclude_from_search' => false,
		'show_ui'             => true,
		'capability_type'     => 'post',
		'hierarchical'        => false,
		'query_var'           => false,
		'supports'            => array('title'),
		'rewrite'			  => array('slug' => 'resume'),
		'menu_icon'           => 'dashicons-list-view'
	));
}

add_action( 'admin_init', 'resume_builder_admin_init' );

function rb_rewrite_flush() {
    
    rb_register_post_type_resume();
    flush_rewrite_rules();
    
}

register_activation_hook( __FILE__, 'rb_rewrite_flush' );
   
function resume_builder_admin_init() {
	/* Load the custom Carbon Fields styling */
   	wp_enqueue_style( 'carbon-custom', plugins_url('css/carbon-custom.css', __FILE__) );
}

add_action( 'init', 'resume_builder_init' );
   
function resume_builder_init() {

	/* Load the Front-End javascript and styling */
	wp_enqueue_script( 'jquery' );
	wp_enqueue_style( 'rb-font-awesome', plugins_url('css/font-awesome.css', __FILE__) );
   	if (!file_exists(get_template_directory().'/resume-builder.css')){
   		wp_enqueue_style( 'rb-styles', plugins_url('css/resume-builder-styles.css', __FILE__) );
   	} else {
	   	wp_enqueue_style( 'rb-styles', get_template_directory_uri().'/resume-builder.css' );
   	}
   	wp_enqueue_script( 'rb-raty', plugins_url('js/jquery.raty.js', __FILE__), array('jquery'),'1.0',true );
   	wp_enqueue_script( 'rb-functions', plugins_url('js/functions.js', __FILE__), array('jquery'),'1.0',true );
}

/**
 * Register Meta Boxes for Resume CPT
 */
add_action('carbon_register_fields', 'rb_register_resume_meta_boxes');
function rb_register_resume_meta_boxes() {
	Carbon_Container::factory('custom_fields', __('Resume Builder'))
		->show_on_post_type('rb_resume')
		->add_fields(array(
			# Resume Shortcode
			Carbon_Field::factory('separator', 'rb_resume_shortcode_title', __('Resume Shortcodes', 'resume-builder')),
			Carbon_Field::factory('html', 'rb_resume_shortcode')
				->set_html( rb_get_resume_shortcode_help_text() ),

			# Complex Sections
			Carbon_Field::factory('separator', 'rb_resume_sections_title', __('The Resume Builder', 'resume-builder')),
			Carbon_Field::factory('complex', 'rb_resume_sections', __('Resume Sections', 'resume-builder'))
				->setup_labels(array(
					'singular_name' => __('Resume Section', 'resume-builder'),
					'plural_name'   => __('Resume Sections', 'resume-builder'),
				))
				->add_fields('introduction_block', array(
					# Section Title
					Carbon_Field::factory('text', 'sectiontitle', __('Introduction Title', 'resume-builder')),

					# Section SubTitle
					Carbon_Field::factory('text', 'sectionsubtitle', __('Introduction Subtitle', 'resume-builder')),

					# Image
					Carbon_Field::factory('attachment', 'sectionimage', __('Introduction Image', 'resume-builder'))
						->help_text(
							__(
								'The image should be sized to 237 x 303 pixels.',
								'resume-builder'
							)
						),

					# Text
					Carbon_Field::factory('rich_text', 'sectiontext', __('Introduction Text', 'resume-builder')),

					# Buttons
					Carbon_Field::factory('complex', 'sectionbuttons', __('Introduction Buttons', 'resume-builder'))
						->setup_labels(array(
							'singular_name' => __('Button', 'resume-builder'),
							'plural_name'   => __('Buttons', 'resume-builder'),
						))
						->add_fields(array(
							# Label
							Carbon_Field::factory('text', 'label', __('Button Label', 'resume-builder'))
								->set_required(true),

							# Link
							Carbon_Field::factory('text', 'link', __('Button Link', 'resume-builder'))
								->set_required(true),

							# Type
							Carbon_Field::factory('select', 'type', __('Button Style', 'resume-builder'))
								->set_required(true)
								->add_options(array(
									'filled' => __('Filled', 'resume-builder'),
									'open'   => __('Open', 'resume-builder'),
								)),
						)),
				))
				->add_fields('default_block', array(
					# Section Title
					Carbon_Field::factory('text', 'sectiontitle', __('Section Title', 'resume-builder')),

					# Section Content
					Carbon_Field::factory('complex', 'sectioncontent', __('Section Content', 'resume-builder'))
						->setup_labels(array(
							'singular_name' => __('Subsection', 'resume-builder'),
							'plural_name'   => __('Subsections', 'resume-builder'),
						))
						->add_fields('text_block', array(
							# Text
							Carbon_Field::factory('rich_text', 'text', __('Text', 'resume-builder'))
								->set_required(true),
						))
						->add_fields('detailed_row', array(
							# Row Title
							Carbon_Field::factory('text', 'rowtitle', __('Row Title', 'resume-builder')),

							# Row Subtitle
							Carbon_Field::factory('text', 'rowsubtitle', __('Row Subtitle', 'resume-builder')),

							# Row Side Text
							Carbon_Field::factory('text', 'rowsidetext', __('Row Side Text', 'resume-builder')),

							# Row Text
							Carbon_Field::factory('rich_text', 'rowtext', __('Row Text', 'resume-builder')),
						)),
				)),

			# Widgets
			Carbon_Field::factory('separator', 'rb_resume_widget', __('Resume Widgets', 'resume-builder')),

				# Widget Contacts Title
				Carbon_Field::factory('text', 'rb_resume_widget_contacts_title', __('Contact Info Title', 'resume-builder')),

					# Email
					Carbon_Field::factory('text', 'rb_resume_widget_contacts_email', __('Email', 'resume-builder')),

					# Phone
					Carbon_Field::factory('text', 'rb_resume_widget_contacts_phone', __('Phone', 'resume-builder')),

					# Website
					Carbon_Field::factory('text', 'rb_resume_widget_contacts_website', __('Website', 'resume-builder')),

					# Address
					Carbon_Field::factory('text', 'rb_resume_widget_contacts_address', __('Address', 'resume-builder')),

				# Widget Title
				Carbon_Field::factory('text', 'rb_resume_widget_skills_title', __('Skills Title', 'resume-builder')),

					# Complex Skills
					Carbon_Field::factory('complex', 'rb_resume_widget_skills', __('Skills', 'resume-builder'))
						->setup_labels(array(
							'singular_name' => __('Skill', 'resume-builder'),
							'plural_name'   => __('Skills', 'resume-builder'),
						))
						->add_fields(array(
							# Title
							Carbon_Field::factory('text', 'title', __('Title', 'resume-builder')),

							# Rating
							Carbon_Field::factory('select', 'rating', __('Star Rating', 'resume-builder'))
								->add_options( rb_generate_rating() ),

							# Text
							Carbon_Field::factory('textarea', 'text', __('Description', 'resume-builder')),
						)),
		));
}

/**
 * Renders the shortcode for the resume
 * 
 * @return void
 */
function rb_get_resume_shortcode_help_text() {
	global $my_admin_page;

	$output = '<em style="color:#aaa; position:relative; top:-4px; left:5px;">'.__('Save the resume to view its available shortcodes.', 'resume-builder').'</em>';

	if ( is_admin() && isset($_GET['post']) ) {
		$post_ID = $_GET['post'];
		
		if (!is_array($post_ID)){

			$output  = '<strong style="width:200px; display:inline-block;">'.__('Full Resume: ', 'resume-builder') . '</strong>[rb_resume id="' . $post_ID . '"]<br/>';
			$output .= '<strong style="width:200px; display:inline-block;">'.__('Resume Intro: ', 'resume-builder') . '</strong>[rb_resume_intro id="' . $post_ID . '"]<br/>';
			$output .= '<strong style="width:200px; display:inline-block;">'.__('Resume Widget Skills: ', 'resume-builder') . '</strong>[rb_resume_widget_skills id="' . $post_ID . '"]<br/>';
			$output .= '<strong style="width:200px; display:inline-block;">'.__('Resume Widget Contacts: ', 'resume-builder') . '</strong>[rb_resume_widget_contacts id="' . $post_ID . '"]<br/>';
		
		}
	
	}

	return $output;
}


/**
 * Generates the Rating Options
 */
function rb_generate_rating() {
	$step = 0.5;
	$start = 0;
	$end = 5;

	$output = array();
	for ($i = $start; $i <= $end; $i = $i + $step) {
		$output[(string)$i] = $i;
	}

	return $output;
}

/**
 * Renders the Intro Section of a given resume
 */
function rb_render_resume_intro($section, $output = true) {
	ob_start();
	
	# Section Thumbnail
	if ( !empty($section['sectionimage']) ) {
		echo '<div class="rb-about-image">' . wp_get_attachment_image($section['sectionimage'], 'rb-resume-thumbnail') . '</div>';
	}

	# Section Text
	if ($section['sectiontitle'] || $section['sectionsubtitle'] || $section['sectiontext'] || $section['sectionbuttons']) {
		echo '<div class="rb-about-text">';
			# Section Title
			echo ( !empty($section['sectiontitle']) ? '<div class="rb-title">' . $section['sectiontitle'] . '</div>' : '' );

			# Section Subtitle
			echo ( !empty($section['sectionsubtitle']) ? '<div class="rb-subtitle">' . $section['sectionsubtitle'] . '</div>' : '' );

			# Section Text
			echo ( !empty($section['sectiontext']) ? '<div class="rb-description">'.wpautop($section['sectiontext']).'</div>' : '' );

			# Section Buttons
			if ( !empty($section['sectionbuttons']) ) {
				echo '<div class="rb-buttons">';
					foreach ($section['sectionbuttons'] as $button) {
						$button_class = ($button['type'] == 'filled') ? '' : 'rb-btn-white';
						$button_label = ($button['type'] == 'filled') ? $button['label'] : $button['label'];
						echo '<a class="rb-btn ' . $button_class . '" href="' . $button['link'] . '">' . $button_label . '</a>';
					}
				echo '</div>';
			}
		echo '</div>';
	}
	
	if (!$output) {
		return ob_get_clean();
	} else {
		echo ob_get_clean();
	}
}

/* Customize the Post Template */
add_filter( 'template_include', 'rb_resume_templates' );
function rb_resume_templates( $template ) {
    $post_types = array( 'rb_resume' );

    if ( is_singular( $post_types ) && ! file_exists( get_stylesheet_directory() . '/single-resume.php' ) ):
        $template = plugin_dir_path( __FILE__ ).'/single-resume.php';
    elseif ( is_singular($post_types) && file_exists( get_stylesheet_directory() . '/single-resume.php' ) ):
    	$template = get_stylesheet_directory() . '/single-resume.php';
    endif;

    return $template;
}

/**
 * Resume Shortcodes
 */
add_shortcode('rb_resume', 'rb_resume_shortcode');
function rb_resume_shortcode($atts, $content = null) {
	
	ob_start();
	
	shortcode_atts(
		array(
			'id' => false,
		),
		$atts
	);

	if ( empty($atts['id']) ) {
		return '';
	}

	$resume = get_post($atts['id']);
	if (!$resume) {
		return '';
	}

	if ( !function_exists('carbon_get_post_meta') ) {
		return '';
	}

	$sections = carbon_get_post_meta($atts['id'], 'rb_resume_sections', 'complex');
	if ( empty($sections) ) {
		return;
	}
	
	echo '<div class="rb-resume-block">';

	foreach ($sections as $s) {
		?>
		<div class="<?php echo ( $s['_type'] == '_default_block' ? 'rb-experience' : 'rb-about' ); ?>">
			<?php
			# Section Content
			if ( $s['_type'] == '_introduction_block' ) {
				rb_render_resume_intro($s);
			} elseif ( $s['_type'] == '_default_block' && !empty($s['sectioncontent']) ) {
			
				// Sort the section content by key (for those servers that are messing with the order for some reason)
+				ksort($s['sectioncontent']);
			
				# Section Title
				echo ( !empty($s['sectiontitle']) ? '<div class="rb-section-title">' . $s['sectiontitle'] . '</div>' : '' );

				foreach ($s['sectioncontent'] as $ss) {
				
					if ($ss['_type'] == '_text_block') {
						echo '<div class="rb-text-block">';
							echo apply_filters('the_content', $ss['text']);
						echo '</div>';
					} elseif ($ss['_type'] == '_detailed_row') {
						?>
						<div class="rb-experience-item">
							<?php
							# Head
							if ($ss['rowtitle'] || $ss['rowsubtitle'] || $ss['rowsidetext']) {
								echo '<div class="rb-experience-head">';
									if ($ss['rowsidetext']) {
										echo '<div class="rb-right">'.wpautop($ss['rowsidetext']).'</div>';
									}

									if ($ss['rowtitle']) {
										echo '<div class="rb-title">' . $ss['rowtitle'] . '</div>';
									}

									if ($ss['rowsubtitle']) {
										echo '<div class="rb-subtitle">' . $ss['rowsubtitle'] . '</div>';
									}
								echo '</div>';
							}

							# Body
							if ($ss['rowtext']) {
								echo '<div class="rb-description">'.apply_filters('the_content', $ss['rowtext']).'</div>';
							}
							?>
						</div>
						<?php
					}
				}
			}
			?>
		</div><!-- /article -->
		<?php
	}
	
	echo '</div>';
	
	return ob_get_clean();
	
}

/**
 * Resume Skills shortcode
 */
add_shortcode('rb_resume_widget_skills', 'rb_resume_widget_skills_shortcode');
function rb_resume_widget_skills_shortcode($atts, $content = null) {
	
	shortcode_atts(array(
		'id' => false,
	), $atts);

	if ($atts['id'] === false) {
		return '';
	}

	$resume = get_post($atts['id']);
	if (!$resume) {
		return '';
	}
	
	ob_start();

	echo '<div class="rb-widget-experience">';

	# Widget Title
	$widget_title = carbon_get_post_meta($resume->ID, 'rb_resume_widget_skills_title');
	if ( !empty($widget_title) ) {
		echo '<h3 class="widget-title">' . $widget_title . '</h3>';
	}

	# Widget Skills
	$skills = carbon_get_post_meta($resume->ID, 'rb_resume_widget_skills', 'complex');
	if ($skills) {
		
		// Sort the skills by key (for those servers that are messing with the order for some reason)
		ksort($skills);
	
		foreach ($skills as $s) {
			?>
			<div class="rb-experience-item">
				<?php
				# Head
				if ($s['title'] || $s['rating']) {
					if ($s['title']) {
						echo '<div class="rb-experience-title">' . $s['title'] . '</div>';
					}

					if ($s['rating']) {
						echo '<div class="rb-experience-rating" data-read-only="true" data-score="' . $s['rating'] . '"></div>';
					}
				}

				# Body
				echo ( $s['text'] ? '<div class="rb-experience-description">'.wpautop($s['text']).'</div>' : '' );
				?>
			</div>
			<?php
		}
	}

	echo '</div>';
	
	$output = ob_get_clean();
	echo $output;
	
}

/**
 * Resume Contacts Shortcode
 */
add_shortcode('rb_resume_widget_contacts', 'rb_resume_widget_contacts_shortcode');
function rb_resume_widget_contacts_shortcode($atts, $content = null) {
	
	shortcode_atts(array(
		'id' => false,
	), $atts);

	if ($atts['id'] === false) {
		return '';
	}

	$resume = get_post($atts['id']);
	if (!$resume) {
		return '';
	}

	$title   = carbon_get_post_meta($resume->ID, 'rb_resume_widget_contacts_title');
	$email   = carbon_get_post_meta($resume->ID, 'rb_resume_widget_contacts_email');
	$phone   = carbon_get_post_meta($resume->ID, 'rb_resume_widget_contacts_phone');
	$website = carbon_get_post_meta($resume->ID, 'rb_resume_widget_contacts_website');
	$address = carbon_get_post_meta($resume->ID, 'rb_resume_widget_contacts_address');

	$contacts = array(
		'email' => array(
			'icon-name' => 'fa-paper-plane-o',
			'content'   => $email,
			'content_before' => '<a href="mailto:' . $email . '">',
			'content_after' => '</a>',
		),
		'phone' => array(
			'icon-name' => 'fa-phone',
			'content'   => $phone,
			'content_before' => '',
			'content_after' => '',
		),
		'website' => array(
			'icon-name' => 'fa-desktop',
			'content'   => $website,
			'content_before' => '<a href="' . $website . '">',
			'content_after' => '</a>',
		),
		'address' => array(
			'icon-name' => 'fa-map-marker',
			'content'   => $address,
			'content_before' => '',
			'content_after' => '',
		),
	);

	ob_start();

	echo '<div class="rb-widget-contactinfo">';

	# Title
	echo ( !empty($title) ? '<h3 class="widget-title">' . $title . '</h3>' : '' );

	# Contacts
	$contacts_output = '';
	foreach ($contacts as $field_ID => $field_details) {
		if ( empty($field_details['content']) ) {
			continue;
		}

		$contacts_output .= 
			'<li>' .
				'<span>' .
					'<i class="fa ' . $field_details['icon-name'] . '"></i>' .
				'</span>' .
				strip_tags( wpautop( $field_details['content_before'] . $field_details['content'] . $field_details['content_after'] ), '<br><a>' ) .
			'</li>';
	}
	if ($contacts_output) {
		echo '<ul class="rb-contact-block">' . $contacts_output . '</ul>';
	}

	echo '</div>';

	$output = ob_get_clean();
	echo $output;
}

/**
 * Resume Intro Shortcode
 */
add_shortcode('rb_resume_intro', 'rb_resume_intro_shortcode');
function rb_resume_intro_shortcode($atts, $content = null) {
	
	shortcode_atts(array(
		'id' => false,
	), $atts);

	if ($atts['id'] === false) {
		return '';
	}

	$resume = get_post($atts['id']);
	if (!$resume) {
		return '';
	}

	$sections = carbon_get_post_meta($atts['id'], 'rb_resume_sections', 'complex');
	if (!$sections) {
		return;
	}
	
	// Sort the sections by key (for those servers that are messing with the order for some reason)
	ksort($sections);

	foreach ($sections as $section) {
		if ($section['_type'] == '_introduction_block') {
			$output = '<div class="rb-resume-block"><div class="rb-about">'.rb_render_resume_intro($section, false).'</div></div>';
		}
	}
	
	return $output;
}

/**
 * Register Resume Widget
 */
add_action('widgets_init', 'rb_register_resume_widget');
function rb_register_resume_widget() {
	register_widget('RB_Resume_Widget');
}

/**
 * Resume Widget
 */
class RB_Resume_Widget extends WP_Widget {
	/**
	 * Constructor
	 */
	function __construct() {
		parent::__construct(
			'rb_resume_widget', # ID
			__('RB: Resume Widget', 'resume-builder'), # Name
			array(
				'description' => __('Displays a resume skills', 'resume-builder'), # Description
				'classname'   => 'rb-resume-builder', # Classname
			)
		);
	}

	/**
	 * Widget Form
	 */
	function form($instance) {
		$field_ID = $this->get_field_id('rb-shortcode');
		$field_name = $this->get_field_name('rb-shortcode');
		$field_value = ( isset($instance['rb-shortcode']) ? $instance['rb-shortcode'] : '' );
		?>
		<p>
			<label for="<?php echo $field_ID; ?>">
				<?php _e('Resume Shortcode:', 'resume-builder'); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $field_ID; ?>" name="<?php echo $field_name; ?>" value="<?php echo esc_attr($field_value); ?>" />
		</p>
		<?php	
	}

	/**
	 * Widget Display
	 */
	function widget($args, $instance) {
		echo '<aside class="widget rb-widget">';
		do_shortcode($instance['rb-shortcode']);
		echo '</aside>';
	}
}