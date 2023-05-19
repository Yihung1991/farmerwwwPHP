<?php

require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin-required-for-api.php';

// header('Content-Type: application/json');
// require __DIR__ . '/parts/admin-required-for-api.php';
// 設定輸出的格式
$output = [
    'success' => false,
    'code' => 0, // 除錯用
    'errors' => [],
    'postData' => $_POST, // 除錯用
];



// 沒有表單資料
if (empty(intval($_POST['sid']))) {
    $output['errors'] = ['sid' => '沒有資料主鍵'];
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
$sid = intval($_POST['sid']);
$lesson_id = $_POST['lesson_id'] ?? '';
$lesson_name = $_POST['lesson_name'] ?? '';
$lesson_category = $_POST['lesson_category_sid'] ?? '';
$lesson_price = $_POST['lesson_price'] ?? '';
$lesson_publish_date = $_POST['lesson_publish_date'] ?? '';
$lesson_end_date = $_POST['lesson_end_date'] ?? '';
$lesson_hours = $_POST['lesson_hours'] ?? '';
$lesson_teacher_sid = $_POST['lesson_teacher_sid'] ?? '';
$lesson_information = $_POST['lesson_information'] ?? '';
$lesson_img = $_POST['memberimgname'] ?? '';
$lesson_uplimit = $_POST['lesson_uplimit'] ?? '';
$lesson_lowerlimit = $_POST['lesson_lowerlimit'] ?? '';
$lesson_onsale = $_POST['lesson_onsale_sid'] ?? '';


$isPass = true; // 預設是通過的
// TODO: 欄位檢查
// 檢查姓名
// if (mb_strlen($name, 'utf8') < 2) {
//   $output['errors']['name'] = '請輸入正確的姓名';
//   $isPass = false;
// }

// // 檢查 email 格式: 有填值才判斷格式
// if (!empty($email) and !filter_var($email, FILTER_VALIDATE_EMAIL)) {
//   $output['errors']['email'] = '格式不合法';
//   $isPass = false;
// }

// $bt = strtotime($birthday); // 轉換為 timestamp
// $birthday = ($bt === false) ? null : date('Y-m-d', $bt);

if ($isPass) {
    $sql = "UPDATE `lesson` SET `lesson_id`=?,`lesson_name`=?,`lesson_category_sid`=?,`lesson_price`=?,`lesson_publish_date`=?,`lesson_end_date`=?,`lesson_hours`=?,`lesson_teacher_sid`=?,`lesson_information`=?,`lesson_img`=?,`lesson_uplimit`=?,`lesson_lowerlimit`=?,`lesson_onsale_sid`=?,`lesson_update_date`=NOW() WHERE `sid`=?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $lesson_id,
        $lesson_name,
        $lesson_category,
        $lesson_price,
        $lesson_publish_date,
        $lesson_end_date,
        $lesson_hours,
        $lesson_teacher_sid,
        $lesson_information,
        $lesson_img,
        $lesson_uplimit,
        $lesson_lowerlimit,
        $lesson_onsale,
        $sid,
    ]);

    if ($stmt->rowCount()) {
        $output['success'] = true;
    } else {
        $output['msg'] = '資料沒有變更';
    }
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);
