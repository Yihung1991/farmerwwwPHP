<?php
require __DIR__ . '/parts/connect_db.php';

require __DIR__ . '/parts/admin-required.php';

$pageName = 'member_comment';
$title = '會員評論';
$pageSid = '5';

//檢查GET參數sid是否有設定
$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

//如果是空字串，轉回列表頁
if (empty($sid)) {
  header('Location: member-list.php');
  exit;
};


$sql = "SELECT
m.member_name,
c.*
FROM
`comment` AS c
JOIN `members` AS m 
ON c.member_sid = m.sid
WHERE
m.sid = $sid";

$rows = $pdo->query($sql)->fetchAll();  //取得指定sid的資料，是陣列


$cates_sql = "SELECT * FROM `all_category`";
$cates = $pdo->query($cates_sql)->fetchAll();

$lesson = [];
$lesson_sql = "SELECT * FROM lesson";
$lesson = $pdo->query($lesson_sql)->fetchAll();

$product = [];
$product_sql = "SELECT * FROM product";
$product = $pdo->query($product_sql)->fetchAll();


?>


<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/css-style.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>
<?php include __DIR__ . '/parts/sidebars.php' ?>

<div class="container w-75">
    <!-- 麵包屑 -->
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">首頁</a></li>
      <li class="breadcrumb-item active" aria-current="page"><a href="member-list.php">會員管理</a></li>
      <li class="breadcrumb-item active" aria-current="page"><a href="member-list_more.php?sid=<?=$sid?>">會員詳細資訊</a></li>
      <li class="breadcrumb-item active" aria-current="page"><?=$title?></li>
    </ol>
  </nav>
  <div class="row">

    <div class="card mt-3">
      <div class="card-body">
        <h4 class="card-title text-center">會員評論（編號：<?= $sid ?>）</h4>

        <?php if (empty($rows)) : ?>
        <h4 class="text-center mt-5" style="font-weight:bold;">此會員尚未有評論資料</h4>
        <h5 class="text-center mt-5"><span id="count">3</span>秒後返回會員清單</h5>
        <script>
        //倒數計時&回清單
        let iid = setInterval(() => {
          count.innerHTML = parseInt(count.innerHTML) - 1;
          if (parseInt(count.innerHTML) < 1) {
            clearInterval(iid)
            }
          }, 1000);
          setTimeout(() => {
            location.href = 'member-list.php';
          }, 3000)
        </script>

        <?php else : ?>

        <table class="table table-striped mt-5">
          <thead>
            <tr>
              <th scope="col">會員名稱</th>
              <th scope="col">評論類型</th>
              <th scope="col">評論項目</th>
              <th scope="col">評論分數</th>
              <th scope="col">評論內容</th>
              <th scope="col">評論時間</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rows as $r) { ?>
              <tr>
                <td><?= $r['member_name'] ?></td>
                <td><?php if ($r['all_category_sid'] === "{$cates[0]['sid']}") {
                      echo "{$cates[0]['name']}";
                    } else if ($r['all_category_sid'] === "{$cates[1]['sid']}") {
                      echo "{$cates[1]['name']}";
                    }
                    ?>
                </td>
                <td><?php
                    if ($r['all_category_sid'] === "{$cates[0]['sid']}") {
                      for ($k = 0; $k < count($lesson); $k++) {
                        if ($r['lesson_sid'] === "{$lesson[$k]['sid']}") {
                          echo "{$lesson[$k]['lesson_name']}";
                        };
                      }
                    } else {
                      for ($k = 0; $k < count($product); $k++) {
                        if ($r['product_sid'] === "{$product[$k]['sid']}") {
                          echo "{$product[$k]['product_name']}";
                        }
                      }
                    }
                    ?></td>
                <td><?php
                    $apple = '<i class="fa-solid fa-apple-whole me-1"></i>';
                    for ($i = 0; $i < intval($r['comment_value']); $i++) {
                      echo $apple;
                    } ?></td>
                <td><?= $r['comment_content'] ?></td>
                <td><?= $r['comment_publish_date'] ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
        <?php endif; ?>

        <div class="d-flex justify-content-center">

          <button type="submit" class="btn btn-secondary d-block mx-auto mt-5" onclick="location.href ='member-list.php'">返回會員清單</button>

        </div>
      </div>
    </div>

  </div>
</div>

<?php include __DIR__ . '/parts/scripts.php' ?>
<script>

</script>

<?php include __DIR__ . '/parts/html-foot.php' ?>