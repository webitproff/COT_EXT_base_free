<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=rc
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

cot_rc_link_file($cfg['plugins_dir'] . '/mailchimp/tpl/sweet-modal/jquery.sweet-modal.min.js');
cot_rc_link_file($cfg['plugins_dir'] . '/mailchimp/tpl/sweet-modal/jquery.sweet-modal.min.css');

cot_rc_add_embed('mailchimp', '
  $(document).ready(function(){
    $(\'input[class*="mailchimp"]\').each(function() {
      var c = $(this).attr(\'class\');
      c = c ? c.match(/(mailchimp-)([^ ;]+)?(;\S*)?/) : false;
      if(c && c[2] != undefined) {
        var tf = $(this).closest(\'form\');
        if(tf.length && tf.find(\'[name="mailchimp_list"]\').length == 0) {
          tf.prepend(\'<div style="display:inline;margin:0;padding:0"><input type="hidden" name="mailchimp_list" value="\'+c[2]+\'"><input type="hidden" name="mailchimp_email" value="\'+$(this).val()+\'"></div>\');
          $(this).change(function() {
            $(this).closest(\'form\').find(\'[name="mailchimp_email"]\').val($(this).val());
          });
        }
      }
    });
  });
');
