<?php

(defined('COT_CODE') && defined('COT_PLUG')) or die('Wrong URL.');

global $structure, $cfg, $L, $usr, $sys;

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'ads', 'RWA');
cot_block($usr['auth_write']);

$id = cot_import('id', 'G', 'INT');

$maxrowsperpage = $cfg['maxrowsperpage'];
list($pg, $d, $durl) = cot_import_pagenav('d', $maxrowsperpage);

$act = cot_import('act', 'G', 'ALP');

if (!$id)
{
	$id = 0;
	$ads = array();
}
else
{
	$ads = $db->query("SELECT * FROM $db_ads WHERE item_id = ".(int)$id." AND item_userid=".$usr['id']." LIMIT 1")->fetch();
  if(!$ads)
  {
    cot_die();
  }
}

if ($act == 'add')
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

  $period = cot_import('rperiod', 'P', 'INT');
  $item['item_period'] = $period;
	$item['item_alt'] = cot_import('ralt', 'P', 'TXT');
	$item['item_clickurl'] = cot_import('rclickurl', 'P', 'TXT');
	$item['item_description'] = cot_import('rdescription', 'P', 'TXT');
	$item['item_userid'] = $usr['id'];
  
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
    
			$db->insert($db_ads, $item);
			$id = $db->lastInsertId();
      
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
		
			if ($db->fieldExists($db_payments, "pay_redirect")){
				$options['redirect'] = $cfg['mainurl'].'/'.cot_url('plug', 'e=ads', '', true);
			}
    
		if (!empty($ads['item_file']) && isset($data['item_file']) && $ads['item_file'] != $data['item_file'] && file_exists($asd['item_file']))
		{
			unlink($ad['item_file']);
		}
		cot_extrafield_movefiles();
	//	cot_message($L['item_saved']);
		cot_ads_sync($item['item_cat']);
    
    cot_payments_create_order('ads', $summ, $options);
          
		cot_redirect(cot_url('plug', array('e' => 'ads'), '', true));
	}
	else
	{
		if (!empty($file) && file_exists($file))
			unlink($file);
	}
}

if ($act == 'save' && $id > 0)
{
	$item = array();
  
	$item['item_title'] = cot_import('rtitle', 'P', 'TXT');
	if (empty($item['item_title']))
	{
		cot_error($L['ads_err_titleempty'], 'rtitle');
	}

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
  
  if($ads['item_expire'] == 0 && $ads['item_paused'] == 0)
  {
   $item['item_cat'] = cot_import('rcat', 'P', 'TXT');
   $item['item_period'] = cot_import('rperiod', 'P', 'INT');
	}
  
  $item['item_alt'] = cot_import('ralt', 'P', 'TXT');
	$item['item_clickurl'] = cot_import('rclickurl', 'P', 'TXT');
	$item['item_description'] = cot_import('rdescription', 'P', 'TXT');

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
		
    $db->update($db_ads, $item, "item_id = ".(int)$id);
    
		if (!empty($ads['item_file']) && isset($data['item_file']) && $ads['item_file'] != $data['item_file'] && file_exists($asd['item_file']))
		{
			unlink($ad['item_file']);
		}
    
		cot_extrafield_movefiles();
		cot_message($L['item_saved']);
    
    if($ads['item_expire'] == 0 && $ads['item_paused'] == 0)
    {
		  cot_ads_sync($item['item_cat']);
    }
    
		cot_redirect(cot_url('plug', array('e' => 'ads'), '', true));
	}
	else
	{
		if (!empty($file) && file_exists($file))
			unlink($file);
	}
}
elseif ($act == 'buy' && $ads['item_expire'] == 0 && $ads['item_paused'] == 0)
{
   require_once cot_incfile('configuration');
   $structure['ads'] = (is_array($structure['ads'])) ? $structure['ads'] : array();
   $configlist = cot_config_list('plug', 'ads', $ads['item_cat']);
   
   $period = $ads['item_period'];
       
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
		
	 if ($db->fieldExists($db_payments, "pay_redirect")){
			$options['redirect'] = $cfg['mainurl'].'/'.cot_url('plug', 'e=ads', '', true);
	 }
      
   cot_payments_create_order('ads', $summ, $options);
   
   cot_redirect(cot_url('plug', array('e' => 'ads'), '', true));
}
elseif ($act == 'paused' && $ads['item_expire'] > $sys['now'] && $ads['item_paused'] == 0 && $id > 0)
{
   $db->update($db_ads,  array('item_expire' => 0, 'item_paused' => ($ads['item_expire'] - $sys['now'])), "item_id=".(int)$id);
   
   cot_redirect(cot_url('plug', array('e' => 'ads'), '', true));
}
elseif ($act == 'unpaused' && $ads['item_paused'] > 0 && $id > 0)
{
   $db->update($db_ads,  array('item_expire' => ($ads['item_paused'] + $sys['now']), 'item_paused' => 0), "item_id=".(int)$id);
   
   cot_redirect(cot_url('plug', array('e' => 'ads'), '', true));
}
elseif ($act == 'del' && $ads['item_expire'] < $sys['now'] && $ads['item_paused'] == 0 && $id > 0)
{
	$urlArr = $list_url_path;
	if ($pagenav['current'] > 0)
		$urlArr['d'] = $pagenav['current'];
	$id = cot_import('id', 'G', 'INT');
	
	$item = $db->query("SELECT * FROM $db_ads WHERE item_id = ".(int)$id." AND item_userid=".$usr['id']." LIMIT 1")->fetch();
	if (!$item)
	{
		cot_die();
	}
	
	$db->delete($db_ads, "item_id = ".(int)$id);
	if (file_exists($item['item_file']))
		unlink($item['item_file']);

	foreach ($cot_extrafields[$db_ads] as $exfld)
	{
		cot_extrafield_unlinkfiles($item['item_' . $exfld['field_name']], $exfld);
	}

	cot_redirect(cot_url('plug', 'e=ads', '', true));
}

