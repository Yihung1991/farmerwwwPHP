<?php
require __DIR__ . '/parts/connect_db.php';


$perPage = 5; // 每一頁最多有幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
  header('Location: ?page=1');
  exit;
}
$pageName = '優惠劵管理';
$title = '優惠劵管理';
$pageSid = 6;


$filterCate = isset($_GET['cate']) ? $_GET['cate'] : NULL;
$filterStatus = isset($_GET['status']) ? $_GET['status'] : NULL;

if ($filterCate == NULL && $filterStatus == NULL) {
  // 沒有做篩選
  $t_sql = "SELECT COUNT(1) FROM `coupon`";
  $totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
  $totalPages = ceil($totalRows / $perPage);
  // 資料
  $rows = [];
  if ($totalRows > 0) {
    if ($page > $totalPages) {
      header('Location: ?page=' . $totalPages);
      exit;
    }
    $sql = sprintf("SELECT * FROM `coupon` ORDER BY `sid` DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
    $rows = $pdo->query($sql)->fetchAll();
  }
} else if (isset($filterCate)) {
  // 根據種類做篩選
  $t_sql = sprintf("SELECT COUNT(1) FROM `coupon` WHERE `coupon_category`= %s", $filterCate);
  $totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
  $totalPages = ceil($totalRows / $perPage);

  $rows = [];
  if ($totalRows > 0) {
    if ($page > $totalPages) {
      header('Location: ?page=' . $totalPages);
      exit;
    }
    $sql = sprintf("SELECT * FROM `coupon` WHERE `coupon_category` = %s ORDER BY `sid` DESC LIMIT %s, %s;", $filterCate, ($page - 1) * $perPage, $perPage);
    $rows = $pdo->query($sql)->fetchAll();
  }
} else if (isset($filterStatus)) {
  // 根據有效無效狀態做篩選
  $t_sql = sprintf("SELECT COUNT(1) FROM `coupon` WHERE `coupon_category`= %s", $filterStatus);
  $totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
  $totalPages = ceil($totalRows / $perPage);

  $rows = [];
  if ($totalRows > 0) {
    if ($page > $totalPages) {
      header('Location: ?page=' . $totalPages);
      exit;
    }
    $sql = sprintf("SELECT * FROM `coupon` WHERE `coupon_category` = %s ORDER BY `sid` DESC LIMIT %s, %s;", $filterStatus, ($page - 1) * $perPage, $perPage);
    $rows = $pdo->query($sql)->fetchAll();
  }
}

// echo json_encode($rows);


$cates = [];
$sql_cate = "SELECT * FROM `coupon_category`";
$cates = $pdo->query($sql_cate)->fetchAll();

$status = [];
$sql_status = "SELECT * FROM `coupon_status`";
$status = $pdo->query($sql_status)->fetchAll();





?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/css-style.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>
<?php include __DIR__ . '/parts/sidebars.php' ?>
<div class="container w-95">
  <div class="row w-95">
    <div class="flex-column w-100">
      <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb" class="mt-3 ms-3">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">首頁</a></li>
          <li class="breadcrumb-item active" aria-current="page">優惠劵管理</li>
        </ol>
      </nav>
      <div class="container d-flex flex-column">
        <div class="col d-flex flex-column">
          <div class="d-flex justify-content-end mb-3 mt-3">
            <a href="coupon-add.php">
              <button type="button" class="btn btn-primary" style="width:120px;">新增優惠劵</button>
            </a>
          </div>
          <div class="col d-flex justify-content-center mb-3 gap-3">
            <!-- 搜索功能 -->

            <div class="input-group rounded" style="width:350px">
              <input type="search" class="light-table-filter form-control rounded" data-table="order-table" placeholder="請輸入優惠卷名稱">
              <span class="input-group-text border-0" id="search-addon">
                <i class="fas fa-search"></i>
              </span>
            </div>

            <!-- 建立時間排序 -->
            <select class="form-select" aria-label="Default select example" style="width: 150px;">
              <option selected>全部時間</option>
              <option value="1">開始日期</option>
              <option value="2">結束日期</option>
            </select>


            <div class="btn-toolbar" role="toolbar" id="lettersToolbar">
              <div class="btn-group1 mr-2">
                <button id="ALL" class="btn btn-outline-success" style="width:100px;">
                  <a href="?page=<?= $page ?>" class="a">ALL</a></button>
                <button id="%" class="filter-button btn btn-outline-success">
                  <a href="?page=<?= $page ?>&cate=1" class="a">NTD</a>
                </button>
                <button id="NTD" class="filter-button btn btn-outline-success">
                  <a href="?page=<?= $page ?>&cate=2" class="a">%</a></button>
              </div>
            </div>

            <div class="btn-toolbar" role="toolbar" id="lettersToolbar">
              <div class="btn-group2 mr-2">
                <button id="invalid" class="filter-button btn btn-outline-success">
                  <a href="?page=<?= $page ?>&status=1" style="text-decoration:none;color:#198754;">無效</a>
                </button>
                <button id="valid" class="filter-button btn btn-outline-success">
                  <a href="?page=<?= $page ?>&status=2" style="text-decoration:none;color:#198754;">有效</a>
                </button>
              </div>
            </div>

          </div>
          <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
              <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page - 1 ?>&cate=<?= $filterCate ?>">
                  <i class="fa-solid fa-circle-arrow-left"></i>
                </a>
              </li>
              <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
                if ($i >= 1 and $i <= $totalPages) :
              ?>
                  <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&cate=<?= $filterCate ?>"><?= $i ?></a>
                  </li>
              <?php
                endif;
              endfor; ?>
              <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page + 1 ?>&cate=<?= $filterCate ?>">
                  <i class="fa-solid fa-circle-arrow-right"></i>
                </a>
              </li>
            </ul>
          </nav>
        </div>
        <table class="table table-striped table-bordered order-table">
          <thead>
            <tr>
              <th scope="col">編號</th>
              <th scope="col">圖片<br>預覽</th>
              <th scope="col">優惠劵<br>名稱</th>
              <th scope="col">關鍵字</th>
              <th scope="col">折扣<br>額度</th>
              <th scope="col">優惠<br>類型</th>
              <th scope="col">使用<br>期限</th>
              <th scope="col">最低<br>消費門檻</th>
              <th scope="col">狀態</th>
              <th scope="col">內容</th>
              <th scope="col">建立<br>日期</th>
              <th scope="col">異動<br>日期</th>
            </tr>
          </thead>
          <tbody class="searchable">
            <?php foreach ($rows as $key => $r) : $key = $key + ($page * $perPage) - 4 ?>
              <tr>
                <td><?= $key ?></td>
                <td><?= $r['coupon_name'] ?></td>
                <td><img src="imgupload/coupon/<?= $r['coupon_img'] ?>" style="width:80px; height:80px;"></td>
                <td><?= $r['coupon_keywords'] ?></td>
                <td><?= $r['coupon_quota'] ?></td>
                <td><?php
                    for ($i = 0; $i <= 1; $i++) {
                      if ($r['coupon_category'] == "{$cates[$i]['sid']}") {
                        echo $cates[$i]['coupon_category'];
                      }
                    }
                    ?>
                </td>
                <td><?= $r['coupon_expiry'] ?></td>
                <td><?= $r['coupon_minimum'] ?></td>
                <td><?php for ($i = 0; $i <= 1; $i++) {
                      if ($r['coupon_status'] == "{$status[$i]['sid']}") {
                        echo $status[$i]['coupon_status'];
                      }
                    } ?></td>
                <td><?= $r['coupon_discription'] ?></td>
                <td><?= $r['coupon_created_at'] ?></td>
                <td><?= $r['coupon_update_date'] ?></td>

              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <script>
    function delete_it(sid) {
      if (confirm(`是否要刪除編號為${sid}的資料?`)) {
        location.href = 'coupon-delete.php?sid=' + sid;
      }
    }

    // $('.filter-button').on('click', function() {
    //   var cateValue = $(this).data('cate');
    //   var statusValue = $(this).data('status');

    //   $.ajax({
    //     url: 'coupon-list-filter.php',
    //     method: 'GET',
    //     data: {
    //       cate: cateValue,
    //       status: statusValue
    //     },
    //     success: function(response) {
    //     }
    //   });
    // });
  </script>

  <?php include __DIR__ . '/parts/scripts.php' ?>
  <?php include __DIR__ . '/parts/html-foot.php' ?>