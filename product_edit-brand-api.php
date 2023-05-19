<?php

require __DIR__ . '/parts/connect_db.php';

header('Content-Type: application/json');

// 送至前端 obj  
$output = [
  'success' => false,
  'code' => 0,
  'errors' => [],
  'postData' => $_POST, // for debug
];
// TODO: column check 沒有表單資料
if (empty(intval($_POST['sid']))) {
  $output['errors'] = ['sid' => '沒有表單資料'];
  echo json_encode($output, JSON_UNESCAPED_UNICODE);
  exit;
}
$sid = intval($_POST['sid']);
$nid = $_POST['nid'] ?? '';
$name = $_POST['name'] ?? '';




if (!empty($_POST['name'])) {
  // TODO: column check
  $isPass = true; // 預設是通過的
  $output['code'] = 100;
  $output['預設通過'] = true;
  // 檢查姓名
  if (mb_strlen($name, 'utf8') < 2) {
    $output['errors']['name'] = '請填寫正確的產品名稱 ';
    $isPass = true;
    $output['code'] = 200;
  }
}




if ($isPass) {
  $sql = "UPDATE `products_brand_category` SET
  `nid`=?,
  `name`=?
  WHERE `products_brand_category`.`sid`= ?";



$stmt = $pdo->prepare($sql);
  $stmt->execute([
    $nid,
    $name,
    $sid,
  ]);
  if ($stmt->rowCount()) {
    $output['success'] = true;
    $output['code'] = 100;
  } else {
    $output['msg'] = '資料沒有變更';
  }
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
