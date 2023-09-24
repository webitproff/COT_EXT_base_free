<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=standalone
[END_COT_EXT]
==================== */

require_once cot_incfile('amarket', 'plug');

if ($m == 'mysales' || $m == 'myorders'){ // Продавец ||  Покупатель

	if(!in_array($n, array('forconfirm','waitpayment','paid','cancelled'))){
		$n = 'forconfirm';
	}

}elseif ($m == 'list'){ // Страница продавца / список товаров
	
	if(!in_array($n, array('edit','seller'))){
		$n = 'seller';
	}	
	$m .= '.'.$n; 
}elseif ($m == 'pay' || $m == 'cancel'){

	$amo_id = cot_import('amo_id', 'G', 'INT');
	
}

if(empty($m) || !isset($m)){ //Якщо відсутні параметри то по основній группі визначаємо

	switch ((int)$usr['maingrp']) {
		case (int)$cfg['plugin']['amarket']['am_seller_id']:
				$m = 'mysales';
				$n = 'forconfirm';
			break;
		case (int)$cfg['plugin']['amarket']['am_custumer_id']:
				$m = 'myorders';
				$n = 'forconfirm';
			break;
		default:
				cot_block();
			break;
	}
}

require_once cot_incfile('amarket', 'plug', $m);