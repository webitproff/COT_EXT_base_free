<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=standalone
 * [END_COT_EXT]
 */

/**
 * ListPoints plugin
 *
 * @package listpoints
 * @version 1.0
 * @author Alexeev Vlad
 * @copyright Copyright (c) http://cmsworks.ru/users/alexvlad
 */
 
defined('COT_CODE') && defined('COT_PLUG') or die('Wrong URL');

require_once cot_incfile('listpoints', 'plug');

$out['subtitle'] = $L['ListPoints'];

($usr['id'] == 0) && cot_die();

$t = new XTemplate(cot_tplfile(array('listpoints'), 'plug'));

if($cfg['plugin']['listpoints']['authgroup'])
{
$pointauth = $db->query("SELECT sum(item_point) FROM $db_userpoints
		WHERE item_type='auth' AND item_userid=".$usr['id']."")->fetchColumn();
    
	$t->assign(array(
    'POINTS_ROW_AUTH_COUNT' => $pointauth,
  ));
    
	$t->parse('MAIN.POINTS_AUTH');
    
$pointrow = $db->query("SELECT * FROM $db_userpoints
		WHERE item_type!='auth' AND item_userid=".$usr['id']." ORDER BY item_date DESC")->fetchAll();
}
else
{
 $pointrow = $db->query("SELECT * FROM $db_userpoints
		WHERE item_userid=".$usr['id']." ORDER BY item_date DESC")->fetchAll();
}

$jj = count($pointrow);

foreach ($pointrow as $row)
	{
    $type = ($row['item_point'][0] == '-') ? '_minus' : '';
    $type = ($L['listpoints_'.$row['item_type'].$type]) ? $L['listpoints_'.$row['item_type'].$type] : $L['listpoints_'.$row['item_type']];
    $type = ($type) ? $type : $row['item_type'];
    
		$t->assign(array(
    'POINTS_ROW_NUM' => $jj,
    'POINTS_ROW_DATE' => cot_date('d.m.y', $row['item_date']),
    'POINTS_ROW_TYPE' => $type,
    'POINTS_ROW_POS' => ($row['item_point'][0] != '-') ? '+' : '-',
    'POINTS_ROW_COUNT' => str_replace('-', '', $row['item_point']),
    ));
		$t->parse('MAIN.POINTS');
    
    $jj--;
	}
  

?>