<?php
require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin-required-for-api.php';

//設定輸出的格式是json
header('Content-Type: application/json');

//設定輸出資料
$output = [
  'success' => false,
  'errors' => [],
  'postData' => $_POST, //除錯用
];

if (empty($_POST)) {
  $output['error']['all'] = '沒有表單資料';
  echo json_encode($output, JSON_UNESCAPED_UNICODE);
  exit;
}
// ??的功用：如果$_POST[] 是undefined，會帶入空字串
$email = $_POST['email'] ?? '';
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$name = $_POST['name'] ?? '';
$nickname = $_POST['nickname'] ?? '';
$mobile = $_POST['mobile'] ?? '';
$add1 = $_POST['add1'] ?? '';
$add2 = $_POST['add2'] ?? '';
$address = $_POST['address'] ?? '';
$birthday = $_POST['birthday'] ?? '';
$member_img = $_POST['memberimgname'] ?? '';






// 後端資料驗證
$isPass = true;

// 驗證name長度不能小於2個字元
if (mb_strlen($name, 'utf8') < 2) {
  $output['errors']['name'] = '請輸入完整姓名';
  $isPass = false;
};

//驗證email格式
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $output['errors']['email'] = '請輸入正確信箱';
  $isPass = false;
}

//驗證生日 (前提是資料庫的生日欄位必須設定成可以是null)
$bt = strtotime($birthday); //將輸入的生日轉換成時間戳，若輸入的格式有誤或沒輸入，會是false
$birthday = $bt === false ? null : date('Y-m-d', $bt); //如果時間戳正確，會轉換成日期格式 



if ($isPass) {
  $sql = "INSERT INTO `members`(`member_email`, `member_password_hash`, `member_name`, `member_nickname`, `member_mobile`, `member_address_1`, `member_address_2`, `member_address_3`, `member_birthday`,`member_img`, `member_publish_date`, `member_update_date`) VALUES (?,?,?,?,?,?,?,?,?,?,NOW(),NOW())";


  $stmt = $pdo->prepare($sql);


  $stmt->execute([
    $email,
    $password,
    $name,
    $nickname,
    $mobile,
    $add1,
    $add2,
    $address,
    $birthday,
    $member_img,
  ]);

  if ($stmt->rowCount()) {
    $output['success'] = true;
  }
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);
