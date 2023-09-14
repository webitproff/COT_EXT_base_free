<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=projects.edit.update.import
  [END_COT_EXT]
  ==================== */
defined('COT_CODE') or die('Wrong URL');

$censor_cnt['title'] = 0;
$censor_cnt['text'] = 0;
$censor_p = array();
$censor_r = array();

foreach(explode(",", $cfg['plugin']['censored']['wordlist']) as $word)
{
 $word = trim($word);
 if(!empty($word))
 {
   $censor_p[] = '/'.$word.'/';
   $censor_r[] = mb_strtoupper($word);
 }
}

$ritem['item_title'] = preg_replace($censor_p, $censor_r, $ritem['item_title'], -1, $censor_cnt['title']);
$ritem['item_text'] = preg_replace($censor_p, $censor_r, $ritem['item_text'], -1, $censor_cnt['text']);

$ritem['item_censore'] = $censor_cnt['title'] + $censor_cnt['text'];