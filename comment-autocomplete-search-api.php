<?php

require __DIR__ . '/parts/connect_db.php';

$output = [];

if (empty($_GET)) {
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

if(!empty($_GET['search_term'])){
    $search_term = $_GET['search_term'];
    
    $sql = "SELECT `sid`, `member_name`, `member_nickname` FROM `members` where member_name LIKE \"%$search_term%\"";

    $output = $pdo->query($sql)->fetchAll();

}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
