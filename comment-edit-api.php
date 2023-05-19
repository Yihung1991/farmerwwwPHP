<?php
require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin-required-for-api.php';
header('Content-Type: application/json');
// 設定輸出的格式
$output = [
    'success' => false,
    'code' => 0, // 除錯用
    'errors' => [],
    'postData' => $_POST, // 除錯用
];

//沒有表單資料
if (empty($_POST)) {
    $output['errors'] = ['all' => '沒有表單資料'];
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
$sid = intval($_POST['sid']);
$comment_value = $_POST['comment_value'] ?? '';
$comment_content = $_POST['comment_content'] ?? '';

$isPass = true; // 預設是通過的
// TODO: 欄位檢查


$sql = "UPDATE `comment` SET `comment_value`=?,`comment_content`=?,`comment_update_date`= NOW() WHERE `sid`=?";

$stmt = $pdo->prepare($sql);

$stmt->execute([

    $comment_value,
    $comment_content,
    $sid
]);

if ($stmt->rowCount()) {
    $output['success'] = true;
}



echo json_encode($output, JSON_UNESCAPED_UNICODE);
