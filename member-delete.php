<?php
require __DIR__ . '/parts/admin-required.php';

require __DIR__ . '/parts/connect_db.php';

//檢查GET參數sid是否有設定
$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

//如果是空字串，轉回列表頁
if (empty($sid)) {
  header('Location: member-list.php');
  exit;
};

$sql = "DELETE FROM `members` WHERE `sid`=$sid";

$pdo->query($sql);

if (isset($_SERVER['HTTP_REFERER'])) {
  header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
  header('Location: member-list.php');
};
