<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=usertags.main
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') or die('Wrong URL.');

if($user_data['user_id'] > 0)
{
 require_once cot_incfile('prjmap', 'plug');
 global $usr;
 $adr = explode('#', $user_data['user_prjmap']);

 $temp_array['PRJMAP_ADR'] = $adr[0];
 $temp_array['PRJMAP_DIST'] = cot_prjmap_getdistance(array($user_data['user_prjmaplat'], $user_data['user_prjmaplng']), $usr['profile'], 'text');

 $temp_array['PRJMAP'] = cot_get_prjmap_user_map($user_data);
}

?>
