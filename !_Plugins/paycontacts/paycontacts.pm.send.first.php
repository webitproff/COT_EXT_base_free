<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=pm.send.first
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('paycontacts', 'plug');

if(!cot_getpaycontactspm_send($to))
{
  cot_redirect(cot_url('users', 'm=details&id='.$to, '', true));
}
 