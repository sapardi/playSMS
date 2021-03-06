<?php
if(!(defined('_SECURE_'))){die('Intruder alert');};

// this file loaded before plugins

$inc = q_sanitize($_REQUEST['inc']);
$op = q_sanitize($_REQUEST['op']);

$err = $_REQUEST['err'];
$errid = $_REQUEST['errid'];
$page = $_REQUEST['page'];
$nav = $_REQUEST['nav'];

$username = $_COOKIE['vc2'];
$uid = username2uid($username);
$sender = username2sender($username);
$mobile = username2mobile($username);
$email = username2email($username);
$name = username2name($username);
$status = username2status($username);
$userstatus = ( isadmin() ? 'Administrator' : ' Normal User' );

// reserved important keywords
$reserved_keywords = array ("PV","BC");

// action icon
$icon_edit = "<img src=\"".$http_path['themes']."/".$themes_module."/images/edit_action.gif\" alt=\""._('Edit')."\" title=\""._('Edit')."\" border=0>";
$icon_delete = "<img src=\"".$http_path['themes']."/".$themes_module."/images/delete_action.gif\" alt=\""._('Delete')."\" title=\""._('Delete')."\" border=0>";
$icon_reply = "<img src=\"".$http_path['themes']."/".$themes_module."/images/reply_action.gif\" alt=\""._('Reply')."\" title=\""._('Reply')."\" border=0>";
$icon_manage = "<img src=\"".$http_path['themes']."/".$themes_module."/images/manage_action.gif\" alt=\""._('Manage')."\" title=\""._('Manage')."\" border=0>";
$icon_view = "<img src=\"".$http_path['themes']."/".$themes_module."/images/view_action.gif\" alt=\""._('View')."\" title=\""._('View')."\" border=0>";
$icon_calendar = "<img src=\"".$http_path['themes']."/".$themes_module."/images/cal.gif\" alt=\""._('Pick Date & Time')."\" title=\""._('Pick Date & Time')."\" border=0>";
$icon_sendsms = "<img src=\"".$http_path['themes']."/".$themes_module."/images/sendsms.gif\" alt=\""._('Send SMS')."\" title=\""._('Send SMS')."\" border=0>";
$icon_phonebook = "<img src=\"".$http_path['themes']."/".$themes_module."/images/phonebook_action.gif\" alt=\""._('Phonebook')."\" title=\""._('Phonebook')."\" border=0>";

// menus
$arr_menu['My Account'][] = array("menu.php?inc=sms_template&op=list", _('Message template'));
$arr_menu['My Account'][] = array("menu.php?inc=send_sms&op=sendsmstopv", _('Send SMS'));
$arr_menu['My Account'][] = array("menu.php?inc=send_sms&op=sendsmstogr", _('Send broadcast SMS'));
$arr_menu['My Account'][] = array("menu.php?inc=user_inbox&op=user_inbox", _('Inbox'));
$arr_menu['My Account'][] = array("menu.php?inc=user_incoming&op=user_incoming", _('Incoming SMS'));
$arr_menu['My Account'][] = array("menu.php?inc=user_outgoing&op=user_outgoing", _('Outgoing SMS'));
$arr_menu['My Account'][] = array("menu.php?inc=user_pref&op=user_pref", _('Preferences'));
ksort($arr_menu['My Account']);

if (isadmin()) {
    // administrator menus
    $arr_menu['Administration'][] = array("menu.php?inc=all_inbox&op=all_inbox", _('All inbox'));
    $arr_menu['Administration'][] = array("menu.php?inc=all_incoming&op=all_incoming", _('All incoming SMS'));
    $arr_menu['Administration'][] = array("menu.php?inc=all_outgoing&op=all_outgoing", _('All outgoing SMS'));
    $arr_menu['Administration'][] = array("menu.php?inc=user_mgmnt&op=user_list", _('Manage user'));
    $arr_menu['Administration'][] = array("menu.php?inc=main_config&op=main_config", _('Main configuration'));
    $arr_menu['Administration'][] = array("menu.php?inc=daemon&op=daemon", _('Manual refresh'));
    ksort($arr_menu['Administration']);
}

?>