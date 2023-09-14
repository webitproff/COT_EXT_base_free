<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=projects.offers.query
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') or die('Wrong URL.');

if ($cfg['plugin']['editoffer']['showoffersall'])
{
  unset($where['forshow']);
  //$where = (count($temp_where) > 0 ? 'WHERE ' . implode(' AND ', $temp_where) : '');
}