<?php
/**
 * [BEGIN_COT_EXT]
 * Code=geotargeting
 * Name=Geo Targeting
 * Description=Определение города и вывод информаиции для определенного города/региона/страны
 * Version=1.5.0
 * Date=2015.06.25
 * Author=Alexeev vlad
 * Auth_guests=R
 * Lock_guests=W12345A
 * Auth_members=R
 * Lock_members=W12345A
 * Requires_plugins=locationselector
 * Recommends_modules=SxGeo IP base v2
 * [END_COT_EXT]
 * 
 * [BEGIN_COT_EXT_CONFIG]
 * geotitle=01:radio
 * integrationsxgeo=02:radio
 * oneshowgeo=03:radio
 * filternow=04:radio
 * geouserfilter=05:radio
 * geoprjfilter=06:radio
 * geofoliofilter=07:radio
 * geomarketfilter=08:radio
 * [END_COT_EXT_CONFIG]
 */

/**
 * Geo Targeting for Cotonti
 *
 * @package geotargeting
 * @version 1.4
 * @author Alexeev vlad
 * @copyright Copyright (c) Alexeev vlad
 */
defined('COT_CODE') or die('Wrong URL.');
