<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_langfile('sendpulse', 'plug');

function cot_sendpulse_form($id = 0, $check = 0, $tpl = 'default')
{
  global $cfg, $usr, $L;

  $check = ($check > 0) ? 1 : 0;
  if($id > 0)
  {
   $tt = new XTemplate(cot_tplfile('sendpulse.form.'.$tpl, 'plug'));

   $tt->assign(array(
    'FORM_CHECK' => $check,
    'FORM_ID' => rand(0, 999),
    'BOOK_ID' => $id
   ));

   $jj=0;
   foreach(explode('|', $cfg['plugin']['sendpulse']['apiform']) as $variable)
   {
    $variable = explode('&', $variable);
    $tt->assign(array(
    'INPUT_NAME' => 'rsp_'.$jj,
    'INPUT_TITLE' => (($usr['lang'] == 'en' && !empty($variable[1])) ? $variable[1] : $variable[0]),
    ));
    if(!empty($variable)) $tt->parse('MAIN.FORM_INPUTS');
    $jj++;
   }

   $tt->parse('MAIN');
   return $tt->text('MAIN');
  }
  else { return ''; }
}