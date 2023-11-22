<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.addofferform.main
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

// Если по заявке уже сформировано предложение для заказчика, то не отображать форму для новых откликов от пилотов

if(!empty($request['request_id']) && $request['request_status'] != 'public')
{
	$addoffer_enabled = false;
}