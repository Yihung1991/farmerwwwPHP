<?php

require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin-required-for-api.php';
//$output是自訂輸出的格式
$output = [
    'success' => false, //如果有新增成功會回傳true
    'code' => 0, //可以再檢查的時候塞入進去,0可以設成其他數字
    'errors' => [], //放錯誤的陣列
    'postData' => $_POST, //除錯用

];

$pageSid = '7';

$lesson_sid = $_POST['lesson_sid'] ?? NULL;
$product_sid = $_POST['product_sid'] ?? NULL;
//TODO:欄位檢查

// if (!empty($_POST['member_sid'])) {

$sql = "INSERT INTO `comment`(`member_sid`,`all_category_sid`,`lesson_sid`,`product_sid`,`comment_value`,`comment_content`,`comment_publish_date`) VALUES (?,?,?,?,?,?,NOW())";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $_POST['member_sid'],
    $_POST['all_category_sid'],
    $_POST['lesson_sid'],
    $_POST['product_sid'],
    $_POST['comment_value'],
    $_POST['comment_content']
]);

if ($stmt->rowCount()) {
    $output['success'] = true;
}
// }

echo json_encode($output, JSON_UNESCAPED_UNICODE);
