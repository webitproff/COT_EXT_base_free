<?php
/**
 * Ratings API
 *
 * @package ratingslike
 * @version 1.0
 * @authors Cotonti Team, CMSWorks Team
 * @copyright Copyright (c) Cotonti Team 2009-2012, CMSWorks Team
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

/**
 * Generates like ratings display for a given item
 *
 * @param string $ext_name Module or plugin code
 * @param string $code Item identifier
 * @param string $cat Item category code (optional)
 * @param bool $readonly Display as read-only
 * @return array Rendered HTML output for ratings and average integer value as an array with 2 elements
 * @global CotDB $db
 */
function cot_ratings_like_display($ext_name, $code, $cat = '')
{
	global $db, $db_ratings, $db_rated, $db_users, $db_pages, $db_com, $usr, $cfg, $usr, $sys, $L, $R;

	// Check permissions
	list($auth_read, $auth_write, $auth_admin) = cot_auth('plug', 'ratingslike');

	$enabled = cot_ratings_enabled($ext_name, $cat, $code);

	if (!$auth_read || !$enabled && !$auth_admin)
	{
		return array('', 0);
	}

	// Get current rating value
	$sql = $db->query("SELECT * FROM $db_ratings
		WHERE rating_area = ? AND rating_code = ? LIMIT 1",
		array($ext_name, $code));

	if ($row = $sql->fetch())
	{
		$rating_summ = $row['rating_summ'];
		$item_has_rating = true;
	}
	else
	{
		$item_has_rating = false;
		$rating_summ = 0;
	}

	// Check if the user has voted already for this item
	$already_voted = false;
	if ($usr['id'] > 0)
	{
		$sql1 = $db->query("SELECT rated_value FROM $db_rated
			WHERE rated_area = ? AND rated_code = ? AND rated_userid = ?",
			array($ext_name, $code, $usr['id']));

		if ($rated_value = $sql1->fetchColumn())
		{
			$already_voted = true;
			$rating_uservote = $L['rat_alreadyvoted'] . ' (' . $rated_value . ')';
		}
	}

	$t = new XTemplate(cot_tplfile('ratingslike', 'plug'));

	/* == Hook for the plugins == */
	foreach (cot_getextplugins('ratingslike.main') as $pl)
	{
		include $pl;
	}
	/* ===== */

	// Get some extra information about votes
	if ($item_has_rating)
	{
		$sql = $db->query("SELECT COUNT(*) FROM $db_rated
			WHERE rated_area = ? AND rated_code = ?",
			array($ext_name, $code));
		$rating_voters = $sql->fetchColumn();
		$rating_since = $L['rat_since'] . ' ' . cot_date('datetime_medium', $row['rating_creationdate']);
		$rating_since_stamp = $row['rating_creationdate'];
	}
	else
	{
		$rating_voters = 0;
		$rating_since = '';
		$rating_since_stamp = '';
	}
	
	// Assign tags
	$t->assign(array(
		'RATINGS_CODE' => $code,
		'RATINGS_SUMM' => number_format($rating_summ, 0, '', 0),
		'RATINGS_VOTERS' => $rating_voters,
		'RATINGS_SINCE' => $rating_since,
		'RATINGS_SINCE_STAMP' => $rating_since_stamp,
		'RATINGS_USERVOTE' => $rating_uservote
	));

	/* == Hook for the plugins == */
	foreach (cot_getextplugins('ratingslike.tags') as $pl)
	{
		include $pl;
	}
	/* ===== */
	
	$itemid = str_replace('like_', '', $code);
	
	switch($ext_name)
	{
		case 'page':
		$sql = $db->query("SELECT * FROM $db_pages
		WHERE page_id = ".(int)$itemid." AND page_ownerid = ".$usr['id']."");
		if($sql->fetchColumn() > 0) $isowner = true;
		break;
		
		case 'com':
		$sql = $db->query("SELECT * FROM $db_com
		WHERE com_id = ".(int)$itemid." AND com_authorid = ".$usr['id']."");
		if($sql->fetchColumn() > 0) $isowner = true;
		break;
	}

	// Render voting form
	$vote_block = (!$isowner && $auth_write && (!$already_voted || $cfg['plugin']['ratings']['ratings_allowchange'])) ? 'NOTVOTED.' : 'VOTED.';

	if ($vote_block == 'NOTVOTED.')
	{

		// 'r=ratings&area=' . $ext_name . '&code=' . $code.'&inr=send'
		$t->assign('RATINGS_VOTE_PLUS_URL', cot_url('plug', array(
			'r' => 'ratingslike',
			'inr' => 'send',
			'area' => $ext_name,
			'code' => $code,
			'cat' => $cat,
			'newrate' => 1
		)));
		$t->assign('RATINGS_VOTE_MINUS_URL', cot_url('plug', array(
			'r' => 'ratingslike',
			'inr' => 'send',
			'area' => $ext_name,
			'code' => $code,
			'cat' => $cat,
			'newrate' => -1
		)));
		$t->parse('LIKERATINGS.NOTVOTED');
	}
	else
	{
		$t->parse('LIKERATINGS.VOTED');
	}

	// Parse and return
	$t->parse('LIKERATINGS');
	$res = $t->text('LIKERATINGS');

	return array($res, $rating_summ);
}

?>
