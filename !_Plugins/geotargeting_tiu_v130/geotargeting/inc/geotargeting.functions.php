<?php
/**
 * Geo Targeting for Cotonti
 *
 * @package geotargeting
 * @version 1.2
 */

  /**
 * Функции для работы с БД плагина Location Selector.
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('forms');
require_once cot_langfile('geotargeting', 'plug');

global $db_ls_regions, $db_ls_cities, $db_x;
$db_ls_regions = (isset($db_ls_regions)) ? $db_ls_regions : $db_x . 'ls_regions';
$db_ls_cities = (isset($db_ls_cities)) ? $db_ls_cities : $db_x . 'ls_cities';
$R['input_location'] = '<span class="locselect">{$country} {$region} {$city}</span>';

if (!$cot_countries)
{
	include_once cot_langfile('countries', 'core');
}

function cot_load_location()
{
	global $db_ls_regions, $db_ls_cities, $db, $cfg, $cot_countries, $cache;
	global $cot_lf_regions, $cot_lf_cities, $cot_lf_locations;

	if (!$cot_lf_regions || !$cot_lf_cities || !$cot_lf_locations)
	{
		$cot_lf_cities = array();
		$cot_lf_regions = array();
		$cot_lf_locations = array();
		if (!empty($cfg['plugin']['geotargeting']['countriesfilter']) && $cfg['plugin']['geotargeting']['countriesfilter'] != 'all')
		{
			$countriesfilter = str_replace(' ', '', $cfg['plugin']['geotargeting']['countriesfilter']);
			$countriesfilter = explode(',', $countriesfilter);
		}

		$where_filter = (count($countriesfilter) > 0) ? "WHERE region_country IN ('" . implode("','", $countriesfilter) . "')" : "";
		$sql = $db->query("SELECT * FROM $db_ls_regions $where_filter");
		while ($reg = $sql->fetch())
		{
			$cot_lf_regions[$reg['region_id']] = $reg['region_name'];
			$cot_lf_locations[$reg['region_country']][$reg['region_id']] = array();
		}
		$where_filter = (count($countriesfilter) > 0) ? "WHERE city_country IN ('" . implode("','", $countriesfilter) . "')" : "";
		$sql = $db->query("SELECT * FROM $db_ls_cities $where_filter");
		while ($city = $sql->fetch())
		{
			$cot_lf_cities[$city['city_id']] = $city['city_name'];
			$cot_lf_locations[$city['city_country']][$city['city_region']][$city['city_id']] = $city['city_name'];
		}
		$cache && $cache->db->store('cot_lf_regions', $cot_lf_regions, COT_DEFAULT_REALM, 3600);
		$cache && $cache->db->store('cot_lf_cities', $cot_lf_cities, COT_DEFAULT_REALM, 3600);
		$cache && $cache->db->store('cot_lf_locations', $cot_lf_locations, COT_DEFAULT_REALM, 3600);
	}
}

function cot_getcountries($countriesfilter = array())
{
	global $cot_countries, $cfg;

	$countries = array();
	$topcountries = ($cfg['plugin']['geotargeting']['topcountries']) ? explode(',', $cfg['plugin']['geotargeting']['topcountries']) : '';
	
	foreach ($cot_countries as $code => $name)
	{
		if ((count($countriesfilter) > 0 && in_array($code, $countriesfilter)) || count($countriesfilter) == 0)
		{
			$countries[$code] = $name;
		}
	}

	if(is_array($topcountries)){
		
		$countries_top = array();
		$countries_other = array();
		
		foreach ($topcountries as $code){
			$countries_top[$code] = $countries[$code];
		}
		
		foreach ($countries as $code => $name){
			if (!in_array($code, $topcountries))
			{
				$countries_other[$code] = $name;
			}
		}
		
		asort($countries_other);
		$countries = array_merge($countries_top, $countries_other);
	}else{
		asort($countries);
	}
	
	return $countries;
}

function cot_getregions($country)
{
	global $cot_lf_regions, $cot_lf_locations;
	$regions = array();
	$cot_lf_locations[$country] = (is_array($cot_lf_locations[$country])) ? $cot_lf_locations[$country] : array();
	foreach ($cot_lf_locations[$country] as $i => $reg)
	{
		$regions[$i] = $cot_lf_regions[$i];
	}
	asort($regions);
	return $regions;
}

function cot_getcities($region)
{
	global $cot_lf_locations;

	$cities = array();
	foreach ($cot_lf_locations as $lcountry => $regs)
	{
		if (array_key_exists($region, $regs))
		{
			$country = $lcountry;
			break;
		}
	}
	
	foreach ($cot_lf_locations[$country][$region] as $id => $name)
	{
		$cities[$id] = $name;
	}
	asort($cities);
	return $cities;
}

function cot_getcountry($country)
{
	global $cot_countries;
	return $cot_countries[$country];
}

function cot_getregion($region)
{
	global $cot_lf_regions;
	return $cot_lf_regions[$region];
}

function cot_getcity($city)
{
	global $cot_lf_cities;
	return $cot_lf_cities[$city];
}

function cot_getlocation($country = '', $region = 0, $city = 0)
{
	global $cot_countries, $cot_lf_regions, $cot_lf_cities;
	
	$location['country'] = '';
	$location['region'] = '';
	$location['city'] = '';	
	if(!empty($country))
	{
		$location['country'] = $cot_countries[$country];
	}
	if(!empty($country) && (int)$region > 0)
	{
		$location['region'] = $cot_lf_regions[$region];
	}
	if(!empty($country) && (int)$region > 0 && (int)$city > 0)
	{
		$location['city'] = $cot_lf_cities[$city];	
	}
	return $location;
}

function cot_import_location($source = 'P')
{
	$result['country'] = cot_import('country',$source, 'TXT');
	$result['region'] = cot_import('region', $source, 'INT');
	$result['city'] = cot_import('city', $source, 'INT');
	$result['region'] = ($result['country'] == '0') ? 0 : $result['region'];
	$result['city'] = ($result['region'] == 0) ? 0 : $result['city'];

	return $result;
}


/**
 * Функции плагина Geo Targeting
 * @author Alexeev vlad
 * @copyright Copyright (c) Alexeev vlad
 */

