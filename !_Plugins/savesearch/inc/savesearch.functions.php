<?php
defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('savesearch', 'plug');
require_once cot_incfile('savesearch', 'plug', 'resources');

cot::$db->registerTable('savesearch');
global $savesearch_phrase_cache;
$savesearch_phrase_cache = array();

function cot_savesearch()
{
	global $db, $db_savesearch, $usr, $R, $_GET;
	$return = 0;

  $code = $_GET['e'];
  $params = $_GET;
  unset($params['e']);

  ksort($params);
  reset($params);

  $return = count($params);

  if(!empty($code) && $return > 0 && $usr['id'] > 0)
  {
     $return = 0;

     $url_params = array();
     $url_search = array();
     foreach($params as $key => $val) {
       $val = trim($val);
       if(!empty($val)) {
          $url_params[] = $key.'='.$val;
          $url_search[$key] = $val;
       }
     }

     $return = count($url_search);

     if($return > 0) {
       $return = $db->query("SELECT COUNT(*) FROM $db_savesearch
    			WHERE s_uid=".$usr['id']." AND s_code='".$code."' AND s_save=1 AND s_var_c='".$db->prep($url_search['c'])."' AND s_var_sq='".$db->prep($url_search['sq'])."' AND MATCH(s_params) AGAINST('".json_encode($url_search)."' IN BOOLEAN MODE)")->fetchColumn();
       $return = cot_rc(($return > 0 ? $R['savesearch_star_off'] : $R['savesearch_star_on']), array('url' => cot_url('plug', 'r=savesearch&code='.$code.'&'.implode('&', $url_params))));
  	} else {
      $return = '';
    }
	} else {
    $return = '';
  }
  return $return;
}

function cot_savesearch_input($area = '', $value = '', $name = 'sq', $attrs = '') {
  $uniq = cot_unique();
  $return = '<span style="display: inline-block;position: relative;">';
    $return .= cot_inputbox('text', $name, htmlspecialchars($value), 'id="savesearch_input_'.$uniq.'" autocomplete="off"'.(!empty($attrs) ? ' '.$attrs : ''));
    $return .= '<ul id="savesearch_helper_'.$uniq.'" class="savesearch_helper" data-found="0" style="display: none;"></ul>';
  $return .= '</span>';
  $return .= '<script>
    var savesearch_input_val = \'\';
    $(\'#savesearch_input_'.$uniq.'\').unbind(\'keyup\').on(\'keyup\', function() {
      var cur_val = $(this).val();
      if(cur_val.length >= 2) {
        savesearch_input_val = cur_val;
        setTimeout(function() {
          if(savesearch_input_val == cur_val) {
            $.getJSON(\'index.php?r=savesearch&a=load_phrase&code='.$area.'&phrase=\' + cur_val, function(data) {
              console.log(data);
              if(data.length > 0) {
                var help_html = \'\';
                for(i=0; data.length > i; i++) {
                  help_html += \'<li data-value="\'+data[i][\'suggestion\']+\'">\' + data[i][\'excerpt\'] + \' (\' + data[i][\'cnt\'] + \')</li>\';
                }
                $(\'#savesearch_helper_'.$uniq.'\').html(help_html).show().attr(\'data-found\', 1).find(\'li\').click(function() {
                  $(\'#savesearch_input_'.$uniq.'\').val($(this).attr(\'data-value\'));
                  $(\'#savesearch_helper_'.$uniq.'\').hide();
                });
              } else {
                $(\'#savesearch_helper_'.$uniq.'\').attr(\'data-found\', 0).html(\'\').hide();
              }
            });
          }
        }, 300);
      }
    });
    $(\'#savesearch_input_'.$uniq.'\').unbind(\'focus\').on(\'focus\', function() {
      if($(\'#savesearch_helper_'.$uniq.'\').attr(\'data-found\') == "1") {
        $(\'#savesearch_helper_'.$uniq.'\').show();
      } else if($(this).val().length >= 2) {
        $(\'#savesearch_input_'.$uniq.'\').trigger(\'keyup\');
      }
    });
    $(\'#savesearch_input_'.$uniq.'\').unbind(\'blur\').on(\'blur\', function() {
      setTimeout(function() {
        $(\'#savesearch_helper_'.$uniq.'\').hide();
      }, 100);
    });
  </script>';

  return $return;
}

function cot_savesearch_url($ss = array()) {
  return cot_url($ss['s_code'], json_decode($ss['s_params'], 1));
}

function cot_savesearch_phrase_cnt($phrase = '') {
  global $db, $db_x, $db_savesearch, $savesearch_phrase_cache;
  $return = 0;
  if(!empty($phrase)) {
    if($savesearch_phrase_cache[$phrase] > 0) {
      $return = $savesearch_phrase_cache[$phrase];
    } else {
      $return = $db->query("SELECT SUM(s_cnt) FROM $db_savesearch WHERE s_save=0 AND s_var_sq='".$db->prep($phrase)."'")->fetchColumn();
      $savesearch_phrase_cache[$phrase] = $return;
    }
  }
  return $return;
}

function cot_savesearch_title($ss = array()) {
  if(!empty($ss['s_var_c'])) {
    global $structure;
    if(is_array($structure[$ss['s_code']]) && is_array($structure[$ss['s_code']][$ss['s_var_c']])) {
      $ss['s_var_c'] = $structure[$ss['s_code']][$ss['s_var_c']]['title'];
    } else {
      $ss['s_var_c'] = '';
    }
  }
  switch($ss['s_code']) {
    case 'market':
      $ss['s_code'] = 'Товары';
      break;
    case 'projects':
      $ss['s_code'] = 'Проекты';
      break;
  }
  return $ss['s_code'].', категория '.(!empty($ss['s_var_c']) ? '"'.$ss['s_var_c'].'"' : 'не указана').', поисковая фраза '.(!empty($ss['s_var_sq']) ? '"<b>'.$ss['s_var_sq'].'"</b> <span title="Кол-во запросов">('.cot_savesearch_phrase_cnt($ss['s_var_sq']).')</span>' : 'не указана');
}