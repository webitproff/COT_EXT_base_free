<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */

/**
 * tiuorders plugin
 *
 * @package tiuorders
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('tiuorders', 'plug');
require_once cot_incfile('products', 'module');
require_once cot_incfile('payments', 'module');

// Проверяем платежки на оплату в маркете
if ($productspays = cot_payments_getallpays('tiuorders', 'paid'))
{
	foreach ($productspays as $pay)
	{
		if (cot_payments_updatestatus($pay['pay_id'], 'done'))
		{
			$db->update($db_products_orders,  array('order_paid' => (int)$sys['now'], 'order_status' => 'paid'), "order_id=".(int)$pay['pay_code']);

			$tiuorder = $db->query("SELECT * FROM $db_products_orders AS o
				LEFT JOIN $db_products AS m ON m.prd_id=o.order_pid
				WHERE order_id=".$pay['pay_code'])->fetch();

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
			
			$summ = $tiuorder['order_cost'] - $tiuorder['order_cost']*$cfg['plugin']['tiuorders']['tax']/100;
			
			// Уведопляем продавца о совершении покупки его товара
			$rsubject = cot_rc($L['tiuorders_paid_mail_toseller_header'], array('order_id' => $tiuorder['order_id'], 'product_title' => $tiuorder['prd_title']));
			$rbody = cot_rc($L['tiuorders_paid_mail_toseller_body'], array(
				'user_name' => $customer['user_name'],
				'product_id' => $tiuorder['prd_id'],
				'product_title' => $tiuorder['prd_title'],
				'order_id' => $tiuorder['order_id'],
				'summ' => $summ.' '.$cfg['payments']['valuta'],	
				'tax' => $cfg['plugin']['tiuorders']['tax'],	
				'warranty' => $cfg['plugin']['tiuorders']['warranty'],	
				'sitename' => $cfg['maintitle'],
				'link' => COT_ABSOLUTE_URL . cot_url('tiuorders', "id=" . $tiuorder['order_id'], '', true)
			));
			cot_mail ($seller['user_email'], $rsubject, $rbody);
			
			// Уведопляем покупателя о совершении покупки
			if(!empty($tiuorder['order_email']))
			{
				$key = sha1($tiuorder['order_email'].'&'.$tiuorder['order_id']);
			}
			
			$rsubject = cot_rc($L['tiuorders_paid_mail_tocustomer_header'], array('order_id' => $tiuorder['order_id'], 'product_title' => $tiuorder['prd_title']));
			$rbody = cot_rc($L['tiuorders_paid_mail_tocustomer_body'], array(
				'user_name' => $customer['user_name'],
				'product_id' => $tiuorder['prd_id'],
				'product_title' => $tiuorder['prd_title'],
				'order_id' => $tiuorder['order_id'],
				'cost' => $tiuorder['order_cost'].' '.$cfg['payments']['valuta'],	
				'tax' => $cfg['plugin']['tiuorders']['tax'],	
				'warranty' => $cfg['plugin']['tiuorders']['warranty'],	
				'sitename' => $cfg['maintitle'],
				'link' => COT_ABSOLUTE_URL . cot_url('tiuorders', "id=" . $tiuorder['order_id'] . '&key=' . $key, '', true)
			));
			cot_mail ($customer['user_email'], $rsubject, $rbody);
			
			/* === Hook === */
			foreach (cot_getextplugins('tiuorders.order.paid') as $pl)
			{
				include $pl;
			}
			/* ===== */
		}
	}
}

// Выплаты продавцам по завершению гарантийного срока по оформленным заказам
$warranty = $cfg['plugin']['tiuorders']['warranty']*60*60*24;
$tiuorders = $db->query("SELECT * FROM $db_products_orders AS o
	LEFT JOIN $db_products AS m ON m.prd_id=o.order_pid
	WHERE order_status='paid' AND order_paid+".$warranty."<".$sys['now'])->fetchAll();
foreach ($tiuorders as $tiuorder)
{
	// Выплата продавцу на счет
	$seller = $db->query("SELECT * FROM $db_users WHERE user_id=".$tiuorder['order_seller'])->fetch();
	
	$summ = $tiuorder['order_cost'] - $tiuorder['order_cost']*$cfg['plugin']['tiuorders']['tax']/100;
	
	$payinfo['pay_userid'] = $tiuorder['order_seller'];
	$payinfo['pay_area'] = 'balance';
	$payinfo['pay_code'] = 'tiuorders:'.$tiuorder['order_id'];
	$payinfo['pay_summ'] = $summ;
	$payinfo['pay_cdate'] = $sys['now'];
	$payinfo['pay_pdate'] = $sys['now'];
	$payinfo['pay_adate'] = $sys['now'];
	$payinfo['pay_status'] = 'done';
	$payinfo['pay_desc'] = cot_rc($L['tiuorders_done_payments_desc'], 
		array(
			'product_title' => $tiuorder['prd_title'],
			'order_id' => $tiuorder['order_id']
		)
	);

	if($db->insert($db_payments, $payinfo))
	{
		// Уведомляем продавца о поступлении оплаты на его счет
		$rsubject = cot_rc($L['tiuorders_done_mail_toseller_header'], array('order_id' => $tiuorder['order_id'], 'product_title' => $tiuorder['prd_title']));
		$rbody = cot_rc($L['tiuorders_done_mail_toseller_body'], array(
			'product_id' => $tiuorder['prd_id'],
			'product_title' => $tiuorder['prd_title'],
			'order_id' => $tiuorder['order_id'],
			'summ' => $summ.' '.$cfg['payments']['valuta'],	
			'tax' => $cfg['plugin']['tiuorders']['tax'],	
			'sitename' => $cfg['maintitle'],
			'link' => COT_ABSOLUTE_URL . cot_url('tiuorders', "id=" . $tiuorder['order_id'], '', true)
		));
		cot_mail ($seller['user_email'], $rsubject, $rbody);
		
		$rorder['order_done'] = $sys['now'];
		$rorder['order_status'] = 'done';

		$db->update($db_products_orders, $rorder, "order_id=".$tiuorder['order_id']);
	}
}