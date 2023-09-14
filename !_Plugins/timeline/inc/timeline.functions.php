<?php

/** 
   
  Разработка сайтов на cotonti, готовые плагины - cotontidev.ru
   
**/

global $db_timeline, $db_x;
$db_timeline = (isset($db_timeline)) ? $db_timeline : $db_x . 'timeline';

require_once cot_langfile('timeline', 'plug');

function cot_add_timeline($usrid = 0, $itemid = 0, $ext = '', $type = '', $text = '')
{
	global $db, $db_timeline, $cfg, $L, $sys;

  $ritem['item_userid'] = $usrid;
  $ritem['item_date'] = $sys['now'];
  $ritem['item_ext'] = $ext;
  $ritem['item_type'] = $type;
  $ritem['item_text'] = $text;
  $ritem['item_itemid'] = $itemid;
  
  $db->insert($db_timeline, $ritem);
}

function cot_get_timeline($usrid = 0, $tpl = '')
{
	global $db, $db_timeline, $cfg, $L, $db_users;

  if($usrid == 0 && $tpl == '')
  {
	 $t1 = new XTemplate(cot_tplfile(array('timeline', 'index'), 'plug'));
                                             
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
		  $t1->assign(array(
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
	 	  $t1->parse('MAIN.TIMELINE'); 
      $jj--;
    }
	 } 
  }
  else
  {
  
	$t1 = new XTemplate(cot_tplfile(array('timeline', $tpl), 'plug'));

  $where['item_userid'] = 'item_userid='.$usrid;
  $where['item_type'] = 'item_type!="register"';
                                             
  $tlarray = array();  
  foreach ($cfg['plugin']['timeline'] as $key => $value)
	{ 
    if($value == 'main' || $value == 'none')
    {  
		 $tlarray[] = $key;
	  }
  }
  $where = ($where) ? 'WHERE ' . implode(' AND ', $where) : '';
  
	$tlrow = $db->query("SELECT * FROM $db_timeline
		" . $where . " ORDER BY item_date DESC")->fetchAll();

	$jj = count($tlrow);

	foreach ($tlrow as $row)
	{  
     $success = (is_array($tlarray)) ? !in_array($row['item_ext'].'_'.$row['item_type'], $tlarray): true;
     if($success)
     {  
		  $t1->assign(array(
       'TIMELINE_ROW_ID' => $row['item_id'],
       'TIMELINE_ROW_NUM' => $jj,
       'TIMELINE_ROW_DATE_STAMP' => $row['item_date'],
       'TIMELINE_ROW_DATE' => cot_date('d.m.y', $row['item_date']),
       'TIMELINE_ROW_TIME' => cot_date('time_medium', $row['item_date']),
       'TIMELINE_ROW_TEXT' => $L['timeline_'.$row['item_ext'].'_'.$row['item_type'].'_details'],
       'TIMELINE_ROW_EXT' => $row['item_ext'],
       'TIMELINE_ROW_TYPE' => $row['item_type'],
       'TIMELINE_ROW_INFO' => cot_get_timeline_info($row['item_ext'], $row['item_type'], $row['item_itemid']),
       'TIMELINE_ROW_ODDEVEN' => cot_build_oddeven($jj)
      ));
	 	  $t1->parse('MAIN.TIMELINE'); 
      $jj--;
    }
	}
	
   $tlrow = $db->query("SELECT user_regdate FROM $db_users
		  WHERE user_id=".$usrid." LIMIT 1")->fetch();
        
   $t1->assign(array(
     'TIMELINE_ROW_DATE_STAMP' => $tlrow['user_regdate'],
     'TIMELINE_ROW_DATE' => cot_date('d.m.y', $tlrow['user_regdate']),
     'TIMELINE_ROW_TIME' => cot_date('time_medium', $tlrow['user_regdate']),
   ));
	 $t1->parse('MAIN.REGISTRATION'); 
  }
    
	$t1->parse('MAIN');
	return $t1->text('MAIN');
}

function cot_get_timeline_info($ext, $type, $id)
{
	global $db, $db_timeline, $db_users, $db_reviews;
  
	$t1 = new XTemplate(cot_tplfile(array('timeline', 'info'), 'plug'));
  
  if($id)
  {  
   if($ext == 'projects' || $ext == 'payprjbold' || $ext == 'payprjtop')
   {
    require_once cot_incfile('projects', 'module');
    $t1->assign(cot_generate_projecttags($id, 'ITEM_'));
    $t1->parse('MAIN.PROJECTS'); 
   }
   elseif($ext == 'reviews')
   {
    require_once cot_incfile('reviews', 'plug');
    $item = $db->query("SELECT * FROM $db_reviews
			WHERE item_code=" . (int)$id . " LIMIT 1")->fetch();
    
    $t1->assign(cot_generate_usertags($item['item_touserid'], 'ITEM_TOUSER_'));
    $t1->assign(array(
				'ITEM_TEXT' => $item['item_text'],
				'ITEM_SCORE' => ($item['item_score'] > 0) ? '+' . $item['item_score'] : $item['item_score'],
			));  
    
    $t1->parse('MAIN.REVIEWS'); 
   }
   elseif($ext == 'market')
   {
    require_once cot_incfile('market', 'module');
    $t1->assign(cot_generate_markettags($id, 'ITEM_'));
    $t1->parse('MAIN.MARKET'); 
   }
   elseif($ext == 'folio')
   {
    require_once cot_incfile('folio', 'module');
    $t1->assign(cot_generate_foliotags($id, 'ITEM_'));
    $t1->parse('MAIN.FOLIO'); 
   }
 
	 $t1->parse('MAIN');
	 return $t1->text('MAIN');
  }
  else
  {
   return '';
  }
}

/** 
   
  Разработка сайтов на cotonti, готовые плагины - cotontidev.ru
   
**/

?>
