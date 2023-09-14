<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=tools
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('checkextrafields', 'plug');

$area = cot_import('area', 'G', 'TXT');

$a = cot_import('a', 'G', 'TXT');

if($a == 'add')
{
 $cat = cot_import('rchk_cat', 'P', 'TXT');
 $rset = cot_import('rchkset', 'P', 'ARR');

 if(empty($cat))
 {
   cot_error('Укажите категорию', 'rchk_cat');
 }
 else
 {
   if((bool)$db->query("SELECT COUNT(*) FROM $db_checkextrafields WHERE chk_area='".$area."' AND chk_cat='".$cat."'")->fetchColumn()) {
     cot_error('Для данной категории уже созадан конфигурация', 'rchk_cat');
   }
   else {
     $set = array();

     foreach($rset as $ts => $val)
     {
       if($val == 1) $set[] = $ts;
     }
     $db->insert($db_checkextrafields, array('chk_area' => $area, 'chk_cat' => $cat, 'chk_set' => json_encode($set)));
   }
 }
 cot_redirect(cot_url('admin', 'm=other&p=checkextrafields&area='.$area, '', true));
}
elseif($a == 'del')
{
 $id = cot_import('id', 'G', 'INT');
 $db->delete($db_checkextrafields, 'chk_id='.$id);
 cot_redirect(cot_url('admin', 'm=other&p=checkextrafields&area='.$area, '', true));
}

$t = new XTemplate(cot_tplfile('checkextrafields.admin', 'plug', true));

if(in_array($area, array('page', 'market', 'projects', 'demands'))) {

  $t->assign(array(
    'CHK_ADD_CATS' => cot_selectbox_structure($area, '', 'rchk_cat'),
  ));

  $db_chkarea = ($area == 'projects') ? $db_projects : (($area == 'demands') ? $db_demands : (($area == 'market') ? $db_market : $db_pages));

  foreach($cot_extrafields[$db_chkarea] as $exfld)
  {
   if($exfld['field_type'] != 'file')
   {
  	$uname = strtoupper($exfld['field_name']);
  	$exfld_title = isset($L[$area.'_'.$exfld['field_name'].'_title']) ?  $L[$area.'_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
    $t->assign(array(
      'CHK_MOD_EXTRAFLD_TITLE' => ($exfld_title) ? $exfld_title : '"'.$uname.'" <b>Нет названия поля!</b>',
      'CHK_MOD_EXTRAFLD' => cot_radiobox(0, 'rchkset['.$area.'_'.$uname.']', array(0, 1), array('Нет', 'Да')),
    ));
    $t->parse('MAIN.EXTRA_ROW');
   }
  }

  $checkextrafields = $db->query("SELECT * FROM $db_checkextrafields WHERE chk_area='".$area."' ORDER BY chk_id DESC")->fetchAll();
  foreach($checkextrafields as $form)
  {
    $form['chk_set'] = json_decode($form['chk_set'], 1);

    foreach($cot_extrafields[$db_chkarea] as $exfld)
    {
     if($exfld['field_type'] != 'file')
     {
    	$uname = strtoupper($exfld['field_name']);
    	$exfld_title = isset($L[$area.'_'.$exfld['field_name'].'_title']) ?  $L[$area.'_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
      $t->assign(array(
        'CHK_ROW_EXTRAFLD_TITLE' => ($exfld_title) ? $exfld_title : '"'.$uname.'" <b>Нет названия поля!</b>',
        'CHK_ROW_EXTRAFLD' => in_array($area.'_'.$uname, $form['chk_set']) ? 1 : 0,
      ));
      $t->parse('MAIN.CHK_ROW.EXTRA_ROW');
     }
    }
    $form['chk_cat'] = cot_structure_buildpath($area, $form['chk_cat']);
    $form['chk_cat'] = array_pop($form['chk_cat']);

    $t->assign(array(
    	'CHK_ROW_DEL_URL' => cot_url('admin', 'm=other&p=checkextrafields&a=del&area='.$area.'&id='.$form['chk_id']),
    	'CHK_ROW_ID' => $form['chk_id'],
      'CHK_ROW_SET' => $form['chk_set'],
    	'CHK_ROW_CAT' => $form['chk_cat'][1],
    ));
  	$t->parse('MAIN.CHK_ROW');
  }
}

cot_display_messages($t);

$t->parse('MAIN');
$adminmain = $t->text('MAIN');

