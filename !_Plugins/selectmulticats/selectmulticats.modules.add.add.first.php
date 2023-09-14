<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=projects.add.add.first,uslugi.add.add.first,market.add.add.first,folio.add.add.first
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

$rmulticats = cot_import('rmulticats', 'P', 'ARR');
if(count($rmulticats) > 0)
{
  $_POST['rcat'] = $rmulticats[0];
}

?>