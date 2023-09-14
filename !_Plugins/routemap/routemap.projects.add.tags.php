<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=projects.add.tags
  Tags=projects.add.tpl:{PRJADD_FORM_ROUTE}
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
$route = cot_route_form();
$t->assign('PRJADD_FORM_ROUTE', $route);


