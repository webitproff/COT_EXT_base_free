<?php
defined('COT_CODE') or die('Wrong URL');

$id = cot_import('id', 'G', 'INT');

$SPApiProxy = new SendpulseApi( SENDPULSE_API_USER_ID, SENDPULSE_API_SECRET, SENDPULSE_TOKEN_STORAGE );

$tt = new XTemplate(cot_tplfile('sendpulse.tools.'.(($id > 0) ? 'book' : 'list'), 'plug'));

if($id > 0)
{
  $book = $SPApiProxy->getBookInfo($id);
  $tt->assign(array(
    'BOOK_ID' => $book[0]->id,
    'BOOK_NAME' => $book[0]->name,
  ));

  $jj = 0;
  foreach($SPApiProxy->getEmailsFromBook($id) as $list)
  {
   $jj++;
   $variables = array();
   foreach($list->variables as $i => $v) { $variables[] = '['.$i.'] => '.$v; }
   $tt->assign(array(
    'LIST_ROW_JJ' => $jj,
    'LIST_ROW_EMAIL' => $list->email,
    'LIST_ROW_PHONE' => ((!empty($list->phone)) ? $list->phone : '-'),
    'LIST_ROW_USER' => ((!empty($list->email)) ? $db->query("SELECT user_name FROM $db_users WHERE user_email='".$list->email."'")->fetchColumn() : ''),
    'LIST_ROW_STATUS' => $list->status_explain,
    'LIST_ROW_VARIABLES' => ((count($variables) > 0) ? implode(', ', $variables) : '')
   ));
   $tt->parse('MAIN.LIST_ROW');
  }
}
else
{
  foreach($SPApiProxy->listAddressBooks() as $list)
  {
   $tt->assign(array(
    'LIST_ROW_ID' => $list->id,
    'LIST_ROW_NAME' => $list->name,
    'LIST_ROW_COUNT_ALL' => $list->all_email_qty,
    'LIST_ROW_COUNT_ACT' => $list->active_email_qty,
    'LIST_ROW_COUNT_INACT' => $list->inactive_email_qty,
    'LIST_ROW_COUNT_DATE' => $list->creationdate,
    'LIST_ROW_STATUS' => $list->status_explain
   ));
   $tt->parse('MAIN.LIST_ROW');
  }

  $balance = $SPApiProxy->getBalance();
  $tt->assign(array(
    'BALANCE' => $balance->balance_currency.' '.$balance->currency,
  ));
}

cot_display_messages($tt);
$tt->parse('MAIN');
$plugin_body = $tt->text('MAIN');