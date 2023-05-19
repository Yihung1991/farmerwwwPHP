<?php

require __DIR__ . '/parts/connect_db.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
    header('Location: list.php');
    exit;
}

$pdo->query("DELETE FROM `comment` WHERE sid=$sid");
header('Location: list.php');
if (empty($_SERVER['HTTP_REFERER'])) {
    header(`Location: list.php`);
} else {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
