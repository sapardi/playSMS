<?php

// insert to left menu array
$arr_menu['Feature'][] = array("menu.php?inc=feature_sms_subscribe&op=sms_subscribe_list", _('Manage subscribe'));

$subscribe_icon_add_message = "<img src=\"".$http_path['themes']."/".$themes_module."/images/edit_action.gif\" alt=\""._('Add message')."\" title=\""._('Add message')."\" border=0>";
$subscribe_icon_view_members = "<img src=\"".$http_path['themes']."/".$themes_module."/images/view_action.gif\" alt=\""._('View members')."\" title=\""._('View members')."\" border=0>";
$subscribe_icon_view_messages = "<img src=\"".$http_path['themes']."/".$themes_module."/images/view_action.gif\" alt=\""._('View messages')."\" title=\""._('View messages')."\" border=0>";

?>