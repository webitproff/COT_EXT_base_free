<?php

require_once cot_langfile('sendfieldstomail', 'plug');

function cot_sendfieldsmail($type = 'page', $id = 0)
{
  global $L;
  $return = '';
  if(in_array($type, array('page', 'market')) && $id > 0) {
    $t1 = new XTemplate(cot_tplfile(array('sendfieldstomail', 'form', $type), 'plug'));
    $t1->assign(array(
      'FORM_ID' => $id,
      'FORM_TYPE' => $type
    ));
    $t1->parse('MAIN');
    $return = $t1->text('MAIN');
  }
  return $return;
}

function cot_sendfieldstomail($email = '', $type = 'page', $id = 0, $code = '')
{
  global $L, $db, $db_users, $db_pages, $db_market, $cfg, $mavatar, $mav_rowset_list;

  $emails = explode(',', $email);

  if(count($emails) > 0 && $id > 0 && in_array($type, array('page', 'market')))
  {
    require_once 'plugins/sendfieldstomail/inc/PHPMailer/PHPMailerAutoload.php';

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

    if(($type == 'page' && $data['page_id'] > 0) || ($type == 'market' && $data['item_id'] > 0))
    {
      $t1 = new XTemplate(cot_tplfile(array('sendfieldstomail', 'mail', $type), 'plug'));

      if($type == 'page') {
        $t1->assign(cot_generate_pagetags($data, 'PAGE_ROW_'));
        $t1->parse('MAIN.PAGE');
      } else if($type == 'market') {
        $t1->assign(cot_generate_markettags($data, 'MARKET_ROW_'));
        $t1->parse('MAIN.MARKET');
      }
      $t1->parse('MAIN');

      $mail = new PHPMailer;
      $mail->CharSet = "UTF-8";
      $mail->IsHTML(true);

      $mail->setFrom($cfg['adminemail'], $cfg['maintitle']);
      foreach($emails as $email) {
        $mail->addAddress($email);
      }

      if($type == 'market' && cot_plugin_active('mavatars')) {
        require_once cot_incfile('mavatars', 'plug');

	      $mavatar = new mavatar('market', $data['item_cat'], $data['item_id'], '', $mav_rowset_list);
        $mavatars_tags = $mavatar->tags();

        foreach($mavatars_tags as $file) {
          if (file_exists($file['FILE'])) {
            $mail->addAttachment($file['FILE'], $file['FILENAME']);
          }
        }
      }

      $title = (!empty($L['sendfieldstomail_mail_'.$type.'_title_'.$code])) ? $L['sendfieldstomail_mail_'.$type.'_title_'.$code] : $L['sendfieldstomail_mail_'.$type.'_title_default'];

      if($type == 'page') {
        $title = cot_rc($title, array(
                    'title' => $data['page_title'],
                    'date' => cot_date('d.m.Y', $data['page_date']),
                    'id' => $data['page_id'],
                 ));
      } else if($type == 'market') {
        $title = cot_rc($title, array(
                    'title' => $data['item_title'],
                    'date' => cot_date('d.m.Y', $data['item_date']),
                    'id' => $data['item_id'],
                 ));
      }

      $mail->Subject = $title;
      $mail->Body    = $t1->text('MAIN');
      $mail->send();

      return true;
    }
    else { return false; }
  }
  else { return false; }
}
