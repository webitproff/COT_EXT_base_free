<?PHP

/* ====================
  [BEGIN_COT_EXT]
  Hooks=standalone
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') && defined('COT_PLUG') or die('Wrong URL');

require_once cot_incfile('ads', 'plug');
require_once cot_langfile('ads');

if ($a != 'click')
{
	$a = 'main';
}

require_once cot_incfile('ads', 'plug', $a);
