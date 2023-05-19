<?php
require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin-required.php';


$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
  header('Location: coupon-list.php'); // 轉向到列表頁
  exit;
}

$pdo->query("DELETE FROM `coupon` WHERE sid=$sid");

if (empty($_SERVER['HTTP_REFERER'])) {
  header('Location: coupon-list.php');
} else {
  header('Location: ' . $_SERVER['HTTP_REFERER']);
}
