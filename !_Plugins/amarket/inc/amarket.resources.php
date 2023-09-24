<?php defined('COT_CODE') or die('Wrong URL');

$R['amarket_list_change_status'] = '<td colspan="6">{$text}</td>';

$R['amarket_btn_change_status_cancel'] = '<a href="{$url}" class="ajax btn btn-danger" rel="get-response{$id}">{$text}</a>';
$R['amarket_btn_change_status_confirm'] = '<a href="{$url}" class="ajax btn btn-success" rel="get-response{$id}">{$text}</a>';
$R['amarket_btn_pay_confirm'] = '<a href="{$url}" class="btn btn-success" >{$text}</a>';
$R['amarket_brc_title'] = $L['amarket_list_for'].' {$user_name} ({$data})';
$R['amarket_edit_count'] = '<a href="{$url_delete}" class="btn btn-danger btn-mini">-</a> {$prd_count} <a href="{$url_add}" class="btn btn-success btn-mini">+</a>';

$R['amarket_link_sort'] = '<a href="{$asc_url}" rel="nofollow">'.$R['icon_down'].'</a> <a href="{$desc_url}" rel="nofollow">'.$R['icon_up'].'</a>';