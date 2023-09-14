<?php

/* ====================
[BEGIN_COT_EXT]
Hooks=admin.config.edit.loop
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('easypaygroup', 'plug');
$adminhelp = $L['easypaygroup_help'];

if ($p == 'easypaygroup' && $row['config_name'] == 'codes' && $cfg['jquery'])
{
	$sskin = cot_tplfile('easypaygroup.admin.config', 'plug', true);
	$tt = new XTemplate($sskin);
	
	$epayset = str_replace("\r\n", "\n", $row['config_value']);
	$epayset = explode("\n", $epayset);

	$jj = 0;
	foreach ($epayset as $lineset)
	{
		$lines = explode("|", $lineset);
		$lines[0] = trim($lines[0]);
		$lines[1] = trim($lines[1]);
		$lines[2] = (int)trim($lines[2]);
		$lines[3] = (trim($lines[3])) ? (float)trim($lines[3]) : 0;
		
		if (!empty($lines[0]) && !empty($lines[1]))
		{
			$tt->assign(array(
				'ADDNUM' => $jj,
				'ADDGROUP' => cot_inputbox('text', 'group', $lines[0], 'class="code_group"'),
				'ADDNAME' => cot_inputbox('text', 'name', $lines[1], 'class="code_name"'),
				'ADDTIME' => cot_inputbox('text', 'time', $lines[2], 'class="code_time" placeholder="Укажите значение в днях"'),
				'ADDCOST' => cot_inputbox('text', 'cost', $lines[3], 'class="code_cost"'),
			));
			$tt->parse('MAIN.ADDITIONAL');
			$jj++;
		}
	}

	$jj++;
	$tt->assign(array(
		'CATNUM' => $jj
	));
	$tt->parse('MAIN');

	$t->assign(array(
		'ADMIN_CONFIG_ROW_CONFIG_MORE' => $tt->text('MAIN') . '<div id="helptext">' . $config_more . '</div>'
	));
}

?>