<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=ajax
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL.');

cot_sendheaders();

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('users', 'a');
cot_block($usr['isadmin']);

$a = cot_import('a', 'G', 'TXT');
$usergroup = cot_import('usergroup', 'G', 'INT');
$usercats = urldecode(cot_import('usercats', 'G', 'TXT'));

if($a == 'export' && $usergroup > 0) {
  $export = array('user_name' => 'Пользователь', 'user_email' => 'Email');
  
  /*
  include 'plugins/usersexport/inc/PHPExcel/Writer/Excel2007.php';
  $objPHPExcel = new PHPExcel();
  
  $objPHPExcel->getProperties()->setCreator('usersexport')
      ->setLastModifiedBy('usersexport')
      ->setTitle('Экспорт Пользователей');
  
  $objPHPExcel->setActiveSheetIndex(0);
  
  $exelcols = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
  
  $ii = 0;
  $col = '';
  foreach($export as $title) {
    $col = ($ii > 25) ? 'A'.$exelcols[$ii] : $exelcols[$ii];
    $objPHPExcel->getActiveSheet()->SetCellValue($col.'1', $title);
    $ii++;
  }
  
  $objPHPExcel->getActiveSheet()->getStyle('A1:'.$col.'1')->getFont()->setBold(true);
  
	*/
  /*
  if(!empty($usercats)) {
    $subcats = cot_structure_children('usercategories', $usercats);
  	if(count($subcats) > 0){
  		foreach ($subcats as $val) {
  			$cat_query[] = "FIND_IN_SET('".$db->prep($val)."', user_cats)";
  		}
  		$usercats = "(".implode(' OR ', $cat_query).")";
  	}
  }
  */             
  $usercats = (!empty($usercats)) ? explode(',', $usercats) : array();                                         
  $usercats = (count($usercats) > 0) ? "(FIND_IN_SET('".implode("', user_cats) OR FIND_IN_SET('", $usercats)."', user_cats))" : '';

  $sqllist_rowset = $db->query("SELECT * FROM $db_users WHERE user_usergroup=".$usergroup.(!empty($usercats) ? ' AND '.$usercats : ''))->fetchAll();
  
  $i = 1;
  echo '<table id="tabletoexel">';
  foreach($sqllist_rowset as $urr)
  { 
    /*
    $i++;
    $ii = 0;
    foreach($export as $itemcol) {
      $col = ($ii > 25) ? 'A'.$exelcols[$ii] : $exelcols[$ii];
      $objPHPExcel->getActiveSheet()->SetCellValue($col.$i, $urr[$itemcol]);
      $ii++;
    }
    */
    echo '<tr>';
    foreach(array_keys($export) as $itemcol) {
      echo '<td>'.$urr[$itemcol].'</td>';
    }
    echo '</tr>';
  }
  echo "</table>
    <script type=\"text/javascript\">
      var tableToExcel = (function() {
        var uri = 'data:application/vnd.ms-excel;base64,'
          , template = '<html xmlns:o=\"urn:schemas-microsoft-com:office:office\" xmlns:x=\"urn:schemas-microsoft-com:office:excel\" xmlns=\"http://www.w3.org/TR/REC-html40\"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
          , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
          , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
        return function(table, name) {
          if (!table.nodeType) table = document.getElementById(table)
          var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
          window.location.href = uri + base64(format(template, ctx))
        }
      })()
      tableToExcel('tabletoexel', 'W3C Example Table')
    </script> 
  ";
  
  /*
  $file = "plugins/usersexport/tpl/export.xlsx";
  $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
  $objWriter->save($file);
    
  if (file_exists($file)) {
  
      if (ob_get_level()) {
        ob_end_clean();
      }
  
      header('Content-Description: File Transfer');
      header('Content-Type: application/xlsx');
      header('Content-Disposition: inline; filename=' . basename($file));
      header('Content-Length: ' . filesize($file));
  
      if ($fd = fopen($file, 'rb')) {
        while (!feof($fd)) {
          print fread($fd, 1024);
        }
        fclose($fd);
      }
      exit;
  }
  */
}