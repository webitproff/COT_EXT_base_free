<?php defined('COT_CODE') or die('Wrong URL');

	$out['subtitle'] = cot_am_title($m,$n);

	//Edit prd list for confirn
	cot_blockguests();

	$patharray[] = array(cot_url('amarket'), $L["amarket_mysales_title"]);

	$amo_id = cot_import('amo_id', 'G', 'INT');

	if($a == "save"){
		cot_check_xp();
		$prd_count = cot_import('prd_count', 'P', 'ARR');
		
		array_walk($prd_count, function(&$count,$key){ //значення кількості тоарів не може бути менше 1 (переписуємо якщо є такі)
			$count = ((int)$count > 1) ? (int)$count : 1 ;
		});

		// Extra fields
		if (isset($cot_extrafields[$db_amarket_orders])){	
			foreach ($cot_extrafields[$db_amarket_orders] as $exfld){
				$ramarket['amo_'.$exfld['field_name']] = cot_import_extrafields('amo_'.$exfld['field_name'], $exfld, 'P', $ramarket['amo_'.$exfld['field_name']]);
			}
			if($db->update($db_amarket_orders,$ramarket, "amo_id = ?", $amo_id)){
				cot_message($L['amarket_update_extfld'], 'ok');
			}
		}

		$update_count = 0;
		foreach ($prd_count as $amp_id => $value) {
			if($db->update($db_amarket_products,array('amp_prd_count' => $value), "amo_id = ? AND amp_id = ?", array($amo_id, $amp_id))){
				$update_count++;
			}
		}		
		cot_message(cot_rc($L['amarket_update_count'], array('count' => $update_count)), 'ok');
		cot_redirect(cot_url('amarket', 'm=list&n=edit&amo_id='.$amo_id, '', true));
	}
	if($a == 'delete'){

		cot_check_xg();
		$prd_id = cot_import('prd_id', 'G', 'INT');
		$products_count = $db->query("SELECT COUNT(*) FROM {$db_amarket_products} WHERE amo_id = ?", $amo_id)->fetchColumn();
		if($products_count > 1 && $prd_id > 0){
			if($db->delete($db_amarket_products, "amo_id = ? AND amp_prd_id = ?", array($amo_id, $prd_id))){
				cot_message($L['Deleted'], 'ok');
			}else{
				cot_message($L['amarket_err_delete_prd_ukn'], 'error');
			}
		}else{
			cot_message($L['amarket_err_delete_prd'], 'error');
		}		
		cot_redirect(cot_url('amarket', 'm=list&n=edit&amo_id='.$amo_id, '', true));
	}

	$prds = $db->query("SELECT p.*, o.* FROM {$db_amarket_products} AS p INNER JOIN {$db_amarket_orders} AS o ON p.amo_id = o.amo_id WHERE o.amo_id = ? AND o.amo_seller = ?", array($amo_id, $usr['id']))->fetchAll();
	
	$t = new XTemplate(cot_tplfile("amarket.{$m}.{$n}", "plug"));
	$prds_count = count($prds);
	foreach ($prds as $prd) {
		
		$t->assign(cot_generate_markettags($prd['amp_prd_id'],'ROW_PRD_'));
		$t->assign(array(
			"ROW_PRD_COUNT" 		=> $prd['amp_prd_count'],
			"ROW_PRD_COUNT_INPUT" 	=> cot_inputbox('number', 'prd_count['.$prd["amp_id"].']', $prd['amp_prd_count'], array('size' => 4, 'maxlength' => 4, 'min' => 1, 'max' => 9999, 'step' => 1))
			));

		if($prds_count > 1){ //Якщо товарів не менше 1 в списку то можна видалити
			$delete_url = cot_url('amarket', 'm=list&n=edit&a=delete&amo_id='.$amo_id.'&prd_id='.$prd["amp_prd_id"]."&".cot_xg(),'',true);
			$t->assign("ROW_PRD_DELETE", cot_rc_link($delete_url, $L['Delete']));
		}

		$t->parse("MAIN.ROW");
	}

	// Extra fields
	if (isset($cot_extrafields[$db_amarket_orders])){	
		$amo_data = $db->query("SELECT * FROM {$db_amarket_orders} WHERE amo_id=?",$amo_id)->fetch();	
		foreach($cot_extrafields[$db_amarket_orders] as $exfld)	{
			$uname = strtoupper($exfld['field_name']);
			$exfld_val = cot_build_extrafields('amo_'.$exfld['field_name'], $exfld, $amo_data['amo_'.$exfld['field_name']]);
			$exfld_title = isset($L['amarket_'.$exfld['field_name'].'_title']) ?  $L['amarket_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
			$t->assign(array(
				'EXTFLD_ROW'.$uname => $exfld_val,
				'EXTFLD_ROW'.$uname.'_TITLE' => $exfld_title,
				'EXTFLD_ROW' => $exfld_val,
				'EXTFLD_ROW_TITLE' => $exfld_title
				));
			$t->parse("MAIN.EXTFLD_ROW");
		}
	}
	
	require_once cot_incfile('users', 'module');
	$customer_data = cot_user_data($prds[0]['amo_customer']);

	$currentbrc[] = array(cot_url('amarket', 'm=list&n=edit&amo_id='.$amo_id), cot_rc('amarket_brc_title', array('user_name' => $customer_data["user_name"],'data' => cot_date("d.m.Y",$prds[0]['amo_added']))));
	$t->assign(array(
		"LIST_FORM_URL" => cot_url('amarket', 'm=list&n=edit&a=save&amo_id='.$amo_id),
		"BREADCRUMBS" 	=> cot_breadcrumbs(array_merge($patharray, $currentbrc), $cfg['homebreadcrumb'], true),
		));

	cot_display_messages($t);