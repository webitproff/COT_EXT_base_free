<?php

defined('COT_CODE') or die('Wrong URL');

cot::$db->registerTable('whowhere');

function cot_whowhere_cfg($parsefoshow = true) {
  $return = array();

  if($parsefoshow) {
    $return['index'] = array(
      'code' => 'index',
      'title' => function($v) {
        return 'На главной';
      }
    );
  }

  if(cot_module_active('forums')) {
    $return['forums_newtopic'] = array(
      'code' => 'forums_newtopic',
      'title' => function($v) {
        if(!empty($v['ww_var_c'])) {
          global $structure;
          if(is_array($structure['forums']) && is_array($structure['forums'][$v['ww_var_c']])) {
            $v['ww_var_c'] = $structure['forums'][$v['ww_var_c']]['title'];
          }
          if(!empty($v['ww_var_c'])) $v['ww_var_c'] = ' в "'.$v['ww_var_c'].'"';
        }
        return cot_rc('<a href="{$ww_var_url}">Создание темы {$ww_var_c}</a>', $v);
      },
      'usl' => array(
        'e' => 'forums',
        'm' => 'newtopic'
      ),
      'as' => array(
        'c' => 's'
      )
    );

    $return['forums_posts'] = array(
      'code' => 'forums_posts',
      'title' => function($v) {
        if(empty($v['ww_var_al']) && $v['ww_var_id'] > 0) {
          global $db, $db_x, $db_forum_topics;
          require_once cot_incfile('forums', 'module');
          $frm = $db->query("SELECT ft_id, ft_title, ft_cat FROM $db_forum_topics WHERE ft_id=".$v['ww_var_id']." LIMIT 1")->fetch();
          if($frm['ft_id'] > 0) {
            $v['ww_var_al'] = $frm['ft_title'];
            if(!empty($frm['ft_cat'])) {
              $v['ww_var_c'] = $frm['ft_cat'];
              global $structure;
              if(is_array($structure['forums']) && is_array($structure['forums'][$v['ww_var_c']])) {
                $v['ww_var_c'] = $structure['forums'][$v['ww_var_c']]['title'];
              }
              if(!empty($v['ww_var_c'])) $v['ww_var_c'] = ' ('.$v['ww_var_c'].')';
            }
          }
        }
        if(empty($v['ww_var_al'])) $v['ww_var_al'] = 'Не найдено';

        return cot_rc('Форум "<a href="{$ww_var_url}">{$ww_var_al}{$ww_var_c}</a>"', $v);
      },
      'usl' => array(
        'e' => 'forums',
        'm' => 'posts'
      ),
      'as' => array(
        'id' => 'q'
      )
    );
    $return['forums_topics'] = array(
      'code' => 'forums_topics',
      'title' => function($v) {
        if(!empty($v['ww_var_c'])) {
          global $structure;
          if(is_array($structure['forums']) && is_array($structure['forums'][$v['ww_var_c']])) {
            $v['ww_var_c'] = $structure['forums'][$v['ww_var_c']]['title'];
          }
          if(!empty($v['ww_var_c'])) $v['ww_var_c'] = ' - "'.$v['ww_var_c'].'"';
        }
        return cot_rc('<a href="{$ww_var_url}">Форум {$ww_var_c}</a>', $v);
      },
      'usl' => array(
        'e' => 'forums',
        'm' => 'topics'
      ),
      'as' => array(
        'c' => 's'
      ),
      'usl_empty' => array('al', 'id')
    );

    $return['forums_list'] = array(
      'code' => 'forums_list',
      'title' => function($v) {
        if(!empty($v['ww_var_c'])) {
          global $structure;
          if(is_array($structure['forums']) && is_array($structure['forums'][$v['ww_var_c']])) {
            $v['ww_var_c'] = $structure['forums'][$v['ww_var_c']]['title'];
          }
          $v['ww_var_c'] = ' - '.(!empty($v['ww_var_c']) ? '"'.$v['ww_var_c'].'"' : 'главная страница');
        }
        return cot_rc('<a href="{$ww_var_url}">Форум {$ww_var_c}</a>', $v);
      },
      'usl' => array(
        'e' => 'forums',
      ),
      'usl_empty' => array('m')
    );
  }

  if(cot_module_active('page')) {
    $return['page_add'] = array(
      'code' => 'page_add',
      'title' => function($v) {
        return 'Добавление страницы';
      },
      'usl' => array(
        'e' => 'page',
        'm' => 'add',
      ),
    );

    $return['page_edit_id'] = array(
      'code' => 'page_edit_id',
      'title' => function($v) {
        if(empty($v['ww_var_al']) && $v['ww_var_id'] > 0) {
          global $db, $db_x, $db_pages;
          require_once cot_incfile('page', 'module');
          $v['ww_var_al'] = $db->query("SELECT page_title FROM $db_pages WHERE page_id=".$v['ww_var_id']." LIMIT 1")->fetchColumn();
        }
        if(empty($v['ww_var_al'])) $v['ww_var_al'] = 'Не найдено';

        return cot_rc('Редактирование страницы <a href="{$ww_var_url}">"'.$v['ww_var_al'].'"</a>', $v);
      },
      'usl' => array(
        'e' => 'page',
        'm' => 'edit',
      ),
      'usl_not_empty' => array('id'),
    );

    $return['page_item_id'] = array(
      'code' => 'page_item_id',
      'title' => function($v) {
        if(empty($v['ww_var_al']) && $v['ww_var_id'] > 0) {
          global $db, $db_x, $db_pages;
          require_once cot_incfile('page', 'module');
          $v['ww_var_al'] = $db->query("SELECT page_title FROM $db_pages WHERE page_id=".$v['ww_var_id']." LIMIT 1")->fetchColumn();
        }
        if(empty($v['ww_var_al'])) $v['ww_var_al'] = 'Не найдено';

        return cot_rc('Страница <a href="{$ww_var_url}">"'.$v['ww_var_al'].'"</a>', $v);
      },
      'usl' => array(
        'e' => 'page',
      ),
      'usl_not_empty' => array('id'),
    );

    $return['page_item_al'] = array(
      'code' => 'page_item_al',
      'title' => function($v) {
        if(empty($v['ww_var_al']) && $v['ww_var_id'] > 0) {
          global $db, $db_x, $db_pages;
          require_once cot_incfile('page', 'module');
          $v['ww_var_al'] = $db->query("SELECT page_title FROM $db_pages WHERE page_id=".$v['ww_var_id']." LIMIT 1")->fetchColumn();
        }
        if(empty($v['ww_var_al'])) $v['ww_var_al'] = 'Не найдено';

        return cot_rc('Страница <a href="{$ww_var_url}">"'.$v['ww_var_al'].'"</a>', $v);
      },
      'usl' => array(
        'e' => 'page',
      ),
      'usl_not_empty' => array('al'),
    );

    $return['page_list'] = array(
      'code' => 'page_list',
      'title' => function($v) {
        if(!empty($v['ww_var_c'])) {
          global $structure;
          if(is_array($structure['page']) && is_array($structure['page'][$v['ww_var_c']])) {
            $v['ww_var_c'] = $structure['page'][$v['ww_var_c']]['title'];
          }
          if(!empty($v['ww_var_c'])) $v['ww_var_c'] = ' "'.$v['ww_var_c'].'"';
        }
        return cot_rc('<a href="{$ww_var_url}">Cтраницы{$ww_var_c}</a>', $v);
      },
      'usl' => array(
        'e' => 'page',
      ),
      'usl_empty' => array('m', 'al', 'id')
    );
  }

  if(cot_module_active('users')) {
    $return['users_details'] = array(
      'code' => 'users_details',
      'title' => function($v) { //функция создания заголовка
        if(!$v['ww_var_al'] && $v['ww_var_id'] > 0) {
           global $db, $db_users;
           $v['ww_var_al'] = $db->query("SELECT user_name FROM $db_users WHERE user_id=".$v['ww_var_id']." LIMIT 1")->fetchColumn();
        }
        if(empty($v['ww_var_al'])) $v['ww_var_al'] = 'Удалено';
        return cot_rc('Пользователя <a href="{$ww_var_url}">{$ww_var_al}</a>', $v);
      },
      'usl' => array(  // условия
        'e' => 'users',
        'm' => 'details'
      ),
      'as' => array( //сохранить алиас из переменной u
        'al' => 'u'
      )
    );
    $return['users_edit'] = array(
      'code' => 'users_edit',
      'title' => function($v) {
        if(!$v['ww_var_al'] && $v['ww_var_id'] > 0) {
           global $db, $db_users;
           $v['ww_var_al'] = $db->query("SELECT user_name FROM $db_users WHERE user_id=".$v['ww_var_id']." LIMIT 1")->fetchColumn();
        }
        if(empty($v['ww_var_al'])) $v['ww_var_al'] = 'Удалено';
        return cot_rc('Редактирования пользователя <a href="{$ww_var_url}">{$ww_var_al}</a>', $v);
      },
      'usl' => array(
        'e' => 'users',
        'm' => 'edit'
      )
    );
    $return['users_profile'] = array(
      'code' => 'users_profile',
      'title' => function($v) {
        return 'Настройки профиля';
      },
      'usl' => array(
        'e' => 'users',
        'm' => 'profile'
      )
    );
    $return['users'] = array(
      'code' => 'users',
      'title' => function($v) {
        return '<a href="{$ww_var_url}">Страницу пользоватей</a>';
      },
      'usl' => array(
        'e' => 'users',
      ),
    );
  }

  if(cot_module_active('payments')) {
    $return['payments_balance_billing'] = array(
      'code' => 'payments_balance_billing',
      'title' => function($v) {
        return cot_rc('<a href="{$ww_var_url}">Пополнение счета</a>', $v);
      },
      'usl' => array(
        'e' => 'payments',
        'm' => 'balance',
        'n' => 'billing'
      )
    );
    $return['payments_balance_payouts'] = array(
      'code' => 'payments_balance_payouts',
      'title' => function($v) {
        return cot_rc('<a href="{$ww_var_url}">Вывод со счета</a>', $v);
      },
      'usl' => array(
        'e' => 'payments',
        'm' => 'balance',
        'n' => 'payouts'
      )
    );
    $return['payments_balance_transfers'] = array(
      'code' => 'payments_balance_transfers',
      'title' => function($v) {
        return cot_rc('<a href="{$ww_var_url}">Перевод пользователю</a>', $v);
      },
      'usl' => array(
        'e' => 'payments',
        'm' => 'balance',
        'n' => 'transfers'
      )
    );
    $return['payments_balance'] = array(
      'code' => 'payments_balance',
      'title' => function($v) {
        return cot_rc('<a href="{$ww_var_url}">История баланса</a>', $v);
      },
      'usl' => array(
        'e' => 'payments',
        'm' => 'balance'
      )
    );
  }

  if(cot_module_active('market')) {
    $return['market_add'] = array(
      'code' => 'market_add',
      'title' => function($v) {
        return 'Добавление товара';
      },
      'usl' => array(
        'e' => 'market',
        'm' => 'add',
      ),
    );

    $return['market_edit_id'] = array(
      'code' => 'market_edit_id',
      'title' => function($v) {
        if(empty($v['ww_var_al']) && $v['ww_var_id'] > 0) {
          global $db, $db_x, $db_market;
          require_once cot_incfile('market', 'module');
          $v['ww_var_al'] = $db->query("SELECT item_title FROM $db_market WHERE item_id=".$v['ww_var_id']." LIMIT 1")->fetchColumn();
        }
        if(empty($v['ww_var_al'])) $v['ww_var_al'] = 'Не найдено';

        return cot_rc('Редактирование товара <a href="{$ww_var_url}">"'.$v['ww_var_al'].'"</a>', $v);
      },
      'usl' => array(
        'e' => 'market',
        'm' => 'edit',
      ),
      'usl_not_empty' => array('id'),
    );

    $return['market_item_id'] = array(
      'code' => 'market_item_id',
      'title' => function($v) {
        if(empty($v['ww_var_al']) && $v['ww_var_id'] > 0) {
          global $db, $db_x, $db_market;
          require_once cot_incfile('market', 'module');
          $v['ww_var_al'] = $db->query("SELECT item_title FROM $db_market WHERE item_id=".$v['ww_var_id']." LIMIT 1")->fetchColumn();
        }
        if(empty($v['ww_var_al'])) $v['ww_var_al'] = 'Не найдено';

        return cot_rc('Товар <a href="{$ww_var_url}">"'.$v['ww_var_al'].'"</a>', $v);
      },
      'usl' => array(
        'e' => 'market',
      ),
      'usl_not_empty' => array('id'),
    );

    $return['market_item_al'] = array(
      'code' => 'market_item_al',
      'title' => function($v) {
        if(empty($v['ww_var_al']) && $v['ww_var_id'] > 0) {
          global $db, $db_x, $db_market;
          require_once cot_incfile('market', 'module');
          $v['ww_var_al'] = $db->query("SELECT item_title FROM $db_market WHERE item_id=".$v['ww_var_id']." LIMIT 1")->fetchColumn();
        }
        if(empty($v['ww_var_al'])) $v['ww_var_al'] = 'Не найдено';

        return cot_rc('Товар <a href="{$ww_var_url}">"'.$v['ww_var_al'].'"</a>', $v);
      },
      'usl' => array(
        'e' => 'market',
      ),
      'usl_not_empty' => array('al'),
    );

    $return['market_preview_id'] = array(
      'code' => 'market_preview_id',
      'title' => function($v) {
        if(empty($v['ww_var_al']) && $v['ww_var_id'] > 0) {
          global $db, $db_x, $db_market;
          require_once cot_incfile('market', 'module');
          $v['ww_var_al'] = $db->query("SELECT item_title FROM $db_market WHERE item_id=".$v['ww_var_id']." LIMIT 1")->fetchColumn();
        }
        if(empty($v['ww_var_al'])) $v['ww_var_al'] = 'Не найдено';

        return cot_rc('Предпросмотр товара <a href="{$ww_var_url}">"'.$v['ww_var_al'].'"</a>', $v);
      },
      'usl' => array(
        'e' => 'market',
        'm' => 'preview',
      ),
      'usl_not_empty' => array('id'),
    );

    $return['market_preview_al'] = array(
      'code' => 'market_preview_al',
      'title' => function($v) {
        if(empty($v['ww_var_al']) && $v['ww_var_id'] > 0) {
          global $db, $db_x, $db_market;
          require_once cot_incfile('market', 'module');
          $v['ww_var_al'] = $db->query("SELECT item_title FROM $db_market WHERE item_id=".$v['ww_var_id']." LIMIT 1")->fetchColumn();
        }
        if(empty($v['ww_var_al'])) $v['ww_var_al'] = 'Не найдено';

        return cot_rc('Предпросмотр товара <a href="{$ww_var_url}">"'.$v['ww_var_al'].'"</a>', $v);
      },
      'usl' => array(
        'e' => 'market',
        'm' => 'preview',
      ),
      'usl_not_empty' => array('al'),
    );

    $return['market_list'] = array(
      'code' => 'market_list',
      'title' => function($v) {
        if(!empty($v['ww_var_c'])) {
          global $structure;
          if(is_array($structure['market']) && is_array($structure['market'][$v['ww_var_c']])) {
            $v['ww_var_c'] = $structure['market'][$v['ww_var_c']]['title'];
          }
          if(!empty($v['ww_var_c'])) $v['ww_var_c'] = ' в "'.$v['ww_var_c'].'"';
        }
        return cot_rc('<a href="{$ww_var_url}">Поиск товаров{$ww_var_c}</a>', $v);
      },
      'usl' => array(
        'e' => 'market',
      ),
      'usl_empty' => array('m', 'al', 'id')
    );
  }

  if(cot_module_active('projects')) {
    $return['projects_add'] = array(
      'code' => 'projects_add',
      'title' => function($v) {
        return 'Добавление проекта';
      },
      'usl' => array(
        'e' => 'projects',
        'm' => 'add',
      ),
    );

    $return['projects_edit_id'] = array(
      'code' => 'projects_edit_id',
      'title' => function($v) {
        if(empty($v['ww_var_al']) && $v['ww_var_id'] > 0) {
          global $db, $db_x, $db_projects;
          require_once cot_incfile('projects', 'module');
          $v['ww_var_al'] = $db->query("SELECT item_title FROM $db_projects WHERE item_id=".$v['ww_var_id']." LIMIT 1")->fetchColumn();
        }
        if(empty($v['ww_var_al'])) $v['ww_var_al'] = 'Не найдено';

        return cot_rc('Редактирование проекта <a href="{$ww_var_url}">"'.$v['ww_var_al'].'"</a>', $v);
      },
      'usl' => array(
        'e' => 'projects',
        'm' => 'edit',
      ),
      'usl_not_empty' => array('id'),
    );

    $return['projects_item_id'] = array(
      'code' => 'projects_item_id',
      'title' => function($v) {
        if(empty($v['ww_var_al']) && $v['ww_var_id'] > 0) {
          global $db, $db_x, $db_projects;
          require_once cot_incfile('projects', 'module');
          $v['ww_var_al'] = $db->query("SELECT item_title FROM $db_projects WHERE item_id=".$v['ww_var_id']." LIMIT 1")->fetchColumn();
        }
        if(empty($v['ww_var_al'])) $v['ww_var_al'] = 'Не найдено';

        return cot_rc('Проект <a href="{$ww_var_url}">"'.$v['ww_var_al'].'"</a>', $v);
      },
      'usl' => array(
        'e' => 'projects',
      ),
      'usl_not_empty' => array('id'),
    );

    $return['projects_item_al'] = array(
      'code' => 'projects_item_al',
      'title' => function($v) {
        if(empty($v['ww_var_al']) && $v['ww_var_id'] > 0) {
          global $db, $db_x, $db_projects;
          require_once cot_incfile('projects', 'module');
          $v['ww_var_al'] = $db->query("SELECT item_title FROM $db_projects WHERE item_id=".$v['ww_var_id']." LIMIT 1")->fetchColumn();
        }
        if(empty($v['ww_var_al'])) $v['ww_var_al'] = 'Не найдено';

        return cot_rc('Проект <a href="{$ww_var_url}">"'.$v['ww_var_al'].'"</a>', $v);
      },
      'usl' => array(
        'e' => 'projects',
      ),
      'usl_not_empty' => array('al'),
    );

    $return['projects_preview_id'] = array(
      'code' => 'projects_preview_id',
      'title' => function($v) {
        if(empty($v['ww_var_al']) && $v['ww_var_id'] > 0) {
          global $db, $db_x, $db_projects;
          require_once cot_incfile('projects', 'module');
          $v['ww_var_al'] = $db->query("SELECT item_title FROM $db_projects WHERE item_id=".$v['ww_var_id']." LIMIT 1")->fetchColumn();
        }
        if(empty($v['ww_var_al'])) $v['ww_var_al'] = 'Не найдено';

        return cot_rc('Предпросмотр проекта <a href="{$ww_var_url}">"'.$v['ww_var_al'].'"</a>', $v);
      },
      'usl' => array(
        'e' => 'projects',
        'm' => 'preview',
      ),
      'usl_not_empty' => array('id'),
    );

    $return['projects_preview_al'] = array(
      'code' => 'projects_preview_al',
      'title' => function($v) {
        if(empty($v['ww_var_al']) && $v['ww_var_id'] > 0) {
          global $db, $db_x, $db_projects;
          require_once cot_incfile('projects', 'module');
          $v['ww_var_al'] = $db->query("SELECT item_title FROM $db_projects WHERE item_id=".$v['ww_var_id']." LIMIT 1")->fetchColumn();
        }
        if(empty($v['ww_var_al'])) $v['ww_var_al'] = 'Не найдено';

        return cot_rc('Предпросмотр проекта <a href="{$ww_var_url}">"'.$v['ww_var_al'].'"</a>', $v);
      },
      'usl' => array(
        'e' => 'projects',
        'm' => 'preview',
      ),
      'usl_not_empty' => array('al'),
    );

    $return['projects_useroffers'] = array(
      'code' => 'projects_useroffers',
      'title' => function($v) {
        return cot_rc('Мои предложения', $v);
      },
      'usl' => array(
        'e' => 'projects',
        'm' => 'useroffers'
      ),
    );

    $return['projects_list'] = array(
      'code' => 'projects_list',
      'title' => function($v) {
        if(!empty($v['ww_var_c'])) {
          global $structure;
          if(is_array($structure['projects']) && is_array($structure['projects'][$v['ww_var_c']])) {
            $v['ww_var_c'] = $structure['projects'][$v['ww_var_c']]['title'];
          }
          if(!empty($v['ww_var_c'])) $v['ww_var_c'] = ' в "'.$v['ww_var_c'].'"';
        }
        return cot_rc('<a href="{$ww_var_url}">Поиск проектов{$ww_var_c}</a>', $v);
      },
      'usl' => array(
        'e' => 'projects',
      ),
      'usl_empty' => array('m', 'al', 'id')
    );
  }

  if(cot_module_active('ds')) {
    $return['ds_dialog'] = array(
      'code' => 'ds_dialog',
      'title' => function($v) {
        if($v['ww_var_id'] > 0) {
          global $db, $db_x, $db_ds_dialog;
          require_once cot_incfile('ds', 'module');
          $dial = $db->query("SELECT * FROM $db_ds_dialog WHERE id=".$v['ww_var_id'].' LIMIT 1')->fetch();
          if($dial['id'] > 0 && ($dial['fromid'] == $v['ww_userid'] || $dial['toid'] == $v['ww_userid'])) {
            global $db, $db_users;
            $tid = ($dial['fromid'] == $v['ww_userid'] ? $dial['toid'] : $dial['fromid']);
            if($tid > 0) $v['ww_var_al'] = $db->query("SELECT user_name FROM $db_users WHERE user_id=".$tid." LIMIT 1")->fetchColumn();
          }
        }
        if(empty($v['ww_var_al'])) $v['ww_var_al'] = 'Не найдено';

        return cot_rc('<a href="{$ww_var_url}">Диалог с '.$v['ww_var_al'].'</a>', $v);
      },
      'usl' => array(
        'e' => 'ds',
        'm' => 'dialog'
      ),
      'as' => array(
        'id' => 'chat'
      )
    );

    $return['ds_list'] = array(
      'code' => 'ds_list',
      'title' => function($v) {
        return cot_rc('<a href="{$ww_var_url}">Личные сообщения</a>', $v);
      },
      'usl' => array(
        'e' => 'ds',
      ),
      'usl_empty' => array('m')
    );
  }

  if(cot_module_active('dsclaims')) {
    $return['dsclaims_dialog'] = array(
      'code' => 'dsclaims_dialog',
      'title' => function($v) {
        if($v['ww_var_id'] > 0) {
          global $db, $db_x, $db_dsclaims_dialog;
          require_once cot_incfile('dsclaims', 'module');
          $dial = $db->query("SELECT * FROM $db_dsclaims_dialog WHERE id=".$v['ww_var_id'].' LIMIT 1')->fetch();
          if($dial['id'] > 0) {
            global $db, $db_users;
            if(($dial['fromid'] == $v['ww_userid'] || $dial['toid'] == $v['ww_userid'])) {
              $tid = ($dial['fromid'] == $v['ww_userid'] ? $dial['toid'] : $dial['fromid']);
              if($tid > 0) $v['ww_var_al'] = $db->query("SELECT user_name FROM $db_users WHERE user_id=".$tid." LIMIT 1")->fetchColumn();
            } else {
              $v['ww_var_al'] = $db->query("SELECT user_name FROM $db_users WHERE user_id=".$dial['fromid']." LIMIT 1")->fetchColumn();
              $v['ww_var_al_2'] = $db->query("SELECT user_name FROM $db_users WHERE user_id=".$dial['toid']." LIMIT 1")->fetchColumn();
              if(!empty($v['ww_var_al']) || !empty($v['ww_var_al_2'])) {
                if(empty($v['ww_var_al'])) {
                  $v['ww_var_al'] = $v['ww_var_al_2'];
                } elseif(!empty($v['ww_var_al_2'])) {
                  $v['ww_var_al'] .= ' и '.$v['ww_var_al_2'];
                }
              }
            }
          }
        }
        return cot_rc('<a href="{$ww_var_url}">Диспут с '.$v['ww_var_al'].'</a>', $v);
      },
      'usl' => array(
        'e' => 'dsclaims',
        'm' => 'dialog'
      ),
      'as' => array(
        'id' => 'chat'
      )
    );

    $return['dsclaims_list'] = array(
      'code' => 'dsclaims_list',
      'title' => function($v) {
        return cot_rc('<a href="{$ww_var_url}">Диспуты</a>', $v);
      },
      'usl' => array(
        'e' => 'dsclaims',
      ),
      'usl_empty' => array('m')
    );
  }

  $return['paypro'] = array(
    'code' => 'paypro',
    'title' => function($v) {
      return cot_rc('<a href="{$ww_var_url}">Покупка PRO</a>', $v);
    },
    'usl' => array(
      'e' => 'paypro'
    )
  );
  /*
  $return['whowhere'] = array(
    'code' => 'whowhere',
    'title' => function($v) {
      return cot_rc('<a href="{$ww_var_url}">Плагин кто где</a>', $v);
    },
    'usl' => array(
      'e' => 'whowhere'
    )
  );
  */

  if(cot_plugin_active('digitalorders')) {
    $return['digitalorders_neworder'] = array(
      'code' => 'digitalorders_neworder',
      'title' => function($v) {
        $v['ww_market_url'] = '';
        $v['ww_market_title'] = 'Не найден';
        if($v['ww_var_id'] > 0) {
          global $db, $db_x, $db_market;
          require_once cot_incfile('market', 'module');

          $itm = $db->query("SELECT * FROM $db_market WHERE item_id=".$v['ww_var_id']." LIMIT 1")->fetch();
          if($itm['item_id'] > 0) {
    				$urlparams = empty($itm['item_alias']) ?
    					array('c' => $itm['item_cat'], 'id' => $itm['item_id']) :
    					array('c' => $itm['item_cat'], 'al' => $itm['item_alias']);
    				$v['ww_market_url'] = cot_url('market', $urlparams, '', true);
            $v['ww_market_title'] = $itm['item_title'];
          }
        }
        return cot_rc('Оформление заказа на товар "<a href="{$ww_market_url}">{$ww_market_title}</a>"', $v);
      },
      'usl' => array(
        'e' => 'digitalorders',
        'm' => 'neworder'
      ),
      'as' => array(
        'id' => 'pid'
      )
    );
    $return['digitalorders_order'] = array(
      'code' => 'digitalorders_order',
      'title' => function($v) {
        $v['ww_order_type'] = 'buyer';
        $v['ww_market_url'] = '';
        $v['ww_market_title'] = 'Не найден';
        if($v['ww_var_id'] > 0) {
          global $db, $db_x, $db_digitalorders, $db_market;
          require_once cot_incfile('digitalorders', 'plug');
          require_once cot_incfile('market', 'module');

          $itm = $db->query("SELECT * FROM $db_digitalorders AS o
        		LEFT JOIN $db_market AS m ON m.item_id=o.order_pid
        		WHERE order_id=".$v['ww_var_id']." LIMIT 1")->fetch();
          if($itm['item_id'] > 0) {
    				$urlparams = empty($itm['item_alias']) ?
    					array('c' => $itm['item_cat'], 'id' => $itm['item_id']) :
    					array('c' => $itm['item_cat'], 'al' => $itm['item_alias']);
    				$v['ww_market_url'] = cot_url('market', $urlparams, '', true);
            $v['ww_market_title'] = $itm['item_title'];
          }
          if($itm['order_id'] > 0 && $v['ww_userid'] > 0 && $itm['order_seller'] == $v['ww_userid']) {
            $v['ww_order_type'] = 'seller';
          }
        }
        return cot_rc(($v['ww_order_type'] == 'buyer' ?
                  'Оформлен заказ <a href="{$ww_var_url}">№'.$v['ww_var_id'].'</a> на товар "<a href="{$ww_market_url}">{$ww_market_title}</a>"'
                  : 'Страница продажи <a href="{$ww_var_url}">№'.$v['ww_var_id'].'</a> на товар "<a href="{$ww_market_url}">{$ww_market_title}</a>"'
            ), $v);
      },
      'usl' => array(
        'e' => 'digitalorders',
        'm' => 'order'
      )
    );
    $return['digitalorders_addclaim'] = array(
      'code' => 'digitalorders_addclaim',
      'title' => function($v) {
        $v['ww_market_url'] = '';
        $v['ww_market_title'] = 'Не найден';
        if($v['ww_var_id'] > 0) {
          global $db, $db_x, $db_digitalorders, $db_market;
          require_once cot_incfile('digitalorders', 'plug');
          require_once cot_incfile('market', 'module');

          $itm = $db->query("SELECT * FROM $db_digitalorders AS o
        		LEFT JOIN $db_market AS m ON m.item_id=o.order_pid
        		WHERE order_id=".$v['ww_var_id']." LIMIT 1")->fetch();
          if($itm['item_id'] > 0) {
    				$urlparams = empty($itm['item_alias']) ?
    					array('c' => $itm['item_cat'], 'id' => $itm['item_id']) :
    					array('c' => $itm['item_cat'], 'al' => $itm['item_alias']);
    				$v['ww_market_url'] = cot_url('market', $urlparams, '', true);
            $v['ww_market_title'] = $itm['item_title'];
          }
          if($itm['order_id'] > 0 && $v['ww_userid'] > 0 && $itm['order_seller'] == $v['ww_userid']) {
            $v['ww_order_type'] = 'seller';
          }
        }
        return cot_rc('Подача жалобы в арбитраж по заказу <a href="{$ww_var_url}">№'.$v['ww_var_id'].'</a> на товар "<a href="{$ww_market_url}">{$ww_market_title}</a>"', $v);
      },
      'usl' => array(
        'e' => 'digitalorders',
        'm' => 'addclaim'
      )
    );
    $return['digitalorders_sales'] = array(
      'code' => 'digitalorders_sales',
      'title' => function($v) {
        return cot_rc('Страница <a href="{$ww_var_url}">Мои продажи</a>', $v);
      },
      'usl' => array(
        'e' => 'digitalorders',
        'm' => 'sales'
      )
    );
    $return['digitalorders_purchases'] = array(
      'code' => 'digitalorders_purchases',
      'title' => function($v) {
        return cot_rc('Страница <a href="{$ww_var_url}">Мои покупки</a>', $v);
      },
      'usl' => array(
        'e' => 'digitalorders',
        'm' => 'purchases'
      )
    );
  }

  return $return;
}