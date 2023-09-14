<?php
/**
 * Geo Targeting for Cotonti
 *
 * @package geotargeting
 * @version 1.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 */

defined('COT_CODE') or die('Wrong URL.');

$L['cfg_integrationsxgeo'] = 'Integration plug SxGeo';
$L['cfg_integrationsxgeo_hint'] = 'Позволяет с помошью этого плагина определить местоположение пользователя и предложить ему выбрать этот город';

$L['cfg_oneshowgeo'] = 'Show prompted to "select the city" found only <b> 1 </ b> again?';
$L['cfg_oneshowgeo_hint'] = 'After the show, if the user did not confirm the found city or not re-elected, the country found the city avtormaticheski <br> applies only when the "Integration with the plugin SxGeo"';

$L['cfg_filternow'] = 'Automatically filter found on the city, even if the user has not yet confirmed or re-elected';
$L['cfg_filternow_hint'] = 'If not, the filter is applied to the users country <br> only when the "Integration with the plugin SxGeo"';

$L['cfg_geouserfilter'] = 'Enable automatic filter for module USERS';
$L['cfg_geouserfilter_hint'] = 'If the user chooses a region / city, then all users will be filtered according to his selection <br> When disabled, there will be the usual selector';

$L['cfg_geoprjfilter'] = 'Enable automatic filter for module PROJECTS';
$L['cfg_geoprjfilter_hint'] = 'Similarly, as the function for USERS';

$L['cfg_geofoliofilter'] = 'Enable automatic filter for module FOLIO';
$L['cfg_geofoliofilter_hint'] = 'Similarly, as the function for USERS';

$L['cfg_geomarketfilter'] = 'Enable automatic filter for module MARKET';
$L['cfg_geomarketfilter_hint'] = 'Similarly, as the function for USERS';

$L['cfg_geotitle'] = 'Show user specified in the title city?';
$L['cfg_geotitle_hint'] = 'for example: Title of your site <b>New York</b>';

$L['info_desc'] = 'The method of issuing visitor content corresponding to its geographical position.';

$L['ls_addcountry'] = 'Add country';
$L['ls_countries'] = 'Countries';
$L['ls_nocountries'] = 'The list of countries is empty';

$L['ls_addregion'] = 'Add region';
$L['ls_regions'] = 'Regions';
$L['ls_noregions'] = 'The list of regions is empty';

$L['ls_addcity'] = 'Add city';
$L['ls_cities'] = 'City';
$L['ls_nocities'] = 'The list of cities is empty';

$L['ls_newcity_newstr'] = 'each city on a separate line';
$L['ls_newcity_list'] = 'Specify a list of cities';

$L['select_country'] = 'Select a country';
$L['select_region'] = 'Select a region';
$L['select_city'] = 'Select a city';

$L['you_city'] = 'You city is';