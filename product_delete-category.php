<?php
// require __DIR__ . '/parts/admin-required.php';
require __DIR__ . '/parts/connect_db.php';
$pageSid = '2';
$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
  header('Location: product_list.php'); // 轉向到列表頁
  exit;
}

$pdo->query("DELETE FROM products_brand_category WHERE sid = $sid");
header('Location: product_list-no-admin.php');

if (empty($_SERVER['HTTP_REFERER'])) {
  header('Location: product_list-brand.php');
} else {
  header('Location: ' . $_SERVER['HTTP_REFERER']);
}
