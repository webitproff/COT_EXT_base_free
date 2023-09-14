<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=projects.edit.update.error
  [END_COT_EXT]
  ==================== */

/**
 * Route for projects (google maps)
 * @Version 1.1.0
 * @package routemap
 * @copyright (c) Alexeev Vlad
 */

defined('COT_CODE') or die('Wrong URL.');

$waypoints = cot_import('waypoints', 'P', 'TXT');

if (!cot_error_found() && !empty($waypoints))
{
 $ritem['item_route'] = $waypoints; 
}


