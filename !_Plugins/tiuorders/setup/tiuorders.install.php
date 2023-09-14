<?php

/**
 * tiuorders plugin
 *
 * @package tiuorders
 * @version 1.0.4
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('products', 'module');
require_once cot_incfile('tiuorders', 'plug');

global $db_products, $cfg;

cot_extrafield_add($db_products, 'file', 'file', $R['input_file'],'zip,rar','','','', '','datas/productsfiles');

if(!file_exists('datas/productsfiles')) mkdir('datas/productsfiles');