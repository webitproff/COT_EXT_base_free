<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=ajax
[END_COT_EXT]
==================== */
 
defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('catselector', 'plug');

$area = cot_import('area','G','ALP');
$c = cot_import('c','G','ALP');
$userrigths = cot_import('userrigths', 'G', 'ALP');

if(!empty($c))
{
	$subcats = cot_structure_children($area, $c, false, false);
	if(is_array($subcats) && count($subcats) > 0)
	{
		$options[0]['id'] = '';
		$options[0]['title'] = $L['catselector_select_text'];

		foreach($subcats as $i => $k)
		{
			if(cot_auth($area, $k, $userrigths))
			{
				$options[$i+1]['id'] = $k;
				$options[$i+1]['title'] = $structure[$area][$k]['title'];
			}
		}
	}
	header('Content-Type: application/json');
	echo json_encode($options);
}

?>
