<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=projects.edit.update.import,uslugi.edit.update.import,market.edit.update.import,folio.edit.update.import
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

$rmulticats = cot_import('rmulticats', 'P', 'ARR');
if(count($rmulticats) > 0)
{
  $ritem['item_multicat'] =  implode(',', $rmulticats);
}

?>