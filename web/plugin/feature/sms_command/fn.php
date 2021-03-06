<?php

/*
 * Implementations of hook checkavailablekeyword()
 *
 * @param $keyword
 *   checkavailablekeyword() will insert keyword for checking to the hook here
 * @return 
 *   TRUE if keyword is NOT available
 */
function sms_command_hook_checkavailablekeyword($keyword)
{
    $ok = false;
    $db_query = "SELECT command_id FROM "._DB_PREF_."_featureCommand WHERE command_keyword='$keyword'";
    if ($db_result = dba_num_rows($db_query))
    {
        $ok = true;
    }
    return $ok;
}

/*
 * Implementations of hook setsmsincomingaction()
 *
 * @param $sms_datetime
 *   date and time when incoming sms inserted to playsms
 * @param $sms_sender
 *   sender on incoming sms
 * @param $command_keyword
 *   check if keyword is for sms_command
 * @param $command_param
 *   get parameters from incoming sms
 * @return $ret
 *   array of keyword owner uid and status, TRUE if incoming sms handled
 */
function sms_command_hook_setsmsincomingaction($sms_datetime,$sms_sender,$command_keyword,$command_param='')
{
    $ok = false;
    $db_query = "SELECT uid,command_id FROM "._DB_PREF_."_featureCommand WHERE command_keyword='$command_keyword'";
    $db_result = dba_query($db_query);
    if ($db_row = dba_fetch_array($db_result))
    {
	$c_uid = $db_row['uid'];
	if (sms_command_handle($sms_datetime,$sms_sender,$command_keyword,$command_param))
	{
	    $ok = true;
	}
    }
    $ret['uid'] = $c_uid;
    $ret['status'] = $ok;
    return $ret;
}

function sms_command_handle($sms_datetime,$sms_sender,$command_keyword,$command_param='')
{
    global $datetime_now, $plugin_config;
    $ok = false;
    $db_query = "SELECT command_exec FROM "._DB_PREF_."_featureCommand WHERE command_keyword='$command_keyword'";
    $db_result = dba_query($db_query);
    $db_row = dba_fetch_array($db_result);
    $command_exec = $db_row['command_exec'];
    $command_exec = str_replace("{SMSDATETIME}","\"$sms_datetime\"",$command_exec);
    $command_exec = str_replace("{SMSSENDER}","\"$sms_sender\"",$command_exec);
    $command_exec = str_replace("{COMMANDKEYWORD}","\"$command_keyword\"",$command_exec);
    $command_exec = str_replace("{COMMANDPARAM}","\"$command_param\"",$command_exec);
    $command_exec = $plugin_config['feature']['sms_command']['bin']."/".$command_exec;
    $command_output = shell_exec(stripslashes($command_exec));
    $db_query = "
	INSERT INTO "._DB_PREF_."_featureCommand_log
	(sms_sender,command_log_datetime,command_log_keyword,command_log_exec) 
	VALUES
	('$sms_sender','$datetime_now','$command_keyword','$command_exec')
    ";
    if ($new_id = @dba_insert_id($db_query))
    {
	$ok = true;
    }
    return $ok;
}

?>