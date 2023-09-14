<?php
defined('COT_CODE') or die('Wrong URL');

function cot_prjmap_form($item = array(), $type = 'prj')
{
 $t_c = new XTemplate(cot_tplfile('prjmap.'.$type.'.script', 'plug'));
 if (count($item) > 0)
  {
   $t = new XTemplate(cot_tplfile('prjmap.'.$type.'.edit', 'plug'));
   
   $adr = explode('#', (($type != 'usr') ? $item['item_adr'] : $item['user_adr']));
 
   $t_c->assign(array(
     'ADR' => $adr[0],
     'LATLNG' => $adr[1]
   ));
   
   $t_c->parse('MAIN');
     
   $t->assign(array(
     'MAIN_SCRIPT' => $t_c->text('MAIN'),
     'INPUT_VAL' => (($type != 'usr') ? $item['item_adr'] : $item['user_adr']),
     'ADR' => $adr[0],
     'LATLNG' => $adr[1]
   ));
   
   $t->parse('MAIN');
   $form = $t->text('MAIN');
  }
 else
 {
  $t_c->parse('MAIN');

  $t = new XTemplate(cot_tplfile('prjmap.'.$type.'.add', 'plug'));
  $t->assign('MAIN_SCRIPT', $t_c->text('MAIN'));
  $t->parse('MAIN');
  $form = $t->text('MAIN');
 }
 return $form;
}

function cot_geoinfo_to_map($geocity = '')
{
	global $db_ls_cities, $db;      
  $geo_search = $db->query(
	"SELECT * FROM $db_ls_cities WHERE city_name='$geocity'")->fetch(); 
  if (!empty($geo_search)) {
   $geoinfo = $geo_search['city_id'];  
  }
return $geoinfo;
}

function cot_prjmap_getdistance($latlng = '', $urr = array(), $type = 'value')
{
  $return = ($type == 'text') ? '' : 0;
  $latlng = (stristr($latlng, '#') === FALSE) ? array(0 => 'empty', 1 => $latlng) : explode("#", $latlng);
  
  $latlng2 = explode("#", $urr['user_adr']);
  
  if(is_array($latlng) && is_array($latlng2))
  {
   $latlng = explode(",", $latlng[1]);
   $latlng2 = explode(",", $latlng2[1]);
   
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
     
     $return = round( 6378137 * acos( cos( $lat1 ) * cos( $lat2 ) * cos( $lng1 - $lng2 ) + sin( $lat1 ) * sin( $lat2 ) ) );
     if($type != 'check')
     {
      if($type == 'text')
      {
        $return = ($return > 1000) ? ($return/1000)." км" : $return." м";
      }
     }
     elseif($type == 'check')
     {
      $return = ($usr['user_mapradius'] == 0) ? true : ($usr['user_mapradius']*1000 > $return);
     }
   }
   elseif($type == 'check')
   {
      $return = ($usr['user_mapradius'] == 0) ? true : false;
   }
  }
  elseif($type == 'check')
  {
    $return = ($usr['user_mapradius'] == 0) ? true : false;
  }

  return $return;    
}

?>