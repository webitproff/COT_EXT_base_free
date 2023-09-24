<?php defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('favoriteusers', 'plug');

global $db, $db_favorite_users, $db_users;

$infavu = $db->query("SELECT DISTINCT(f.favu_added_user_id) FROM {$db_favorite_users} AS f WHERE f.favu_added_user_id NOT IN(SELECT u.user_id FROM {$db_users} AS u) GROUP BY f.favu_added_user_id")->fetchAll(PDO::FETCH_COLUMN);

foreach ($infavu as $id) {
	$db->delete($db_favorite_users, "favu_added_user_id={$id}");
}