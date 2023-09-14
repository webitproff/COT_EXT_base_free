<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=projects.preview.tags,projects.tags
  Tags=projects.tpl:{PRJ_ROUTE};projects.preview.tpl:{PRJ_ROUTE}
  [END_COT_EXT]
  ==================== */

/**
 * Route for projects (google maps)
 * @Version 1.1.0
 * @package routemap
 * @copyright (c) Alexeev Vlad
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('routemap', 'plug');
$route = cot_get_route_map($item['item_route']);
$t->assign('PRJ_ROUTE', $route);


