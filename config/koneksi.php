<?php
//KONVERSI PHP KE PHP 7
require_once "parser-php-version.php";

date_default_timezone_set('Asia/Jakarta');
$server = "localhost";
$username = "root";
$password = "";
$database = "db_siakad";

mysql_connect($server, $username, $password);
mysql_select_db($database);

function anti_injection($data)
{
	$filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES))));
	return $filter;
}

function average($arr)
{
	if (!is_array($arr)) return false;
	return array_sum($arr) / count($arr);
}

function cek_session_admin()
{
	$level = $_SESSION[level];
	if ($level != 'superuser' and $level != 'kepala') {
		echo "<script>document.location='index.php';</script>";
	}
}

function cek_session_guru()
{
	$level = $_SESSION[level];
	if ($level != 'guru' and $level != 'superuser' and $level != 'kepala') {
		echo "<script>document.location='index.php';</script>";
	}
}

function cek_session_siswa()
{
	$level = $_SESSION[level];
	if ($level == '') {
		echo "<script>document.location='index.php';</script>";
	}
}
function randomStr($length = 10)
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}
