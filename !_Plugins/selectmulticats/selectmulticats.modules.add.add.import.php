<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=projects.add.add.import,uslugi.add.add.import,market.add.add.import,folio.add.add.import
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

$rmulticats = cot_import('rmulticats', 'P', 'ARR');
if(count($rmulticats) > 0)
{
  $ritem['item_multicat'] =  implode(',', $rmulticats);
}

?>