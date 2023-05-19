<?php date_default_timezone_set('Asia/Taipei') ?>
<?php

require __DIR__ . '/parts/connect_db.php';
header('Content-Type: application/json');
// 設定輸出的格式
$output = [
    'success' => false,
    'code' => 0, // 除錯用
    'errors' => [],
    'postData' => $_POST, // 除錯用
];

// 沒有表單資料
if (empty(intval($_POST['sid']))) {
    $output['errors'] = ['sid' => '沒有資料主鍵'];
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
//order_product sid

$sid = intval($_POST['sid']);
$coupon_sid = intval($_POST['coupon']) ?? '';
$order_paid = intval($_POST['order_paid']) ?? '';
$order_sended = intval($_POST['order_sended']) ?? '';
$order_refund = intval($_POST['order_refund']) ?? '';
$order_edate = ($today = date("Y-m-d H:i:s")) ?? '';


$isPass = true; // 預設是通過的

if ($isPass) {
    $sql = "UPDATE `order_product` SET
    `coupon_sid`=?,
    `order_paid`=?,
    `order_sended`=?,
    `order_refund`=?,
    `order_edate`=?
    WHERE `sid`=?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $coupon_sid,
        $order_paid,
        $order_sended,
        $order_refund,
        $order_edate,
        $sid,

    ]);

    if ($stmt->rowCount()) {
        $output['success'] = true;
    } else {
        $output['msg'] = '資料沒有變更';
    }
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);
