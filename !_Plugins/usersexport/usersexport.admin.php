<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=tools
[END_COT_EXT]
==================== */

(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('users', 'a');
cot_block($usr['isadmin']);

$tt = new XTemplate(cot_tplfile('usersexport', 'plug', true));

  require_once cot_langfile('usergroupselector', 'plug');
  
	$options = explode(',', $cfg['plugin']['usergroupselector']['groups']);
	$groups_values = array();
	$groups_titles = array();
	foreach ($options as $v)
	{
		$groups_values[] = $v;
		$groups_titles[] = $cot_groups[$v]['title'];		
	}
	
	$tt->assign('GROUPSELECTBOX', cot_selectbox(7, 'usergroup', $groups_values, $groups_titles));

  require_once cot_incfile('usercategories', 'plug');
  
  $tt->assign(array(
  	'SELECTUSERCATS' => cot_usercategories_treecheck(array(), 'usercatstmp', '', '', '')
  ));

$tt->parse('MAIN');
$plugin_body = $tt->text('MAIN');
