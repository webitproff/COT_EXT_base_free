<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=tools
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'seo', 'RWA');
cot_block($usr['isadmin']);

require_once cot_incfile('seo', 'plug');

$id = cot_import('id', 'G', 'INT');

if ($a == 'add')
{
	$rseo['seo_area'] = cot_import('rarea', 'P', 'ALP');
	$rseo['seo_category'] = cot_import('rcat', 'P', 'TXT');
	$rseo['seo_city'] = cot_import('rcity', 'P', 'TXT');
	$rseo['seo_title'] = cot_import('rtitle', 'P', 'TXT');
	$rseo['seo_desc'] = cot_import('rdesc', 'P', 'TXT');
	$rseo['seo_h1'] = cot_import('rh1', 'P', 'TXT');
	$rseo['seo_text'] = cot_import('rtext', 'P', 'HTM');

	cot_check(empty($rseo['seo_area']), 'seo_error_area');

	if (!cot_error_found())
	{
        $rseo['seo_lang'] = $cfg['defaultlang'];

        $db->insert($db_seo, $rseo);

		cot_redirect(cot_url('admin', 'm=other&p=seo', '', true));
	}
	cot_redirect(cot_url('admin', 'm=other&p=seo&n=add', '', true));
}

if ($a == 'update')
{
	$rseo['seo_area'] = cot_import('rarea', 'P', 'ALP');
	$rseo['seo_category'] = cot_import('rcat', 'P', 'TXT');
	$rseo['seo_city'] = cot_import('rcity', 'P', 'TXT');
	$rseo['seo_title'] = cot_import('rtitle', 'P', 'TXT');
	$rseo['seo_desc'] = cot_import('rdesc', 'P', 'TXT');
	$rseo['seo_h1'] = cot_import('rh1', 'P', 'TXT');
	$rseo['seo_text'] = cot_import('rtext', 'P', 'HTM');

	cot_check(empty($rseo['seo_area']), 'seo_error_area');

	if (!cot_error_found())
	{
		$db->update($db_seo, $rseo, "seo_id=".$id);

		cot_redirect(cot_url('admin', 'm=other&p=seo', '', true));
	}
	cot_redirect(cot_url('admin', 'm=other&p=seo&n=edit&id='.$id, '', true));
}

if ($a == 'delete')
{
	$db->delete($db_seo, "seo_id=?", array($id));
	cot_redirect(cot_url('admin', 'm=other&p=seo', '', true));
}

$t = new XTemplate(cot_tplfile('seo.admin', 'plug', true));

$totalseo = 0;
$seos = $db->query("SELECT * FROM $db_seo WHERE seo_lang='" . $cfg['defaultlang'] . "' ORDER BY seo_area DESC")->fetchAll();
foreach ($seos as $seo)
{
	$totalseo++;
	$t->assign(array(
		'SEO_ROW_ID' => $seo['seo_id'],
		'SEO_ROW_AREA' => $seo['seo_area'],
		'SEO_ROW_CAT' => $seo['seo_category'],
		'SEO_ROW_CITY' => $seo['seo_city'],
		'SEO_ROW_TITLE' => $seo['seo_title'],
		'SEO_ROW_DESC' => $seo['seo_desc'],
		'SEO_ROW_H1' => $seo['seo_h1'],
		'SEO_ROW_TEXT' => $seo['seo_text'],
	));
	$t->parse('MAIN.SEO_ROW');
}

$t->assign('TOTALSEO', $totalseo);

if($n == 'edit')
{
	$sql = $db->query("SELECT * FROM $db_seo WHERE seo_id=".$id);
	cot_die($sql->rowCount() == 0);
	$rseo = $sql->fetch();

	$t->assign(array(
		'SEO_FORM_ACTION_URL' => cot_url('admin', 'm=other&p=seo&a=update&id='.$id),
		'SEO_FORM_AREA' => cot_inputbox('text', 'rarea', $rseo['seo_area'], 'size="56"'),
		'SEO_FORM_CAT' => cot_inputbox('text', 'rcat', $rseo['seo_category'], 'size="56"'),
		'SEO_FORM_CITY' => cot_inputbox('text', 'rcity', $rseo['seo_city'], 'size="56"'),
		'SEO_FORM_TITLE' => cot_inputbox('text', 'rtitle', $rseo['seo_title'], 'size="56"'),
		'SEO_FORM_DESC' => cot_inputbox('text', 'rdesc', $rseo['seo_desc'], 'size="56"'),
		'SEO_FORM_H1' => cot_inputbox('text', 'rh1', $rseo['seo_h1'], 'size="56"'),
		'SEO_FORM_TEXT' => cot_textarea('rtext', $rseo['seo_text'], 24, 120, '', 'input_textarea_editor'),
	));

	cot_display_messages($t, 'MAIN.EDITSEO');

	$t->parse('MAIN.EDITSEO');
}

if($n == 'add')
{
	$t->assign(array(
		'SEO_FORM_ACTION_URL' => cot_url('admin', 'm=other&p=seo&a=add'),
		'SEO_FORM_AREA' => cot_inputbox('text', 'rarea', $rseo['seo_area'], 'size="56"'),
		'SEO_FORM_CAT' => cot_inputbox('text', 'rcat', $rseo['seo_category'], 'size="56"'),
		'SEO_FORM_CITY' => cot_inputbox('text', 'rcity', $rseo['seo_city'], 'size="56"'),
		'SEO_FORM_TITLE' => cot_inputbox('text', 'rtitle', $rseo['seo_title'], 'size="56"'),
		'SEO_FORM_DESC' => cot_inputbox('text', 'rdesc', $rseo['seo_desc'], 'size="56"'),
		'SEO_FORM_H1' => cot_inputbox('text', 'rh1', $rseo['seo_h1'], 'size="56"'),
		'SEO_FORM_TEXT' => cot_textarea('rtext', $rseo['seo_text'], 24, 120, '', 'input_textarea_editor'),
	));

	cot_display_messages($t, 'MAIN.ADDSEO');

	$t->parse('MAIN.ADDSEO');
}

$t->parse('MAIN');
$adminmain = $t->text('MAIN');