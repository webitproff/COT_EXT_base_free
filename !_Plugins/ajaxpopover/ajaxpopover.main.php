<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.details.main,projects.main,folio.main
 * Order=99
 * [END_COT_EXT]
 */


defined('COT_CODE') or die('Wrong URL.');

if (COT_AJAX && cot_import('popover', 'G', 'INT')) {
   $mskin = cot_tplfile(array('ajaxpopover', cot_import('e', 'G', 'TXT')), 'plug');
}
