<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.profile.update.first
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('paycontacts', 'plug');

$contactsfilter = explode(",", $cfg['plugin']['paycontacts']['extrafilter']);
foreach($contactsfilter as $filter)
{
 $filtertxt = cot_import('ruser'.$filter, 'P', 'TXT');

$pattern = '/\+?[78][-\(]?\d{3}\)?-?\d{3}-?\d{2}-?\d{2}/';
$text = preg_replace($pattern, "*** контакты запрещены ***", $text);

//$pattern = '/(\D|\A)((\d[\s\-\.]?){5}\d)(\D|\Z)/x';
$pattern = '/([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}/';
$text = preg_replace($pattern, "*** контакты запрещены ***", $text);

$pattern = '/(\S+)@(\S+)\.(\S+)/';
$text = preg_replace($pattern, "*** контакты запрещены ***", $text);

 cot_error('pro_emailandpass', 'ruser'.$filter);
}