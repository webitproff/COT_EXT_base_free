<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=ajax
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

$postid = cot_import('postid', 'P', 'TXT');
$text = cot_import('text', 'P', 'TXT');

if ($postid > 0 && ($usr['maingrp'] || $cfg['plugin']['editofferposts']['editusers']))
{
	$sql = $db->query("SELECT * FROM $db_projects_posts WHERE post_id=" . $postid . ($usr['maingrp'] != 5 ? " AND post_userid=" . $usr['id'] : ''));
	
  if ($sql->fetchColumn() > 0);
  {
    $db->update($db_projects_posts, array('post_text' => $text), 'post_id=?', $postid);
  }  
}

