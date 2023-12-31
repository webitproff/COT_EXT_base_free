<?PHP
/**
 * Reply for Comments plugin: русский перевод
 *
 * @package rcomm
 * @author Dr2005alex
 * @copyright Copyright (c) Dr2005alex 2013 | 2023
 * @license BSD License
 **/

defined('COT_CODE') or die('Wrong URL');
$L['info_name'] = 'Ответ на комментарий';
$L['info_desc'] = 'Позволяет пользователям отвечать на комментарии к публикациям на сайте';
$L['info_notes'] = 'Синтаксические правки локализации Tested on Cotonti engine v.0.9.24 | PHP v.7.4.33 | MySQL 5.7 | server Apache 2.4 | <a target="_blank" href="https://t.me/webitproff"><b>webitproff<b></a> ';
$L['rcomm_writes']="пишет";
$L['rcomm_reply']="ответить";
$L['rcomm_reply_send']="Отправить ответ";
$L['rcomm_reply_rep']="Напишите ответ";
$L['rcomm_reply_g_name']="Напишите ваше имя";
$L['rcomm_reply_repedit']="Отредактируйте комментарий";

$L['rcomm_reply_link_txt']="Ответ к комментарию #";
$L['rcomm_show_comm']="Показать ещё..";
$L['rcomm_delete_comments'] = "Bы уверены, что хотите удалить этот комментарий?  Имейте ввиду, что при удалении комментария удаляются и ответы к нему!!!";
$L['rcomm_reply_edit'] = "Редактировать";
$L['rcomm_pm_viewlink'] = "Посмотреть ответ";
//pm
$L['rcomm_pm_title'] = "Вам ответили в комментариях";
$L['rcomm_pm_text'] = 'Пользователь %1$s
 ответил на ваш комментарий. Для просмотра перейдите по этой ссылке. %2$s';

$L['rcomm_mail_notifytitle'] = "Вам ответили в комментариях";
$L['rcomm_mail_text'] = 'Уважаемый %3$s.
Пользователь %1$s ответил на ваш комментарий.
Для просмотра комментария перейдите по этой ссылке. %2$s';

//profile
$L['rcomm_pf_pm_title'] = "Получать личные сообщения, при получении ответа на оставленный комментарий";
$L['rcomm_pf_mail_title'] = "Получать уведомление на email, при получении ответа на оставленный комментарий";

// errors
$L['rcomm_reply_text_min']="Комментарий слишком короткий либо отсутствует";
$L['rcomm_reply_text_long']="Комментарий слишком длинный";

$L['cfg_multipad_reply'] = array("Множитель глубины");
$L['cfg_multipad_reply_hint'] = 'Используется для отступа ответа. формула [Множитель]*[глубину] = отступ. Результат margin-left:[Множитель]*[глубину]px';
$L['cfg_color_line'] = array("Цвет линий, соединяющих ответы");
$L['cfg_color_line_hint'] = 'css формат. Пример: #ff942e, #C09, red, blue и т.д. Работает при включенном jquery.';
$L['cfg_open_comments'] = array("Открывать просмотренные комментарии");
$L['cfg_open_comments_hint'] = "Ренее просмотренние комментарии при повторном просмотре страницы, будут открыты.";
$L['cfg_scroll_reply'] = array("Включить 'притягивание' комментария к ответу, при нажатии на ссылку");
$L['cfg_scroll_reply_hint'] = "Комметарий, на который был дан ответ, будет показан рядом с ответом. Методом jquery scroll";
$L['cfg_pm_send'] = array("Отправлять <u>личное сообщенние</u> пользователю, которому ответили в комментариях?");
$L['cfg_mail_send'] = array("Отправлять сообщенние пользователю на <u>email</u>, которому ответили в комментариях?");
$L['cfg_ajax_send'] = array("Использовать jquery для отправки форм и т.д. ?");
$L['cfg_main_editor'] = array("Использовать текстовый редактор, установленный по умолчанию на сайте?");
$L['cfg_margin_line'] = array("Отступ линии от левой границы комменария в пикселях px");
