<?php

/* ====================
 * [BEGIN_COT_EXT]
 * Hooks=ajax
 * [END_COT_EXT]
 */

defined('COT_CODE') && defined('COT_PLUG') or die('Wrong URL');

require_once cot_incfile('userwall', 'plug');
require_once cot_incfile('forms');

$a = cot_import('a', 'G', 'ALP');
$id = (int) cot_import('id', 'G', 'INT');

cot_block(!empty($a) && $usr['id'] > 0);

if($a == 'add')
{
 $wall = array();
 $wall['item_userid'] = $usr['id'];
 $wall['item_date'] = $sys['now'];
 $wall['item_text'] = cot_import('rwall_text', 'P', 'HTM');
 
 if (empty($wall['item_text']))
 {
	cot_error("Пустой пост не может быть опубликован", 'rwall_text');
 }
 
 $wall['item_text'] = htmlspecialchars($wall['item_text']);
 
 if (!cot_error_found())
	{
    $db->insert($db_userwall, $wall);
    cot_message("Пост успешно опубликован");
  }
   
 cot_redirect(cot_url('users', "m=details&u=".$usr['name'], '', true));  
}
elseif($a == 'like' && $id > 0)
{
  $islike = $db->query("SELECT COUNT(*) FROM $db_userwall_likes
			WHERE like_pid=".$id." AND like_uid=".$usr['id'])->fetchColumn();
  
  if($islike)
  {
    $db->delete($db_userwall_likes, "like_pid=".$id." AND like_uid=".$usr['id']);
  }
  else
  {
    $db->insert($db_userwall_likes, array('like_pid' => $id, 'like_uid' => $usr['id']));
  }
  
  echo $db->query("SELECT COUNT(*) FROM $db_userwall_likes
			WHERE like_pid=".$id)->fetchColumn();
}
elseif($a == 'del' && $id > 0)
{
  $wall = $db->query("SELECT * FROM $db_userwall WHERE item_id=".$id." AND item_userid=".$usr['id']." LIMIT 1")->fetch();

  if($wall['item_id'] > 0 || $usr['maingrp'] == 5 || $usr['maingrp'] == 6)
  {
		$db->delete($db_userwall, "item_id=$id");
  }
  
	cot_redirect(cot_url('users', "m=details&id=".$wall['item_userid'], '', true)); 
}
elseif($a == 'edit' && $id > 0 && COT_AJAX)
{
  $wall = $db->query("SELECT * FROM $db_userwall WHERE item_id=".$id." AND item_userid=".$usr['id']." LIMIT 1")->fetch();

  if($wall['item_id'] > 0 || $usr['maingrp'] == 5 || $usr['maingrp'] == 6)
  {
	  echo '<form class="uk-form" name="newwallpost" action="'.cot_url('plug', 'r=userwall&a=update&id='.$wall['item_id']).'" method="post">
             <fieldset>
                     <div class="uk-form-row">
                         <textarea name="rwall_text" class="uk-width-1-1">'.$wall['item_text'].'</textarea>
                     </div>
                    <div class="uk-form-row">
                         <button class="uk-button uk-button-success" type="submit">Сохранить</button>
                     </div>
             </fieldset>
          </form>';
  }
  else
  {
    echo "Ошибка, Вы не можете редакритовать данный пост.";
  }
}
elseif($a == 'update' && $id > 0)
{
  $wall = $db->query("SELECT * FROM $db_userwall WHERE item_id=".$id." AND item_userid=".$usr['id']." LIMIT 1")->fetch();

  if($wall['item_id'] > 0 || $usr['maingrp'] == 5 || $usr['maingrp'] == 6)
  {
     $wall_text = cot_import('rwall_text', 'P', 'HTM');
 
     if (!empty($wall_text))
     {
       $db->update($db_userwall, array('item_text' => htmlspecialchars($wall_text)), 'item_id='.$wall['item_id']);
       cot_message("Пост успешно отредактирован");
     }
  }
  
	cot_redirect(cot_url('users', "m=details&id=".$wall['item_userid'], '', true)); 
}
else
{
 cot_block(!1);
}

