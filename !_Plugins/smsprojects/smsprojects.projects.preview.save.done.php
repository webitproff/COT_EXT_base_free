<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.preview.save.done
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

if($prj['item_state'] == 0)
{
	smsprojects_sendprj($item);
}