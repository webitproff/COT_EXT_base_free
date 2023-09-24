<?php defined('COT_CODE') or die('Wrong URL.');
/**
 * [BEGIN_COT_EXT]
 * Hooks=projectstags.main
 * Tags=projects.tpl:{PRJ_CONTACTS_FOR_BUY},{PRJ_BUY_CONTACT_URL};projects.edit.tpl:{PRJEDIT_FORM_CONTACTS_FOR_BUY};projects.add.tpl:{PRJADD_FORM_CONTACTS_FOR_BUY};projects.offers.tpl:{OFFER_ROW_BC_COST},{OFFER_FORM_BC_COST}
 * [END_COT_EXT]
 */
$temp_array['BUY_CONTACT_URL'] = cot_url('buycontacts', array('a' => 'buycontacts', 'id' => $item_data['item_id']));