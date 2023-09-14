<?php

/**
 * catselector plugin
 *
 * @package catselector
 * @version 1.0.1
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

require_once cot_langfile('catselector', 'plug');

function catselector_selectbox($area, $check, $name, $attr = '', $userrigths = 'W', $rsc = 1)
{
	global $db, $structure, $usr, $L, $R;
	
	if(!empty($check))
	{
		$parents = cot_structure_parents($area, $check);
	}
	
	$result = '';
	
	$subcats = cot_structure_children($area, $parents[0], true, true);
	$maxlvl = 1;
	
	if(!empty($check)){
		foreach ($subcats as $i => $k)
		{
			$mtch = $structure[$area][$k]['path'].'.';
			$mtchlen = mb_strlen($mtch);
			$mtchlvl = mb_substr_count($mtch,".");
			if($mtchlvl > $maxlvl) $maxlvl = $mtchlvl;
		}
	}
	
	for($lvl = 1; $lvl <= $maxlvl; $lvl++)
	{
		if(!$rsc){
			$onchange_select_set_input = "$('input[name=".$name."]').val($(this).val());";
		}
		
		$result .= "<select name=\"".$name."\" ".$attr." onChange=\"".$onchange_select_set_input."catselector_changeselect(this, '".$area."', '".$name."', '".$userrigths."', '".$rsc."');\">";
		$result .= "<option value=\"\">".$L['catselector_select_text']."</option>";
		foreach ($structure[$area] as $i => $x)
		{		
			if(cot_auth($area, $i, $userrigths))
			{
				$mtch = $structure[$area][$i]['path'].'.';
				$mtchlen = mb_strlen($mtch);
				$mtchlvl = mb_substr_count($mtch,".");

				if(($mtchlvl == 1 && $lvl == 1) || ($lvl > 1 && $mtchlvl == $lvl && in_array($i, $subcats)))
				{
					$selected_cat = ($parents[$lvl-1] == $i) ? 'selected="selected"' : '';
					$result .= "<option ".$selected_cat." value=\"".$i."\">".$x['title']."</option>";
				}
			}
		}
		$result .= "</select>";
	}
	
	if(!$rsc){
		$result .= "<input type=\"hidden\" name=\"".$name."\" value=\"".$check."\"/>";
	}
	
	return($result);
}
