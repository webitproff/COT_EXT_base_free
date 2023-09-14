<?php

(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');

global $adminpath, $structure, $cfg, $L, $usr, $sys;

$adminpath[] = array(cot_url('admin', array('m' => 'other', 'p' => 'ads')), $L['ads_banners']);

if (empty($structure['ads']))
{
	cot_error($L['ads_category_no']);
}

$id = cot_import('id', 'G', 'INT');
$maxrowsperpage = $cfg['maxrowsperpage'];
list($pg, $d, $durl) = cot_import_pagenav('d', $maxrowsperpage);
$interval = cot_import('interval', 'G', 'TXT');

$act = cot_import('act', 'P', 'ALP');
if (!$id)
{
	$id = 0;
	$adminpath[] = '&nbsp;'.$L['Add'];
	$ads = array();
}
else
{
	$ads = $db->query("SELECT * FROM $db_ads WHERE item_id = ".(int)$id." LIMIT 1")->fetch();
	$adminpath[] = $L['ads_banner_edit'].": ".htmlspecialchars($ads['ads_title']);
}

if ($act == 'save')
{
	$item = array();

	$item['item_title'] = cot_import('rtitle', 'P', 'TXT');
	if (empty($item['item_title']))
	{
		cot_error($L['ads_err_titleempty'], 'rtitle');
	}
	$item['item_cat'] = cot_import('rcat', 'P', 'TXT');
	$file = ads_import_file('rfile', $ads['ads_file']);
	$delFile = cot_import('rdel_rfile', 'P', 'BOL') ? 1 : 0;
	if ($delFile)
	{
		$item['item_file'] = '';
	}

	if (!empty($file))
	{
		@$gd = getimagesize($file);
		if (!$gd)
		{
			cot_error($L['ads_err_inv_file_type'], 'rfile');
		}
		else
		{
			switch ($gd[2])
			{
				case IMAGETYPE_GIF:
				case IMAGETYPE_JPEG:
				case IMAGETYPE_PNG:
				case IMAGETYPE_BMP:
						$item['item_filetype'] = 'img';
					break;
				case IMAGETYPE_SWF:
				case IMAGETYPE_SWC:
						$item['item_filetype'] = 'swf';
					break;
				default:
					cot_error($L['ads_err_inv_file_type'], 'rfile');
			}
		}
	}
	else
  {
		if (!$delFile)
		{
			unset($item['item_filetype']);
		}
	}

	$item['item_alt'] = cot_import('ralt', 'P', 'TXT');
	$item['item_clickurl'] = cot_import('rclickurl', 'P', 'TXT');
	$item['item_description'] = cot_import('rdescription', 'P', 'TXT');
	$item['item_expire'] = cot_import_date('rexpire');
	$item['item_userid'] = cot_import('ruserid', 'P', 'INT');

	//$item['item_begin'] = $sys['now'];

	// Extra fields
	foreach ($cot_extrafields[$db_ads] as $exfld)
	{
		$item['item_' . $exfld['field_name']] = cot_import_extrafields('r' . $exfld['field_name'], $exfld);
	}
	
	if (!cot_error_found())
	{
		if (!empty($file))
		{
			$item['item_file'] = $file;
		}
		if ($id > 0)
		{
			$db->update($db_ads, $item, "item_id = ".(int)$id);
			cot_log("Edited adv # {$id} - {$data['item_title']}", 'adm');
      cot_message($L['item_saved']);
		}
		else
		{
      if($item['item_userid'] != $usr['id']) {
        $period = cot_import('rperiod', 'P', 'INT');
        $item['item_period'] = $period;
        $item['item_expire'] = 0;
      	$item['item_begin'] = 0;
      }
			$db->insert($db_ads, $item);
			$id = $db->lastInsertId();

      if($item['item_userid'] != $usr['id']) {
        $period = cot_import('rperiod', 'P', 'INT');
        $item['item_period'] = $period;
        $item['item_expire'] = 0;
      	$item['item_begin'] = 0;

        require_once cot_incfile('configuration');
        $structure['ads'] = (is_array($structure['ads'])) ? $structure['ads'] : array();
        $configlist = cot_config_list('plug', 'ads', $item['item_cat']);

        if($cfg['plugin']['ads']['purchase_period'] == 'day')
         {
  			   $options['time'] = $period * 24 * 60 * 60;
  			 }
         elseif($cfg['plugin']['ads']['purchase_period'] == 'week')
         {
  			   $options['time'] = $period * 7 * 24 * 60 * 60;
         }
         else
         {
  			   $options['time'] = $period * 30 * 24 * 60 * 60;
         }

     	  $summ = $period * $configlist['price']['config_value'];
        $options['desc'] = $L['ads_payments_desc'];
  			$options['code'] = $id;
        $options['userid'] = $item['item_userid'];

        if(cot_payments_create_adsorder($summ, $options)) {
           cot_message('Баннер добавлен и оплачен');
        } else {
           cot_message('Баннер добавлен, но НЕ оплачен', 'warning');
        }
      } else {
        cot_message($L['item_saved']);
      }

			cot_log("Added new adv # {$id} - {$item['item_title']}", 'adm');			
		}
		if (!empty($ads['item_file']) && isset($data['item_file']) && $ads['item_file'] != $data['item_file'] && file_exists($asd['item_file']))
		{
			unlink($ad['item_file']);
		}
		cot_extrafield_movefiles();
		
		cot_redirect(cot_url('admin', array('m' => 'other', 'p' => 'ads'), '', true));
	}
	else
	{
		if (!empty($file) && file_exists($file))
			unlink($file);
	}
}

$delUrl = ($ad['item_id'] > 0) ? cot_confirm_url(cot_url('admin', 'm=other&p=ads&act=delete&id='.$ads['item_id'].'&'.cot_xg()), 'admin') : '';

$sql = $db->query("SELECT user_id, user_name FROM $db_users ORDER BY `user_id` ASC");
$clients = $sql->fetchAll(PDO::FETCH_KEY_PAIR);
$clients = (!$clients) ? array() : $clients;

$formFile = cot_inputbox('file', 'rfile', $ads['item_file']);
if (!empty($ads['item_file']))
	$formFile .= cot_checkbox(false, 'rdel_rfile', $L['Delete']);

$period = ($cfg['plugin']['ads']['purchase_period'] == 'day') ? range(1, 31) : range(1, 12);

$t->assign(array(
	'FORM_ID' => $ads['item_id'],
	'FORM_TITLE' => cot_inputbox('text', 'rtitle', $ads['item_title'], array('size' => '20',
		'maxlength' => '32')),
	'FORM_CATEGORY' => cot_selectbox_structure('ads', $ads['item_cat'], 'rcat', '', false, false),
	'FORM_FILE' => $formFile,
	'FORM_IMAGE' => $ads['item_file'],
	'FORM_ALT' => cot_inputbox('text', 'ralt', $ads['item_alt']),
	'FORM_CLICKURL' => cot_inputbox('text', 'rclickurl', $ads['item_clickurl']),
	'FORM_DESCRIPTION' => cot_textarea('rdescription', $ads['item_description'], 5, 60),
	'FORM_CLIENT_ID' => cot_selectbox($ads['item_userid'], 'ruserid', array_keys($clients), array_values($clients), false),
  'FORM_PERIOD' => cot_selectbox($ads['item_period'], 'rperiod', $period, $period, false),
	'FORM_PUBLISH_DOWN' => cot_selectbox_date($ads['item_expire'], 'long', 'rexpire'),
	'FORM_DELETE_URL' => $delUrl,
));

foreach ($cot_extrafields[$db_ads] as $exfld)
{
	$uname = strtoupper($exfld['field_name']);
	$exfld_val = cot_build_extrafields('r' . $exfld['field_name'], $exfld, $ads['item_'.$exfld['field_name']]);
	$exfld_title =  isset($L['item_' . $exfld['field_name'] . '_title']) ? $L['item_' . $exfld['field_name'] . '_title'] : $exfld['field_description'];
	$t->assign(array(
		'FORM_' . $uname => $exfld_val,
		'FORM_' . $uname . '_TITLE' => $exfld_title,
		'FORM_EXTRAFLD' => $exfld_val,
		'FORM_EXTRAFLD_TITLE' => $exfld_title
		));
	$t->parse('MAIN.EXTRAFLD');
}

cot_display_messages($t);
$t->assign(array(
	'PAGE_TITLE' => isset($ads['item_id']) ? $L['ads_banner_edit'].": ".htmlspecialchars($ads['item_title']) :
		$L['ads_banner_new'],
));