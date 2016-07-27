<?php
// Tutorial Module                    										
// Created by kaotik													

$modversion['name'] = _MI_SIMITFRAMEWORK_NAME;
$modversion['version'] = 2010.08;
$modversion['description'] = _MI_SIMITFRAMEWORK_DESC;
$modversion['author'] = "KS Tan (kstan@simit.com.my)";
$modversion['credits'] = "Sim IT Sdn. Bhd.";
$modversion['help'] = "";
$modversion['license'] = "-";
$modversion['official'] = 0;
$modversion['image'] = "images/modulepic.jpg";
$modversion['dirname'] = "simantz";

// Admin
$modversion['hasAdmin'] = 1;

// Menu
$modversion['hasMain'] = 1;
$modversion['adminindex'] = "admin/index.php";

// SQL

$i=0;
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

$modversion['tables'][$i] = "workflowtransactionhistory";$i++;
$modversion['tables'][$i] = "workflowtransaction";$i++;

$modversion['tables'][$i] = "workflownode";$i++;
$modversion['tables'][$i] = "workflow";$i++;

$modversion['tables'][$i] = "workflowuserchoiceline";$i++;
$modversion['tables'][$i] = "workflowuserchoice";$i++;
$modversion['tables'][$i] = "workflowstatus";$i++;
$modversion['tables'][$i] = "races";$i++;
$modversion['tables'][$i] = "region";$i++;
$modversion['tables'][$i] = "religion";$i++;
$modversion['tables'][$i] = "period";$i++;
$modversion['tables'][$i] = "organization";$i++;
$modversion['tables'][$i] = "currency";$i++;
$modversion['tables'][$i] = "country";$i++;
$modversion['tables'][$i] = "permission";$i++;
$modversion['tables'][$i] = "window";$i++;
$modversion['tables'][$i] = "version";$i++;
$modversion['tables'][$i] = "audit";$i++;
$modversion['tables'][$i] = "loginevent";$i++;

$modversion['blocks'][1]['file'] = "historyblock.php";
$modversion['blocks'][1]['name'] = 'History';
$modversion['blocks'][1]['description'] = 'This is a Block for the access history link';
$modversion['blocks'][1]['show_func'] = "showHistory";
$modversion['blocks'][1]['edit_func'] = "editHistoryCount";
$modversion['blocks'][1]['template'] = 'sideblockshortcut.html';
$modversion['blocks'][1]['options'] = "10";
//$modversion['blocks'][1]['edit_func'] = "extgalleryBlockEdit";

//$modversion['hasNotification'] = 1;
//$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
//$modversion['notification']['lookup_func'] = 'extgalleryNotifyIteminfo';

//$modversion['notification']['category'][1]['name'] = 'global';
//$modversion['notification']['category'][1]['title'] = _MI_EXTGAL_GLOBAL_NOTIFY;
//$modversion['notification']['category'][1]['description'] = _MI_EXTGAL_GLOBAL_NOTIFYDSC;
//$modversion['notification']['category'][1]['subscribe_from'] = '*';
//$modversion['notification']['category'][1]['item_name'] = '';

//$modversion['notification']['event'][1]['name'] = 'new_photo';
//$modversion['notification']['event'][1]['category'] = 'global';
//$modversion['notification']['event'][1]['title'] = _MI_EXTGAL_NEW_PHOTO_NOTIFY;
//$modversion['notification']['event'][1]['caption'] = _MI_EXTGAL_NEW_PHOTO_NOTIFYCAP;
//$modversion['notification']['event'][1]['description'] = _MI_EXTGAL_NEW_PHOTO_NOTIFYDSC;
//$modversion['notification']['event'][1]['mail_template'] = 'global_new_photo';
//$modversion['notification']['event'][1]['mail_subject'] = _MI_EXTGAL_NEW_PHOTO_NOTIFYSBJ;


?>
