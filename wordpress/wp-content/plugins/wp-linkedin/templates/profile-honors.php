<div id="honors" class="section">
<div class="heading"><?php _e('Honors & Awards', 'wp-linkedin'); ?></div>
<?php foreach ($profile->honorsAwards->values as $v): ?>
<div class="honor">
	<div class="title"><strong><?php echo $v->name; ?></strong><?php
		if (isset($v->date)): ?> (<?php echo $v->date->year; ?>)<?php endif; ?></div>
	<?php if (isset($v->issuer)): ?><div class="issuer"><?php echo $v->issuer; ?></div><?php endif; ?>
	<?php if (isset($v->description)): ?>
		<div class="summary"><?php echo wpautop($v->description); ?></div>
	<?php endif; ?>
</div>
<?php endforeach; ?>
</div>