<?php
require __DIR__ . '/parts/connect_db.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
    header('Location: myorder.php');
    exit;
}

$pdo->query("DELETE FROM `order_product` WHERE sid=$sid");

if (empty($_SERVER['HTTP_REFERER'])) {
    header('Location: myorder.php');
} else {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    //               ^ 控一格 固定用法
}
