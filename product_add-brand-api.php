<?php

require __DIR__ . '/parts/connect_db.php';
$pageSid = '2';
header('Content-Type: application/json');

// 送至前端 obj  
$output = [
  'success' => false,
  'code' => 0,
  'errors' => [],
  'postData' => $_POST, // for debug
];
// TODO: column check 沒有表單資料
if (empty($_POST)) {
  $output['errors'] = ['all' => '沒有表單資料'];
  echo json_encode($output, JSON_UNESCAPED_UNICODE);
  exit;
}

$nid = $_POST['nid'] ?? '';
$name = $_POST['name'] ?? '';


if (!empty($_POST['name'])) {
  // TODO: column check
  $isPass = true; // 預設是通過的
  $output['code'] = 100;
  // 檢查姓名
  if (mb_strlen($name, 'utf8') < 2) {
    $output['errors']['name'] = '請填寫正確的產品名稱，至少2個以上字元。 ';
    $isPass = true;
    $output['code'] = 200;
  }
}



if ($isPass) {
  $output['code'] = 500;
  $sql = "INSERT INTO `products_brand_category`(`nid`,`name`)VALUES(?,?)";

  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    $nid,
    $name,
  ]);
  if ($stmt->rowCount()) {
    $output['success'] = true;
  }
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
