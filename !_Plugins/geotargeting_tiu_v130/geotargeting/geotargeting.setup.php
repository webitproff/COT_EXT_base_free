<?php
/**
 * [BEGIN_COT_EXT]
 * Code=geotargeting
 * Name=Geo Targeting
 * Description=Определение города и вывод информаиции для определенного города/региона/страны
 * Version=1.3
 * Date=2015.08.26
 * Author=Alexeev vlad
 * Auth_guests=R
 * Lock_guests=W12345A
 * Auth_members=R
 * Lock_members=W12345A
 * Recommends_modules=SxGeo IP base v2
 * Notes=This plug-in is based on "locationselector" by CMSWorks.ru, littledev.ru
 * [END_COT_EXT]
 * 
 * [BEGIN_COT_EXT_CONFIG]
 * geotitle=01:radio
 * integrationsxgeo=02:radio
 * oneshowgeo=03:radio
 * filternow=04:radio
 * countriesfilter=05:string
 * topcountries=06:string
 * [END_COT_EXT_CONFIG]
 */

/**
 * Geo Targeting for Cotonti
 *
 * @package geotargeting
 * @version 1.3
 * @author Alexeev vlad
 * @copyright Copyright (c) Alexeev vlad
 */
defined('COT_CODE') or die('Wrong URL.');
