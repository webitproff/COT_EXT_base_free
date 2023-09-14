<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=users.passrecover.first
[END_COT_EXT]
==================== */
 
defined('COT_CODE') or die('Wrong URL');

cot_block($usr['id'] == 0);

if ($a == 'request' && $email != '')
{
	cot_shield_protect();
	$sql = $db->query("SELECT user_id, user_name, user_lostpass FROM $db_users WHERE user_email='".$db->prep($email)."' ORDER BY user_id ASC");

  $email_found= FALSE;
	while ($row = $sql->fetch())
	{
		$rusername = $row['user_name'];
		$ruserid = $row['user_id'];
		$validationkey = $row['user_lostpass'];

		if (empty($validationkey) || $validationkey == "0")
		{
			$validationkey = md5(microtime());
			$sql = $db->update($db_users, array('user_lostpass' => $validationkey, 'user_lastip' => $usr['ip']), "user_id=$ruserid");
		}

		$email_found = TRUE;
		if (!$cfg['useremailduplicate']) break;
	}
	if ($email_found)
	{
		cot_shield_update(60, "Password recovery email sent");
    cot_redirect(cot_url('users', 'm=passrecover&a=auth&v='.$validationkey, '', true));
  }
	else
	{
		cot_shield_update(10, "Password recovery requested");
		$env['status'] = '403 Forbidden';
		cot_log("Pass recovery failed, user : ".$rusername);
		cot_redirect(cot_url('message', 'msg=154', '', true));
	}
}
?>
