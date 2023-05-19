<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<?php
require __DIR__ . '/parts/connect_db.php';
$pageSid = '4';
$pageName = 'myorder_members';
$title = '訂單編輯';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
    header('Location: myorder.php'); // 轉向到列表頁
    exit;
}

//order_product sid

$tlsql = "SELECT 
`order_product_sid`, 
order_product.member_sid , 
members.sid, 
members.member_name, 
coupon.sid, 
coupon.coupon_name,
 order_paid.sid, 
 order_paid.order_paid, 
 order_sended.sid, 
 order_sended.order_sended , 
 order_refund.sid, 
 order_refund.order_refund, 
 `order_product`.`order_sdate`, 
 `order_product`.`order_edate` 
 FROM `order_product` 
 LEFT JOIN members on order_product.member_sid = members.sid 
 LEFT JOIN coupon on order_product.coupon_sid = coupon.sid 
 LEFT JOIN order_paid on order_product.order_paid = order_paid.sid 
 LEFT JOIN order_sended on order_product.order_sended = order_sended.sid 
 LEFT JOIN order_refund on order_product.order_refund = order_refund.sid 
 WHERE order_product_sid=$sid";
$totalr = $pdo->query($tlsql)->fetch();
if (empty($totalr)) {
    header('Location: myorder.php'); // 轉向到列表頁
    exit;
}

$mpt_sql = "SELECT 
    `order_product_sid`, 
    order_product.member_sid , 
    members.sid, 
    members.member_name,
    members.member_mobile,
    members.member_address_1,
    members.member_address_2,
    members.member_address_3,
    coupon.sid, 
    coupon.coupon_name,
     order_paid.sid, 
     order_paid.order_paid, 
     order_sended.sid, 
     order_sended.order_sended , 
     order_refund.sid, 
     order_refund.order_refund, 
     `order_product`.`order_sdate`, 
     `order_product`.`order_edate` 
     FROM `order_product` 
     LEFT JOIN members on order_product.member_sid = members.sid 
     LEFT JOIN coupon on order_product.coupon_sid = coupon.sid 
     LEFT JOIN order_paid on order_product.order_paid = order_paid.sid 
     LEFT JOIN order_sended on order_product.order_sended = order_sended.sid 
     LEFT JOIN order_refund on order_product.order_refund = order_refund.sid
     WHERE order_product_sid=$sid";
$mptotalr = $pdo->query($mpt_sql)->fetch();
if (empty($mptotalr)) {
    header('Location: myorder.php'); // 轉向到列表頁
    exit;
}

$coupon_sql = "SELECT coupon.* FROM `coupon` WHERE 1";
$coupon = $pdo->query($coupon_sql)->fetch();
if (empty($coupon)) {
    header('Location: myorder.php'); // 轉向到列表頁
    exit;
}


$price_sql = "SELECT 
product.product_img,
order_product_details.sid,
order_product_details.order_sid,
members.sid,
members.member_name,
order_product_details.product_sid,
product.product_name,
products_brand_category2.name,
product_category.sid,
product_category.product_category,
product.product_price,order_product_details.product_quantity,product.product_price * order_product_details.product_quantity as totalprice

FROM `order_product_details`
LEFT JOIN order_product ON order_product.sid = order_product_details.order_sid
LEFT JOIN members ON members.sid = order_product.member_sid
LEFT JOIN product ON order_product_details.product_sid = product.sid
LEFT JOIN products_brand_category2 ON product.product_brand = products_brand_category2.sid
LEFT JOIN product_category ON product.product_category = products_brand_category2.sid
WHERE order_product_details.order_sid=$sid;
";
$price = $pdo->query($price_sql)->fetch();
if (empty($price)) {
    header('Location: myorder.php'); // 轉向到列表頁
    exit;
}

$pay_sql = "SELECT *
FROM 
`order_paid` 
JOIN order_sended
JOIN order_refund
WHERE 1";
$pay = $pdo->query($pay_sql)->fetch();

$refund_sql = "SELECT *
FROM 
`order_refund` 
WHERE 1";
$refund = $pdo->query($refund_sql)->fetch();




// $order_sid = isset($_GET['order_product_sid']) ? intval($_GET['order_product_sid']) : 0;
// if (empty($order_sid)) {
//     header('Location: myorder.php'); // 轉向到列表頁
//     exit;
// }

$t_unpaid_perPage = 15; // 每一頁最多有幾筆
$t_unpaid_page = isset($_GETt_unpaid_['page']) ? intval($_GETt_unpaid_['page']) : 1;
if ($t_unpaid_page < 1) {
    header('Location: ?page=1');
    exit;
}

$t_unpaid = "SELECT  COUNT(*) FROM `order_product`;";
$t_unpaid_totalRows = $pdo->query($t_unpaid)->fetch(PDO::FETCH_NUM)[0];
$t_unpaid_totalPages = ceil($t_unpaid_totalRows / $t_unpaid_perPage);

