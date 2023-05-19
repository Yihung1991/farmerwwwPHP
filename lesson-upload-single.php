<?php
# 用 postman 測試
header('Content-Type: application/json');
$fieldName = 'avatar';

$extMap = [
  'image/png' => '.png',
  'image/jpeg' => '.jpg',
];

$success = false;
$filename = '';
if (!empty($_FILES[$fieldName]) and $_FILES[$fieldName]['error'] === 0) {

  // 如果類型不對, 就直接結束
  if (empty($extMap[$_FILES[$fieldName]['type']])) {
    echo json_encode([
      'success' => false,
      'error' => '檔案類型錯誤'
    ]);
    exit;
  }

  $ext = $extMap[$_FILES[$fieldName]['type']];
  $filename = sha1(uniqid() . rand()) . $ext;  // 隨機的檔名



  $success = move_uploaded_file(
    $_FILES[$fieldName]['tmp_name'],
    __DIR__ . './imgupload/lesson/' . $filename
  );
}

echo json_encode([
  'success' => $success,
  'filename' => $filename,
  'files' => $_FILES
]);
