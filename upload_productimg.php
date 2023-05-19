<?php
require __DIR__ . '/parts/admin-required-for-api.php';

# 用 postman 測試

header('Content-Type: application/json');
$fieldName = 'productimg';

# 用來篩選上傳檔案及作為副檔名
$extMap = [
  'image/jpeg' => '.jpg',
  'image/png' => '.png',
];


$success = false;
$filename = '';

if (!empty($_FILES[$fieldName]) and $_FILES[$fieldName]['error'] === 0) {

  # 如果檔案類型錯誤，就結束
  if (empty($extMap[$_FILES[$fieldName]['type']])) {
    echo json_encode([
      'success' => false,
      'error' => '檔案類型錯誤'
    ]);
    exit;
  }

  # 副檔名
  $ext = $extMap[$_FILES[$fieldName]['type']];
  # 隨機檔名
  $filename = sha1(uniqid() . rand()) . $ext;



  $success = move_uploaded_file(
    $_FILES[$fieldName]['tmp_name'],
    __DIR__ . './imgupload/product/' . $filename
  );
}

echo json_encode([
  'success' => $success,
  'filename' => $filename,
  'files' => $_FILES
]);
