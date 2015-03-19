<?php
if (!function_exists('li_profile_name')) {
	function li_profile_name($v) {
		if ($v->firstName != 'private') {
			$fullName = $v->firstName . ' ' . $v->lastName;
		} else {
			$fullName = __('Anonymous', 'wp-linkedin');
		}

		if (isset($v->siteStandardProfileRequest->url)) {
			return sprintf('<a href="%s">%s</a>', esc_url($v->siteStandardProfileRequest->url), $fullName);
		} else {
			return $fullName;
		}
	}
}

if (!function_exists('li_find_links')) {
	function li_find_links($v) {
		$regex = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/i';
		return preg_replace($regex, '<a href="\\0">\\0</a>', $v);
	}
}
?>

<div class="linkedin">
<?php if (is_array($updates->values) && !empty($updates->values)):?>
<ul class="updates"><?php foreach ($updates->values as $update):
if (!isset($update->updateContent->person)) continue;
$p = $update->updateContent->person;
if ($p->firstName == 'private') continue;
$profile_name = li_profile_name($p);

switch ($update->updateType) {
	case 'CONN':
		$conn = array();
		foreach ($p->connections->values as $c) {
			$conn[] = li_profile_name($c);
		}
		echo '<li class="type-'.strtolower($update->updateType) . '">';
		printf(__('%1$s is now connected to %2$s.', 'wp-linkedin'), $profile_name, implode(', ', $conn));
		echo '</li>';

		break;
	case 'NCON':
		echo '<li class="type-'.strtolower($update->updateType) . '">';
		printf(__('%s is now a connection.', 'wp-linkedin'), $profile_name);
		echo '</li>';
		break;
	case 'CCEM':
		echo '<li class="type-'.strtolower($update->updateType) . '">';
		printf(__('%s has joined LinkedIn.', 'wp-linkedin'), $profile_name);
		echo '</li>';
		break;
	case 'SHAR':
		echo '<li class="type-'.strtolower($update->updateType) . '">';
		printf(__('%1$s says: %2$s', 'wp-linkedin'), $profile_name, li_find_links($p->currentShare->comment));
		echo '</li>';
		break;
	case 'STAT':
		echo '<li class="type-'.strtolower($update->updateType) . '">';
		printf(__('%1$s says: %2$s', 'wp-linkedin'), $profile_name, li_find_links($p->currentStatus));
		echo '</li>';
		break;
	case 'VIRL':
		echo '<li class="type-'.strtolower($update->updateType) . '">';
		$like = $update->updateContent->updateAction->originalUpdate->updateContent->person;
		$author = li_profile_name($like);
		printf(__('%1$s likes: %2$s by %3$s', 'wp-linkedin'), $profile_name,
				li_find_links($like->currentShare->comment), $author);
		echo '</li>';
		break;
	case 'JGRP':
		$groups = array();
		foreach ($p->memberGroups->values as $g) {
			$groups[] = $g->name;
		}
		echo '<li class="type-'.strtolower($update->updateType) . '">';
		printf(_n('%1$s joined the group %2$s.', '%1$s joined the groups %2$s.', count($groups), 'wp-linkedin'),
				$profile_name, implode(', ', $groups));
		echo '</li>';

		break;
	case 'APPS':
	case 'APPM':
		foreach ($p->personActivities->values as $a) {
			echo '<li class="type-'.strtolower($update->updateType) . '">';
			echo $a->body;
			echo '</li>';
		}
		break;
	case 'PICU':
		echo '<li class="type-'.strtolower($update->updateType) . '">';
		printf(__('%s has a new profile picture.', 'wp-linkedin'), $profile_name);
		echo '</li>';
		break;
	case 'PROF':
	case 'PRFU':
	case 'PRFX':
		echo '<li class="type-'.strtolower($update->updateType) . '">';
		printf(__('%s has an updated profile.', 'wp-linkedin'), $profile_name);
		echo '</li>';
		break;
	case 'PREC':
	case 'SVPR':
		$reco = array();
		foreach ($p->recommendationsGiven->values as $r) {
			$reco[] = li_profile_name($r->recommendee);
		}
		echo '<li class="type-'.strtolower($update->updateType) . '">';
		printf(__('%1$s recommends %2$s.', 'wp-linkedin'), $profile_name, implode(', ', $reco));
		echo '</li>';
		break;
	case 'JOBP':
		$j = $update->updateContent->job;
		$p = $j->jobPoster;
		echo '<li class="type-'.strtolower($update->updateType) . '">';
		printf(__('%1$s posted a job: %2$s at %3$s.', 'wp-linkedin'), $profile_name,
				$j->position->title, $j->company->name);
		echo '</li>';
		break;
	case 'MSFC':
		$p = $update->updateContent->companyPersonUpdate->person;
		echo '<li class="type-'.strtolower($update->updateType) . '">';
		printf(__('%1$s is now following %2$s.', 'wp-linkedin'), $profile_name,
				$update->updateContent->company->name);
		echo '</li>';
		break;
	case 'CMPY':
		echo '<li class="type-'.strtolower($update->updateType) . '">';
		printf(__('%s has an updated profile.', 'wp-linkedin'),
				$update->updateContent->company->name);
		echo '</li>';
		break;
	default:
		echo "<!--\n";
		echo json_encode($update);
		echo "\n-->";
}
?>
<?php endforeach; ?>
</ul>
<?php else: ?>
<p><?php _e('No updates', 'wp-lnkedin'); ?></p>
<?php endif; ?>

<?php if (LI_DEBUG): ?>
<!--
<?php echo json_encode($updates); ?>
-->
<?php endif; ?>
</div>
