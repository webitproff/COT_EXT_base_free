<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('projects', 'module');

$laterprj = $db->update($db_projects, array('item_update' => $sys['now'], 'item_state' => 0), 'item_state=1 AND item_laterprj>0 AND item_laterprj<'.$sys['now']);