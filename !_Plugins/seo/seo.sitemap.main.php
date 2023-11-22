<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=sitemap.main
 * [END_COT_EXT]
 */ 

defined('COT_CODE') or die('Wrong URL.');

	require_once cot_incfile('seo', 'plug');

//	Пилоты
	
	$links = array();
	$sitemap_where = array();
	$sitemap_where['pilots'] = 'user_maingrp=4';
	$sitemap_where['catsorcity'] = "(user_cats!='' OR user_city>0)";

	$sitemap_where = count($sitemap_where) > 0 ? 'WHERE ' . join(' AND ', $sitemap_where) : '';
	$res = $db->query("SELECT * FROM $db_users AS u 
		$sitemap_where");
	foreach ($res->fetchAll() as $row)
	{
		if(!empty($row['user_cats'])){
			$ucats = explode(',', $row['user_cats']);
			foreach ($ucats as $ucat) {
				$links[$ucat.$row['user_city']] = array('group' => 'pilot', 'cat' => $ucat, 'cityalias' => ($row['user_city'] > 0) ? geo_getcityalias($row['user_city']) : '');
			}
		}elseif(!empty($row['user_city'])){
			$links[$row['user_city']] = array('group' => 'pilot', 'cityalias' => geo_getcityalias($row['user_city']));
		}
	}

	foreach ($links as $link) 
	{
		sitemap_parse($t, $items, array(
			'url'  => cot_url('users', $link),
		));
	}

// ================

//	Фото и видео

	$links = array();
	$sitemap_where = array();
	$sitemap_where['state'] = 'item_state=0';

	$sitemap_where = count($sitemap_where) > 0 ? 'WHERE ' . join(' AND ', $sitemap_where) : '';
	$res = $db->query("SELECT * FROM $db_folio AS f 
		$sitemap_where");
	foreach ($res->fetchAll() as $row)
	{
		$links[$row['item_type'].$row['item_city']] = array('type' => $row['item_type'], 'cityalias' => ($row['item_city'] > 0) ? geo_getcityalias($row['user_city']) : '');
	}

	foreach ($links as $link) 
	{
		sitemap_parse($t, $items, array(
			'url'  => cot_url('folio', $link),
		));
	}
