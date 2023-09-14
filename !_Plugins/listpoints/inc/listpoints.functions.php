<?php

/**
 * ListPoints plugin
 *
 * @package listpoints
 * @version 1.0
 * @author Alexeev Vlad
 * @copyright Copyright (c) http://cmsworks.ru/users/alexvlad
 */

global $db_userpoints, $db_x;
$db_userpoints = (isset($db_userpoints)) ? $db_userpoints : $db_x . 'userpoints';

require_once cot_langfile('listpoints', 'plug');

function cot_get_listpoints($usrid = 0, $tpl = '')
{
	global $db, $db_userpoints, $cfg, $L;

	$t1 = new XTemplate(cot_tplfile(array('listpoints', $tpl), 'plug'));

	if($cfg['plugin']['listpoints']['authgroup'])
	{
	$pointauth = $db->query("SELECT sum(item_point) FROM $db_userpoints
		WHERE item_type='auth' AND item_userid=".$usrid."")->fetchColumn();
    
	$t1->assign(array(
    'POINTS_ROW_AUTH_COUNT' => $pointauth,
  ));
    
	$t1->parse('MAIN.POINTS_AUTH');
    
	$pointrow = $db->query("SELECT * FROM $db_userpoints
		WHERE item_type!='auth' AND item_userid=".$usrid." ORDER BY item_date DESC")->fetchAll();
	}
	else
	{
	 $pointrow = $db->query("SELECT * FROM $db_userpoints
		WHERE item_userid=".$usrid." ORDER BY item_date DESC")->fetchAll();
	}

	$jj = count($pointrow);

	foreach ($pointrow as $row)
	{
    $type = ($row['item_point'][0] == '-') ? '_minus' : '';
    $type = ($L['listpoints_'.$row['item_type'].$type]) ? $L['listpoints_'.$row['item_type'].$type] : $L['listpoints_'.$row['item_type']];
    $type = ($type) ? $type : $row['item_type'];
    
		$t1->assign(array(
    'POINTS_ROW_NUM' => $jj,
    'POINTS_ROW_DATE' => cot_date('d.m.y', $row['item_date']),
    'POINTS_ROW_TYPE' => $type,
    'POINTS_ROW_POS' => ($row['item_point'][0] != '-') ? '+' : '-',
    'POINTS_ROW_COUNT' => str_replace('-', '', $row['item_point']),
    ));
		$t1->parse('MAIN.POINTS');
    
    $jj--;
	}
  
	$t1->parse('MAIN');
	return $t1->text('MAIN');
}


?>
