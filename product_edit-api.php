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
$product_name = $_POST['product_name'] ?? '';
$product_brand = $_POST['product_brand'] ?? '';
$product_category = $_POST['product_category'] ?? '';
$product_price = $_POST['product_price'] ?? '';
$product_publish_date = $_POST['product_publish_date'] ?? '';
$product_end_date = $_POST['product_end_date'] ?? '';
$product_img = $_POST['productimgname'] ?? '';
$product_state = $_POST['product_state'] ?? '';
$product_spec_introduction = $_POST['product_spec_introduction'] ?? '';
$product_introduction = $_POST['product_introduction'] ?? '';
$product_update = $_POST['product_update'] ?? '';




if (!empty($_POST['product_name'])) {
  // TODO: column check
  $isPass = true; // 預設是通過的
  $output['code'] = 100;
  $output['預設通過'] = true;
  // 檢查姓名
  if (mb_strlen($product_name, 'utf8') < 2) {
    $output['errors']['product_name'] = '請填寫正確的產品名稱 ';
    $isPass = true;
    $output['code'] = 200;
  }
}



if ($isPass) {


  $sql = "UPDATE `product`SET`product_name`=?,`product_brand`=?,`product_category`=?,`product_publish_date`=?,`product_end_date`=?,`product_spec_introduction`=?,`product_price`=?,
`product_introduction`=?,`product_state`=?,`product_img`=?,`product_update`=now()WHERE `sid`= ?";


  $pd = strtotime($product_publish_date); // 轉換為 timestamp
  $product_publish_date = ($pd === false) ? null : date('Y-m-d', $pd);
  $ed = strtotime($product_end_date); // 轉換為 timestamp
  $product_end_date = ($ed === false) ? null : date('Y-m-d', $ed);
  // $ud = strtotime($product_update); // 轉換為 timetasmp
  // $product_update = ($ud === false) ? null : date('Y-m-d', $ud);

  $stmt = $pdo->prepare($sql);

  $stmt->execute([
    $product_name,
    $product_brand,
    $product_category,
    $product_publish_date,
    $product_end_date,
    $product_spec_introduction,
    $product_price,
    $product_introduction,
    $product_state,
    $product_img,
    $sid
  ]);
  if ($stmt->rowCount()) {
    $output['success'] = true;
    $output['code'] = 100;
  } else {
    $output['msg'] = '資料沒有變更';
  }
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
