<div id="languages" class="section">
<div class="heading"><?php _e('Languages', 'wp-linkedin'); ?></div>
<ul>
<?php foreach ($profile->languages->values as $v): ?>
<li class="language"><?php echo $v->language->name; ?><?php
	if (isset($v->proficiency)):
		echo "<span class=\"proficiency\">{$v->proficiency->name}</span>";
	endif; ?></li>
<?php endforeach; ?>
</ul>
</div>