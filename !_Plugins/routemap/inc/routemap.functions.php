<?php
/**
 * Route for projects (google maps)
 * @Version 1.1.0
 * @package routemap
 * @copyright (c) Alexeev Vlad
 */

function cot_route_form($data = '')
{
 global $cfg;
 $t_c = new XTemplate(cot_tplfile('routemap.script.add.'.$cfg['plugin']['routemap']['mapservice'], 'plug'));
 if ($data)
  {
   $t = new XTemplate(cot_tplfile('routemap.edit', 'plug'));
   
   $jj = 1;   
   $points = explode('&', $data);
   $last = count($points);
   
   $viapoints = array();

   foreach ($points as $r_info)
   {
     $row = explode('#', $r_info);
       if ($jj == 1)
       {
        $t->assign('ROUTE_FROM_NAME', $row[0]);
        $t_c->assign('ROUTE_FROM_LATLNG', $row[1]);
       }elseif ($jj == $last){
        $t->assign('ROUTE_TO_NAME', $row[0]);
        $t_c->assign('ROUTE_TO_LATLNG', $row[1]);
       }else{
        $viapoints[] = $jj;
        $t->assign('ROUTE_POINT_NAME', $row[0]);      
        $t->parse('MAIN.ROUTE');
        
        $t_c->assign('ROUTE_POINT_LATLNG', $row[1]);      
        $t_c->parse('MAIN.ROUTE');
       }
       $jj++;
   }
   $t_c->assign('ROUTE_VIA_POINTS', implode(',', $viapoints));
   $t_c->assign('ROUTE_VIA_POINTS_COUNT', count($viapoints));
   $t_c->parse('MAIN');
   
   $t->assign(array(
     'MAIN_SCRIPT' => $t_c->text('MAIN'),
     'ROUTE_DATA' => $data,
   ));
   
   $t->parse('MAIN');
   $form = $t->text('MAIN');
  }
 else
 {
  $t_c->parse('MAIN');

  $t = new XTemplate(cot_tplfile('routemap.add', 'plug'));
  $t->assign('MAIN_SCRIPT', $t_c->text('MAIN'));
  $t->parse('MAIN');
  $form = $t->text('MAIN');
 }
 return $form;
}


function cot_get_route_map($data = '')
{
 global $cfg;
 if ($data)
  {
   $t_s = new XTemplate(cot_tplfile('routemap.route.map.'.$cfg['plugin']['routemap']['mapservice'], 'plug'));
   
   $jj = 1;   
   $points = explode('&', $data);
   $last = count($points);
   
   foreach ($points as $r_info)
   {
     $row = explode('#', $r_info);
       if ($jj == 1)
       {
        $t_s->assign('ROUTE_FROM_NAME', $row[0]);
        $t_s->assign('ROUTE_FROM_LATLNG', $row[1]);
       }elseif ($jj == $last){
        $t_s->assign('ROUTE_TO_NAME', $row[0]);
        $t_s->assign('ROUTE_TO_LATLNG', $row[1]);
       }else{             
        $t_s->assign('ROUTE_POINT_NAME', $row[0]);
        $t_s->assign('ROUTE_POINT_LATLNG', $row[1]);
        $t_s->parse('MAIN.ROUTE');
       }
       $jj++;
   }
   
   $t_s->parse('MAIN');
   $route = $t_s->text('MAIN');
  }
 else
 {
  $route = '';
 }
 
 return $route;
}