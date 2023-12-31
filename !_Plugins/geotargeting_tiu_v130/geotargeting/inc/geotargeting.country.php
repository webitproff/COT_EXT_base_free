<?php
/**
 * Geo Targeting for Cotonti
 *
 * @package geotargeting
 * @version 1.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 */

defined('COT_CODE') or die('Wrong URL');

if($a == 'update')
{
	$countriesfilter = cot_import('enabled_countries', 'P', 'ARR');
	
	$rconfig['config_value'] = implode(',', $countriesfilter);
	$db->update($db_config, $rconfig, "config_cat='geotargeting' AND config_name='countriesfilter'");
	$cache && $cache->clear();
	
	cot_redirect(cot_url('admin', 'm=other&p=geotargeting', '', true));
}

$t = new XTemplate(cot_tplfile('geotargeting.country', 'plug'));

$countriesfilter = str_replace(' ', '', $cfg['plugin']['geotargeting']['countriesfilter']);
$countriesfilter = explode(',', $countriesfilter);

$jj = 0;
foreach ($cot_countries as $code => $name)
{
	$jj++;
	
	$flag = (!file_exists('images/flags/'.$code.'.png')) ? '00' : $code;
	
	$t->assign(array(
		"COUNTRY_ROW_CODE" => $code,
		"COUNTRY_ROW_NAME" => $name,
		"COUNTRY_ROW_URL" => cot_url('admin', 'm=other&p=geotargeting&n=region&country=' . $code),
		"COUNTRY_ROW_FLAG" => cot_rc('icon_flag', array('code' => $flag, 'alt' => '')),
		"COUNTRY_ROW_NUM" => $jj,
		"COUNTRY_ROW_ODDEVEN" => cot_build_oddeven($jj),
		"COUNTRY_ROW_CHECKED" => (in_array($code, $countriesfilter)) ? true : false,
	));

	$t->parse("MAIN.ROWS");
}

$t->assign(array(
	'GEOTARGETING_FORM_UPDATE' => cot_url('admin', 'm=other&p=geotargeting&a=update'),
));

if($jj == 0)
{
	$t->parse("MAIN.NOROWS");
}
$t->parse("MAIN");
$plugin_body .= $t->text("MAIN");

?>