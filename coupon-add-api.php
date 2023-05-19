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


$a = htmlspecialchars($_POST['a'], ENT_QUOTES) ?? '';
$b = htmlspecialchars($_POST['b'], ENT_QUOTES) ?? '';
$cate = htmlspecialchars($_POST['cate'], ENT_QUOTES) ?? '';
$quota = htmlspecialchars($_POST['quota'], ENT_QUOTES) ?? '';
$expiry = htmlspecialchars($_POST['expiry'], ENT_QUOTES) ?? '';
$description = htmlspecialchars($_POST['description'], ENT_QUOTES) ?? '';
$minimum = htmlspecialchars($_POST['minimum'], ENT_QUOTES) ?? '';
$status = htmlspecialchars($_POST['status'], ENT_QUOTES) ?? '';
$coupon_img = $_POST['couponimgname'] ?? '';




// 沒有表單資料
if (empty($_POST)) {
  $output['errors'] = ['all' => '沒有優惠卷資料'];
  echo json_encode($output, JSON_UNESCAPED_UNICODE);
  exit;
}



$isPass = true; // 預設是通過的

if (mb_strlen($a, 'utf8') > 20) {
  $output['errors']['name'] = '長度超過20字';
  $isPass = false;
}

if (mb_strlen($b, 'utf8') > 20) {
  $output['errors']['name'] = '長度超過20字';
  $isPass = false;
}


if ($isPass) {
  $sql = "INSERT INTO `coupon` (
    `coupon_name`,`coupon_keywords`,`coupon_category`,
    `coupon_quota`,`coupon_expiry`,`coupon_discription`,
    `coupon_minimum`,`coupon_status`,`coupon_img`
    ) VALUES (
      ?, ?, ?,
      ?, ?, ?,
      ?, ?, ?
    )";

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

  ]);

  if ($stmt->rowCount()) {
    $output['success'] = true;
  }
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
