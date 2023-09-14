<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=tools
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') or die('Wrong URL.');

$a = cot_import('a', 'G', 'TXT');

if ($a == 'edit')
{
	cot_shield_protect();
	
	$post_id = (int)cot_import('id', 'G', 'INT');
	$post_text['post_text'] = cot_import('text', 'G', 'TXT');
	
	if (!empty($post_text['post_text']) && !cot_error_found())
	{
    $db->update($db_projects_posts, $post_text, 'post_id=?', $post_id);
	}
}
else
{
$t_o = new XTemplate(cot_tplfile('offerspost', 'plug'));

require_once cot_incfile('projects', 'module');

if ($a == 'addpost')
{
	cot_shield_protect();
	
	$offer_post['post_pid'] = (int)cot_import('id', 'G', 'INT');
	$offer_post['post_oid'] = (int)cot_import('oid', 'G', 'INT');
	$offer_post['post_userid'] = (int)$usr['id'];
	$offer_post['post_date'] = (int)$sys['now'];
	$offer_post['post_text'] = cot_import('posttext', 'P', 'TXT');
	$offer_post['post_touser'] = (int)cot_import('touser', 'P', 'INT');
	
	if (!empty($offer_post['post_text']) && !cot_error_found())
	{
		$db->insert($db_projects_posts, $offer_post);
	}
	cot_redirect(cot_url('admin', 'm=other&p=offerspost', '', true)); 
	exit;
}


$sql = $db->query("SELECT * FROM $db_projects_posts ORDER BY post_date DESC");

$last_oid = array('0' => '0');
while ($post_t = $sql->fetch())
{
$newoffers = true;
foreach ($last_oid as $key => $value)
{
  if ($value == $post_t['post_oid'])
  {
   $newoffers = false;
  }
}

if ($newoffers)
{
$last_oid[] = $post_t['post_oid'];
$offers = $db->query("SELECT * FROM $db_projects_offers WHERE item_id=" . $post_t['post_oid'] . "")->fetch();

	$t_o->assign(cot_generate_usertags($offers['item_userid'], 'OFFER_ROW_OWNER_'));
	$t_o->assign(array(
		"OFFER_ROW_ID" => $offers['item_id'],
		"OFFER_ROW_DATE" => date('d.m.Y H:i', $offers['item_date']),
		"OFFER_ROW_TEXT" => cot_parse($offers['item_text']),
		"OFFER_ROW_COSTMIN" => number_format($offers['item_cost_min'], '0', '.', ' '),
		"OFFER_ROW_COSTMAX" => number_format($offers['item_cost_max'], '0', '.', ' '),
		"OFFER_ROW_TIMEMIN" => $offers['item_time_min'],
		"OFFER_ROW_TIMEMAX" => $offers['item_time_max'],
		"OFFER_ROW_TIMETYPE" => $L['offers_timetype'][$offers['item_time_type']],
		"OFFER_ROW_HIDDEN" => $offers['item_hidden'],
	));
  
  $t_o->assign(cot_generate_projecttags($offers['item_pid'], 'OFFER_ROW_PRJ_'));

		$sql_prjposts = $db->query("SELECT * FROM $db_projects_posts as p LEFT JOIN $db_users as u ON u.user_id=p.post_userid
			WHERE post_pid=" . $offers['item_pid'] . " AND post_oid=" . $offers['item_id'] . " ORDER BY post_id");

		while ($posts = $sql_prjposts->fetch())
		{
			$t_o->assign(cot_generate_usertags($posts, 'POST_ROW_OWNER_'));
			$t_o->assign(array(
				"POST_ROW_TEXT" => cot_parse($posts['post_text']),
				"POST_ROW_DATE" => date('d.m.y H:i', $posts['post_date']),
				"POST_ROW_ID" => $posts['post_id'],
				"POST_ROW_NEW" => $posts['post_new'],
			));

			$t_o->parse("MAIN.ROWS.POSTS.POSTS_ROWS");
		}

		$t_o->assign(array(
			"ADDPOST_ACTION_URL" => cot_url('admin', 'm=other&p=offerspost&id=' . $offers['item_pid'] . '&oid=' . $offers['item_id'] . '&a=addpost'),
			"ADDPOST_TEXT" => cot_textarea('posttext',  $offer_post['post_text'], 3, 60),
			"ADDPOST_OFFERID" => $offers['item_id'],
			"ADDPOST_ID" => $offers['item_pid'],

		));
		$t_o->parse("MAIN.ROWS.POSTS.POSTFORM");

		$t_o->parse("MAIN.ROWS.POSTS");
	
	$t_o->parse("MAIN.ROWS");
}
}


$t_o->parse('MAIN');
$adminmain = $t_o->text('MAIN');
}