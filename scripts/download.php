<?php
include("header.php");
require_once('../../ts-yt-dl-defaults/mysql_security.php');
require_once("functions.php");
login_check();
session_start();
$userid = $_SESSION['userid'];
$url = $_POST['url'];
$parm = $_POST['parm'];
$thumbnail = exec("youtube-dl --get-thumbnail $url");
if (!empty($url) && filter_var($url, FILTER_VALIDATE_URL)) {
	// write to file
	//$ip = $_SERVER['REMOTE_ADDR'];
	$timestamp = date('YmdHis');
	if (!mkdir("$ts-yt-dl_data_path/$userid/$timestamp", 0755, true)) {
	    die('Failed to create folders...');
	}
	//file_put_contents("/srv/ts-yt-dl/tmp/$timestamp.ts", "_USERID=\"$userid\"\n_TSCALL=\"$parm $url\"\n_REMOTEADDR=\"$ip\"");
	exec("nohup youtube-dl -o $ts-yt-dl_data_path/$userid/$timestamp $parm $url > /dev/null 2>&1 &");
	echo "<body>
	<div id=\"content\">
	<img class=\"thumbnail\" src=\"$thumbnail\">
	</div>";
} else {
	header("Location: ./index.php?error=no_url");
}
include('footer.php');
?>
