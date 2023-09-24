<?php defined('COT_CODE') or die('Wrong URL');

function cot_get_date_diff($array){
	global $Ls;
	$prefixstart ='item_WORKPERIOD';
	$prefixend = 'item_WORKPERIODEND';
	$datedifftmp = array();
	for ($i=0; $i < 9; $i++) {
		if($i==1)continue;
					if ($i==0) {
							$datedifftmp[$i] = $array[$prefixend] - $array[$prefixstart];
								}else{
							$datedifftmp[$i] = $array[$prefixend.$i] - $array[$prefixstart.$i];
					}			
	}
	$alldate = array_sum($datedifftmp);
	$units = array(
		'31536000' => $Ls['Years'],
		'2592000' => $Ls['Months'],
		'604800' => $Ls['Weeks'],
		'86400' => $Ls['Days'],
		'3600' => $Ls['Hours'],
		'60' => $Ls['Minutes'],
		'1' => $Ls['Seconds'],
		'0.001' => $Ls['Milliseconds']
	);

   return cot_build_friendlynumber($alldate, $units,3);
}