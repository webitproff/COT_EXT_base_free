<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=global
[END_COT_EXT]
==================== */

require_once cot_incfile('deleteme', 'plug');
require_once cot_incfile('payments', 'module');

// Проверяем платежки на оплату услуги Удаления профиля.
if ($dmpays = cot_payments_getallpays('deleteme', 'paid'))
{
	foreach ($dmpays as $pay)
	{	
		$id = $pay['pay_userid'];
		/*$sql = $db->delete($db_users, "user_id=$id");
		$sql = $db->delete($db_groups_users, "gru_userid=$id");

		foreach($cot_extrafields[$db_users] as $exfld)
		{
			cot_extrafield_unlinkfiles($urr['user_'.$exfld['field_name']], $exfld);
		}

		if (cot_module_active('pfs') && $cfg['plugin']['deleteme']['dm_pfs'])
		{
			require_once cot_incfile('pfs', 'module');
			cot_pfs_deleteall($id);
		}

		/* === Hook === */
		foreach (cot_getextplugins('users.edit.update.delete') as $pl)
		{
			include $pl;
		}
		/* ===== */		


		if (cot_payments_updatestatus($pay['pay_id'], 'done'))
		{
			/* === Hook === */
			foreach (cot_getextplugins('deleteme.done') as $pl)
			{
				include $pl;
			}
			/* ===== */

			cot_log("Deleted user #".$id,'adm');			
			
			if($cfg['plugin']['deleteme']['dm_notif']){
				 $body = cot_rc($L['dm_mail_body'], array('name' => $usr['name'], 'mail' => $usr['profile']['user_email'],'cost' => $pay['pay_summ'].' '.$cfg['payments']['valuta']));
				 cot_mail($cfg['adminemail'], $L['dm_mail_subj'], $body);
			}
		
		}
		
		cot_redirect(cot_url('message', "msg=109&rc=200&id=".$id, '', true));
	}
}


