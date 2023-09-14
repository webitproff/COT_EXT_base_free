<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=ajax
[END_COT_EXT]
==================== */
 
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('sendfieldstomail', 'plug');

$id = cot_import('stmid','G','INT');
$type = cot_import('sfmtype','G','TXT');
$email = urldecode(cot_import('sfmemail','G','TXT'));

$return = array('status' => 'error', 'msg' => $L['sendfieldstomail_error']);

if(!empty($email) && $id > 0 && in_array($type, array('page', 'market')))
{
  if($type == 'page') {
    require_once cot_incfile('page', 'module');

  	$data = $db->query("SELECT p.*, u.* FROM $db_pages AS p
  		LEFT JOIN $db_users AS u ON u.user_id=p.page_ownerid
  		WHERE p.page_id=".$id." LIMIT 1")->fetch();
  }
  elseif($type == 'market') {
    require_once cot_incfile('market', 'module');

    $data = $db->query("SELECT p.*, u.* FROM $db_market AS p LEFT JOIN $db_users AS u ON u.user_id=p.item_userid WHERE item_id=".$id." LIMIT 1")->fetch();
  }

  if(($type == 'page' && $data['page_id'] > 0) || ($type == 'market' && $data['item_id'] > 0)) {
    cot_sendfieldstomail($email, $type, $id);
    $return = array('status' => 'success', 'msg' => $L['sendfieldstomail_success']);
  }
}
elseif(empty($email))
{
  $return['msg'] = $L['sendfieldstomail_empty_email'];
}

echo json_encode($return);

?>
