<?php
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('ads', 'plug');
require_once cot_incfile('structure');

cot_structure_add('ads', array('structure_area' => 'ads', 'structure_code' => 'index', 'structure_title' => 'Главная страница', 'structure_path' => '001'));
cot_structure_add('ads', array('structure_area' => 'ads', 'structure_code' => 'projects', 'structure_title' => 'Страница проектов', 'structure_path' => '002'));
cot_structure_add('ads', array('structure_area' => 'ads', 'structure_code' => 'market', 'structure_title' => 'Страница товаров', 'structure_path' => '003'));
cot_structure_add('ads', array('structure_area' => 'ads', 'structure_code' => 'folio', 'structure_title' => 'Страница портфолио', 'structure_path' => '004'));

$db->update($db_auth, array('auth_rights' => 5), "auth_code='projects' AND auth_groupid=4");
$db->update($db_auth, array('auth_rights' => 3, 'auth_rights_lock' => 128), "auth_code='projects' AND auth_groupid=1");