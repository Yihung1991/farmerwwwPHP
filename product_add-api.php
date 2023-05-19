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
$sid = $_POST['sid'] ?? '';
$product_name = $_POST['product_name'] ?? '';
$product_brand = $_POST['product_brand'] ?? '';
$product_category = $_POST['product_category'] ?? '';
$product_state = $_POST['product_state'] ?? '';
$product_price = $_POST['product_price'] ?? '';
$product_publish_date = $_POST['product_publish_date'] ?? '';
$product_end_date = $_POST['product_end_date'] ?? '';
$product_img = $_POST['productimgname'] ?? '';
$product_spec_introduction = $_POST['product_spec_introduction'] ?? '';
$product_introduction = $_POST['product_introduction'] ?? '';




if (!empty($_POST['product_name'])) {
  // TODO: column check
  $isPass = true; // 預設是通過的
  $output['code'] = 100;
  $output['code'] = $sid;
  // 檢查姓名
  if (mb_strlen($product_name, 'utf8') < 2) {
    $output['errors']['product_name'] = '請填寫正確的產品名稱，至少2個以上字元。 ';
    $isPass = true;
    $output['code'] = 200;
  }
}






if ($isPass) {
  $output['code'] = 500;
  $sql = "INSERT INTO `product`(
    `product_id`,
    `product_name`,
    `product_brand`,
    `product_category`,
    `product_state`,
    `product_publish_date`,
    `product_end_date`,
    `product_spec_introduction`,
    `product_price`,
    `product_introduction`,
    `product_img`,
    `product_created_at`,
    `product_update`
)VALUES(
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    NOW(), NOW())";



  $stmt = $pdo->prepare($sql);
  $today = strtotime(date('YmdHis'));
  $product_id = $today;
  $pd = strtotime($product_publish_date); // 轉換為 timestamp
  $product_publish_date = ($pd === false) ? null : date('Y-m-d', $pd);
  $ed = strtotime($product_end_date); // 轉換為 timestamp
  $product_end_date = ($ed === false) ? null : date('Y-m-d', $ed);
  // $product_img = 'e04';


  $stmt->execute([
    $product_id,
    $product_name,
    $product_brand,
    $product_category,
    $product_state,
    $product_publish_date,
    $product_end_date,
    $product_spec_introduction,
    $product_price,
    $product_introduction,
    $product_img,
  ]);
  if ($stmt->rowCount()) {
    $output['success'] = true;
  }
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
