<?php
require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin-required.php';
$pageName = '優惠劵使用分析表';
$title = '優惠劵使用分析表';


$couponSid = isset($_POST['couponSid']) ? intval($_POST['couponSid']) : 1;
//TODO :頁面防呆



$perPage = 10; // 每一頁最多有幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
  header('Location: ?page=1');
  exit;
}

$t_sql = sprintf("SELECT COUNT(1) FROM coupon_details WHERE `coupon_sid` = %s", $couponSid);
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
$totalPages = ceil($totalRows / $perPage);

$rows = []; // 資料
if ($totalRows > 0) {
  if ($page > $totalPages) {
    header('Location: ?page=' . $totalPages);
    exit;
  }
  $sql = sprintf("SELECT * FROM `coupon_details` WHERE `coupon_sid` = %s ORDER BY `sid` DESC LIMIT %s, %s", $couponSid, ($page - 1) * $perPage, $perPage);
  $rows = $pdo->query($sql)->fetchAll();
}


$Csql = "SELECT * FROM `coupon` WHERE sid=$couponSid";
$c = $pdo->query($Csql)->fetch();
$c_j = json_encode($c, JSON_UNESCAPED_UNICODE);


$m = [];
$m_sql = "SELECT * FROM `members`";
$m = $pdo->query($m_sql)->fetchAll();
$m_j = json_encode($m, JSON_UNESCAPED_UNICODE);

$u = [];
$u_sql = "SELECT * FROM `coupon_used`";
$u = $pdo->query($u_sql)->fetchAll();

$ac = [];
$ac_sql = "SELECT * FROM `all_category`";
$ac = $pdo->query($ac_sql)->fetchAll();





?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/css-style.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>
<?php include __DIR__ . '/parts/sidebars.php' ?>
<div class="container w-75">
  <div class="row">
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb" class="mt-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">首頁</a></li>
        <li class="breadcrumb-item"><a href="coupon-list.php">優惠劵管理</a></li>
        <li class="breadcrumb-item active" aria-current="page">優惠劵使用率分析</li>
      </ol>
    </nav>
    <div class="col">
      <div class="d-flex justify-content-end mb-3 mt-3">
        <a class="page-link" href="coupon-chart.php?sid=<?= $c['sid'] ?>">
          <button type="submit" class="btn btn-primary" style="width:120px;" value="<?= $c['sid'] ?>">使用率分析</button>
        </a>
      </div>
      <nav aria-label="Page navigation example">
        <ul class="pagination">
          <form action="?page=<?= $page - 1 ?>" method="post" name="couponSid" class="page-item">
            <button type="submit" name="couponSid" value="<?= $couponSid ?>" class="page-link <?= $page == 1 ? 'disabled' : '' ?>">
              <i class="fa-solid fa-circle-arrow-left"></i>
            </button>
          </form>
          <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
            if ($i >= 1 and $i <= $totalPages) : ?>
              <form action="?page=<?= $i ?>" method="post" name="couponSid" class="page-item">
                <button type="submit" name="couponSid" value="<?= $couponSid ?>" class="page-link <?= $page == $i ? 'active' : '' ?>">
                  <?= $i ?>
                </button>
              </form>
          <?php
            endif;
          endfor; ?>
          <form action="?page=<?= $page + 1 ?>" method="post" name="couponSid" class="page-item">
            <button type="submit" name="couponSid" value="<?= $couponSid ?>" class="page-link <?= $page == $totalPages ? 'disabled' : '' ?>">
              <i class="fa-solid fa-circle-arrow-right"></i>
            </button>
          </form>
        </ul>
      </nav>
    </div>
  </div>
  <table class="table table-striped table-bordered">
    <h4><?= $c['coupon_name'] ?>使用分析表</h4>
    <thead>
      <tr>
        <th scope="col">優惠劵擁有者</th>
        <th scope="col">有效開始日期</th>
        <th scope="col">到期日</th>
        <th scope="col">使用狀態</th>
        <th scope="col">使用的訂單</th>
        <th scope="col">收回優惠劵使用權</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $r) : ?>
        <tr>
          <td><?php for ($i = 0; $i <= 99; $i++) {
                if ($r['member_sid'] == "{$m[$i]['sid']}") {
                  echo $m[$i]['member_name'];
                }
              } ?></td>
          <td><?= $r['coupon_sdate'] ?></td>
          <td><?= $r['coupon_edate'] ?></td>
          <td><?php for ($i = 0; $i <= 2; $i++) {
                if ($r['coupon_used'] == "{$u[$i]['sid']}") {
                  echo $u[$i]['coupon_used'];
                }
              } ?></td>
          <td><?php for ($i = 0; $i <= 1; $i++) {
                if ($r['order_category'] == "{$ac[$i]['sid']}") {
                  echo $ac[$i]['name'];
                }
              } ?></td>
          <td><a href="javascript: delete_it(<?= $r['sid'] ?>)"><i class="fa-solid fa-trash"></i></a></td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>
<script>
  function delete_it(sid) {
    if (confirm(`是否要收回該會員的優惠卷使用權?`)) {
      location.href = 'coupon-delete-CD.php?sid=' + sid;
    }
  }
</script>
<?php include __DIR__ . '/parts/scripts.php' ?>
<?php include __DIR__ . '/parts/html-foot.php' ?>