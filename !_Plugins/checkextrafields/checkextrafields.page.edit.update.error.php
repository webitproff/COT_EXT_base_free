<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=page.edit.update.error
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('checkextrafields', 'plug');

if(!empty($rpage['page_cat'])) {
  $checkextrafields = $db->query("SELECT * FROM $db_checkextrafields WHERE chk_area='page' AND chk_cat='".$rpage['page_cat']."'")->fetch();

  if($checkextrafields['chk_id'] > 0) {
    $checkextrafields['chk_set'] = json_decode($checkextrafields['chk_set'], 1);

    foreach($cot_extrafields[$db_pages] as $exfld)
    {
      if($exfld['field_type'] != 'file')
      {
        if(in_array('page_'.$exfld['field_name'], $checkextrafields['chk_set'])) {
          $exfld_title = isset($L['page_'.$exfld['field_name'].'_title']) ?  $L['page_'.$exfld['field_name'].'_title'] : $exfld['field_description'];

          $chkerror = isset($L['checkextrafields_page_'.$exfld['field_name']]) ? $L['checkextrafields_page_'.$exfld['field_name']] : $L['checkextrafields_default'].$exfld_title;

          cot_check(empty($rpage['page_' . $exfld['field_name']]), $chkerror, 'rpage'.$exfld['field_name']);
        }
      }
    }

    if(in_array('files', $checkextrafields['chk_set']) && cot_module_active('files') && $row_page['page_id'] > 0) {
       $checkfiles = $db->query("SELECT COUNT(*) FROM $db_files WHERE file_source='page' AND file_item=".$row_page['page_id']."")->fetchColumn();
       cot_check(!$checkfiles, $L['checkextrafields_page_files'], 'default');
    }
    if(in_array('mavatars', $checkextrafields['chk_set']) && cot_plugin_active('mavatars') && $row_page['page_id'] > 0) {
       $mavatar = new mavatar('market', $rpage['page_cat'], $row_page['page_id'], 'edit');
       $mavatars_tags = $mavatar->tags();
       cot_check((count($mavatars_tags) == 0), $L['checkextrafields_page_mavatars'], 'default');
    }
  }
}

