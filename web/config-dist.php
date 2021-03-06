<?php
// PHP PEAR DB compatible database engine:
// msql, mssql, mysql, oci8, odbc, pgsql, sqlite
$core_config['db']['type'] = 'mysql';		// database engine
$core_config['db']['host'] = 'localhost';	// database host/server
$core_config['db']['port'] = '';			// database port
$core_config['db']['user'] = 'root';		// database username
$core_config['db']['pass'] = 'rootpassword';	// database password
$core_config['db']['name'] = 'playsms';		// database name
$core_config['db']['pref'] = 'playsms';		// table's prefix without trailing underscore

// SMTP configuration
$core_config['smtp']['relm'] = ''; // yes, not realm, its relm
$core_config['smtp']['user'] = '';
$core_config['smtp']['pass'] = '';
$core_config['smtp']['host'] = 'localhost';
$core_config['smtp']['port'] = '';


// Do not change anything below this line unless you know what to do
// -----------------------------------------------------------------


// you can turn on or off PHP error reporting
// on production level you should turn off PHP error reporting, by default its on
error_reporting(0);
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

// logs directories
$apps_path['logs']	= '/var/log/playsms';

// 0 for single session login; 1 for multi session login
// multi session login is not secure because playsms leaves md5 crypted username and password
// on admin's computer
$core_config['multilogin']	= 0;

// log level: 0=disabled, 1=info, 2=warning, 3=debug
// WARNING: log level 3 will also save sensitif information such as password for used gateway
$core_config['logstate']	= 0;

// are we using http or https ? the default is using http instead https
$core_config['ishttps']		= false;

// max sms text length
$core_config['smsmaxlength']	= 2*153; // single text sms can be 160 char instead of 1*153

?>