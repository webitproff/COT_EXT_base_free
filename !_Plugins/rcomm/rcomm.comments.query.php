<?PHP
/* ====================
[BEGIN_COT_EXT]
Hooks=comments.query
[END_COT_EXT]

==================== */

/**
 * Reply for Comments plugin
 *
 * @package rcomm
 * @author Dr2005alex
 * @copyright Copyright (c) Dr2005alex 2013 | Updated and bugfixed by Dmitri Beliavski (https://sed.by/) 2023
 * @license BSD License
 **/


defined('COT_CODE') or die('Wrong URL');

$db_com = Cot::$db->com;

$ord = explode(" ",$comments_order);
$comments_order = ($ord[1] == 'ASC') ? ' com_reply_date ASC,  com_id ASC ' : ' com_reply_date DESC,  com_id DESC ' ;

if ($cfg['jquery'] && $cfg['plugin']['rcomm']['ajax_send']) {
  // открытие всеx просмотренных комментариев
  if( $R['opencomments']) {
    $pagenav['current'] = (empty($pagenav['current'])) ? 1 : $pagenav['current'];
    $cfg['plugin']['comments']['maxcommentsperpage'] = (int)$cfg['plugin']['comments']['maxcommentsperpage'] * $pagenav['current'];
    $d = 0;
  }
}

$sql = Cot::$db->query("SELECT * FROM $db_com WHERE com_area = ? AND com_code = ?  ORDER BY $comments_order ", array($ext_name, $code));
$total_comm = $sql->rowCount();
$i = 0;
foreach ($sql->fetchAll() as $row) {
  $i++;
  $reply_index[$row['com_id']]= ( $ord[1] == 'ASC' ) ? $i : $total_comm - $i+1;
  $reply_index['id'][$row['com_id']]= $row['com_id'];

  // поиск первого ответа и последнего
  if ($row['com_reply'] != 0 ) {
    if (empty($coord[$row['com_reply']]['first'])) {
      $coord[$row['com_reply']]['first'] =  $row['com_id'];
    }
    $coord[$row['com_reply']]['last'] =  $row['com_id'];
  }
}
