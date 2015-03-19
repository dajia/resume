<div id="volunteer-experiences" class="section">
<div class="heading"><?php _e('Volunteer Experiences', 'wp-linkedin'); ?></div>
<?php foreach ($profile->volunteer->volunteerExperiences->values as $v): ?>
<div class="volunteer">
	<div class="role"><strong><?php echo $v->role; ?></strong><?php if (isset($v->startDate)): ?>
		(<?php echo $v->startDate->year; ?> - <?php echo isset($v->endDate) ? $v->endDate->year : __('Present', 'wp-linkedin'); ?>)
	<?php endif; ?></div>
	<div class="organization"><?php echo $v->organization->name; ?></div>
	<?php if (isset($v->cause)): ?>
		<div class="cause"><?php echo wp_linkedin_cause($v->cause->name); ?></div>
	<?php endif; ?>
	<?php if (isset($v->description)): ?>
		<div class="summary"><?php echo wpautop($v->description); ?></div>
	<?php endif; ?>
</div>
<?php endforeach; ?>
</div>