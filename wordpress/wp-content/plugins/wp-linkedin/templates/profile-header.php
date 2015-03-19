<div id ="cartouche" class="section">
	<a href="<?php echo esc_url($profile->publicProfileUrl); ?>"><img class="picture" src="<?php echo $profile->pictureUrl; ?>" width="80px" /></a>
	<div class="name"><a href="<?php echo esc_url($profile->publicProfileUrl); ?>"><?php echo $profile->firstName; ?> <?php echo $profile->lastName; ?></a></div>
	<div class="headline"><?php echo $profile->headline; ?></div>
	<div class="location"><?php echo $profile->location->name; ?> | <?php echo $profile->industry; ?></div>
</div>

<?php if (isset($profile->summary)): ?>
<div id="summary" class="section">
<div class="heading"><?php _e('Summary', 'wp-linkedin'); ?></div>
<div class="summary"><?php echo wpautop($profile->summary); ?></div>
</div>
<?php endif; ?>

<?php if (isset($profile->specialties)): ?>
<div id="specialties" class="section">
<div class="heading"><?php _e('Specialties', 'wp-linkedin'); ?></div>
<div class="specialties"><?php echo wpautop($profile->specialties); ?></div>
</div>
<?php endif;
