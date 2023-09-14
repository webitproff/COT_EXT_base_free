<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=tools
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('searchforms', 'plug');

$a = cot_import('a', 'G', 'TXT');
$n = cot_import('n', 'G', 'TXT');

if($a == 'add')
{
 $code = cot_import('rcode', 'P', 'TXT');

 $set_tmp = cot_import('rform_modules', 'P', 'ARR');
 unset($set_tmp['nullval']);

 if(count($set_tmp) == 0)
 {
   cot_error('Укажите хотя бы один из модулей', 'rcode');
 }
 else
 {
   if(empty($code)) $code = 'default';

   $set = array();
   foreach($set_tmp as $tm)
   {
     $set[$tm] = array('search' => array(), 'sort' => array());
     foreach(cot_import('rsetup_'.$tm.'_serach', 'P', 'ARR') as $ts => $val)
     {
       if($val == 1) $set[$tm]['search'][] = $ts;
     }
     foreach(cot_import('rsetup_'.$tm.'_sort', 'P', 'ARR') as $ts => $val)
     {
       if($val == 1) $set[$tm]['sort'][] = $ts;
     }
   }

  $db->insert($db_searchforms, array('form_code' => $code, 'form_set' => json_encode($set)));
 }
 cot_redirect(cot_url('admin', 'm=other&p=searchforms', '', true));
}
elseif($a == 'del')
{
 $id = cot_import('id', 'G', 'INT');
 $db->delete($db_searchforms, 'form_id='.$id);
 cot_redirect(cot_url('admin', 'm=other&p=searchforms', '', true));
}

