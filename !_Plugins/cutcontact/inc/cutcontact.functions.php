<?php 
/**
 * Cut contact
 *
 * @package cutcontact
 * @copyright (c) CrazyFreeMan (simple-website.in.ua)
 */

defined('COT_CODE') or die('Wrong URL');

/**
* @param string $text_for_cutting Text for cutting contacts
* @return string
* @global $cfg
* 
*/
function cot_cutcontact($text_for_cutting, $exten) {
	global $cfg;
	$cutpatterntmp = str_replace("\r\n", "\n", $cfg['plugin']['cutcontact']['confregular']);
	$cutpatterntmp = explode("\n", $cutpatterntmp);
	$cutrepltexttmp = str_replace("\r\n", "", $cfg['plugin']['cutcontact']['confrepltext']);
	$cutrepltexttmp = "{".$cutrepltexttmp."}";
	$cutpatterntxt = json_decode($cutrepltexttmp, true);	

	foreach ($cutpatterntmp as $key => $cutpattern)
	{
		$cutpattern = trim($cutpattern);
		$cutpatterntext = ($cutpatterntxt[$key]) ? "<b>".$cutpatterntxt[$key]."</b>" : '' ;		
		$text_for_cutting  = preg_replace($cutpattern, $cutpatterntext, $text_for_cutting);
		cot_log('Cut contact from '.$exten, 'plg');				
	}
	return $text_for_cutting;
}