<?php
require __DIR__ . '/parts/connect_db.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
    header('Location: myorder.php');
    exit;
}

$pdo->query(" DELETE FROM `order_product_details`   WHERE  order_sid=$sid limit 1");

if (empty($_SERVER['HTTP_REFERER'])) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    //               ^ 控一格 固定用法
}