$t = new XTemplate(cot_tplfile(array('ads', 'main'), 'plug'));
cot_display_messages($t);

$where = 'WHERE user_id='.(($ads['item_userid'] > 0) ? $ads['item_userid'] : $usr['id']);

$formFile = cot_inputbox('file', 'rfile', $ads['item_file']);
if (!empty($ads['item_file']))
	$formFile .= cot_checkbox(false, 'rdel_rfile', $L['Delete']);

$period = ($cfg['plugin']['ads']['purchase_period'] == 'day') ? range(1, 31) : range(1, 12);
$t->assign(array(
	'ADS_FORM_ID' => $ads['item_id'],
	'ADS_FORM_TITLE' => cot_inputbox('text', 'rtitle', $ads['item_title'], array('size' => '20', 'maxlength' => '32')),
	'ADS_FORM_CATEGORY' => ads_selectbox($ads['item_cat'], 'rcat', false),
	'ADS_FORM_FILE' => $formFile,
	'ADS_FORM_IMAGE' => $ads['item_file'],
	'ADS_FORM_PERIOD' => cot_selectbox($ads['item_period'], 'rperiod', $period, $period, false),
	'ADS_FORM_ALT' => cot_inputbox('text', 'ralt', $ads['item_alt']),
	'ADS_FORM_CLICKURL' => cot_inputbox('text', 'rclickurl', $ads['item_clickurl']),
	'ADS_FORM_DESCRIPTION' => cot_textarea('rdescription', $ads['item_description'], 5, 60),
));

foreach ($cot_extrafields[$db_ads] as $exfld)
{
	$uname = strtoupper($exfld['field_name']);
	$exfld_val = cot_build_extrafields('r' . $exfld['field_name'], $exfld, $ads['item_'.$exfld['field_name']]);
	$exfld_title =  isset($L['item_' . $exfld['field_name'] . '_title']) ? $L['item_' . $exfld['field_name'] . '_title'] : $exfld['field_description'];
	$t->assign(array(
		'ADS_FORM_' . $uname => $exfld_val,
		'ADS_FORM_' . $uname . '_TITLE' => $exfld_title,
		'ADS_FORM_EXTRAFLD' => $exfld_val,
		'ADS_FORM_EXTRAFLD_TITLE' => $exfld_title
		));
	$t->parse('MAIN.EDIT.EXTRAFLD');
	$t->parse('MAIN.SHOW.EXTRAFLD');
}

$t->assign(array(
	'PAGE_TITLE' => isset($ads['item_id']) ? $L['ads_banner_edit'].": ".htmlspecialchars($ads['item_title']) :
		$L['ads_banner_new'],
));


$list = $db->query("SELECT * FROM $db_ads WHERE item_userid=".$usr['id']."")->fetchAll();

$jj=0;
foreach ($list as $item)
{
  $jj++;
	$t->assign(ads_generate_tags($item, 'ADS_ROW_'));
	$t->assign(array(
		'ADS_ROW_NUM' => $jj,
	));
	$t->parse('MAIN.SHOW.ADS_ROW');
}

$t->assign(array(
	'ADS_COUNT' => $jj
));

if($id > 0)
{
 $t->parse('MAIN.EDIT');
}
else
{
 $t->parse('MAIN.SHOW');
}