<?php
/**
 * Route for projects (google maps)
 * @Version 1.0
 * @package routemap
 * @copyright (c) Alexeev Vlad
 */

require_once cot_langfile('prjmap', 'plug');

global $prjmap_mapradius, $prjmap_mapradius_default;
$prjmap_mapradius = array(
 5 => '5 км',
 10 => '10 км',
 20 => '20 км',
 30 => '30 км',
 40 => '40 км',
 50 => '50 км',
);
/* по умолчанию */
$prjmap_mapradius_default = 5;

function cot_prjmap_form($item, $area = 'prj')
{
 $t_c = new XTemplate(cot_tplfile('prjmap.' . $area . '.script', 'plug'));
 if ($item)
  {
   $t = new XTemplate(cot_tplfile('prjmap.' . $area . '.edit', 'plug'));

   $adr = explode('#', $item['item_prjmap']);

   $latlng = explode(',', $adr[1]);
   if(!is_numeric($latlng[0]) || !is_numeric($latlng[1])) $latlng = array(0, 0);

   $t_c->assign(array(
     'ADR' => $adr[0],
     'LATLNG' => $adr[1],
     'PRJMAP_LAT' => $latlng[0],
     'PRJMAP_LNG' => $latlng[1]
   ));

   $t_c->parse('MAIN');

   $t->assign(array(
     'MAIN_SCRIPT' => $t_c->text('MAIN'),
     'INPUT_VAL' => $item['item_prjmap'],
     'ADR' => $adr[0],
     'LATLNG' => $adr[1],
     'PRJMAP_LAT' => $latlng[0],
     'PRJMAP_LNG' => $latlng[1]
   ));

   $t->parse('MAIN');
   $form = $t->text('MAIN');
  }
 else
 {
  $t_c->parse('MAIN');

  $t = new XTemplate(cot_tplfile('prjmap.' . $area . '.add', 'plug'));
  $t->assign('MAIN_SCRIPT', $t_c->text('MAIN'));
  $t->parse('MAIN');
  $form = $t->text('MAIN');
 }
 return $form;
}

function cot_prjmap_user_form($item = array())
{
 $t_c = new XTemplate(cot_tplfile('prjmap.usr.script', 'plug'));
 if (count($item) > 0)
  {
   $t = new XTemplate(cot_tplfile('prjmap.usr.edit', 'plug'));

   $adr = explode('#', $item['user_prjmap']);

   $latlng = explode(',', $adr[1]);
   if(!is_numeric($latlng[0]) || !is_numeric($latlng[1])) $latlng = array(0, 0);

   $t_c->assign(array(
     'ADR' => $adr[0],
     'LATLNG' => $adr[1],
     'PRJMAP_LAT' => $latlng[0],
     'PRJMAP_LNG' => $latlng[1]
   ));

   $t_c->parse('MAIN');

   $t->assign(array(
     'MAIN_SCRIPT' => $t_c->text('MAIN'),
     'INPUT_VAL' => $item['user_prjmap'],
     'ADR' => $adr[0],
     'LATLNG' => $adr[1],
     'PRJMAP_LAT' => $latlng[0],
     'PRJMAP_LNG' => $latlng[1]
   ));

   $t->parse('MAIN');
   $form = $t->text('MAIN');
  }
 else
 {
  $t_c->parse('MAIN');

  $t = new XTemplate(cot_tplfile('prjmap.usr.add', 'plug'));
  $t->assign('MAIN_SCRIPT', $t_c->text('MAIN'));
  $t->parse('MAIN');
  $form = $t->text('MAIN');
 }
 return $form;
}

global $prjmap_id;
if(!isset($prjmap_id)) $prjmap_id = 0;

