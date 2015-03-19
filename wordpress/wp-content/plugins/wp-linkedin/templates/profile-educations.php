<div id="educations" class="section">
<div class="heading"><?php _e('Education', 'wp-linkedin'); ?></div>
<?php foreach ($profile->educations->values as $v): ?>
<div class="education">
	<div class="school"><strong><?php echo $v->schoolName; ?></strong> (<?php echo $v->startDate->year; ?> - <?php echo isset($v->endDate) ? $v->endDate->year : __('Present', 'wp-linkedin'); ?>)</div>
	<div class="degree"><?php echo $v->degree; ?>, <?php echo $v->fieldOfStudy; ?></div>
	<?php if (isset($v->activities) && !empty($v->activities)): ?>
		<div class="activities"><em><?php _e('Activities and societies', 'wp-linkedin'); ?>:</em> <?php echo $v->activities; ?></div>
	<?php endif; ?>
	<?php if (isset($v->notes) && !empty($v->notes)): ?>
		<div class="notes"><?php echo wpautop($v->notes); ?></div>
	<?php endif; ?>
</div>
<?php endforeach; ?>
</div>