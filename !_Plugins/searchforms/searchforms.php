<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=standalone
 * [END_COT_EXT]
 */

defined('COT_CODE') && defined('COT_PLUG') or die('Wrong URL');

require_once cot_incfile('searchforms', 'plug');

$code = cot_import('code', 'G', 'TXT');

$t = new XTemplate(cot_tplfile(array('searchforms', 'result', $code), 'plug'));

$t->assign('FORM', cot_searchforms_show($code, $_GET));

$form = $db->query("SELECT * FROM $db_searchforms WHERE form_code='".$code."' LIMIT 1")->fetch();
if($form['form_id'] > 0)
{
  $form['form_set'] = json_decode($form['form_set'], 1);

  $data = array(
    'global' => array(
      'search' => $_GET['rglobal_search']
    ),
    'page' => array(
      'search' => $_GET['rpage_search'],
      'sort' => $_GET['rpage_sort']
    ),
    'market' => array(
      'search' => $_GET['rmarket_search'],
      'sort' => $_GET['rmarket_sort']
    ),
    'projects' => array(
      'search' => $_GET['rprojects_search'],
      'sort' => $_GET['rprojects_sort']
    ),
    'demands' => array(
      'search' => $_GET['rdemands_search'],
      'sort' => $_GET['rdemands_sort']
    )
  );

  $query_select = array(
    'page' => array('page_date', 'page_id'),
    'market' => array('item_date', 'item_id'),
    'projects' => array('item_date', 'item_id'),
    'demands' => array('item_date', 'item_id')
  );

  $query_tables = array(
    'page' => $db_pages,
    'market' => $db_market,
    'projects' => $db_projects,
    'demands' => $db_demands
  );

  $query_pref = array(
    'page' => 'page_',
    'market' => 'item_',
    'projects' => 'item_',
    'demands' => 'item_'
  );

  $result = array();

  foreach($form['form_set'] as $area => $tags)
  {

   $where = array();
   $order = array();

   foreach($tags['search'] as $tg)
   {
    if(!empty($data[$area]['search'][$tg])) $where[$area.'_'.$tg] = (is_numeric($data[$area]['search'][$tg]) ? $tg."=".$data[$area]['search'][$tg] : $tg." LIKE '%".$data[$area]['search'][$tg]."%'");
   }
   foreach($tags['sort'] as $tg)
   {
    if(in_array($data[$area]['sort'][$tg], array('asc', 'desc'))) $order[$area.'_'.$tg] = $tg." ".$data[$area]['sort'][$tg];
   }

   if(is_array($data['global']['search']))
   {
    foreach($data['global']['search'] as $tg => $val)
    {
     if(!empty($val)) $where[$area.'_'.$tg] = $query_pref[$area].$tg." LIKE '%".$val."%'";
    }
   }

   $sqllist = $db->query("SELECT ".$query_select[$area][0]." as date, ".$query_select[$area][1]." as id FROM ".$query_tables[$area]." ".(count($where) > 0 ? 'WHERE ' . implode(' AND ', $where) : '')." ".(count($order) > 0 ? 'ORDER BY ' . implode(' AND ', $order) : '')."")->fetchAll();
   foreach($sqllist as $item) {
     $result[cot_date2stamp(cot_date('d.m.Y', $item['date']), 'd.m.Y')][$area][] = $item['id'];
   }
  }

  krsort($result);

  /* === Hook - Part1 : Set === */
  $extppage = cot_getextplugins('page.list.loop');
  $extpmarket = cot_getextplugins('market.list.loop');
  $extpprojects = cot_getextplugins('projects.list.loop');
  $extpdemands = cot_getextplugins('demands.list.loop');
  /* ===== */

  foreach($result as $row)
  {
    foreach($row as $area => $ids)
    {
      foreach($ids as $id)
      {
        if($area == 'page') {
          $pag = $db->query("SELECT * FROM $db_pages WHERE page_id=".$id." LIMIT 1")->fetch();
          $t->assign(cot_generate_pagetags($pag, 'PAGE_ROW_'));
      		$t->assign(array(
      			'LIST_ROW_OWNER' => cot_build_user($pag['page_ownerid'], htmlspecialchars($pag['user_name']))
      		));
      		$t->assign(cot_generate_usertags($pag, 'LIST_ROW_OWNER_'));
      
      		/* === Hook - Part2 : Include === */
      		foreach ($extppage as $pl)
      		{
      			include $pl;
      		}
      		/* ===== */
    
          $t->parse('MAIN.SEARCH.PAGE');
        } else if($area == 'market') {
          $item = $db->query("SELECT * FROM $db_market WHERE item_id=".$id." LIMIT 1")->fetch();      
          $t->assign(cot_generate_markettags($item, 'MARKET_ROW_'));          
        	$t->assign(cot_generate_usertags($item, 'MARKET_ROW_OWNER_'));
          
        	/* === Hook - Part2 : Include === */
        	foreach ($extpmarket as $pl)
        	{
        		include $pl;
        	}
        	/* ===== */
  
          $t->parse('MAIN.SEARCH.MARKET');
        } else if($area == 'projects') {
          $item = $db->query("SELECT * FROM $db_projects WHERE item_id=".$id." LIMIT 1")->fetch();
          $t->assign(cot_generate_markettags($item, 'PROJECTS_ROW_'));
        	$t->assign(cot_generate_usertags($item, 'PROJECTS_ROW_OWNER_'));
          
        	/* === Hook - Part2 : Include === */
        	foreach ($extpprojects as $pl)
        	{
        		include $pl;
        	}
        	/* ===== */

          $t->parse('MAIN.SEARCH.PROJECTS');
        } else if($area == 'demands') {
          $item = $db->query("SELECT * FROM $db_demands WHERE item_id=".$id." LIMIT 1")->fetch();
          $t->assign(cot_generate_markettags($item, 'DEMANDS_ROW_'));
        	$t->assign(cot_generate_usertags($item, 'DEMANDS_ROW_OWNER_'));

        	/* === Hook - Part2 : Include === */
        	foreach ($extpdemands as $pl)
        	{
        		include $pl;
        	}
        	/* ===== */

          $t->parse('MAIN.SEARCH.DEMANDS');
        }

        $t->parse('MAIN.SEARCH');
      }
    }
  }
  if(count($result) == 1) $t->parse('MAIN.SEARCH');
}

