<?php

defined('COT_CODE') or die('Wrong URL.');

global $cot_extrafields, $db_reviews, $db_x;
$db_reviews = (isset($db_reviews)) ? $db_reviews : $db_x . 'reviews';

function cot_update_review_star($userid)
{
	global $db, $db_users, $db_reviews;
	
	if ($userid)
	{
		$rsql = $db->query("SELECT 
    AVG(item_rquality) as quality, 
    AVG(item_rcost) as cost, 
    AVG(item_ramity) as amity 
    FROM $db_reviews WHERE item_touserid=" . (int)$userid)->fetch(); 
    		
    $db->update($db_users, array('user_rquality' => $rsql['quality'], 'user_rcost' => $rsql['cost'], 'user_ramity' => $rsql['amity']), "user_id=" . (int)$userid);

		return true;
	}
	else
	{
		return false;
	}
}

function cot_get_avg_star($sta, $stb, $stc)
{	
  $nums = array();
  $count = 0;
  ($sta) && $nums[] = (int)$sta;
  ($stb) && $nums[] = (int)$stb;
  ($stc) && $nums[] = (int)$stc;
  $count = count($nums);
  if ($count != 0)
  {
    $return = array_sum($nums) / $count;
   	return (float)round($return, 1);
  }

  return 0;
}

function cot_reviewstar_form($type = '', $a = 0, $b = 0, $c = 0, $id = 0)
{
  if(!empty($type))
  {   
	 $t1 = new XTemplate(cot_tplfile(array('reviewstar', 'form'), 'plug'));
  
   if($type != 'ADD')
   {
			$t1->assign(array(
					'STAR_1' => ($a > 0) ? $a : 0,
					'STAR_2' => ($b > 0) ? $b : 0,
          'STAR_3' => ($c > 0) ? $c : 0,
          'STAR_SUMM' => cot_get_avg_star($a, $b, $c),
			));
   }

	 $t1->assign(array(
		'ID' => $id
	 ));

   $t1->parse('MAIN.'.$type);
	 $t1->parse('MAIN');
	 return $t1->text('MAIN');
  }

  return '';
}

?>