$members_shop = []; // 資料
if ($t_unpaid_totalRows > 0) {
    if ($t_unpaid_page > $t_unpaid_totalPages) {
        header('Location: ?page=' . $t_unpaid_totalPages);
        exit;
    }
    $msl =
        ("SELECT 
    product.product_img,
    order_product_details.sid,
    order_product_details.order_sid,
    members.sid,
    members.member_name,
    order_product_details.product_sid,
    product.product_name,
    products_brand_category2.name,
    product_category.sid,
    product_category.product_category,
    product.product_price,order_product_details.product_quantity,product.product_price * order_product_details.product_quantity as totalprice
    
    FROM `order_product_details`
    LEFT JOIN order_product ON order_product.sid = order_product_details.order_sid
    LEFT JOIN members ON members.sid = order_product.member_sid
    LEFT JOIN product ON order_product_details.product_sid = product.sid
    LEFT JOIN products_brand_category2 ON product.product_brand = products_brand_category2.sid
    LEFT JOIN product_category ON product.product_category = product_category.sid
    WHERE order_product_details.order_sid=$sid;");
    $members_shop = $pdo->query($msl)->fetchAll();
};

?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<?php date_default_timezone_set('Asia/Taipei') ?>
<?php include __DIR__ . '/parts/navbar.php' ?>
<?php include __DIR__ . '/parts/sidebars.php' ?>


<div class="container w-75">
    <div class="row">
        <div style="width: 100vw" class="flex-wrap d-flex justify-content-center">
            <div>
                <div style="width:80vw">
                    <form name="form1" onsubmit="checkForm(event)" novalidate>
                        <div class="m-1 d-flex justify-content-between align-items-center">
                            <h2 class="m-3">訂單編號:#<?= htmlentities($totalr['order_product_sid']) ?>詳細資料
                            </h2>
                            <div>
                                <div class="alert alert-primary" role="alert" id="editAlert" style="display: none;"></div>
                                <button type="submit" class="btn btn-primary">更新資料</button>
                                <input type="button" class="btn btn-secondary" onclick="location='myorder.php'" value="返回上一頁"></input>
                                <div class="alert alert-primary" role="alert" id="editAlert" style="display: none;"></div>
                            </div>
                        </div>
                        <input type="hidden" name="sid" value="<?= $totalr['order_product_sid'] ?>">
                        <input type="hidden" name="order_edate" value="<?= $totalr['order_edate'] ?>">
                        <div class=" justify-content-center flex-row-reverse align-items-center" style="width: 100%; height: 200px;">
                            <div class=" gap-2 d-flex justify-content-between" style="width: auto; height: auto;">
                                <div class="card mb-1 gap-2 " style="width: 30%; height: 200px">
                                    <div id="order_menber_data" class="card-header">
                                        收件人資料
                                    </div>
                                    <div class="card-body gap-5">
                                        <div class="d-flex gap-1">
                                            <p class="card-title">訂購人: 會員<?= htmlentities($mptotalr['member_sid']) ?> <?= htmlentities($mptotalr['member_name']) ?></p>

                                        </div>
                                        <div class="d-flex gap-1">
                                            <p class="card-title">送貨地點:</p>
                                        </div>
                                        <div>
                                            <P><input id="address" type="text" class="form-control" value="<?= $mptotalr['member_address_1'] ?>-<?= $mptotalr['member_address_2'] ?>-<?= $mptotalr['member_address_3'] ?>" style="width:320px" id="myorder_address1" name="address" required></P>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-4" style="width: 30% ; height: 200px">
                                    <div id="order_menber_data" class="card-header">
                                        訂單成立與異動
                                    </div>
                                    <div class="card-body gap-5">
                                        <div class="d-flex gap-1 mt-1">
                                            <p class="card-title">訂單成立日期: <?= htmlentities($mptotalr['order_sdate']) ?></p>
                                        </div>

                                        <div class="d-flex gap-1">
                                            <p class="card-title">訂單異動日期: <?= $today = date("Y-m-d H:i:s") ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-4" style="width: 22%;">
                                    <div id="order_menber_data" class="card-header">
                                        訂單價格結算
                                    </div>
                                    <div class="card-body  gap-5">
                                        <div class="d-flex gap-1">
                                            <p class="card-title">適用優惠券:</p>
                                            <p class="card-text">
                                            <div id="item">
                                                <select id="coupon" name="coupon" style="cursor:pointer;" class="selectpicker ml-1 mb-2" data-width="150px" ()">
                                                    <option value="<?= $coupon['sid'] ?>"><?= $mptotalr['coupon_name'] ?></option>
                                                    <option value=""></option>
                                                    <option value="0">註冊禮</option>
                                                    <option value="2">春季優惠券</option>
                                                    <option value="5">萬聖大放送</option>
                                                    <option value="4">春節大放送</option>
                                                    <option value="6">蘋果季</option>
                                                    <option value="8">生日禮</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-1">
                                            <p class="card-title">訂單總價: <?= $price['totalprice'] ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-2" style="width: 20% ; height: 200px">
                                    <div id="order_menber_data" class="card-header">
                                        訂單狀態
                                    </div>
                                    <div class="d-flex flex-wrap m-3 align-items-center">
                                        <div class="d-flex gap-1">
                                            <p class="card-title">運送狀態:
                                            <div id="item">
                                                <select id="order_paid" name="order_paid" style="cursor:pointer;" class="selectpicker ml-1 mb-2" data-width="150px" ">
                                        <option value=" <?= $totalr['order_paid'] ?>"><?= $totalr['order_paid'] ?></option>
                                                    <option value=""></option>
                                                    <option value="0">已付款</option>
                                                    <option value="1">未付款</option>
                                                    <option value="2">已取消</option>
                                                </select>
                                            </div>
                                            </p>
                                        </div>



                                        <div class="d-flex gap-1">
                                            <p class="card-title">運送狀態:
                                            <div id="item">
                                                <select id="order_sended" name="order_sended" style="cursor:pointer;" class="selectpicker ml-1 mb-2" data-width="150px" ">
                                        <option value=" <?= $totalr['order_sended'] ?>"><?= $totalr['order_sended'] ?></option>
                                                    <option value=""></option>
                                                    <option value="0">已送達</option>
                                                    <option value="1">退貨中</option>
                                                    <option value="2">配送中</option>
                                                    <option value="3">未出貨</option>
                                                </select>
                                            </div>
                                            </p>
                                        </div>

                                        <div class="d-flex gap-1">
                                            <p class="card-title">退款狀態:</p>
                                            <div id="item">
                                                <select id="order_refund" name="order_refund" style="cursor:pointer;" class="selectpicker ml-1 mb-2" data-width="150px"">
                                        <option value=" <?= $totalr['order_refund'] ?>"><?= $totalr['order_refund'] ?></option>
                                                    <option value=""></option>
                                                    <option value="0">申訴處理中</option>
                                                    <option value="1">退款完成</option>
                                                    <option value="2">退款取消</option>
                                                    <option value="3">不需退款</option>
                                                    <option value="4">案件審核中</option>


                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="card">
                        <div id="order_prodata_data" class="card-header">
                            訂購商品清單
                        </div>
                        <div class="card-product">
                            <table class="table table-striped table-bordered text-center">
                                <table class="table table-striped text-center table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">
                                                <span class="material-symbols-outlined">
                                                    delete
                                                </span>
                                            </th>
                                            <th scope="col">訂單編號</th>
                                            <th scope="col">產品編號</th>
                                            <th scope="col">產品名稱</th>
                                            <th scope="col">品牌</th>
                                            <th scope="col">分類</th>
                                            <th scope="col">單價</th>
                                            <th scope="col">數量</th>
                                            <th scope="col">小記</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($members_shop as $ms) : ?>
                                            <tr>
                                                <td>
                                                    <a href="javascript: delete_it(<?= $ms['order_sid'] ?>)">
                                                        <!-- 給予一個假連結 -->
                                                        <i class="fa-solid fa-trash-can"></i>
                                                        <span class="material-symbols-outlined">
                                                            delete
                                                        </span>
                                                    </a>
                                                </td>
                                                <td><?= $ms['order_sid'] ?></td>
                                                <td><?= $ms['product_sid'] ?></td>
                                                <td><?= $ms['product_name'] ?></td>
                                                <td><?= $ms['name'] ?></td>
                                                <td><?= $ms['product_category'] ?></td>
                                                <td><?= $ms['product_price'] ?></td>
                                                <td class="d-flex justify-content-center"><input type="text" class="form-control" value="<?= $ms['product_quantity'] ?>" style="width:50px" id="quantity" name="quantity" required></td>
                                                <td><?= $ms['product_quantity'] * $ms['product_price'] ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/parts/scripts.php' ?>
    <script>
        let isPass = true;

        function delete_it(order_sid) {
            if (confirm(`訂單中的這項產品要被你刪掉囉! 確定?`)) {
                location.href = 'myorder_list_delete.php?sid=' + order_sid;
            }
        }

        const checkForm = function(event) {
            event.preventDefault();

            const fd = new FormData(document.form1);
            fetch('myorder_list_edit_api.php', {
                method: 'POST',
                body: fd,
            }).then(r => r.json()).then(obj => {
                console.log(obj);
                if (obj.success) {
                    alert("修改成功");
                    window.location.reload();
                    // 跳轉到列表頁
                }
            })
        }
    </script>
    <?php include __DIR__ . '/parts/html-foot.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>