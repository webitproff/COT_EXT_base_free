<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=market.add.add.error
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('checkextrafields', 'plug');

if(!empty($ritem['market_cat'])) {
  $checkextrafields = $db->query("SELECT * FROM $db_checkextrafields WHERE chk_area='market' AND chk_cat='".$ritem['market_cat']."'")->fetch();

  if($checkextrafields['chk_id'] > 0) {
    $checkextrafields['chk_set'] = json_decode($checkextrafields['chk_set'], 1);

    foreach($cot_extrafields[$db_market] as $exfld)
    {
      if($exfld['field_type'] != 'file')
      {
        if(in_array('market_'.$exfld['field_name'], $checkextrafields['chk_set'])) {
          $exfld_title = isset($L['market_'.$exfld['field_name'].'_title']) ?  $L['market_'.$exfld['field_name'].'_title'] : $exfld['field_description'];

          $chkerror = isset($L['checkextrafields_market_'.$exfld['field_name']]) ? $L['checkextrafields_market_'.$exfld['field_name']] : $L['checkextrafields_default'].$exfld_title;

          cot_check(empty($ritem['market_' . $exfld['field_name']]), $chkerror, 'ritem'.$exfld['field_name']);
        }
      }
    }

    if(in_array('files', $checkextrafields['chk_set']) && cot_module_active('files') && $usr['id'] > 0) {
       cot_check($db->query("SELECT COUNT(*) FROM $db_files WHERE file_source='market' AND user_id=".$usr['id'])->fetchColumn() == 0, $L['checkextrafields_market_files']);
    }
    if(in_array('mavatars', $checkextrafields['chk_set']) && cot_plugin_active('mavatars')) {
       $mavatar = new mavatar('market', $ritem['market_cat'], '', 'edit');
       $mavatars_tags = $mavatar->tags();
       cot_check((count($mavatars_tags) == 0), $L['checkextrafields_market_mavatars']);
    }
  }
}


