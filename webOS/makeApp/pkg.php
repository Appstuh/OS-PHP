<?php
/*
	Copyright:	Appstuh 2010. Some rights reserved.
	License:	AGPLv3
	Purpose:	Generate IPKG feed compatible with Preware and webOS Quick Install for webOS developers' internal testing systems
					so that the dev no longer has to use USB to connect to the device (if using Preware)
	Warranty:	No warranty is provided. Nothing. Nada. Zip. Zilch. Nothing.
	Cost:		Nothing. Though if you find this helps you out, we wouldn't mind a nice donation. Contact us if you wish to donate
*/


// CONFIGURE BELOW:

$mysql = array(
	'host'	=> '127.0.0.1', // your database host
	'user'	=> '', // your mysql username
	'pass'	=> '', // your mysql password
	'db'	=> ''); // your mysql database name

$feedname = "My webOS development feed"; // options: The name that will show up in Preware or webOS Quick Install

// DO NOT EDIT BELOW UNLESS YOU KNOW WHAT YOU ARE DOING

$conn = mysql_connect($mysql['host'], $mysql['user'], $mysql['pass']);
mysql_select_db($mysql['db']);

$query = mysql_query("SELECT * FROM pkgs");

$text = "";

while ($row = mysql_fetch_array($query)) {
	$filename = $row['appid'] . "_" . $row['ver'] . "_" . $row['arch'] . ".ipk";
	$text .= "Package: " . $row['appid'] . "\n";
	$text .= "Version: " .  $row['ver'] . "\n";
	$text .= "Section: " .  $row['section'] . "\n";
	$text .= "Architecture: " .  $row['arch'] . "\n";
	$text .= "Maintainer: " .  $row['maintainer'] . "\n";
	$text .= "Size: " .  filesize($filename) . "\n";
	$text .= "Source: { \"LastUpdated\":\"" . time() . "\", \"Title\": \"" . $row['title'] . "\", \"FullDescription\": \"" . $row['desc'] . "\", \"Type\":\"Application\", \"Category\":\"" .  $row['section'] . "\", \"Feed\": \"" . $feedname . "\" }\n";
	$text .= "Filename: " .  $filename . "\n";
	$text .= "Description: " .  $row['title'] . "\n";
	$text .= "\n\n";
}

file_put_contents("./Packages", $text);
mysql_close($conn);
?>