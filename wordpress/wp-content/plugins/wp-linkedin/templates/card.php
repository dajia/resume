<div class="linkedin"><div class="card">
<div id="cartouche">
	<div><a href="<?php echo esc_url($profile->publicProfileUrl); ?>"><img class="picture alignleft" src="<?php echo $profile->pictureUrl; ?>" width="<?php echo $picture_width; ?>px"></a></div>
	<div class="name"><a href="<?php echo esc_url($profile->publicProfileUrl); ?>"><?php echo $profile->firstName; ?> <?php echo $profile->lastName; ?></a></div>
	<div class="headline"><?php echo $profile->headline; ?></div>
</div>

<?php if (isset($profile->summary) && $summary_length): ?>
<div class="summary"><?php echo wpautop(wp_linkedin_excerpt($profile->summary, $summary_length)); ?></div>
<?php endif; ?>

</div>
<?php if (LI_DEBUG): ?>
<!--
<?php echo json_encode($profile); ?>
-->
<?php endif; ?>
</div>
