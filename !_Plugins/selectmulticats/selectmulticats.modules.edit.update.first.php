<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=projects.edit.update.first,uslugi.edit.update.first,market.edit.update.first,folio.edit.update.first
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

$rmulticats = cot_import('rmulticats', 'P', 'ARR');
if(count($rmulticats) > 0)
{
  $_POST['rcat'] = $rmulticats[0];
}

?>