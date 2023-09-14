
<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=input
Order=10
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

if ($usr['id'] > 0 || (!$cfg['plugin']['whowhere']['disable_guests'] && !empty($usr['ip'])))
{
  require_once cot_incfile('whowhere', 'plug');

  $params = array(
    'r' => cot_import('r', 'G', 'TXT'),
    'e' => cot_import('e', 'G', 'TXT'),
    'm' => cot_import('m', 'G', 'TXT'),
    'n' => cot_import('n', 'G', 'TXT'),
    'c' => cot_import('c', 'G', 'TXT'),
    'id' => cot_import('id', 'G', 'INT'),
    'al' => cot_import('al', 'G', 'TXT'),
  );

  $whowhere_upd = array(
    'ww_ip' => $usr['ip'],
    'ww_userid' => $usr['id'],
    'ww_date' => $sys['now'],
    'ww_code' => '',
    'ww_var_e' => $params['e'],
    'ww_var_m' => $params['m'],
    'ww_var_n' => $params['n'],
    'ww_var_c' => $params['c'],
    'ww_var_id' => $params['id'],
    'ww_var_al' => $params['al'],
    'ww_var_url' => $_SERVER['REQUEST_URI'],
  );

  if(empty($params['r']) && (empty($params['e']) || $params['e'] == 'index')) {
    $whowhere_upd['ww_code'] = 'index';
  } elseif(empty($params['r']) && !empty($params['e'])) {
    $whowhere_cfg = cot_whowhere_cfg(false);

    foreach($whowhere_cfg as $code => $ww) {
      $usl = true;
      foreach($ww['usl'] as $k => $v) {
        if(!isset($params[$k])) $params[$k] = cot_import($k, 'G', 'TXT');
        if($params[$k] != $v) {
          $usl = false;
          break;
        }
      }
      if(is_array($ww['usl_empty'])) foreach($ww['usl_empty'] as $k) {
        if(!isset($params[$k])) $params[$k] = cot_import($k, 'G', 'TXT');
        if(!empty($params[$k])) {
          $usl = false;
          break;
        }
      }
      if(is_array($ww['usl_not_empty'])) foreach($ww['usl_not_empty'] as $k) {
        if(!isset($params[$k])) $params[$k] = cot_import($k, 'G', 'TXT');
        if(empty($params[$k])) {
          $usl = false;
          break;
        }
      }
      if($usl) {
        $whowhere_upd['ww_code'] = $code;
        if(is_array($ww['as'])) foreach($ww['as'] as $k => $v) {
          $whowhere_upd['ww_var_'.$k] = cot_import($v, 'G', 'TXT');
        }
        break;
      }
    }
  }

  if(!empty($whowhere_upd['ww_code'])) $db->insert($db_whowhere, $whowhere_upd);
}