<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=ajax
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');


$id = cot_import('id', 'P', 'TXT');
$type = cot_import('type', 'P', 'TXT');
$text = cot_import('text', 'P', 'TXT');

if ($id != 0)
{
	$sql = $db->query("SELECT * FROM $db_projects_offers WHERE offer_pid=" . $id . " AND offer_userid=" . $usr['id'] . "");
	
  if ($sql->fetchColumn() != 0 || $usr['maingrp'] == 5);
  {
    $offerupd['offer_date'] = (int)$sys['now'];
   	if ($type == 'cost')
    {
     	$offerupd['offer_cost'] = (float)$text;
		}
    elseif ($type == 'time_min')
    {
      $offerupd['offer_time_min'] = (int)$text;
    }
    elseif ($type == 'time_max')
    {
      $offerupd['offer_time_max'] = (int)$text;
    }
    elseif ($type == 'text')
    { 
      $offerupd['offer_text'] = $text;
    }  

    $result = $db->update($db_projects_offers, $offerupd, 'offer_id=?', $id);
  }  
}

