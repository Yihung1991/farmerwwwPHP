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

if (empty(intval($_POST['sid']))) {
  $output['errors']['all'] = '沒有sid';
  echo json_encode($output, JSON_UNESCAPED_UNICODE);
  exit;
}

$sid = intval($_POST['sid']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$sql = "SELECT * FROM `members` WHERE `sid`=$sid";
$r = $pdo->query($sql)->fetch();  //取得指定sid的資料，是陣列



//驗證舊密碼
$hash = $r['member_password_hash'];
$output['success'] = password_verify($_POST['oldpsw'], $hash);

if ($output['success']) {
  $sql = "UPDATE `members` SET `member_password_hash`=?,`member_update_date`=NOW() WHERE `sid`=?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    $password,
    $sid,
  ]);
} else {
  $output['errors']['oldpsw'] = '舊密碼錯誤';
  echo json_encode($output, JSON_UNESCAPED_UNICODE);
  exit;
}

if ($stmt->rowCount()) {
  $output['success'] = true;
} else {
  $output['msg'] = '資料沒有變更';
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);
