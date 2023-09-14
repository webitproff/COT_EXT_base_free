<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.edit.update.error
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('checkextrafields', 'plug');

if(!empty($ritem['item_cat'])) {
  $checkextrafields = $db->query("SELECT * FROM $db_checkextrafields WHERE chk_area='projects' AND chk_cat='".$ritem['item_cat']."'")->fetch();

  if($checkextrafields['chk_id'] > 0) {
    $checkextrafields['chk_set'] = json_decode($checkextrafields['chk_set'], 1);

    foreach($cot_extrafields[$db_projects] as $exfld)
    {
      if($exfld['field_type'] != 'file')
      {
        if(in_array('projects_'.$exfld['field_name'], $checkextrafields['chk_set'])) {
          $exfld_title = isset($L['projects_'.$exfld['field_name'].'_title']) ?  $L['projects_'.$exfld['field_name'].'_title'] : $exfld['field_description'];

          $chkerror = isset($L['checkextrafields_projects_'.$exfld['field_name']]) ? $L['checkextrafields_projects_'.$exfld['field_name']] : $L['checkextrafields_default'].$exfld_title;

          cot_check(empty($ritem['item_' . $exfld['field_name']]), $chkerror, 'ritem'.$exfld['field_name']);
        }
      }
    }

    if(in_array('files', $checkextrafields['chk_set']) && cot_module_active('files') && $item['item_id'] > 0) {
       cot_check($db->query("SELECT COUNT(*) FROM $db_files WHERE file_source='projects' AND file_item=".$item['item_id'])->fetchColumn() == 0, $L['checkextrafields_projects_files']);
    }
    if(in_array('mavatars', $checkextrafields['chk_set']) && cot_plugin_active('mavatars') && $item['item_id'] > 0) {
       $mavatar = new mavatar('projects', $ritem['item_cat'], $item['item_id'], 'edit');
       $mavatars_tags = $mavatar->tags();
       cot_check((count($mavatars_tags) == 0), $L['checkextrafields_projects_mavatars']);
    }
  }
}


