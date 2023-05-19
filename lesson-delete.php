<?php
require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin-required.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
    header('Location: lesson-list.php'); // 轉向到列表頁
    exit;
}

$pdo->query("DELETE FROM `lesson` WHERE sid=$sid");

if (empty($_SERVER['HTTP_REFERER'])) {
    header('Location: lesson-list.php');
} else {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
