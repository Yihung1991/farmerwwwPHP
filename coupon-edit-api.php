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



$a = $_POST['a'] ?? '';
$b = $_POST['b'] ?? '';
$cate = $_POST['cate'] ?? '';
$quota = $_POST['quota'] ?? '';
$expiry = $_POST['expiry'] ?? '';
$description = $_POST['description'] ?? '';
$minimum = $_POST['minimum'] ?? '';
$status = $_POST['status'] ?? '';
$coupon_img = $_POST['couponimgname'] ?? '';
$sid = intval($_POST['sid']);






// 沒有表單資料
if (empty($_POST)) {
  $output['errors'] = ['all' => '沒有優惠卷資料'];
  echo json_encode($output, JSON_UNESCAPED_UNICODE);
  exit;
}



$isPass = true; // 預設是通過的

if ($isPass) {
  $sql = "UPDATE `coupon` SET `coupon_name`=?,`coupon_keywords`=?,`coupon_category`=?,`coupon_quota`=?,`coupon_expiry`=?,`coupon_discription`=?,`coupon_minimum`=?,`coupon_status`=?,`coupon_img`=?,`coupon_created_at`=NOW(),`coupon_update_date`=NOW() WHERE `sid`=?";

  $stmt = $pdo->prepare($sql);

  $stmt->execute([
    $a,
    $b,
    $cate,
    $quota,
    $expiry,
    $description,
    $minimum,
    $status,
    $coupon_img,
    $sid
  ]);

  if ($stmt->rowCount()) {
    $output['success'] = true;
  }
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
