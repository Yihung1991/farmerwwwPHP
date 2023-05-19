<?php require __DIR__ . '/parts/connect_db.php';


header('Content-Type: application/json');

//設定輸出資料
$output = [
  'success' => false,
  'errors' => '',
  'postData' => $_POST,
];

if(empty($_POST['account'] or $_POST['password'])){
  $output['error'] = '資料不足';
  echo json_encode($output, JSON_UNESCAPED_UNICODE);
  exit;
}

// 取得資料
$sql = "SELECT * FROM `admins` WHERE `account`=?";

$stmt = $pdo -> prepare($sql);

$stmt -> execute([
  $_POST['account']
]);

//驗證帳號
$r = $stmt->fetch();
if(empty($r)){
  $output['error'] = '帳號或密碼錯誤';
  echo json_encode($output, JSON_UNESCAPED_UNICODE);
  exit;
}

//驗證密碼
$hash = $r['password_hash'];
$output['success'] = password_verify($_POST['password'],$hash);

if($output['success']){
  $_SESSION['admin'] = [
    'account' => $r['account']
  ];
}else{
  $output['error'] = '帳號或密碼錯誤';
  echo json_encode($output, JSON_UNESCAPED_UNICODE);
  exit;
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);
