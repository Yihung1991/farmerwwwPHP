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
//order_product sid

$member_sid = intval($_POST['member_sid']) ?? '';
$coupon_sid = intval($_POST['coupon']) ?? '';
$order_paid = intval($_POST['order_paid']) ?? '';
$order_sended = intval($_POST['order_sended']) ?? '';
$order_refund = intval($_POST['order_refund']) ?? '';
// $order_sdate = ($today = date("Y-m-d H:i:s")) ?? '';


$isPass = true; // 預設是通過的


if ($isPass) {
    $sql = "INSERT INTO `order_product`(`member_sid`,`coupon_sid`,`order_paid`,`order_sended`, `order_refund`,`order_sdate`) VALUES (?,?,?,?,?,NOW())";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([        
        $member_sid,
        $coupon_sid,
        $order_paid,
        $order_sended,
        $order_refund,     

    ]);

    if ($stmt->rowCount()) {
        $output['success'] = true;
    } else {
        $output['msg'] = '資料沒有變更';
    }
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);
