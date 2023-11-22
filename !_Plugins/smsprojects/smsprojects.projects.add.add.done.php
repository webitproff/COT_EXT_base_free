<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.add.add.done
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

if($ritem['item_state'] == 0)
{
	smsprojects_sendprj($id);
}