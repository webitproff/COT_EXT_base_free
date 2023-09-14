<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('mailchimp', 'plug');

if(!empty($_POST['mailchimp_list']) && !empty($_POST['mailchimp_email'])) {
  require_once cot_incfile('mailchimp', 'plug');
  cot_mailchimp_subscribe($_POST['mailchimp_list'], $_POST['mailchimp_email'], 'subscribed', array('FNAME' => '', 'PHONE' => ''));
}
