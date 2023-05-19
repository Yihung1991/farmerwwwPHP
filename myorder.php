<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<?php
require __DIR__ . '/parts/connect_db.php';
$pageName = 'myorder';
$title = '所有訂單';
$pageSid = '4';

$perPage = 8; // 每一頁最多有幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header('Location: ?page=1');
    exit;
}

$t_sql = "SELECT COUNT(1) FROM order_product";
// 取得總筆數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
// 總頁數
$totalPages = ceil($totalRows / $perPage);

$rows = []; // 資料
if ($totalRows > 0) {
    if ($page > $totalPages) {
        header('Location: ?page=' . $totalPages);
        exit;
    }

    $sql = sprintf("SELECT 
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
     ORDER BY `order_sdate` 
     DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
    $rows = $pdo->query($sql)->fetchAll();
}

////////未出貨篩選/////////
$t_unpaid_perPage = 8; // 每一頁最多有幾筆
$t_unpaid_page = isset($_GETt_unpaid_['page']) ? intval($_GETt_unpaid_['page']) : 1;
if ($t_unpaid_page < 1) {
    header('Location: ?page=1');
    exit;
}

$t_unpaid = "SELECT  COUNT(order_sended) FROM `order_product` WHERE `order_sended` = '3';";
$t_unpaid_totalRows = $pdo->query($t_unpaid)->fetch(PDO::FETCH_NUM)[0];
$t_unpaid_totalPages = ceil($t_unpaid_totalRows / $t_unpaid_perPage);


$t_unpaid = []; // 資料
if ($t_unpaid_totalRows > 0) {
    if ($t_unpaid_page > $t_unpaid_totalPages) {
        header('Location: ?page=' . $t_unpaid_totalPages);
        exit;
    }

    $t_unpaid_sql =
        sprintf("SELECT 
        `order_product_sid`, 
        order_product.member_sid , 
        members.sid, 
        members.member_name,
        coupon.sid, coupon.coupon_name, 
        order_paid.sid, order_paid.order_paid, 
        order_sended.sid, order_sended.order_sended , 
        order_refund.sid, order_refund.order_refund, 
        `order_product`.`order_sdate`, 
        `order_product`.`order_edate`
        FROM `order_product` 
        LEFT JOIN members on order_product.member_sid = members.sid 
        LEFT JOIN coupon on order_product.coupon_sid = coupon.sid 
        LEFT JOIN order_paid on order_product.order_paid = order_paid.sid 
        LEFT JOIN order_sended on order_product.order_sended = order_sended.sid 
        LEFT JOIN order_refund on order_product.order_refund = order_refund.sid 
        WHERE order_product.order_sended = 3
        ORDER BY `order_sdate`
        DESC LIMIT %s, %s", ($t_unpaid_page - 1) * $t_unpaid_perPage, $t_unpaid_perPage);
    $t_unpaid = $pdo->query($t_unpaid_sql)->fetchAll();
}

////////配送中篩選/////////
$t_sending_perPage = 8; // 每一頁最多有幾筆
$t_sending_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($t_sending_page < 1) {
    header('Location: ?page=1');
    exit;
}

$t_sending = "SELECT  COUNT(order_sended) FROM `order_product` WHERE `order_sended` = '2';";
$t_sending_totalRows = $pdo->query($t_sending)->fetch(PDO::FETCH_NUM)[0];
$t_sending_totalPages = ceil($t_sending_totalRows / $t_sending_perPage);

$t_sending = []; // 資料
if ($t_sending_totalRows > 0) {
    if ($t_sending_page > $t_sending_totalPages) {
        header('Location: ?page=' . $t_sending_totalPages);
        exit;
    }

    $t_sending_sql =
        sprintf("SELECT 
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
     WHERE order_product.order_sended = 2
     ORDER BY `order_sdate`
     DESC LIMIT %s, %s", ($t_sending_page - 1) * $t_sending_perPage, $t_sending_perPage);
    $t_sending = $pdo->query($t_sending_sql)->fetchAll();
}

////已送達/////
$t_sed_perPage = 8; // 每一頁最多有幾筆
$t_sed_page = isset($_GETt_sed_['page']) ? intval($_GETt_sed_['page']) : 1;
if ($t_sed_page < 1) {
    header('Location: ?page=1');
    exit;
}

$t_sed = "SELECT  COUNT(order_sended) FROM `order_product` WHERE `order_sended` = '0';";
$t_sed_totalRows = $pdo->query($t_sed)->fetch(PDO::FETCH_NUM)[0];
$t_sed_totalPages = ceil($t_sed_totalRows / $t_sed_perPage);

$t_sed = []; // 資料
if ($t_sed_totalRows > 0) {
    if ($t_sed_page > $t_sed_totalPages) {
        header('Location: ?page=' . $t_sed_totalPages);
        exit;
    }
    $t_sed_sql =
        sprintf("SELECT 
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
     WHERE order_product.order_sended = 0
     ORDER BY `order_sdate`
     DESC LIMIT %s, %s", ($t_sed_page - 1) * $t_sed_perPage, $t_sed_perPage);
    $t_sed = $pdo->query($t_sed_sql)->fetchAll();
}
////訂單完成/////
$finsh_perPage = 8; // 每一頁最多有幾筆
$finsh_page = isset($_GETfinsh_['page']) ? intval($_GETfinsh_['page']) : 1;
if ($finsh_page < 1) {
    header('Location: ?page=1');
    exit;
}

$finsh = "SELECT COUNT(*) FROM `order_product` 
WHERE 
 order_product.order_sended = 0 AND
 order_product.order_refund = 3";
$finsh_totalRows = $pdo->query($finsh)->fetch(PDO::FETCH_NUM)[0];
$finsh_totalPages = ceil($finsh_totalRows / $finsh_perPage);

$t_finsh = []; // 資料
if ($finsh_totalRows > 0) {
    if ($finsh_page > $finsh_totalPages) {
        header('Location: ?page=' . $finsh_totalPages);
        exit;
    }
    $finsh_sql =
        sprintf("SELECT 
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
     WHERE 
     order_product.order_sended = 0 AND
     order_paid.sid = 0 AND
     order_product.order_refund = 3
     ORDER BY `order_sdate`
     DESC LIMIT %s, %s", ($finsh_page - 1) * $finsh_perPage, $finsh_perPage);
    $t_finsh = $pdo->query($finsh_sql)->fetchAll();
}


$ft_sql = "SELECT COUNT(*) FROM `order_product` 
WHERE 
 order_product.order_sended = 0 AND
 order_product.order_refund = 3";
$ftotalRows = $pdo->query($ft_sql)->fetch(PDO::FETCH_NUM)[0];



?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>
<?php include __DIR__ . '/parts/sidebars.php' ?>


<div class="container">
    <div class="row">
        <div class="d-flex justify-content-center">
            <!-- 訂單篩選功能分頁 -->
            <div class=" justify-content-center table-hover">
                <div class="flex-nowrap justify-content-center">
                    <h2 class="m-3">訂單管理-首頁</h2>
                    <div class="flex-nowrap justify-content-center" style="width: 80vw; height: auto;">
                        <nav>
                            <div class="nav nav-tabs d-flex justify-content-around" id="nav-tab" role="tablist">
                                <button class="nav-link active flex-grow-1" id="myorder" data-bs-toggle="tab" data-bs-target="#myorder_tab" type="button" role="tab" aria-controls="nav-home" aria-selected="active">全部訂單(<?php echo $totalRows ?>)</button>
                                <button class="nav-link flex-grow-1" id="myorder_unsend" data-bs-toggle="tab" data-bs-target="#myorder_unsend_tab" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">未出貨(<?php echo $t_unpaid_totalRows ?>)</button>
                                <button class="nav-link flex-grow-1" id="myorder_sended" data-bs-toggle="tab" data-bs-target="#myorder_sended_tab" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">配送中(<?php echo $t_sending_totalRows ?>)</button>
                                <button class="nav-link flex-grow-1" id="myorder_arrive" data-bs-toggle="tab" data-bs-target="#myorder_arrive_tab" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">已送達(<?php echo $t_sed_totalRows ?>)</button>
                                <button class="nav-link flex-grow-1" id="myorder_finish" data-bs-toggle="tab" data-bs-target="#myorder_finish_tab" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">完成訂單(<?php echo $ftotalRows ?>)</button>
                                <form class="d-flex ms-5" style="height:40px; width: 330px;">
                                    <input class="form-control me-2" type="search" placeholder="輸入訂單/顧客編號或關鍵字" aria-label="Search">
                                    <button class="btn btn-outline-success" style="height:40px; width: 100px;" type="submit">搜尋</button>
                                </form>
                                <input type="button" class="btn btn-outline-success ms-2" style="height:40px; width: 100px;" onclick="location='myorder_list_add.php'" value=" 新增訂單"></input>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="myorder_tab" role="tabpanel" aria-labelledby="nav-home-tab">
                                <!-- 全部商品分頁     -->
                                <table class="table table-striped text-center table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">
                                                <span class="material-symbols-outlined">
                                                    delete
                                                </span>
                                            </th>
                                            <th scope="col">訂單編號</th>
                                            <th scope="col">會員ID</th>
                                            <th scope="col">所屬會員</th>
                                            <th scope="col">適用優惠券</th>
                                            <th scope="col">付款狀態</th>
                                            <th scope="col">出貨狀態</th>
                                            <th scope="col">退款狀態</th>
                                            <th scope="col">訂單成立日期</th>
                                            <th scope="col">訂單訂單最後異動日期</th>
                                            <th scope="col">
                                                <span class="material-symbols-outlined">
                                                    edit_square
                                                </span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($rows as $r) : ?>
                                            <tr class="table-hover">
                                                <td>
                                                    <a href="javascript: delete_it(<?= $r['order_product_sid'] ?>)">
                                                        <!-- 給予一個假連結 -->
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </a>
                                                </td>
                                                <td><?= $r['order_product_sid'] ?></td>
                                                <td><?= $r['member_sid'] ?></td>
                                                <td><?= $r['member_name'] ?></td>
                                                <td><?= $r['coupon_name'] ?></td>
                                                <td><?= $r['order_paid'] ?></td>
                                                <td><?= $r['order_sended'] ?></td>
                                                <td><?= $r['order_refund'] ?></td>
                                                <td><?= $r['order_sdate'] ?></td>
                                                <td><?= $r['order_edate'] ?></td>
                                                <td>
                                                    <a href="myorder_list_edit.php?sid=<?= $r['order_product_sid'] ?>">
                                                        <span class="material-symbols-outlined">
                                                            edit_square
                                                        </span>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                                <!-- 表格分頁開始 -->
                                <div class="d-flex justify-content-center">
                                    <div class="col d-flex justify-content-center">
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination">
                                                <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>"><a class="page-link" href="<?php echo "myorder.php?page=" ?><?php echo $page - 1 ?>"><span class="material-symbols-outlined">
                                                            keyboard_double_arrow_left
                                                        </span></a></li>
                                                <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
                                                    if ($i >= 1 and $i <= $totalPages) :
                                                ?>
                                                        <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                                                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                                        </li>
                                                <?php endif;
                                                endfor; ?>
                                                <li class="page-item"><a class="page-link" href="<?php echo "myorder.php?page=" ?><?php echo $page + 1 ?>"><span class="material-symbols-outlined">
                                                            keyboard_double_arrow_right
                                                        </span></a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                                <!-- 表格分頁結束 -->
                                <!-- 全部商品分頁結束     -->
                            </div>
                            <div class="tab-pane fade" id="myorder_unsend_tab" role="tabpanel" aria-labelledby="nav-contact-tab">
                                <!-- 未出貨商品分頁     -->
                                <table class="table table-striped text-center table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">
                                                <span class="material-symbols-outlined">
                                                    delete
                                                </span>
                                            </th>
                                            <th scope="col">訂單編號</th>
                                            <th scope="col">會員ID</th>
                                            <th scope="col">所屬會員</th>
                                            <th scope="col">適用優惠券</th>
                                            <th scope="col">付款狀態</th>
                                            <th scope="col">出貨狀態</th>
                                            <th scope="col">退款狀態</th>
                                            <th scope="col">訂單成立日期</th>
                                            <th scope="col">訂單訂單最後異動日期</th>
                                            <th scope="col">
                                                <span class="material-symbols-outlined">
                                                    edit_square
                                                </span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($t_unpaid as $upr) : ?>
                                            <tr>
                                                <td>
                                                    <a href="javascript: delete_it(<?= $upr['order_product_sid'] ?>)">
                                                        <!-- 給予一個假連結 -->
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </a>
                                                </td>
                                                <td><?= $upr['order_product_sid'] ?></td>
                                                <td><?= $upr['member_sid'] ?></td>
                                                <td><?= $upr['member_name'] ?></td>
                                                <td><?= $upr['coupon_name'] ?></td>
                                                <td><?= $upr['order_paid'] ?></td>
                                                <td class="bg-warning"><?= $upr['order_sended'] ?></td>
                                                <td><?= $upr['order_refund'] ?></td>
                                                <td><?= $upr['order_sdate'] ?></td>
                                                <td><?= $upr['order_edate'] ?></td>
                                                <td>
                                                    <a href="myorder_list_edit.php?sid=<?= $upr['order_product_sid'] ?>">
                                                        <span class="material-symbols-outlined">
                                                            edit_square
                                                        </span>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                                <!-- 表格分頁開始 -->
                                <div class="d-flex justify-content-center">
                                    <div class="col d-flex justify-content-center">
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination">
                                                <li class="page-item <?= $t_unpaid_page == 1 ? 'disabled' : '' ?>"><a class="page-link" href="<?php echo "myorder.php?page=" ?><?php echo $page - 1 ?>"><span class="material-symbols-outlined">
                                                            keyboard_double_arrow_left
                                                        </span></a></li>
                                                <?php for ($t_unpaid_i = $t_unpaid_page - 5; $t_unpaid_i <= $t_unpaid_page + 5; $t_unpaid_i++) :
                                                    if ($t_unpaid_i >= 1 and $t_unpaid_i <= $t_unpaid_totalPages) :
                                                ?>
                                                        <li class="page-item <?= $t_unpaid_page == $t_unpaid_i ? 'active' : '' ?>">
                                                            <a class="page-link" href="?page=<?= $t_unpaid_i ?>"><?= $t_unpaid_i ?></a>
                                                        </li>
                                                <?php endif;
                                                endfor; ?>
                                                <li class="page-item"><a class="page-link" href="<?php echo "myorder.php?page=" ?><?php echo $t_unpaid_page + 1 ?>"><span class="material-symbols-outlined">
                                                            keyboard_double_arrow_right
                                                        </span></a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                                <!-- 表格分頁結束 -->
                                <!-- 未出貨商品分頁結束     -->
                            </div>
                            <div class="tab-pane fade" id="myorder_sended_tab" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <!-- 配送中商品分頁     -->
                                <table class="table table-striped text-center table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">
                                                <span class="material-symbols-outlined">
                                                    delete
                                                </span>
                                            </th>
                                            <th scope="col">訂單編號</th>
                                            <th scope="col">會員ID</th>
                                            <th scope="col">所屬會員</th>
                                            <th scope="col">適用優惠券</th>
                                            <th scope="col">付款狀態</th>
                                            <th scope="col">出貨狀態</th>
                                            <th scope="col">退款狀態</th>
                                            <th scope="col">訂單成立日期</th>
                                            <th scope="col">訂單訂單最後異動日期</th>
                                            <th scope="col">
                                                <span class="material-symbols-outlined">
                                                    edit_square
                                                </span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($t_sending as $spr) : ?>
                                            <tr>
                                                <td>
                                                    <a href="javascript: delete_it(<?= $spr['order_product_sid'] ?>)">
                                                        <!-- 給予一個假連結 -->
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </a>
                                                </td>
                                                <td><?= $spr['order_product_sid'] ?></td>
                                                <td><?= $spr['member_sid'] ?></td>
                                                <td><?= $spr['member_name'] ?></td>
                                                <td><?= $spr['coupon_name'] ?></td>
                                                <td><?= $spr['order_paid'] ?></td>
                                                <td class="bg-warning"><?= $spr['order_sended'] ?></td>
                                                <td><?= $spr['order_refund'] ?></td>
                                                <td><?= $spr['order_sdate'] ?></td>
                                                <td><?= $spr['order_edate'] ?></td>
                                                <td>
                                                    <a href="myorder_list_edit.php?sid=<?= $spr['order_product_sid'] ?>">
                                                        <span class="material-symbols-outlined">
                                                            edit_square
                                                        </span>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                                <!-- 表格分頁開始 -->
                                <div class="d-flex justify-content-center">
                                    <div class="col d-flex justify-content-center">
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination">
                                                <li class="page-item <?= $t_sending_page == 1 ? 'disabled' : '' ?>"><a class="page-link" href="<?php echo "myorder.php?page=" ?><?php echo $page - 1 ?>"><span class="material-symbols-outlined">
                                                            keyboard_double_arrow_left
                                                        </span></a></li>
                                                <?php for ($t_sending_i = $t_sending_page - 5; $t_sending_i <= $t_sending_page + 5; $t_sending_i++) :
                                                    if ($t_sending_i >= 1 and $t_sending_i <= $t_sending_totalPages) :
                                                ?>
                                                        <li class="page-item <?= $t_sending_page == $t_sending_i ? 'active' : '' ?>">
                                                            <a class="page-link" href="?page=<?= $t_sending_i ?>"><?= $t_sending_i ?></a>
                                                        </li>
                                                <?php endif;
                                                endfor; ?>
                                                <li class="page-item"><a class="page-link" href="<?php echo "myorder.php?page=" ?><?php echo $t_sending_page + 1 ?>"><span class="material-symbols-outlined">
                                                            keyboard_double_arrow_right
                                                        </span></a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                                <!-- 表格分頁結束 -->
                                <!-- 出貨中商品分頁     -->
                            </div>
                            <div class="tab-pane fade" id="myorder_arrive_tab" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <!-- 已送達分頁     -->
                                <table class="table table-striped text-center table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">
                                                <span class="material-symbols-outlined">
                                                    delete
                                                </span>
                                            </th>
                                            <th scope="col">訂單編號</th>
                                            <th scope="col">會員ID</th>
                                            <th scope="col">所屬會員</th>
                                            <th scope="col">適用優惠券</th>
                                            <th scope="col">付款狀態</th>
                                            <th scope="col">出貨狀態</th>
                                            <th scope="col">退款狀態</th>
                                            <th scope="col">訂單成立日期</th>
                                            <th scope="col">訂單訂單最後異動日期</th>
                                            <th scope="col">
                                                <span class="material-symbols-outlined">
                                                    edit_square
                                                </span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($t_sed as $sepr) : ?>
                                            <tr>
                                                <td>
                                                    <a href="javascript: delete_it(<?= $sepr['order_product_sid'] ?>)">
                                                        <!-- 給予一個假連結 -->
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </a>
                                                </td>
                                                <td><?= $sepr['order_product_sid'] ?></td>
                                                <td><?= $sepr['member_sid'] ?></td>
                                                <td><?= $sepr['member_name'] ?></td>
                                                <td><?= $sepr['coupon_name'] ?></td>
                                                <td><?= $sepr['order_paid'] ?></td>
                                                <td class="bg-warning"><?= $sepr['order_sended'] ?></td>
                                                <td><?= $sepr['order_refund'] ?></td>
                                                <td><?= $sepr['order_sdate'] ?></td>
                                                <td><?= $sepr['order_edate'] ?></td>
                                                <td>
                                                    <a href="myorder_list_edit.php?sid=<?= $sepr['order_product_sid'] ?>">
                                                        <span class="material-symbols-outlined">
                                                            edit_square
                                                        </span>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                                <!-- 表格分頁開始 -->
                                <div class="d-flex justify-content-center">
                                    <div class="col d-flex justify-content-center">
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination">
                                                <li class="page-item <?= $t_sed_page == 1 ? 'disabled' : '' ?>"><a class="page-link" href="<?php echo "myorder.php?page=" ?><?php echo $page - 1 ?>"><span class="material-symbols-outlined">
                                                            keyboard_double_arrow_left
                                                        </span></a></li>
                                                <?php for ($t_sed_i = $t_sed_page - 5; $t_sed_i <= $t_sed_page + 5; $t_sed_i++) :
                                                    if ($t_sed_i >= 1 and $t_sed_i <= $t_sed_totalPages) :
                                                ?>
                                                        <li class="page-item <?= $t_sed_page == $t_sed_i ? 'active' : '' ?>">
                                                            <a class="page-link" href="?page=<?= $t_sed_i ?>"><?= $t_sed_i ?></a>
                                                        </li>
                                                <?php endif;
                                                endfor; ?>
                                                <li class="page-item"><a class="page-link" href="<?php echo "myorder.php?page=" ?><?php echo $t_sed_page + 1 ?>"><span class="material-symbols-outlined">
                                                            keyboard_double_arrow_right
                                                        </span></a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="myorder_finish_tab" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <!-- 已送達分頁     -->
                                <table class="table table-striped text-center table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">
                                                <span class="material-symbols-outlined">
                                                    delete
                                                </span>
                                            </th>
                                            <th scope="col">訂單編號</th>
                                            <th scope="col">會員ID</th>
                                            <th scope="col">所屬會員</th>
                                            <th scope="col">適用優惠券</th>
                                            <th scope="col">付款狀態</th>
                                            <th scope="col">出貨狀態</th>
                                            <th scope="col">退款狀態</th>
                                            <th scope="col">訂單成立日期</th>
                                            <th scope="col">訂單訂單最後異動日期</th>
                                            <th scope="col">
                                                <span class="material-symbols-outlined">
                                                    edit_square
                                                </span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($t_finsh as $sfinsh) : ?>
                                            <tr>
                                                <td>
                                                    <a href="javascript: delete_it(<?= $sfinsh['order_product_sid'] ?>)">
                                                        <!-- 給予一個假連結 -->
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </a>
                                                </td>
                                                <td><?= $sfinsh['order_product_sid'] ?></td>
                                                <td><?= $sfinsh['member_sid'] ?></td>
                                                <td><?= $sfinsh['member_name'] ?></td>
                                                <td><?= $sfinsh['coupon_name'] ?></td>
                                                <td class="bg-primary text-white"><?= $sfinsh['order_paid'] ?></td>
                                                <td class="bg-warning"><?= $sfinsh['order_sended'] ?></td>
                                                <td class="bg-primary text-white"><?= $sfinsh['order_refund'] ?></td>
                                                <td><?= $sfinsh['order_sdate'] ?></td>
                                                <td><?= $sfinsh['order_edate'] ?></td>
                                                <td>
                                                    <a href="myorder_list_edit.php?sid=<?= $sfinsh['order_product_sid'] ?>">
                                                        <span class="material-symbols-outlined">
                                                            edit_square
                                                        </span>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                                <!-- 表格分頁開始 -->
                                <div class="d-flex justify-content-center">
                                    <div class="col d-flex justify-content-center">
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination">
                                                <li class="page-item <?= $finsh_page == 1 ? 'disabled' : '' ?>"><a class="page-link" href="<?php echo "myorder.php?page=" ?><?php echo $finsh_page - 1 ?>"><span class="material-symbols-outlined">
                                                            keyboard_double_arrow_left
                                                        </span></a></li>
                                                <?php for ($finsh_i = $finsh_page - 5; $finsh_i <= $finsh_page + 5; $finsh_i++) :
                                                    if ($finsh_i >= 1 and $finsh_i <= $finsh_totalPages) :
                                                ?>
                                                        <li class="page-item <?= $finsh_page == $finsh_i ? 'active' : '' ?>">
                                                            <a class="page-link" href="?page=<?= $finsh_i ?>"><?= $finsh_i ?></a>
                                                        </li>
                                                <?php endif;
                                                endfor; ?>
                                                <li class="page-item"><a class="page-link" href="<?php echo "myorder.php?page=" ?><?php echo $finsh_page + 1 ?>"><span class="material-symbols-outlined">
                                                            keyboard_double_arrow_right
                                                        </span></a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 訂單篩選功能分頁結尾 -->
        </div>
    </div>
</div>




<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
    function delete_it(order_product_sid) {
        if (confirm(`編號為 ${order_product_sid} 的訂單要被你刪掉囉! 確定?`)) {
            location.href = 'myorder_delete.php?sid=' + order_product_sid;
        }
    }
</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>