<?php defined('COT_CODE') && defined('COT_PLUG') or die('Wrong URL');
 /**
 * [BEGIN_COT_EXT]
 * Hooks=standalone
 * [END_COT_EXT]
 */

require_once cot_incfile('buycontacts', 'plug');

list($auth_read, $auth_write, $auth_admin) = cot_auth('plug', 'buycontacts');
cot_block($auth_write);

$id = cot_import('id', 'G', 'INT');	

	if ($a == 'buycontacts' && !empty($id))
	{
		$summ = cot_contact_getcost($id);//отримати вартість для покупки по проекту
		cot_check($summ == false, cot_rc($L['buycontacts_err'], array('err_num' => 1)));
		$param = cot_contact_getparam($id);
		if(isset($param['offer_id'])){ //перевірямо чи є запис пропозиції для проекту, якщо немає то помилка
			cot_check(empty($param['offer_id']), cot_rc($L['buycontacts_err'], array('err_num' => 2)));
			cot_check(empty($param['prj_title']), cot_rc($L['buycontacts_err'], array('err_num' => 3)));

			if(!cot_error_found()){
					$options['code'] = $param['offer_id']; //отримати ІД пропозиції
					$options['desc'] = cot_rc($L['buy_contact_desc'], array('prj_title' => $param['prj_title'])); //Назва проекту
					
					if ($db->fieldExists($db_payments, "pay_redirect") && isset($param['prj_cat'])){

						$options['redirect'] = (empty($param['prj_alias'])) ? 
						cot_url('projects', 'c='.$param['prj_cat'].'&id='.$id,'', true) : cot_url('projects', 'c='.$param['prj_cat'].'&al='.$param['prj_alias'],'', true);
						//$cfg['mainurl'].'/'.cot_url('payments', 'm=balance', '', true);
					}					
					cot_payments_create_order('prj.buycontacts', $summ, $options);
				}
			}else{
				cot_error('buycontacts_err_offer', 'error'); // помилка якщо немає пропозицій
			}
	}

$t = new XTemplate(cot_tplfile('buycontacts', 'plug'));

cot_display_messages($t);

$t->assign(array(
	'BC_URL_BACK' => $_SERVER['HTTP_REFERER']
));