if($n == 'preview')
{
  $code = cot_import('code', 'G', 'TXT');
  echo cot_searchforms_show($code);
}
else
{
  $t = new XTemplate(cot_tplfile('searchforms.admin', 'plug', true));

  $t->assign(array(
    'FORM_ADD_MODULES' => cot_checklistbox('', 'rform_modules', array_keys($searchforms_cfg), array_keys($searchforms_cfg)),
  ));

  /** PAGE **/
  $t->assign(array(
  	'FORM_MOD_PAGE_SEARCH_CAT' => cot_radiobox(0, 'rsetup_page_serach[page_cat]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_PAGE_SEARCH_KEYWORDS' => cot_radiobox(0, 'rsetup_page_serach[page_keywords]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_PAGE_SEARCH_TITLE' => cot_radiobox(0, 'rsetup_page_serach[page_title]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_PAGE_SEARCH_DESC' => cot_radiobox(0, 'rsetup_page_serach[page_desc]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_PAGE_SEARCH_AUTHOR' => cot_radiobox(0, 'rsetup_page_serach[page_author]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_PAGE_SEARCH_TEXT' => cot_radiobox(0, 'rsetup_page_serach[page_text]', array(0, 1), array('Выкл', 'Вкл')),

  	'FORM_MOD_PAGE_SEARCH_ID' => cot_radiobox(0, 'rsetup_page_serach[page_id]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_PAGE_SEARCH_METATITLE' => cot_radiobox(0, 'rsetup_page_serach[page_metatitle]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_PAGE_SEARCH_METADESC' => cot_radiobox(0, 'rsetup_page_serach[page_metadesc]', array(0, 1), array('Выкл', 'Вкл')),

  	'FORM_MOD_PAGE_SORT_CAT' => cot_radiobox(0, 'rsetup_page_sort[page_cat]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_PAGE_SORT_KEYWORDS' => cot_radiobox(0, 'rsetup_page_sort[page_keywords]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_PAGE_SORT_TITLE' => cot_radiobox(0, 'rsetup_page_sort[page_title]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_PAGE_SORT_DESC' => cot_radiobox(0, 'rsetup_page_sort[page_desc]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_PAGE_SORT_AUTHOR' => cot_radiobox(0, 'rsetup_page_sort[page_author]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_PAGE_SORT_DATE' => cot_radiobox(0, 'rsetup_page_sort[page_date]', array(0, 1), array('Выкл', 'Вкл')),

  	'FORM_MOD_PAGE_SORT_ID' => cot_radiobox(0, 'rsetup_page_sort[page_id]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_PAGE_SORT_HITS' => cot_radiobox(0, 'rsetup_page_sort[page_count]', array(0, 1), array('Выкл', 'Вкл')),
  ));

  foreach($cot_extrafields[$db_pages] as $exfld)
  {
   if($exfld['field_type'] != 'file')
   {
  	$uname = strtoupper($exfld['field_name']);
  	$exfld_title = isset($L['pages_'.$exfld['field_name'].'_title']) ?  $L['pages_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
    $t->assign(array(
      'FORM_MOD_PAGE_SEARCH_EXTRAFLD_TITLE' => ($exfld_title) ? $exfld_title : '"'.$uname.'" <b>Нет названия поля!</b>',
      'FORM_MOD_PAGE_SEARCH_EXTRAFLD' => cot_radiobox(0, 'rsetup_page_serach[page_'.$uname.']', array(0, 1), array('Выкл', 'Вкл')),
      'FORM_MOD_PAGE_SORT_EXTRAFLD' => cot_radiobox(0, 'rsetup_page_sort[page_'.$uname.']', array(0, 1), array('Выкл', 'Вкл')),
    ));
    $searchforms_cfg['page']['search']['page_'.$uname] = array('title' => (($exfld_title) ? $exfld_title : $uname), 'tag' => 'PAGE_SEARCH_'.$uname);
    $searchforms_cfg['page']['sort']['page_'.$uname] = array('title' => (($exfld_title) ? $exfld_title : $uname), 'tag' => 'PAGE_SORT_'.$uname);
    $t->parse('MAIN.PAGEEXTRA');
   }
  }
  /** PAGE **/

  /** MARKET **/
  $t->assign(array(
  	'FORM_MOD_MARKET_SEARCH_CAT' => cot_radiobox(0, 'rsetup_market_serach[item_cat]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_MARKET_SEARCH_TITLE' => cot_radiobox(0, 'rsetup_market_serach[item_title]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_MARKET_SEARCH_TEXT' => cot_radiobox(0, 'rsetup_market_serach[item_text]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_MARKET_SEARCH_COST' => cot_radiobox(0, 'rsetup_market_serach[item_cost]', array(0, 1), array('Выкл', 'Вкл')),

    'FORM_MOD_MARKET_SEARCH_ID' => cot_radiobox(0, 'rsetup_market_serach[item_id]', array(0, 1), array('Выкл', 'Вкл')),

  	'FORM_MOD_MARKET_SORT_CAT' => cot_radiobox(0, 'rsetup_market_sort[item_cat]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_MARKET_SORT_TITLE' => cot_radiobox(0, 'rsetup_market_sort[item_title]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_MARKET_SORT_COST' => cot_radiobox(0, 'rsetup_market_sort[item_cost]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_MARKET_SORT_DATE' => cot_radiobox(0, 'rsetup_market_sort[item_date]', array(0, 1), array('Выкл', 'Вкл')),

  	'FORM_MOD_MARKET_SORT_ID' => cot_radiobox(0, 'rsetup_market_sort[item_id]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_MARKET_SORT_UPDATE' => cot_radiobox(0, 'rsetup_market_sort[item_update]', array(0, 1), array('Выкл', 'Вкл')),
  ));

  foreach($cot_extrafields[$db_market] as $exfld)
  {
   if($exfld['field_type'] != 'file')
   {
  	$uname = strtoupper($exfld['field_name']);
  	$exfld_title = isset($L['market_'.$exfld['field_name'].'_title']) ?  $L['market_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
    $t->assign(array(
      'FORM_MOD_MARKET_SEARCH_EXTRAFLD_TITLE' => ($exfld_title) ? $exfld_title : '"'.$uname.'" <b>Нет названия поля!</b>',
      'FORM_MOD_MARKET_SEARCH_EXTRAFLD' => cot_radiobox(0, 'rsetup_market_serach[item_'.$uname.']', array(0, 1), array('Выкл', 'Вкл')),
      'FORM_MOD_MARKET_SORT_EXTRAFLD' => cot_radiobox(0, 'rsetup_market_sort[item_'.$uname.']', array(0, 1), array('Выкл', 'Вкл')),
    ));
    $searchforms_cfg['market']['search']['item_'.$uname] = array('title' => (($exfld_title) ? $exfld_title : $uname), 'tag' => 'MARKET_SEARCH_'.$uname);
    $searchforms_cfg['market']['sort']['item_'.$uname] = array('title' => (($exfld_title) ? $exfld_title : $uname), 'tag' => 'MARKET_SORT_'.$uname);
    $t->parse('MAIN.MARKETEXTRA');
   }
  }
  /** MARKET **/

  /** PROJECTS **/
  $t->assign(array(
  	'FORM_MOD_PROJECTS_SEARCH_CAT' => cot_radiobox(0, 'rsetup_projects_serach[item_cat]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_PROJECTS_SEARCH_TITLE' => cot_radiobox(0, 'rsetup_projects_serach[item_title]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_PROJECTS_SEARCH_TEXT' => cot_radiobox(0, 'rsetup_projects_serach[item_text]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_PROJECTS_SEARCH_COST' => cot_radiobox(0, 'rsetup_projects_serach[item_cost]', array(0, 1), array('Выкл', 'Вкл')),

  	'FORM_MOD_PROJECTS_SEARCH_ID' => cot_radiobox(0, 'rsetup_projects_serach[item_id]', array(0, 1), array('Выкл', 'Вкл')),

  	'FORM_MOD_PROJECTS_SORT_CAT' => cot_radiobox(0, 'rsetup_projects_sort[item_cat]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_PROJECTS_SORT_TITLE' => cot_radiobox(0, 'rsetup_projects_sort[item_title]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_PROJECTS_SORT_COST' => cot_radiobox(0, 'rsetup_projects_sort[item_cost]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_PROJECTS_SORT_DATE' => cot_radiobox(0, 'rsetup_projects_sort[item_date]', array(0, 1), array('Выкл', 'Вкл')),

  	'FORM_MOD_PROJECTS_SORT_ID' => cot_radiobox(0, 'rsetup_projects_sort[item_id]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_PROJECTS_SORT_UPDATE' => cot_radiobox(0, 'rsetup_projects_sort[item_update]', array(0, 1), array('Выкл', 'Вкл')),
  ));

  foreach($cot_extrafields[$db_projects] as $exfld)
  {
   if($exfld['field_type'] != 'file')
   {
  	$uname = strtoupper($exfld['field_name']);
  	$exfld_title = isset($L['projects_'.$exfld['field_name'].'_title']) ?  $L['projects_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
    $t->assign(array(
      'FORM_MOD_PROJECTS_SEARCH_EXTRAFLD_TITLE' => ($exfld_title) ? $exfld_title : '"'.$uname.'" <b>Нет названия поля!</b>',
      'FORM_MOD_PROJECTS_SEARCH_EXTRAFLD' => cot_radiobox(0, 'rsetup_projects_serach[item_'.$uname.']', array(0, 1), array('Выкл', 'Вкл')),
      'FORM_MOD_PROJECTS_SORT_EXTRAFLD' => cot_radiobox(0, 'rsetup_projects_sort[item_'.$uname.']', array(0, 1), array('Выкл', 'Вкл')),
    ));
    $searchforms_cfg['projects']['search']['item_'.$uname] = array('title' => (($exfld_title) ? $exfld_title : $uname), 'tag' => 'PROJECTS_SEARCH_'.$uname);
    $searchforms_cfg['projects']['sort']['item_'.$uname] = array('title' => (($exfld_title) ? $exfld_title : $uname), 'tag' => 'PROJECTS_SORT_'.$uname);
    $t->parse('MAIN.PROJECTSEXTRA');
   }
  }
  /** PROJECTS **/

  /** DEMANDS **/
  $t->assign(array(
  	'FORM_MOD_DEMANDS_SEARCH_CAT' => cot_radiobox(0, 'rsetup_demands_serach[item_cat]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_DEMANDS_SEARCH_TITLE' => cot_radiobox(0, 'rsetup_demands_serach[item_title]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_DEMANDS_SEARCH_TEXT' => cot_radiobox(0, 'rsetup_demands_serach[item_text]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_DEMANDS_SEARCH_COST' => cot_radiobox(0, 'rsetup_demands_serach[item_cost]', array(0, 1), array('Выкл', 'Вкл')),

  	'FORM_MOD_DEMANDS_SEARCH_ID' => cot_radiobox(0, 'rsetup_demands_serach[item_id]', array(0, 1), array('Выкл', 'Вкл')),

  	'FORM_MOD_DEMANDS_SORT_CAT' => cot_radiobox(0, 'rsetup_demands_sort[item_cat]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_DEMANDS_SORT_TITLE' => cot_radiobox(0, 'rsetup_demands_sort[item_title]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_DEMANDS_SORT_COST' => cot_radiobox(0, 'rsetup_demands_sort[item_cost]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_DEMANDS_SORT_DATE' => cot_radiobox(0, 'rsetup_demands_sort[item_date]', array(0, 1), array('Выкл', 'Вкл')),

  	'FORM_MOD_DEMANDS_SORT_ID' => cot_radiobox(0, 'rsetup_demands_sort[item_id]', array(0, 1), array('Выкл', 'Вкл')),
  	'FORM_MOD_DEMANDS_SORT_UPDATE' => cot_radiobox(0, 'rsetup_demands_sort[item_update]', array(0, 1), array('Выкл', 'Вкл')),
  ));

  foreach($cot_extrafields[$db_demands] as $exfld)
  {
   if($exfld['field_type'] != 'file')
   {
  	$uname = strtoupper($exfld['field_name']);
  	$exfld_title = isset($L['demands_'.$exfld['field_name'].'_title']) ?  $L['demands_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
    $t->assign(array(
      'FORM_MOD_DEMANDS_SEARCH_EXTRAFLD_TITLE' => ($exfld_title) ? $exfld_title : '"'.$uname.'" <b>Нет названия поля!</b>',
      'FORM_MOD_DEMANDS_SEARCH_EXTRAFLD' => cot_radiobox(0, 'rsetup_demands_serach[item_'.$uname.']', array(0, 1), array('Выкл', 'Вкл')),
      'FORM_MOD_DEMANDS_SORT_EXTRAFLD' => cot_radiobox(0, 'rsetup_demands_sort[item_'.$uname.']', array(0, 1), array('Выкл', 'Вкл')),
    ));
    $searchforms_cfg['demands']['search']['item_'.$uname] = array('title' => (($exfld_title) ? $exfld_title : $uname), 'tag' => 'DEMANDS_SEARCH_'.$uname);
    $searchforms_cfg['demands']['sort']['item_'.$uname] = array('title' => (($exfld_title) ? $exfld_title : $uname), 'tag' => 'DEMANDS_SORT_'.$uname);
    $t->parse('MAIN.DEMANDSEXTRA');
   }
  }
  /** DEMANDS **/

  $searchforms = $db->query("SELECT * FROM $db_searchforms ORDER BY form_id DESC")->fetchAll();
  foreach($searchforms as $form)
  {
    $form['form_set'] = json_decode($form['form_set'], 1);
    foreach($form['form_set'] as $area => $tags)
    {
     $t->assign(array(
      'AREA' => $area,
     ));

     foreach($tags['search'] as $tg)
     {
       $t->assign(array(
        'NAME' => $searchforms_cfg[$area]['search'][$tg]['title'],
        'TAG' => '{'.$searchforms_cfg[$area]['search'][$tg]['tag'].'}',
        'TYPE' => 'Поиск',
       ));
       $t->parse('MAIN.FORM_ROW.FORM_TAGS');
     }
     foreach($tags['sort'] as $tg)
     {
       $t->assign(array(
        'NAME' => $searchforms_cfg[$area]['sort'][$tg]['title'],
        'TAG' => '{'.$searchforms_cfg[$area]['sort'][$tg]['tag'].'}',
        'TYPE' => 'Сортировка',
       ));
       $t->parse('MAIN.FORM_ROW.FORM_TAGS');
     }
    }

    $t->assign(array(
    	'FORM_ROW_DEL_URL' => cot_url('admin', 'm=other&p=searchforms&a=del&id='.$form['form_id']),
      'FORM_ROW_SHOW_URL' => cot_url('admin', 'm=other&p=searchforms&n=preview&code='.$form['form_code']),
    	'FORM_ROW_ID' => $form['form_id'],
    	'FORM_ROW_CODE' => $form['form_code'],
      'FORM_ROW_TAG' => '{PHP|cot_searchforms_show("'.$form['form_code'].'")}'
    ));
  	$t->parse('MAIN.FORM_ROW');
  }

  cot_display_messages($t);

  $t->parse('MAIN');
  $adminmain = $t->text('MAIN');
}
