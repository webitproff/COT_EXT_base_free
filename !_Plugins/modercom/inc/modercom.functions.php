<?php
/**
 * Comments system for Cotonti
 *
 * @package modercom
 * @version 1.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');


/**
 * Returns number of validated comments for item
 *
 * @param string $ext_name Target extension name
 * @param string $code Item code
 * @param array $row Database row entry (optional)
 * @return int
 * @global CotDB $db
 */
function cot_modercom_comments_count($ext_name, $code, $row = array())
{
	global $db, $db_com;

	$sql = $db->query("SELECT COUNT(*) FROM $db_com WHERE com_state=0 AND com_area = ? AND com_code = ?", array($ext_name, $code));
	if ($sql->rowCount() == 1)
	{
		$cnt = (int) $sql->fetchColumn();
		$com_cache[$ext_name][$code] = $cnt;
	}

	return $cnt;
}


/**
 * Generates comments display for a given item
 *
 * @param string $link_area Target URL area for cot_url()
 * @param string $link_params Target URL params for cot_url()
 * @param string $ext_name Module or plugin code
 * @param string $code Item identifier
 * @param string $cat Item category code (optional)
 * @param array $row Database row entry (optional)
 * @return string Rendered HTML output for comments
 * @see cot_comments_count()
 * @global CotDB $db
 */
function cot_modercom_comments_link($link_area, $link_params, $ext_name, $code, $cat = '', $row = array())
{
	global $cfg, $db, $R, $L, $db_com;

	if (!cot_comments_enabled($ext_name, $cat, $code))
	{
		return '';
	}

	$res = cot_rc('comments_link', array(
		'url' => cot_url($link_area, $link_params, '#comments'),
		'count' => $cfg['plugin']['comments']['countcomments'] ? cot_modercom_comments_count($ext_name, $code, $row) : ''
	));
	return $res;
}

?>