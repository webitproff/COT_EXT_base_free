<?php

/**
 * tiuorders plugin
 *
 * @package tiuorders
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

$id = cot_import('id', 'G', 'INT');
$key = cot_import('key', 'G', 'TXT');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'tiuorders');
cot_block($usr['auth_read']);

if ($id > 0)
{
	$sql = $db->query("SELECT * FROM $db_products_orders  AS o
		LEFT JOIN $db_products AS p ON p.prd_id=o.order_pid
		WHERE order_status!='new' AND order_id=".$id." LIMIT 1");
}

if (!$id || !$sql || $sql->rowCount() == 0)
{
	cot_die_message(404, TRUE);
}
$tiuorder = $sql->fetch();

cot_block($usr['isadmin'] || $usr['id'] == $tiuorder['order_userid'] || $usr['id'] == $tiuorder['order_seller'] || !empty($key) && $usr['id'] == 0);

if($usr['id'] == 0)
{
	$hash = sha1($tiuorder['order_email'].'&'.$tiuorder['order_id']);
	cot_block($key == $hash);
}

/* === Hook === */
$extp = cot_getextplugins('tiuorders.order.first');
foreach ($extp as $pl)
{
	include $pl;
}
/* ===== */

$out['subtitle'] = $L['tiuorders_title'];
$out['head'] .= $R['code_noindex'];

$mskin = cot_tplfile(array('tiuorders', 'order', $structure['products'][$tiuorder['prd_cat']]['tpl']), 'plug');

/* === Hook === */
foreach (cot_getextplugins('tiuorders.order.main') as $pl)
{
	include $pl;
}
/* ===== */

$t = new XTemplate($mskin);

$catpatharray[] = array(cot_url('products'), $L['Products']);
//$catpatharray = array_merge($catpatharray, cot_structure_buildpath('products', $item['prd_cat']));
//$catpatharray[] = array(cot_url('products', 'id='.$id), $tiuorder['prd_title']);
$catpatharray[] = array('', $L['tiuorders_title']);

$catpath = cot_breadcrumbs($catpatharray, $cfg['homebreadcrumb'], true);

$t->assign(array(
	"BREADCRUMBS" => $catpath,
));

// Error and message handling
cot_display_messages($t);

$t->assign(cot_generate_prdtags($tiuorder['order_pid'], 'ORDER_PRD_', $cfg['products']['shorttextlen'], $usr['isadmin'], $cfg['homebreadcrumb']));
$t->assign(cot_generate_usertags($tiuorder['order_seller'], 'ORDER_SELLER_'));
$t->assign(cot_generate_usertags($tiuorder['order_userid'], 'ORDER_CUSTOMER_'));

$t->assign(array(
	"ORDER_ID" => $tiuorder['order_id'],
	"ORDER_COUNT" => $tiuorder['order_count'],
	"ORDER_COST" => $tiuorder['order_cost'],
	"ORDER_TITLE" => $tiuorder['order_title'],
	"ORDER_COMMENT" => $tiuorder['order_text'],
	"ORDER_EMAIL" => $tiuorder['order_email'],
	"ORDER_PAID" => $tiuorder['order_paid'],
	"ORDER_DONE" => $tiuorder['order_done'],
	"ORDER_STATUS" => $tiuorder['order_status'],
	"ORDER_DOWNLOAD" => (in_array($tiuorder['order_status'], array('paid', 'done')) && !empty($tiuorder['prd_file']) && file_exists($cfg['plugin']['tiuorders']['filepath'].'/'.$tiuorder['prd_file'])) ? cot_url('plug', 'r=tiuorders&m=download&id='.$tiuorder['order_id'].'&key='.$key) : '',
	"ORDER_LOCALSTATUS" => $L['tiuorders_status_'.$tiuorder['order_status']],
	"ORDER_WARRANTYDATE" => $tiuorder['order_paid'] + $cfg['plugin']['tiuorders']['warranty']*60*60*24,
));

