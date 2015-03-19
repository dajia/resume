<div class="linkedin"><div class="profile"><?php
echo wp_linkedin_load_template('profile-header', array('profile' => $profile));

if (isset($profile->positions->values) &&
		is_array($profile->positions->values)) {
	echo wp_linkedin_load_template('profile-positions', array('profile' => $profile));
}

if (isset($profile->projects->values) &&
		is_array($profile->projects->values)) {
	echo wp_linkedin_load_template('profile-projects', array('profile' => $profile));
}

if (isset($profile->publications->values) &&
		is_array($profile->publications->values)) {
	echo wp_linkedin_load_template('profile-publications', array('profile' => $profile));
}

if (isset($profile->volunteer->volunteerExperiences->values) &&
		is_array($profile->volunteer->volunteerExperiences->values)) {
	echo wp_linkedin_load_template('profile-volunteer', array('profile' => $profile));
}

if (isset($profile->skills->values) &&
		is_array($profile->skills->values)) {
	echo wp_linkedin_load_template('profile-skills', array('profile' => $profile));
}

if (isset($profile->languages->values) &&
		is_array($profile->languages->values)) {
	echo wp_linkedin_load_template('profile-languages', array('profile' => $profile));
}

if (isset($profile->educations->values) &&
		is_array($profile->educations->values)) {
	echo wp_linkedin_load_template('profile-educations', array('profile' => $profile));
}

if (isset($profile->honorsAwards->values) &&
		is_array($profile->honorsAwards->values)) {
	echo wp_linkedin_load_template('profile-honors', array('profile' => $profile));
}

if (isset($profile->recommendationsReceived->values) &&
		is_array($profile->recommendationsReceived->values)) {
	echo wp_linkedin_load_template('profile-recommendations', array('profile' => $profile));
}

if (LI_DEBUG) {
	echo wp_linkedin_load_template('profile-debug', array('profile' => $profile));
}
?></div></div>
