<div id="skills" class="section">
<div class="heading"><?php _e('Skills &amp; Expertise', 'wp-linkedin'); ?></div>
<?php
$skills = array();
foreach ($profile->skills->values as $v) {
	$skills[] = '<span class="skill">'.$v->skill->name.'</span>';
} ?>
<p><?php echo implode(', ', $skills); ?></p>
</div>