<?php
	wp_enqueue_script('responsive-scrollable');
	shuffle($recommendations);
?>
<div class="linkedin">
	<div class="scrollable"
		data-width="<?php echo $width; ?>" data-interval="<?php  echo $interval; ?>"
		style='width:<?php echo (is_numeric($width)) ? "{$width}px" : '100%'; ?>'>
		<div class="items">
		<?php foreach ($recommendations as $recommendation): ?>
			<blockquote>
				<div class="recommendation"><?php echo nl2br(wp_linkedin_excerpt($recommendation->recommendationText, $length)); ?></div>
				<div class="recommender"><?php if (isset($recommendation->recommender->publicProfileUrl)): ?>
					<a href="<?php echo esc_url($recommendation->recommender->publicProfileUrl); ?>"
						target="_blank"><?php echo $recommendation->recommender->firstName; ?>
						<?php echo $recommendation->recommender->lastName; ?></a>
					<?php else: ?>
					<?php _e('Anonymous', 'wp-linkedin'); ?>
				<?php endif; ?></div>
			</blockquote>
		<?php  endforeach; ?>
		</div>
	</div>
<?php if (LI_DEBUG): ?>
<!--
<?php echo json_encode($recommendations); ?>
-->
<?php endif; ?>
</div>
