<?php

playsmsd();
getsmsinbox();
getsmsstatus();
execcommoncustomcmd();

if ($_REQUEST['op']=='daemon') {
    echo "<h2><font color=green>"._('playSMS server successfully refreshed')."</font></h2>";
    die();
}

$url = $_REQUEST['url'];
if (isset($url)) {
    $url = base64_decode($url);
    header ("Location: $url");
}
?>