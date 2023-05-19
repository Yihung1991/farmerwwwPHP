<?php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = 'admin1'; //XAMPP沒有密碼
$db_name = 'farmerwww2';


$dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8";
$pdo_opptions = [
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]; //將PDO的FETCH()預設為關聯式陣列


$pdo = new PDO($dsn, $db_user, $db_pass, $pdo_opptions);

//啟動SESSION(登入用的)
if (!isset($_SESSION)) {
  session_start();
}
