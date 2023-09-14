<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=standalone
 * [END_COT_EXT]
 */

/** 
   
  Разработка сайтов на cotonti, готовые плагины - cotontidev.ru
   
**/

defined('COT_CODE') && defined('COT_PLUG') or die('Wrong URL');

require_once cot_incfile('timeline', 'plug');

$out['subtitle'] = $L['timeline_index'];

$t = new XTemplate(cot_tplfile(array('timeline', 'index'), 'plug'));

$tlarray = array();

  foreach ($cfg['plugin']['timeline'] as $key => $value)
	 {
    if($value == 'details' || $value == 'none')
    {
		 $tlarray[] = $key;
	  }
  }

  $where = ($where) ? 'WHERE ' . implode(' AND ', $where) : '';
  $limit = ($cfg['plugin']['timeline']['indexlimit'] > 0) ? 'LIMIT '.$cfg['plugin']['timeline']['indexlimit'] : '';

	$tlrow = $db->query("SELECT * FROM $db_timeline
		" . $where . " ORDER BY item_date DESC " . $limit . "")->fetchAll();

	$jj = count($tlrow);

	 foreach ($tlrow as $row)
	 { 
     $success = (is_array($tlarray)) ? !in_array($row['item_ext'].'_'.$row['item_type'], $tlarray): true;
     if($success)
     { 
		  $t->assign(array(
       'TIMELINE_ROW_ID' => $row['item_id'],
       'TIMELINE_ROW_USERID' => $row['item_userid'],
       'TIMELINE_ROW_NUM' => $jj,
       'TIMELINE_ROW_DATE_STAMP' => $row['item_date'],
       'TIMELINE_ROW_DATE' => cot_date('d.m.y', $row['item_date']),
       'TIMELINE_ROW_TIME' => cot_date('time_medium', $row['item_date']),
       'TIMELINE_ROW_TEXT' => $row['item_text'],
       'TIMELINE_ROW_EXT' => $row['item_ext'],
       'TIMELINE_ROW_TYPE' => $row['item_type'],
       'TIMELINE_ROW_INFO' => cot_get_timeline_info($row['item_ext'], $row['item_type'], $row['item_itemid']),
       'TIMELINE_ROW_ODDEVEN' => cot_build_oddeven($jj)
      ));
	 	  $t->parse('MAIN.TIMELINE');
      $jj--;
    }
	 
   }

?>