<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=projects.list.query
  Order=99
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') or die('Wrong URL.');

$map = cot_import('map', 'G', 'INT');
$list_url_path['map'] = ($map == 1 ? 1 : 0);

$showmapradius = (isset($_GET['city']) || ($usr_geoinfo['city'] > 0 && !isset($_GET['search'])));

if($showmapradius && $_GET['mapradius'] > 0 && $_GET['city'] > 0) {
  $getcity = cot_getcity($_GET['city']);
  $xml = simplexml_load_file('http://maps.google.com/maps/api/geocode/xml?address='.$getcity.'&sensor=false');
  if( $xml->status == 'OK' ) {
    $lat = $xml->result->geometry->location->lat;
    $lng = $xml->result->geometry->location->lng;

    $where['location'] = '('.(!empty($where['location']) ? $where['location'].' OR ' : '').'(item_prjmaplat!=0 AND item_prjmaplng!=0 AND prjmapdist('.$lat.', '.$lng.', item_prjmaplat, item_prjmaplng)<'.$_GET['mapradius'].'))';

    $db->query("DROP FUNCTION IF EXISTS prjmapdist");
    $db->query("CREATE FUNCTION prjmapdist(lat1 float, lon1 float, lat2 float, lon2 float) RETURNS float
      BEGIN
      declare d_lon float;
      declare x float;
      declare y float;

      set lat1 = lat1 * pi() / 180;
      set lon1 = lon1 * pi() / 180;
      set lat2 = lat2 * pi() / 180;
      set lon2 = lon2 * pi() / 180;
      set d_lon = lon1 - lon2;

      set y = POWER(COS(lat2) * SIN(d_lon), 2) + POWER(COS(lat1) * SIN(lat2) - SIN(lat1) * COS(lat2) * COS(d_lon), 2);
      set x = SIN(lat1) * SIN(lat2) + COS(lat1) * COS(lat2) * COS(d_lon);
      RETURN ROUND( (ATAN2(SQRT(y), x) * 6372.795) , 3);
    END;");

    $join_columns .= ', prjmapdist('.$lat.', '.$lng.', item_prjmaplat, item_prjmaplng) as mapdistance';
  }
}
