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


$certainMember = $_POST['certainMember'] ?? '';
$coupon_sid = $_POST['coupon_sid'] ?? '';
$sDate = $_POST['sDate'] ?? '';
$eDate = $_POST['eDate'] ?? '';
$coupon_used = $_POST['coupon_used'] ?? '';
$order_category = $_POST['order_category'] ?? '';



// 沒有表單資料
if (empty($_POST)) {
  $output['errors'] = ['all' => '沒有優惠卷資料'];
  echo json_encode($output, JSON_UNESCAPED_UNICODE);
  exit;
}



$isPass = true; // 預設是通過的

if ($isPass) {
  $sql = "INSERT INTO `coupon_details` (
    `member_sid`,`coupon_sid`,`coupon_sdate`,
    `coupon_edate`,`coupon_used`,`order_category`
    ) VALUES (
      ?, ?, ?,
      ?, ?, ?
    )";

  $stmt = $pdo->prepare($sql);

  $stmt->execute([
    $certainMember,
    $coupon_sid,
    $sDate,
    $eDate,
    $coupon_used,
    $order_category
  ]);

  if ($stmt->rowCount()) {
    $output['success'] = true;
  }
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
