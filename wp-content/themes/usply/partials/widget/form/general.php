<?
global $team, $locations, $website_settings, $forms;

global $team;
$team_members = $team->team_members;
$team_member = null;

if(isset($_GET['team_id'])) {
	$team_member = $team_members[$_GET['team_id']];
}
else {
	shuffle($team_members);
	foreach($team_members as $team_member) {
		if(
			true
			&& ($team_member->images->wide !== null)
			&& (array_sum(array_map(function($v) { return count($v); }, (array)$team_member->services)) > 0)
		) break;
	}
}
?>
<div class="widget widget-form form-general two-column hidden">
	<div class="content">
		<div class="inner-content">
			<article></article>
			<aside>
				<i class="icon-close"></i>
				<div class="h2 inherit"></div>
				<p class="h3 inherit"></p>
                <?= $forms->generateForm('general');  ?>
			</aside>
		</div>
	</div>
</div>