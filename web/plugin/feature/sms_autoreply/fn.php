<?php

/*
 * Implementations of hook checkavailablekeyword()
 *
 * @param $keyword
 *   checkavailablekeyword() will insert keyword for checking to the hook here
 * @return 
 *   TRUE if keyword is NOT available
 */
function sms_autoreply_hook_checkavailablekeyword($keyword)
{
    $ok = false;
    $db_query = "SELECT autoreply_id FROM "._DB_PREF_."_featureAutoreply WHERE autoreply_keyword='$keyword'";
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
 * @param $autoreply_keyword
 *   check if keyword is for sms_autoreply
 * @param $autoreply_param
 *   get parameters from incoming sms
 * @return $ret
 *   array of keyword owner uid and status, TRUE if incoming sms handled
 */
function sms_autoreply_hook_setsmsincomingaction($sms_datetime,$sms_sender,$autoreply_keyword,$autoreply_param='')
{
    $ok = false;
    $db_query = "SELECT uid,autoreply_id FROM "._DB_PREF_."_featureAutoreply WHERE autoreply_keyword='$autoreply_keyword'";
    $db_result = dba_query($db_query);
    if ($db_row = dba_fetch_array($db_result))
    {
	$c_uid = $db_row['uid'];
	if (sms_autoreply_handle($sms_datetime,$sms_sender,$autoreply_keyword,$autoreply_param))
	{
	    $ok = true;
	}
    }
    $ret['uid'] = $c_uid;
    $ret['status'] = $ok;
    return $ret;
}

function sms_autoreply_handle($sms_datetime,$sms_sender,$autoreply_keyword,$autoreply_param='')
{
    global $datetime_now;
    $ok = false;
    $autoreply_request = $autoreply_keyword." ".$autoreply_param;
    $array_autoreply_request = explode(" ",$autoreply_request);
    for ($i=0;$i<count($array_autoreply_request);$i++)
    {
	$autoreply_part[$i] = trim($array_autoreply_request[$i]);
	$tmp_autoreply_request .= $array_autoreply_request[$i]." ";
    }
    $autoreply_request = trim($tmp_autoreply_request);
    for ($i=1;$i<8;$i++)
    {
	$autoreply_scenario_param_list .= "autoreply_scenario_param$i='".$autoreply_part[$i]."' AND ";
    }
    $db_query = "
	SELECT autoreply_scenario_result FROM "._DB_PREF_."_featureAutoreply_scenario 
	WHERE $autoreply_scenario_param_list 1=1
    ";
    $db_result = dba_query($db_query);
    $db_row = dba_fetch_array($db_result);
    if ($autoreply_scenario_result = $db_row['autoreply_scenario_result'])
    {
        $db_query = "
	    INSERT INTO "._DB_PREF_."_featureAutoreply_log
	    (sms_sender,autoreply_log_datetime,autoreply_log_keyword,autoreply_log_request) 
	    VALUES
	    ('$sms_sender','$datetime_now','$autoreply_keyword','$autoreply_request')
	";
	if ($new_id = @dba_insert_id($db_query))
	{
	    $ok = true;
	}
    }
    if ($ok)
    {
	$ok = false;
	$db_query = "SELECT uid FROM "._DB_PREF_."_featureAutoreply WHERE autoreply_keyword='$autoreply_keyword'";
	$db_result = dba_query($db_query);
	$db_row = dba_fetch_array($db_result);
	$c_uid = $db_row['uid'];
	$c_username = uid2username($c_uid);
	$smslog_id = websend2pv($c_username,$sms_sender,$autoreply_scenario_result);
	if ($smslog_id)
	{
	    $ok = true;
	}
    }
    return $ok;
}

?>