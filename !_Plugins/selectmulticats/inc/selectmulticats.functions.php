<?php

function cot_selectmulticats($area, $chosen, $name, $placeholder ='', $limit = 0, $parent = '', $level = 0)
{
	global $structure, $cfg, $R, $L;
  global $i18n_notmain, $i18n_locale, $i18n_write, $i18n_admin, $i18n_read, $db_i18n_pages;

  if($level == 0) $result = '<select name="'.$name.'[]" class="selectpicker default" multiple'.($limit > 0 ? ' data-max-options="'.$limit.'"' : '').' data-selected-text-format="count" title="'.(!empty($placeholder) ? $placeholder : $L['All']).'">';

  if(!is_array($chosen)) $chosen = explode(',', $chosen);

  if(is_array($structure[$area])) {
  	if (empty($parent))
  	{
  		$i18n_enabled = $i18n_read;
  		$children = array();
  		foreach ($structure[$area] as $i => $x)
  		{
  			if (mb_substr_count($structure[$area][$i]['path'], ".") == 0)
  			{
  				$children[] = $i;
  			}
  		}
  	}
  	else
  	{
  		$i18n_enabled = $i18n_read && cot_i18n_enabled($parent);
  		$children = $structure[$area][$parent]['subcats'];
  	}

    if(!count($children)) {
      return '';
    }


    foreach ($children as $row)
    {
      $subcats = $structure[$area][$row]['subcats'];
      if(count($subcats) > 0) {
        if($level == 0) $result .= '<optgroup label="'.htmlspecialchars($structure[$area][$row]['title']).'">';
          $result .= '<option value="'.$row.'"'.($level > 1 ? ' data-subtext="'.htmlspecialchars($structure[$area][$row]['title']).'"' : '').(in_array($row, $chosen) ? ' selected="selected"' : '').'>'.htmlspecialchars($structure[$area][($level > 1 ? $parent : $row)]['title']).'</option>';
          $result .= cot_selectmulticats($area, $chosen, $name, $placeholder, $limit, $row, $level + 1);
        if($level == 0) $result .= '</optgroup>';
      } else {
        $result .= '<option value="'.$row.'"'.($level > 1 ? ' data-subtext="'.htmlspecialchars($structure[$area][$row]['title']).'"' : '').(in_array($row, $chosen) ? ' selected="selected"' : '').'>'.htmlspecialchars($structure[$area][($level > 1 ? $parent : $row)]['title']).'</option>';
      }
    }
  }

  if($level == 0) {
    $result .= '</select>';
  }

  if($cfg['msg_separate']) $result .= cot_implode_messages($name, 'error');

	return $result;
}