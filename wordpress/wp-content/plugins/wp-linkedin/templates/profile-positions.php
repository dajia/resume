<div id="positions" class="section">
<div class="heading"><?php _e('Experience', 'wp-linkedin'); ?></div>
<?php foreach ($profile->positions->values as $v): ?>
<div class="position">
	<div class="title"><strong><?php echo $v->title; ?></strong> (<?php echo $v->startDate->year; ?> - <?php echo isset($v->endDate) ? $v->endDate->year : __('Present', 'wp-linkedin'); ?>)</div>
	<div class="company"><?php echo $v->company->name; ?></div><?php
	$industry = array();
	if (isset($v->company->type)) $industry[] = $v->company->type;
	if (isset($v->company->size)) $industry[] = $v->company->size;
	if (isset($v->company->industry)) $industry[] = $v->company->industry;
	if (!empty($industry)): ?>
	<div class="industry"><?php echo implode(', ', $industry); ?></div> <?php
	endif;
	if (isset($v->summary)): ?>
	<div class="summary"><?php echo wpautop($v->summary); ?></div>
	<?php endif; ?>
</div>
<?php endforeach; ?>
</div>