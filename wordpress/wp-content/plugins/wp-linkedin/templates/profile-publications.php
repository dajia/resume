<div id="publications" class="section">
<div class="heading"><?php _e('Publications', 'wp-linkedin'); ?></div>
<?php foreach ($profile->publications->values as $v): ?>
<div class="publication"><?php
		$title = '<strong>'.$v->title.'</strong>';
		if (isset($v->url)) $title = '<a href="'.esc_url($v->url).'">'.$title.'</a>';
		if (isset($v->date->year)) $title = $title.' ('.$v->date->year.')';
	?><div class="title"><?php echo $title; ?></div>
	<?php if (isset($v->publisher->name)): ?>
    <div class="publisher"><?php echo $v->publisher->name; ?></div>
    <?php endif; ?>
    <?php if (isset($v->authors->values)): ?>
    <div class="authors">
		<div class="count"><?php printf(__('%d authors', 'wp-linkedin'), count($v->authors->values)); ?></div><?php
		foreach ($v->authors->values as $m):
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
    <?php if (isset($v->summary) && !empty($v->summary)): ?>
    <div class="summary"><?php echo wpautop($v->summary); ?></div>
    <?php endif; ?>
</div>
<?php endforeach; ?>
</div>