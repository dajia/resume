<?php

# Resume single post page, you can adjust this file by copying it to your theme's folder and editing.

get_header(); the_post();

?><div class="rb-resume-left">

	<?php echo do_shortcode('[rb_resume id="'.$post->ID.'"]'); ?>

</div>
<div class="rb-resume-right widget-area">

	<div class="widget"><?php echo do_shortcode('[rb_resume_widget_contacts id="'.$post->ID.'"]'); ?></div>
	<div class="widget"><?php echo do_shortcode('[rb_resume_widget_skills id="'.$post->ID.'"]'); ?></div>
	
</div><?php

get_footer();