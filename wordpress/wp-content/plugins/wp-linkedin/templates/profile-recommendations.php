<div id="recommendations" class="section">
<div class="heading"><?php _e('Recommendations', 'wp-linkedin'); ?></div>
<?php foreach ($profile->recommendationsReceived->values as $v): ?>
<blockquote>
	<div class="recommendation"><?php  echo nl2br($v->recommendationText); ?></div>
	<div class="recommender"><?php if (isset($v->recommender->publicProfileUrl)): ?>
		<a href="<?php echo esc_url($v->recommender->publicProfileUrl); ?>"
		target="_blank"><?php echo $v->recommender->firstName; ?> <?php echo $v->recommender->lastName; ?></a>
		<?php else: ?>
		<?php  _e('Anonymous', 'wp-linkedin'); ?>
	<?php endif; ?></div>
</blockquote>
<?php endforeach; ?>
</div>