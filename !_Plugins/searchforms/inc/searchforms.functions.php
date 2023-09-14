<?php
defined('COT_CODE') or die('Wrong URL.');

cot::$db->registerTable('searchforms');
$db_phones = $db_x.'searchforms';

require_once cot_incfile('extrafields');
require_once cot_incfile('page', 'module');
require_once cot_incfile('market', 'module');
require_once cot_incfile('projects', 'module');
require_once cot_incfile('demands', 'module');

$searchforms_cfg = array(
  'global' => array(
    'search' => array(
      'id' => array('title' => 'ID', 'tag' => 'GLOBAL_SEARCH_ID'),
      'title' => array('title' => $L['Title'], 'tag' => 'GLOBAL_SEARCH_TITLE'),
      'text' => array('title' => $L['Text'], 'tag' => 'GLOBAL_SEARCH_TEXT'),
    )
  ),
  'page' => array(
    'search' => array(
      'page_cat' => array('title' => $L['Category'], 'tag' => 'PAGE_SEARCH_CAT'),
      'page_title' => array('title' => $L['Title'], 'tag' => 'PAGE_SEARCH_TITLE'),
      'page_keywords' => array('title' => $L['page_metakeywords'], 'tag' => 'PAGE_SEARCH_KEYWORDS'),
      'page_author' => array('title' => $L['Author'], 'tag' => 'PAGE_SEARCH_AUTHOR'),
      'page_desc' => array('title' => $L['Description'], 'tag' => 'PAGE_SORT_DESC'),
      'page_text' => array('title' => $L['Text'], 'tag' => 'PAGE_SEARCH_TEXT'),

      'page_id' => array('title' => 'ID', 'tag' => 'PAGE_SEARCH_ID'),
      'page_metatitle' => array('title' => $L['page_metatitle'], 'tag' => 'PAGE_SEARCH_METATITLE'),
      'page_metadesc' => array('title' => $L['page_metadesc'], 'tag' => 'PAGE_SEARCH_METADESC'),
    ),
    'sort' => array(
      'page_cat' => array('title' => $L['Category'], 'tag' => 'PAGE_SORT_CAT'),
      'page_title' => array('title' => $L['Title'], 'tag' => 'PAGE_SORT_TITLE'),
      'page_keywords' => array('title' => $L['page_metakeywords'], 'tag' => 'PAGE_SORT_KEYWORDS'),
      'page_author' => array('title' => $L['Author'], 'tag' => 'PAGE_SORT_AUTHOR'),
      'page_desc' => array('title' => $L['Description'], 'tag' => 'PAGE_SORT_DESC'),
      'page_date' => array('title' => $L['Date'], 'tag' => 'PAGE_SORT_DATE'),

      'page_id' => array('title' => 'id страницы', 'tag' => 'PAGE_SORT_ID'),
      'page_count' => array('title' => $L['Hits'], 'tag' => 'PAGE_SORT_HITS'),
    )
  ),
  'market' => array(
    'search' => array(
      'item_cat' => array('title' => $L['Category'], 'tag' => 'MARKET_SEARCH_CAT'),
      'item_title' => array('title' => $L['Title'], 'tag' => 'MARKET_SEARCH_TITLE'),
      'item_text' => array('title' => $L['Text'], 'tag' => 'MARKET_SEARCH_TEXT'),
      'item_cost' => array('title' => $L['market_price'], 'tag' => 'MARKET_SEARCH_COST'),

      'item_id' => array('title' => 'ID', 'tag' => 'MARKET_SEARCH_ID'),
    ),
    'sort' => array(
      'item_cat' => array('title' => $L['Category'], 'tag' => 'MARKET_SORT_CAT'),
      'item_title' => array('title' => $L['Title'], 'tag' => 'MARKET_SORT_TITLE'),
      'item_cost' => array('title' => $L['market_price'], 'tag' => 'MARKET_SORT_COST'),
      'item_date' => array('title' => $L['Date'], 'tag' => 'MARKET_SORT_DATE'),

      'item_id' => array('title' => 'ID', 'tag' => 'MARKET_SORT_ID'),
      'item_update' => array('title' => $L['Update'], 'tag' => 'MARKET_SORT_UPDATE'),
      'item_count' => array('title' => $L['Hits'], 'tag' => 'MARKET_SORT_HITS'),
    )
  ),
  'projects' => array(
    'search' => array(
      'projects_cat' => array('title' => $L['Category'], 'tag' => 'PROJECTS_SEARCH_CAT'),
      'projects_title' => array('title' => $L['Title'], 'tag' => 'PROJECTS_SEARCH_TITLE'),
      'projects_text' => array('title' => $L['Text'], 'tag' => 'PROJECTS_SEARCH_TEXT'),
      'projects_cost' => array('title' => $L['market_price'], 'tag' => 'PROJECTS_SEARCH_COST'),

      'projects_id' => array('title' => 'ID', 'tag' => 'PROJECTS_SEARCH_ID'),
    ),
    'sort' => array(
      'projects_cat' => array('title' => $L['Category'], 'tag' => 'PROJECTS_SORT_CAT'),
      'projects_title' => array('title' => $L['Title'], 'tag' => 'PROJECTS_SORT_TITLE'),
      'projects_cost' => array('title' => $L['market_price'], 'tag' => 'PROJECTS_SORT_COST'),
      'projects_date' => array('title' => $L['Date'], 'tag' => 'PROJECTS_SORT_DATE'),

      'projects_id' => array('title' => 'ID', 'tag' => 'PROJECTS_SORT_ID'),
      'projects_update' => array('title' => $L['Update'], 'tag' => 'PROJECTS_SORT_UPDATE'),
      'projects_count' => array('title' => $L['Hits'], 'tag' => 'PROJECTS_SORT_HITS'),
    )
  ),
  'demands' => array(
    'search' => array(
      'demands_cat' => array('title' => $L['Category'], 'tag' => 'DEMANDS_SEARCH_CAT'),
      'demands_title' => array('title' => $L['Title'], 'tag' => 'DEMANDS_SEARCH_TITLE'),
      'demands_text' => array('title' => $L['Text'], 'tag' => 'DEMANDS_SEARCH_TEXT'),
      'demands_cost' => array('title' => $L['market_price'], 'tag' => 'DEMANDS_SEARCH_COST'),

      'demands_id' => array('title' => 'ID', 'tag' => 'DEMANDS_SEARCH_ID'),
    ),
    'sort' => array(
      'demands_cat' => array('title' => $L['Category'], 'tag' => 'DEMANDS_SORT_CAT'),
      'demands_title' => array('title' => $L['Title'], 'tag' => 'DEMANDS_SORT_TITLE'),
      'demands_cost' => array('title' => $L['market_price'], 'tag' => 'DEMANDS_SORT_COST'),
      'demands_date' => array('title' => $L['Date'], 'tag' => 'DEMANDS_SORT_DATE'),

      'demands_id' => array('title' => 'ID', 'tag' => 'DEMANDS_SORT_ID'),
      'demands_update' => array('title' => $L['Update'], 'tag' => 'DEMANDS_SORT_UPDATE'),
      'demands_count' => array('title' => $L['Hits'], 'tag' => 'DEMANDS_SORT_HITS'),
    )
  )
);