function cot_get_prjmap_map($data = array(), $area = 'prj')
{
 if($data)
  {
   global $prjmap_id;
   $prjmap_id++;

   $t_s = new XTemplate(cot_tplfile('prjmap.' . $area, 'plug'));
   $adr = explode('#', $data['item_prjmap']);
   $latlng = explode(',', $adr[1]);
   if(!is_numeric($latlng[0]) || !is_numeric($latlng[1])) $latlng = array(0, 0);

   $t_s->assign('PRJMAP_ID', $prjmap_id);

   $t_s->assign('PRJ_CITY', ($data['item_city'] > 0 ? cot_getcity($data['item_city']) : ''));
   $t_s->assign('PRJ_ADR', $adr[0]);

   $t_s->assign('PRJMAP_LAT', $latlng[0]);
   $t_s->assign('PRJMAP_LNG', $latlng[1]);

   $t_s->parse('MAIN');
   $prjmap = $t_s->text('MAIN');
  }
 else
 {
  $prjmap = '';
 }

 return $prjmap;
}

function cot_get_prjmap_user_map($data = array())
{
 if($data)
  {
   global $prjmap_id;
   $prjmap_id++;

   $t_s = new XTemplate(cot_tplfile('prjmap.usr', 'plug'));
   $adr = explode('#', $data['user_prjmap']);
   $latlng = explode(',', $adr[1]);
   if(!is_numeric($latlng[0]) || !is_numeric($latlng[1])) $latlng = array(0, 0);

   $t_s->assign('PRJMAP_ID', $prjmap_id);

   $t_s->assign('USER_CITY', ($data['user_city'] > 0 ? cot_getcity($data['user_city']) : ''));
   $t_s->assign('USER_ADR', $adr[0]);

   $t_s->assign('PRJMAP_LAT', $latlng[0]);
   $t_s->assign('PRJMAP_LNG', $latlng[1]);

   $t_s->parse('MAIN');
   $prjmap = $t_s->text('MAIN');
  }
 else
 {
  $prjmap = '';
 }

 return $prjmap;
}

function cot_prjmap_geoinfo_to_map($geocity = '')
{
	global $db_ls_cities, $db;
  $geo_search = $db->query(
	"SELECT * FROM $db_ls_cities WHERE city_name='$geocity'")->fetch();
  if (!empty($geo_search)) {
   $geoinfo = $geo_search['city_id'];
  }
return $geoinfo;
}

function cot_prjmap_getdistance($latlng = array(), $urr = array(), $type = 'value')
{
  global $prjmap_mapradius_default;
  if(!$urr['user_mapradius']) $urr['user_mapradius'] = $prjmap_mapradius_default;

  $return = ($type == 'text') ? '' : 0;
  $latlng2 = array($urr['user_prjmaplat'], $urr['user_prjmaplng']);

  if(is_array($latlng) && is_array($latlng2))
  {
   $lat1 = $latlng[0];
   $lng1 = $latlng[1];

   $lat2 = $latlng2[0];
   $lng2 = $latlng2[1];

   if($lat1 && $lng1 && $lat2 && $lng2)
   {
     $lat1=deg2rad($lat1);
     $lng1=deg2rad($lng1);
     $lat2=deg2rad($lat2);
     $lng2=deg2rad($lng2);

     $delta_lat=($lat2 - $lat1);
     $delta_lng=($lng2 - $lng1);

     $return = ($lat1 == $lat2 && $lng1 == $lng2) ? 1 : round( 6378137 * acos( cos( $lat1 ) * cos( $lat2 ) * cos( $lng1 - $lng2 ) + sin( $lat1 ) * sin( $lat2 ) ) );
     if($type == 'text')
     {
      $return = ($return > 1000) ? ($return/1000)." км" : $return." м";
     }
     elseif($type == 'check')
     {
      $return = ($urr['user_mapradius'] == 0) ? true : ($urr['user_mapradius']*1000 > $return);
     }
   }
   elseif($type == 'check')
   {
      $return = ($urr['user_mapradius'] == 0) ? true : false;
   }
  }
  elseif($type == 'check')
  {
    $return = ($urr['user_mapradius'] == 0) ? true : false;
  }

  return $return;
}