if($tiuorder['order_status'] == 'claim')
{
	$t->assign(array(
		"CLAIM_DATE" => $tiuorder['order_claim'],
		"CLAIM_TEXT" => $tiuorder['order_claimtext'],
	));
	
	if($usr['isadmin'])
	{
		// Отменяем заказ, возвращаем оплату покупателю
		if($a == 'acceptclaim')
		{
			$rorder['order_cancel'] = $sys['now'];
			$rorder['order_status'] = 'cancel';

			if($db->update($db_products_orders, $rorder, 'order_id='.$id))
			{
				if($tiuorder['order_userid'] > 0)
				{
					$payinfo['pay_userid'] = $tiuorder['order_userid'];
					$payinfo['pay_area'] = 'balance';
					$payinfo['pay_code'] = 'products:'.$tiuorder['order_id'];
					$payinfo['pay_summ'] = $tiuorder['order_cost'];
					$payinfo['pay_cdate'] = $sys['now'];
					$payinfo['pay_pdate'] = $sys['now'];
					$payinfo['pay_adate'] = $sys['now'];
					$payinfo['pay_status'] = 'done';
					$payinfo['pay_desc'] = cot_rc($L['tiuorders_claim_payments_customer_desc'], 
						array(
							'product_title' => $tiuorder['prd_title'],
							'order_id' => $tiuorder['order_id']
						)
					);

					$db->insert($db_payments, $payinfo);
				}
				
				$seller = $db->query("SELECT * FROM $db_users WHERE user_id=".$tiuorder['order_seller'])->fetch();
				
				if($tiuorder['order_userid'] > 0)
				{
					$customer = $db->query("SELECT * FROM $db_users WHERE user_id=".$tiuorder['order_userid'])->fetch();
				}
				else
				{
					$customer['user_name'] = $tiuorder['order_email'];
					$customer['user_email'] = $tiuorder['order_email'];
				}
				
				// Уведопляем продавца об отмене заказа
				$rsubject = cot_rc($L['tiuorders_acceptclaim_mail_toseller_header'], array('order_id' => $tiuorder['order_id'], 'product_title' => $tiuorder['prd_title']));
				$rbody = cot_rc($L['tiuorders_acceptclaim_mail_toseller_body'], array(
					'product_id' => $tiuorder['prd_id'],
					'product_title' => $tiuorder['prd_title'],
					'order_id' => $tiuorder['order_id'],	
					'sitename' => $cfg['maintitle'],
					'link' => COT_ABSOLUTE_URL . cot_url('tiuorders', "id=" . $tiuorder['order_id'], '', true)
				));
				cot_mail ($seller['user_email'], $rsubject, $rbody);

				// Уведопляем покупателя об отмене заказа
				$rsubject = cot_rc($L['tiuorders_acceptclaim_mail_tocustomer_header'], array('order_id' => $tiuorder['order_id'], 'product_title' => $tiuorder['prd_title']));
				$rbody = cot_rc($L['tiuorders_acceptclaim_mail_tocustomer_body'], array(
					'product_id' => $tiuorder['prd_id'],
					'product_title' => $tiuorder['prd_title'],
					'order_id' => $tiuorder['order_id'],	
					'sitename' => $cfg['maintitle'],
					'link' => COT_ABSOLUTE_URL . cot_url('tiuorders', "id=" . $tiuorder['order_id'], '', true)
				));
				cot_mail ($customer['user_email'], $rsubject, $rbody);

				cot_redirect(cot_url('tiuorders', 'm=order&id=' . $id, '', true));
				exit;
			}
			
			cot_redirect(cot_url('tiuorders', 'm=order&id=' . $id, '', true));
			exit;
		}
		
		// Отменяем жалобу
		if($a == 'cancelclaim')
		{
			$rorder['order_claim'] = 0;
			$rorder['order_status'] = 'paid';

			if($db->update($db_products_orders, $rorder, 'order_id='.$id))
			{
				$customer = $db->query("SELECT * FROM $db_users WHERE user_id=".$tiuorder['order_userid'])->fetch();
				
				// Уведопляем покупателя об отклонении жалобы
				$rsubject = cot_rc($L['tiuorders_cancelclaim_mail_tocustomer_header'], array('order_id' => $tiuorder['order_id'], 'product_title' => $tiuorder['prd_title']));
				$rbody = cot_rc($L['tiuorders_cancelclaim_mail_tocustomer_body'], array(
					'product_title' => $tiuorder['prd_title'],
					'order_id' => $tiuorder['order_id'],	
					'sitename' => $cfg['maintitle'],
					'link' => COT_ABSOLUTE_URL . cot_url('tiuorders', "id=" . $tiuorder['order_id'], '', true)
				));
				cot_mail ($customer['user_email'], $rsubject, $rbody);
			}
			
			cot_redirect(cot_url('tiuorders', 'm=order&id=' . $id, '', true));
			exit;
		}
		
		$t->parse('MAIN.CLAIM.ADMINCLAIM');
	}
	$t->parse('MAIN.CLAIM');
}

/* === Hook === */
foreach (cot_getextplugins('tiuorders.order.tags') as $pl)
{
	include $pl;
}
/* ===== */
