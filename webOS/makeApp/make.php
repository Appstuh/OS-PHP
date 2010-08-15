<?php
/*
	Copyright:	Appstuh 2010. Some rights reserved.
	License:	AGPLv3
	Purpose:	Generate IPKG feed compatible with Preware and webOS Quick Install for webOS developers' internal testing systems
					so that the dev no longer has to use USB to connect to the device (if using Preware)
	Warranty:	No warranty is provided. Nothing. Nada. Zip. Zilch. Nothing.
	Cost:		Nothing. Though if you find this helps you out, we wouldn't mind a nice donation. Contact us if you wish to donate
	Usage:		http://yourhost/make.php?pkg=com.yourdomain.app
*/


// CONFIGURE BELOW:

$mysql = array(
	'host'	=> '', // your database host
	'user'	=> '', // your mysql username
	'pass'	=> '', // your mysql password
	'db'	=> ''); // your mysql database name

$wwwdir = ""; // the directory where we should drop the ipkg file -- INCLUDE end slash

$os = ""; // options: windows or linux

// DO NOT EDIT BELOW UNLESS YOU KNOW WHAT YOU ARE DOING

switch($os) {
	case 'windows':
		$cp = "xcopy";
		$rm = "del";
		$cpswitch = "/E /Y";
		break;
	case 'linux':
	default:
		$cp = "cp";
		$rm = "rm";
		$cpswitch = "-R";
		break;
}

$conn = mysql_connect($mysql['host'], $mysql['user'], $mysql['pass']);
mysql_select_db($mysql['db']);

$query = mysql_query("SELECT * FROM pkgs WHERE appid='" . $_GET['pkg'] . "'");

$row = mysql_fetch_array($query);

$appinfo = "";
$appinfo .= "{" . "\n";
$appinfo .= '	"' . "id" . '": ' . '"' . $row['appid'] . '",' . "\n";
$appinfo .= '	"' . "version" . '": ' . '"' . $row['ver'] . '",' . "\n";
$appinfo .= '	"' . "vendor" . '": ' . '"' . $row['maintainer'] . '",' . "\n";
$appinfo .= '	"' . "type" . '": ' . '"' . "web" . '",' . "\n";
$appinfo .= '	"' . "main" . '": ' . '"' . "index.html" . '",' . "\n";
$appinfo .= '	"' . "title" . '": ' . '"' . $row['title'] . '",' . "\n";
if ((bool)$row['support'] === TRUE) {
	$supportQ = mysql_query("SELECT * FROM opt WHERE opt='support'");
	$suppInfo = mysql_fetch_array($supportQ);
	$suppInfo = explode(';;;', $suppInfo['val']);
	$appinfo .= '	"support":' . " {\n";
	$appinfo .= '		"url": "' . $suppInfo[0] . '",' . "\n";
	$appinfo .= '		"email": {' . "\n";
	$appinfo .= '			"address": "' . $suppInfo[1] . '",' . "\n";
	$appinfo .= '			"subject": "' . $suppInfo[2] . '"' . "\n";
	$appinfo .= '		},' . "\n";
	$appinfo .= '		"resources": [' . "\n";
	$resourceQ = mysql_query("SELECT * FROM opt WHERE opt='supportResource'");
	$numResource = mysql_num_rows($resourceQ);
	$i = 0;
	while($supportRow = mysql_fetch_array($resourceQ)) {
		$supportRow = explode(';;;', $supportRow['val']);
		$i++;
		$appinfo .= "			{\n";
		$appinfo .= '				"type": "' . $supportRow[0] . '",' . "\n";
		$appinfo .= '				"label": "' . $supportRow[1] . '",' . "\n";
		$appinfo .= '				"url": "' . $supportRow[2] . '",' . "\n";
		$appinfo .= '			}' . (($i < $numResource) ? ',' : '') . "\n"; 
	}
	$appinfo .= "		]\n";
	$appinfo .= "	},\n";
}
$appinfo .= '	"' . "icon" . '": ' . '"' . $row['icon'] . '"' . "\n";
$appinfo .= "}";

$appinfo = str_replace("#{-appName}", $row['title'], $appinfo);

$out = exec($rm . " " . $row['pathto'] . "/*");

$out = exec($cp . " \"" . $row['path'] . (($os == "windows") ? "\*" : "/*") . "\" \"" . $row['pathto'] . (($os == "windows") ? "\\" : "/") . "\" " . $cpswitch);

file_put_contents($row['pathto'] . "/appinfo.json", $appinfo);

$filename = $wwwdir . $row['appid'] . "_" . $row['ver'] . "_" . $row['arch'] . ".ipk";
exec("palm-package -o \"" . $wwwdir . "\" \"" . $row['pathto'] . "/\"");
echo "Created IPKG file...<br />";

exec("palm-install \"" . $filename . "\"");
echo "Installed to emulator...<br />";

exec("palm-launch -d tcp " . $row['appid']);
echo "Launched to emulator<br />";
?>