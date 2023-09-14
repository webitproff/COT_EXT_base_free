<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=users.profile.update.first
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('prjmap', 'plug');

if(isset($_POST['ruserprjmap'])) {
  $waypoints = cot_import('ruserprjmap', 'P', 'TXT');
  $ruser['user_prjmap'] = '';
  $ruser['user_prjmaplat'] = 0;
  $ruser['user_prjmaplng'] = 0;

  if (!empty($waypoints))
  {
   $ruser['user_prjmap'] = $waypoints;
   $waypoints = explode('#', $waypoints);
   $waypoints = str_replace(array('(', ')'), array('', ''), $waypoints[1]);
   $waypoints = explode(',', $waypoints);

   if(is_numeric((float)$waypoints[0]) && is_numeric((float)$waypoints[1])) {
     $ruser['user_prjmaplat'] = (float)$waypoints[0];
     $ruser['user_prjmaplng'] = (float)$waypoints[1];
   }
  }
}

if(isset($_POST['rusermapradius'])) {
  $ruser['user_mapradius'] = cot_import('rusermapradius', 'P', 'INT');
  if(!in_array($ruser['user_mapradius'], array_keys($prjmap_mapradius))) {
    $ruser['user_mapradius'] = $prjmap_mapradius_default;
  }
}
