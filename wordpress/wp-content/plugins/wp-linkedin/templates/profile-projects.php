<div id="projects" class="section">
<div class="heading"><?php _e('Projects', 'wp-linkedin'); ?></div>
<?php foreach ($profile->projects->values as $v): ?>
<div class="project"><?php
	$name = $v->name;
	if (!empty($v->url)) $name = "<a href=\"{$v->url}\" target=\"_blank\">{$v->name}</a>";
	?>
	<div class="title"><strong><?php echo $name; ?></strong> (<?php echo $v->startDate->year; ?> - <?php echo isset($v->endDate) ? $v->endDate->year : __('Present', 'wp-linkedin'); ?>)</div>
	<?php if (isset($v->members->values) && is_array($v->members->values) && count($v->members->values) > 1): ?>
	<div class="project-members">
		<div class="count"><?php printf(__('%d team members', 'wp-linkedin'), count($v->members->values)); ?></div><?php
		foreach ($v->members->values as $m):
			$p = isset($m->person) ? $m->person : null;
			$pictureUrl = (isset($p->pictureUrl)) ? $p->pictureUrl : 'http://www.gravatar.com/avatar/?s=80&f=y&d=mm';

			if (isset($m->name)) {
				$name = $m->name;
			} elseif ($p->publicProfileUrl) {
				$name = $p->firstName . ' ' . $p->lastName;
			} else {
				$name = __('Anonymous', 'wp-linkedin');
			}

			if (isset($p->headline)) $name .= ' - ' . $p->headline;

			if (isset($p->publicProfileUrl)): ?>
				<a href="<?php echo esc_url($p->publicProfileUrl); ?>"
					target="_blank"><img src="<?php echo esc_url($pictureUrl); ?>"
					alt="<?php echo $name; ?>" title="<?php echo $name; ?>"></a><?php
			else: ?>
				<img src="<?php echo esc_url($pictureUrl); ?>"
					alt="<?php echo $name; ?>" title="<?php echo $name; ?>"><?php
			endif;
		endforeach; ?>
	</div>
	<?php endif; ?>
	<?php if (isset($v->description)): ?>
	<div class="summary"><?php echo wpautop($v->description); ?></div>
	<?php endif; ?>
	</div>
<?php endforeach; ?>
</div>