$searchforms_sort = array(
  '' => 'Упорядочить',
  'asc' => 'Возрастанию',
  'desc' => 'Убыванию',
);

function cot_searchforms_show($code, $data = array())
{
  global $db, $db_searchforms, $searchforms_cfg, $searchforms_sort, $L, $cot_extrafields, $db_pages, $db_market, $db_projects, $db_demands;

  $return = '';

  $form = $db->query("SELECT * FROM $db_searchforms WHERE form_code='".$code."' LIMIT 1")->fetch();
  if($form['form_id'] > 0)
  {
    $t = new XTemplate(cot_tplfile(array('searchforms', 'form', $code), 'plug'));
    $t->assign('CODE', $code);

    $form['form_set'] = json_decode($form['form_set'], 1);
    $form['inputs'] = array('page' => array('search' => array(), 'sort' => array()), 'market' => array('search' => array(), 'sort' => array()), 'projects' => array('search' => array(), 'sort' => array()), 'demands' => array('search' => array(), 'sort' => array()));

    if(count($form['form_set']['page']['search']) > 0 || count($form['form_set']['page']['sort']) > 0)
    {
      if(in_array('page_cat', array_keys($form['form_set']['page']['search']))) $form['inputs']['page']['search']['page_cat'] = cot_selectbox_structure('page', $data['rpage_search']['page_cat'], 'rpage_search[page_cat]', '', true, true, true);

      foreach($cot_extrafields[$db_pages] as $exfld)
      {
       if($exfld['field_type'] != 'file')
       {
      	$uname = strtoupper($exfld['field_name']);
      	$exfld_title = isset($L['pages_'.$exfld['field_name'].'_title']) ?  $L['pages_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
        $t->assign('PAGE_SEARCH_' . $uname . '_TITLE', $exfld_title);
        $t->assign('PAGE_SORT_' . $uname . '_TITLE', $exfld_title);
        if(in_array($exfld['field_type'], array('select', 'checkbox', 'radio', 'range', 'checklistbox'))) {
         $form['inputs']['page']['search']['page_' . $uname] = cot_build_extrafields('rpage_search[page_'.$exfld['field_name'].']', $exfld, $data['rpage_search']['page_'.$exfld['field_name']]);
        } else {
         $form['inputs']['page']['search']['page_' . $uname] = cot_inputbox('text', 'rpage_search[page_'.$exfld['field_name'].']', $data['rpage_search']['page_'.$exfld['field_name']]);
        }
        $form['inputs']['page']['sort']['page_' . $uname] = cot_selectbox($data['rpage_sort']['page_'.$exfld['field_name']], 'rpage_sort[page_'.$exfld['field_name'].']', array_keys($searchforms_sort), array_values($searchforms_sort), false);

        $searchforms_cfg['page']['search']['page_' . $uname]['tag'] = 'PAGE_SEARCH_' . $uname;
        $searchforms_cfg['page']['sort']['page_' . $uname]['tag'] = 'PAGE_SORT_' . $uname;
       }
      }
    }

    if(count($form['form_set']['market']['search']) > 0 || count($form['form_set']['market']['sort']) > 0)
    {
      if(in_array('item_cat', array_keys($form['form_set']['market']['search']))) $form['inputs']['market']['search']['item_cat'] = cot_selectbox_structure('market', $data['rmarket_search']['item_cat'], 'rmarket_search[item_cat]', '', true, true, true);

      foreach($cot_extrafields[$db_market] as $exfld)
      {
       if($exfld['field_type'] != 'file')
       {
      	$uname = strtoupper($exfld['field_name']);
      	$exfld_title = isset($L['market_'.$exfld['field_name'].'_title']) ?  $L['market_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
        $t->assign('MARKET_SEARCH_' . $uname . '_TITLE', $exfld_title);
        $t->assign('MARKET_SORT_' . $uname . '_TITLE', $exfld_title);
        if(in_array($exfld['field_type'], array('select', 'checkbox', 'radio', 'range', 'checklistbox'))) {
         $form['inputs']['market']['search']['item_' . $uname] = cot_build_extrafields('rmarket_search[item_'.$exfld['field_name'].']', $exfld, $data['rmarket_search']['item_'.$exfld['field_name']]);
        } else {
         $form['inputs']['market']['search']['item_' . $uname] = cot_inputbox('text', 'rmarket_search[item_'.$exfld['field_name'].']', $data['rmarket_search']['item_'.$exfld['field_name']]);
        }
        $form['inputs']['market']['sort']['item_' . $uname] = cot_selectbox($data['rmarket_sort']['item_'.$exfld['field_name']], 'rmarket_sort[item_'.$exfld['field_name'].']', array_keys($searchforms_sort), array_values($searchforms_sort), false);

        $searchforms_cfg['market']['search']['item_' . $uname]['tag'] = 'MARKET_SEARCH_' . $uname;
        $searchforms_cfg['market']['sort']['item_' . $uname]['tag'] = 'MARKET_SORT_' . $uname;
       }
      }
    }

    if(count($form['form_set']['projects']['search']) > 0 || count($form['form_set']['projects']['sort']) > 0)
    {
      if(in_array('item_cat', array_keys($form['form_set']['projects']['search']))) $form['inputs']['projects']['search']['item_cat'] = cot_selectbox_structure('projects', $data['rprojects_search']['item_cat'], 'rprojects_search[item_cat]', '', true, true, true);

      foreach($cot_extrafields[$db_projects] as $exfld)
      {
       if($exfld['field_type'] != 'file')
       {
      	$uname = strtoupper($exfld['field_name']);
      	$exfld_title = isset($L['projects_'.$exfld['field_name'].'_title']) ?  $L['projects_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
        $t->assign('PROJECTS_SEARCH_' . $uname . '_TITLE', $exfld_title);
        $t->assign('PROJECTS_SORT_' . $uname . '_TITLE', $exfld_title);
        if(in_array($exfld['field_type'], array('select', 'checkbox', 'radio', 'range', 'checklistbox'))) {
         $form['inputs']['projects']['search']['item_' . $uname] = cot_build_extrafields('rprojects_search[item_'.$exfld['field_name'].']', $exfld, $data['rprojects_search']['item_'.$exfld['field_name']]);
        } else {
         $form['inputs']['projects']['search']['item_' . $uname] = cot_inputbox('text', 'rprojects_search[item_'.$exfld['field_name'].']', $data['rprojects_search']['item_'.$exfld['field_name']]);
        }
        $form['inputs']['projects']['sort']['item_' . $uname] = cot_selectbox($data['rprojects_sort']['item_'.$exfld['field_name']], 'rprojects_sort[item_'.$exfld['field_name'].']', array_keys($searchforms_sort), array_values($searchforms_sort), false);

        $searchforms_cfg['projects']['search']['item_' . $uname]['tag'] = 'PROJECTS_SEARCH_' . $uname;
        $searchforms_cfg['projects']['sort']['item_' . $uname]['tag'] = 'PROJECTS_SORT_' . $uname;
       }
      }
    }

    if(count($form['form_set']['demands']['search']) > 0 || count($form['form_set']['demands']['sort']) > 0)
    {
      if(in_array('item_cat', array_keys($form['form_set']['demands']['search']))) $form['inputs']['demands']['search']['item_cat'] = cot_selectbox_structure('demands', $data['rdemands_search']['item_cat'], 'rdemands_search[item_cat]', '', true, true, true);

      foreach($cot_extrafields[$db_demands] as $exfld)
      {
       if($exfld['field_type'] != 'file')
       {
      	$uname = strtoupper($exfld['field_name']);
      	$exfld_title = isset($L['demands_'.$exfld['field_name'].'_title']) ?  $L['demands_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
        $t->assign('DEMANDS_SEARCH_' . $uname . '_TITLE', $exfld_title);
        $t->assign('DEMANDS_SORT_' . $uname . '_TITLE', $exfld_title);
        if(in_array($exfld['field_type'], array('select', 'checkbox', 'radio', 'range', 'checklistbox'))) {
         $form['inputs']['demands']['search']['item_' . $uname] = cot_build_extrafields('rdemands_search[item_'.$exfld['field_name'].']', $exfld, $data['rdemands_search']['item_'.$exfld['field_name']]);
        } else {
         $form['inputs']['demands']['search']['item_' . $uname] = cot_inputbox('text', 'rdemands_search[item_'.$exfld['field_name'].']', $data['rdemands_search']['item_'.$exfld['field_name']]);
        }
        $form['inputs']['demands']['sort']['item_' . $uname] = cot_selectbox($data['rdemands_sort']['item_'.$exfld['field_name']], 'rdemands_sort[item_'.$exfld['field_name'].']', array_keys($searchforms_sort), array_values($searchforms_sort), false);

        $searchforms_cfg['demands']['search']['item_' . $uname]['tag'] = 'DEMANDS_SEARCH_' . $uname;
        $searchforms_cfg['demands']['sort']['item_' . $uname]['tag'] = 'DEMANDS_SORT_' . $uname;
       }
      }
    }

    foreach($form['form_set'] as $area => $tags)
    {
      foreach($tags['search'] as $tg)
      {
       $t->assign($searchforms_cfg[$area]['search'][$tg]['tag'], (in_array($tg, array_keys($form['inputs'][$area]['search'])) ? $form['inputs'][$area]['search'][$tg] : cot_inputbox('text', 'r'.$area.'_search['.$tg.']', $data['r'.$area.'_search'][$tg])));
      }
      foreach($tags['sort'] as $tg)
      {
        $t->assign($searchforms_cfg[$area]['sort'][$tg]['tag'], (in_array($tg, array_keys($form['inputs'][$area]['sort'])) ? $form['inputs'][$area]['sort'][$tg] : cot_selectbox($data['r'.$area.'_sort'][$tg], 'r'.$area.'_sort['.$tg.']', array_keys($searchforms_sort), array_values($searchforms_sort), false)));
      }
    }


    foreach($searchforms_cfg['global']['search'] as $tg => $tags)
    {
      $t->assign($tags['tag'], cot_inputbox('text', 'rglobal_search['.$tg.']', $data['rglobal_search'][$tg]));
    }


   $t->parse('MAIN');
   $return = $t->text('MAIN');
 }

 return $return;
}