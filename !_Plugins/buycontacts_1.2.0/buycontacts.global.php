<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=global
[END_COT_EXT]
==================== */

require_once cot_incfile('buycontacts', 'plug');
require_once cot_incfile('projects', 'module');
require_once cot_incfile('payments', 'module');

if ($pays = cot_payments_getallpays('prj.buycontacts', 'paid'))
{
	foreach ($pays as $pay)
	{	
		//Статус змінити статус платежу 
		if (cot_payments_updatestatus($pay['pay_id'], 'done'))
		{
			//Статус що контакт придбаний для пропозиції по проекту
			$db->update($db_projects_offers,  array('item_buycontacts' => 1), "item_id=".(int)$pay['pay_code']);			
		}
	}
}