<?php
defined('COT_CODE') or die('Wrong URL.');
require_once cot_incfile('extrafields');

// Tables and extras
cot::$db->registerTable('ads');
cot_extrafields_register_table('ads');

$ads_allowed_ext = array('bmp', 'gif', 'jpg', 'jpeg', 'swf', 'png');
$ads_files_dir = 'datas/ads/';

function ads_show($cat = '', $cnt = 1, $tpl = 'ads')
{
    global $sys, $usr, $cfg, $db, $db_users, $db_ads;
    
    $cats = array();
    $where = array();
    $cnt = (int)$cnt;

    $where['item_published'] = "item_paused=0";
    $where['item_expire'] = "item_expire >='".(int)$sys['now']."'";

    $cat = str_replace(' ', '', $cat);

    if ($cat != '')
    {
        $categs = explode(',', $cat);
        foreach ($categs as $tmp)
        {
            $tmp = trim($tmp);
            if (empty($tmp))
            {
                continue;
            }
            if ($subcats)
            {
                $cats = array_merge($cats, cot_structure_children('ads', $tmp, true, true, false, false));
            }
            else
            {
                $cats[] = $tmp;
            }
        }
        $cats = array_unique($cats);
    }

    if (count($cats) > 0)
    {
        $where['item_cat'] = 'item_cat IN ("'.implode('", "', $cats).'")';
    }

    $where = (!empty($where)) ? ' WHERE '.implode(' AND ', $where) : '';
    
    $ads = $db->query("SELECT * FROM $db_ads 
         $where ORDER BY item_lastshow ASC LIMIT $cnt")->fetchAll();
    
    $t = new XTemplate(cot_tplfile($tpl, 'plug'));
    $jj=0;
    foreach ($ads as $ad)
    {
        ads_tracks($ad['item_id'], 'show');  // записываем показ
        $jj++;
        $t->assign(ads_generate_tags($ad, 'ADS_ROW_'));
        $t->assign(array(
            'ADS_ROW_NUM' => $jj,
        ));
        $t->parse('MAIN.ROW');
    }
    $t->parse('MAIN');

    return $t->text('MAIN');
}

function ads_import_file($inputname, $oldvalue = '')
{
    global $lang, $L, $cot_translit, $ads_allowed_ext, $ads_files_dir, $cfg;

    $import = !empty($_FILES[$inputname]) ? $_FILES[$inputname] : array();
    $import['delete'] = cot_import('rdel_'.$inputname, 'P', 'BOL') ? 1 : 0;

    if (is_array($import) && !$import['error'] && !empty($import['name']))
    {
        $fname = mb_substr($import['name'], 0, mb_strrpos($import['name'], '.'));
        $ext = mb_strtolower(mb_substr($import['name'], mb_strrpos($import['name'], '.') + 1));

        if (!file_exists($ads_files_dir))
        {
            mkdir($ads_files_dir);
        }
        if (empty($ads_allowed_ext) || in_array($ext, $ads_allowed_ext))
        {
            if ($lang != 'en')
            {
                require_once cot_langfile('translit', 'core');
                $fname = (is_array($cot_translit)) ? strtr($fname, $cot_translit) : '';
            }
            $fname = str_replace(' ', '_', $fname);
            $fname = preg_replace('#[^a-zA-Z0-9\-_\.\ \+]#', '', $fname);
            $fname = str_replace('..', '.', $fname);
            $fname = (empty($fname)) ? cot_unique() : $fname;

            $fname .= (file_exists("{$ads_files_dir}/$fname.$ext") && $oldvalue != $fname.'.'.$ext) ? date("YmjGis") : '';
            $fname .= '.'.$ext;

            $file['old'] = (!empty($oldvalue) && ($import['delete'] || $import['tmp_name'])) ? $oldvalue : '';
            $file['tmp'] = (!$import['delete']) ? $import['tmp_name'] : '';
            $file['new'] = (!$import['delete']) ? $ads_files_dir.$fname : '';

            if (!empty($file['old']) && file_exists($file['old']))
            {
              unlink($file['old']);
            }
            if (!empty($file['tmp']) && !empty($file['tmp']))
            {
              move_uploaded_file($file['tmp'], $file['new']);
            }
            return $file['new'];
        }
        else
        {
            cot_error($L['ads_err_inv_file_type'], $inputname);
            return '';
        }
    }
}

function ads_generate_tags($ads, $tagPrefix = '')
{
    global $cfg, $L, $Ls, $sys, $usr, $structure, $cot_extrafields, $db_ads;

    $temp_array = array();

    if (is_int($ads) && $ads > 0)
    {
        $ads = $db->query("SELECT * FROM $db_ads WHERE item_id = ".(int)$ads." LIMIT 1")->fetch();
    }
    if ($ads['item_id'] > 0)
    {
        $temp_array = array(
            'EDIT_URL' => cot_url('plug', array('e' => 'ads', 'a' => 'edit', 'id' => $ads['item_id'])),
            'DEL_URL' => ($ads['item_expire'] < $sys['now'] && $ads['item_paused'] == 0) ? cot_url('plug', array('e' => 'ads', 'a' => 'edit', 'act' => 'del', 'id' => $ads['item_id'])) : '',
            'URL' => $ads['item_clickurl'],
            'ALT' => $ads['item_alt'],
            'ID' => $ads['item_id'],
            'TITLE' => htmlspecialchars($ads['item_title']),
	          'DESCRIPTION' => $ads['item_description'],
            'CLICKS' => $ads['item_track_clicks'],
            'SHOWS' => $ads['item_track_shows'],
            'CATEGORY' => $ads['item_cat'],
            'CATEGORY_TITLE' => htmlspecialchars($structure['ads'][$ads['item_cat']]['title']),
            'CLICKS_PERSENT' => ($ads['item_track_shows'] > 0) ?
                round($ads['item_track_clicks'] / $ads['item_track_shows'] * 100, 0)." %" : '0 %',
            'FILETYPE' => $ads['item_filetype'],
            'IMAGE' => $ads['item_file'],
            'FILETYPE' => $ads['item_filetype'],
            'CLICK_URL' => cot_url('plug', 'e=ads&a=click&id='.$ads['item_id']),
	          'EXPIRE' => $ads['item_expire'],
            'PAUSED' => $ads['item_paused'],
            'PAUSED_TIME' => ($ads['item_paused'] > 0) ? cot_build_timegap($sys['now'] - $ads['item_paused']) : '',
            'PERIOD' => cot_declension($ads['item_period'], $Ls['ads_'.$cfg['plugin']['ads']['purchase_period']]),
        );

        foreach ($cot_extrafields[$db_ads] as $exfld)
        {
            $tag = mb_strtoupper($exfld['field_name']);
            $exfld_val = cot_build_extrafields_data('item_', $exfld, $row['item_'.$exfld['field_name']]);
            $exfld_title = isset($L['item_' . $exfld['field_name'] . '_title']) ? $L['item_' . $exfld['field_name'] . '_title'] : $exfld['field_description'];
            $temp_array[$tag . '_TITLE'] = $exfld_title;
            $temp_array[$tag] = $exfld_val;
            $temp_array[$tag . '_VALUE'] = $row['item_'.$exfld['field_name']];
        }
    }

    $return_array = array();
    foreach ($temp_array as $key => $val)
    {
      $return_array[$tagPrefix.$key] = $val;
    }

    return $return_array;
}

function cot_ads_sync($cat)
{
    global $db, $db_structure, $db_ads;
    $sql = $db->query("SELECT COUNT(*) FROM $db_ads
        WHERE item_cat='".$db->prep($cat)."'");
    return (int) $sql->fetchColumn();
}


function cot_ads_updatecat($oldcat, $newcat)
{
    global $db, $db_ads;
    return (bool)$db->update($db_ads, array("item_cat" => $newcat), "item_cat='".$db->prep($oldcat)."'");
}

function ads_selectbox($check, $name, $add_empty = false)
{
    global $structure, $cfg, $L;
    require_once cot_incfile('configuration');
    $structure['ads'] = (is_array($structure['ads'])) ? $structure['ads'] : array();
    $result_array = array();
    foreach ($structure['ads'] as $i => $x)
    {
        $configlist = cot_config_list('plug', 'ads', $i);
        if ($i != 'all')
        {
            $result_array[$i] = $x['tpath'].' ('.$configlist['price']['config_value'].' '.$cfg['payments']['valuta'].' в '.$L['ads_paymentinterval'].')';
        }
    }
    $result = cot_selectbox($check, $name, array_keys($result_array), array_values($result_array), $add_empty);

    return($result);
}

function ads_tracks($id, $type = 'show')
{
  global $db, $sys, $cfg, $db_ads;

  if(cot_import('e','G','TXT') != 'ads' || (cot_import('e','G','TXT') == 'ads' && cot_import('a','G','TXT') == 'click'))
  {
    if ($type == 'show')
      {
        $db->query("UPDATE $db_ads SET item_track_shows = item_track_shows+1, item_lastshow = ".$sys['now']." WHERE item_id = ".(int)$id."");
      }
    elseif($type == 'click')
      {
        $db->query("UPDATE $db_ads SET item_track_clicks = item_track_clicks+1 WHERE item_id = ".(int)$id."");
      }
   }
}

/**
 * Создание платежки
 * @param string $area тип услуги, по-умолчанию пополнение счета
 * @param int $summ стоимость
 * @param array $options дополнительные параметры
 */
function cot_payments_create_adsorder($summ, $options = array())
{
	global $db_payments, $db_payments_balance, $db, $sys, $cfg, $usr;

  require_once cot_incfile('payments', 'module');

	if(empty($summ))
	{
		cot_redirect(cot_url('payments', 'm=error&msg=3', '', true));
	}

	$payinfo['pay_userid'] = $usr['id'];
	$payinfo['pay_area'] = 'ads';
	$payinfo['pay_summ'] = $summ;
	$payinfo['pay_cdate'] = $sys['now'];
	$payinfo['pay_status'] = 'new';

	if (count($options) > 0)
	{
		foreach ($options as $i => $opt)
		{
			$payinfo['pay_' . $i] = $opt;
		}
	}

  $return = false;

  if($payinfo['pay_userid'] > 0 && cot_payments_getuserbalance($payinfo['pay_userid']) >= $payinfo['pay_summ']) {
  	$db->insert($db_payments, $payinfo);
  	$id = $db->lastInsertId();

  	if (cot_payments_updatestatus($id, 'paid'))
    {
  		cot_payments_updateuserbalance($payinfo['pay_userid'], -$payinfo['pay_summ'], $id);

      $return = true;
  		/* === Hook === */
  		foreach (cot_getextplugins('payments.billing.paid.done') as $pl)
  		{
  			include $pl;
  		}
  		/* ===== */
  	}
  }

  return $return;
}