function cot_geoinfo_to_localselect($geocountry = '', $geocity = '')
{
	global $db_ls_cities, $db;
  
  $usr_geoinfo['region'] = '';
	$usr_geoinfo['city'] = ''; 
  $usr_geoinfo['country'] = $geocountry;
      
  $geo_search = $db->query(
	"SELECT * FROM $db_ls_cities WHERE city_country='$geocountry' AND city_name='$geocity'")->fetch(); 
  if (!empty($geo_search)) {
   $usr_geoinfo['country'] = $geo_search['city_country'];
   $usr_geoinfo['region'] = $geo_search['city_region'];
   $usr_geoinfo['city'] = $geo_search['city_id'];  
  }
return $usr_geoinfo;
}

function cot_import_geolocation($source = 'P')   //Получаем выбранные данные
{
	$result['country'] = cot_import('country',$source, 'TXT');
	$result['region'] = cot_import('region', $source, 'INT');
	$result['city'] = cot_import('city', $source, 'INT');
  //Проверяем если не выбран регион/город, куки не записываем
  $result['country'] = ($result['country'] != '0') ? $result['country'] : null;
	$result['region'] = ($result['region'] != '0') ? $result['region'] : null;
	$result['city'] = ($result['city'] != '0') ? $result['city'] : null;

	return $result;
}

function cot_select_location($country = '', $region = 0, $city = 0, $userdefault = false)
{
	global $cfg, $L, $R, $usr;

	$countriesfilter = array();
	if (!empty($cfg['plugin']['geotargeting']['countriesfilter']) &&  $cfg['plugin']['geotargeting']['countriesfilter'] != 'all')
	{
		$countriesfilter = str_replace(' ', '', $cfg['plugin']['geotargeting']['countriesfilter']);
		$countriesfilter = explode(',', $countriesfilter);
		$disabled = (count($countriesfilter) == 1) ? 'disabled="disabled" ' : '';
		$country = (count($countriesfilter) == 1) ? $countriesfilter[0] : $country;
	}
	
	if ($userdefault && $usr['id'] > 0 && $country == '' && $region == 0 && $city == 0)
	{
		$country = $usr['profile']['user_country'];
		$region = $usr['profile']['user_region'];
		$city = $usr['profile']['user_city'];
	}
	
	$countries = cot_getcountries($countriesfilter);
	if($countries){
		$countries = array(0 => $L['select_country']) + $countries;
		$country_selectbox = cot_selectbox($country, 'country', array_keys($countries), array_values($countries), 
			false, $disabled . 'class="locselectcountry form-control" id="locselectcountry"');
		$country_selectbox .= (count($countriesfilter) == 1) ? cot_inputbox('hidden', 'country', $country) : '';

		$region = ($country == '' || count($countries) < 2) ? 0 : $region;
		$regions = (!empty($country)) ? cot_getregions($country) : array();
		$regions = array(0 => $L['select_region']) + $regions;
		$disabled = (empty($country) || count($regions) < 2) ? 'disabled="disabled" ' : '';
		$region_selectbox = cot_selectbox($region, 'region', array_keys($regions), array_values($regions), 
			false, $disabled . 'class="locselectregion form-control" id="locselectregion"');

		$city = ($region == 0 || count($regions) < 2) ? 0 : $city;
		$cities = (!empty($region)) ? cot_getcities($region) : array();
		$cities = array(0 => $L['select_city']) + $cities;
		$disabled = (empty($region) || count($cities) < 2) ? 'disabled="disabled" ' : '';
		$city_selectbox = cot_selectbox($city, 'city', array_keys($cities), array_values($cities), 
			false, $disabled . 'class="locselectcity form-control" id="locselectcity"');	

		$result = cot_rc('input_location', array(
			'country' => $country_selectbox,
			'region' => $region_selectbox,
			'city' => $city_selectbox
		));

		return $result;
	}else{
		return false;
	}
}

function cot_geotargeting_header_tpl($template ='', $usr_geoinfo, $select_geo, $geo_fordrop, $url = '')
{
  global $L;
  
	$t1 = new XTemplate(cot_tplfile(array('geotargeting', $template), 'plug'));
if ($template = 'modal')
{	
  $t1->assign(array(
  'GEOTARGETING_SUBMIT' => $url,
 	'GEOTARGETING_SEARCH' => (function_exists('cot_select_location')) ?
			cot_select_location($usr_geoinfo['country'], $usr_geoinfo['region'], $usr_geoinfo['city']) : '',
  ));
}
$t1->assign(array(
  //если выбран город, пишем город для региона соответственно, если ничего не выбранно пишем "выберите город"
  'GEOTARGETING_NAME_SELECT' => (!empty($select_geo)) ? $select_geo : $L['select_city'],
  'GEOTARGETING_DROP_OPEN' => (!empty($geo_fordrop)) ? 'open' : '',
  'GEOTARGETING_MODAL_BUTTON' => (!empty($geo_fordrop)) ? 1 : 0,  
));
	
	$t1->parse("MAIN");
	return $t1->text("MAIN");
}  
?>