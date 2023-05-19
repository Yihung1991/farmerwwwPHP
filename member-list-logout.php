<?php
require __DIR__ . '/parts/connect_db.php';


$pageName = 'member_list';
$title = '會員清單';
$pageSid = '5';





$per_page = 8; //每頁幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; //要看哪一頁
//如果頁數小於1，跳轉到第一頁
if ($page < 1) {
  header('Location: ?page=1');
  exit;
}

if (isset($_GET['orderby'])) {
  $myorder = 'ASC';
} else {
  $myorder = 'DESC';
}

$state_sid = [];
$search = [];


if (isset($_GET['state_sid'])) {
  //篩選狀態
  //計算總筆數
  $state_sid = $_GET['state_sid'];
  $t_sql = "SELECT COUNT(1) FROM `members` WHERE `member_state_sid`='$state_sid'";
  $total = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0]; //COUNT輸出結果只會有一個資料欄，所以用索引式陣列呈現並直接取得值

  $total_page = ceil($total / $per_page); //總頁數
  $rows = [];

  if ($total > 0) {
    //如果頁數大於最大頁數，跳轉到最後一頁
    if ($page > $total_page) {
      header('Location: ?page=' . $total_page);
      exit;
    }
    $sql = sprintf("SELECT * FROM `members` WHERE `member_state_sid`='$state_sid' ORDER BY `sid` $myorder  LIMIT %s, %s", ($page - 1) * $per_page, $per_page);
    $rows = $pdo->query($sql)->fetchAll();
  }
} else if (isset($_GET['search'])) {
  //檢索
  //計算總筆數
  $search = $_GET['search'];
  $t_sql = "SELECT COUNT(1) FROM `members` WHERE `member_name` LIKE '%$search%'";
  $total = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0]; //COUNT輸出結果只會有一個資料欄，所以用索引式陣列呈現並直接取得值


  $total_page = ceil($total / $per_page); //總頁數

  $rows = [];

  if ($total > 0) {
    //如果頁數大於最大頁數，跳轉到最後一頁
    if ($page > $total_page) {
      header('Location: ?page=' . $total_page);
      exit;
    }
    $sql = sprintf("SELECT * FROM `members` WHERE `member_name` LIKE '%s' ORDER BY `sid` $myorder  LIMIT %s, %s", '%' . $search . '%', ($page - 1) * $per_page, $per_page);
    $rows = $pdo->query($sql)->fetchAll();
  };
} else {
  //總表
  //計算總筆數
  $t_sql = "SELECT COUNT(1) FROM `members`";
  $total = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0]; //COUNT輸出結果只會有一個資料欄，所以用索引式陣列呈現並直接取得值


  $total_page = ceil($total / $per_page); //總頁數

  $rows = [];


  if ($total > 0) {
    //如果頁數大於最大頁數，跳轉到最後一頁
    if ($page > $total_page) {
      header('Location: ?page=' . $total_page);
      exit;
    }
    $sql = sprintf("SELECT * FROM `members` ORDER BY `sid` $myorder LIMIT %s, %s", ($page - 1) * $per_page, $per_page);
    $rows = $pdo->query($sql)->fetchAll();
  }
}


//會員狀態
$state_sql = "SELECT * FROM `member_state`";
$state = $pdo->query($state_sql)->fetchAll();

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
      <li class="breadcrumb-item active" aria-current="page">會員管理</li>
    </ol>
  </nav>
  <button class="btn btn-primary mt-3 d-block" style="margin-left:auto;" onclick="location.href ='member-add.php'">新增會員</button>
  <div class="d-flex justify-content-center gap-5 align-items-center">
    <!-- 搜尋功能   -->
    <form name="form1" class="d-flex mt-3" onsubmit="event.preventDefault()">
      <input class="form-control me-2 " type="search" placeholder="請輸入姓名" aria-label="Search" id="search" name="search">
      <button class="btn btn-outline-secondary" type="submit" onclick="nameSearch()"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
    <!-- 篩選功能 -->
    <div class="dropdown">
    <button class="btn btn-outline-secondary dropdown-toggle mt-3" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="width:160px">
        <?php if(isset($_GET['state_sid'])){ if($_GET['state_sid']==1){echo '未驗證';}else if($_GET['state_sid']==2){echo '使用中';}else{echo '已禁用';}}else{echo '狀態篩選';}?>
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        <li><a class="dropdown-item text-center" href="member-list.php">所有會員</a></li>
        <li><a class="dropdown-item text-center" href="member-list.php?state_sid=1"><?= $state[0]['member_state'] ?></a></li>
        <li><a class="dropdown-item text-center" href="member-list.php?state_sid=2"><?= $state[1]['member_state'] ?></a></li>
        <li><a class="dropdown-item text-center" href="member-list.php?state_sid=3"><?= $state[2]['member_state'] ?></a></li>
      </ul>
    </div>
  </div>

  <?php if (empty($rows)) : ?>
    <h4 class="text-center mt-5" style="font-weight:bold;">查無會員資料</h4>
    <h5 class="text-center mt-5"><span id="count">3</span>秒後返回會員清單</h5>
    <script>
      // 倒數計時&回清單
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

    <!-- 分頁按鈕  -->

    <?php if (isset($_GET['state_sid'])) :
      if (isset($_GET['orderby'])) { ?>
        <!-- 篩選 -->

        <nav aria-label="Page navigation example" class="d-flex justify-content-center mt-3">
          <ul class="pagination">
            <!-- 回上一頁，第一頁按鈕不能按 -->
            <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
              <a class="page-link" href="?orderby=1&<?= 'state_sid=' . $state_sid . '&page=' . $page - 1 ?>">
                <i class="fa-solid fa-circle-arrow-left"></i>
              </a>
            </li>
            <!-- 跑迴圈帶出頁碼，當前頁數往前5頁+往後5頁 -->
            <?php for ($i = $page - 5; $i <= $page + 5; $i++) {
              // 設定$i的範圍是在1~總頁數才會顯示(不然會出現負數頁或超出總頁數)
              if ($i >= 1 and $i <= $total_page) {  ?>
                <li class="page-item <?= $page == $i ? 'active' : '' ?> ">
                  <a class="page-link" href="?orderby=1&<?= 'state_sid=' . $state_sid . '&page=' . $i ?>"><?= $i ?></a>
                </li>
              <?php }; ?>
            <?php }; ?>
            <!-- 到下一頁，最後一頁按鈕不能按 -->
            <li class="page-item <?= $page == $total_page ? 'disabled' : '' ?>">
              <a class="page-link" href="?orderby=1&<?= 'state_sid=' . $state_sid . '&page=' . $page + 1 ?>">
                <i class="fa-solid fa-circle-arrow-right"></i>
              </a>
            </li>
          </ul>
        </nav>

      <?php  } else { ?>

        <nav aria-label="Page navigation example" class="d-flex justify-content-center mt-3">
          <ul class="pagination">
            <!-- 回上一頁，第一頁按鈕不能按 -->
            <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
              <a class="page-link" href="?<?= 'state_sid=' . $state_sid . '&page=' . $page - 1 ?>">
                <i class="fa-solid fa-circle-arrow-left"></i>
              </a>
            </li>
            <!-- 跑迴圈帶出頁碼，當前頁數往前5頁+往後5頁 -->
            <?php for ($i = $page - 5; $i <= $page + 5; $i++) {
              // 設定$i的範圍是在1~總頁數才會顯示(不然會出現負數頁或超出總頁數)
              if ($i >= 1 and $i <= $total_page) {  ?>
                <li class="page-item <?= $page == $i ? 'active' : '' ?> ">
                  <a class="page-link" href="?<?= 'state_sid=' . $state_sid . '&page=' . $i ?>"><?= $i ?></a>
                </li>
              <?php }; ?>
            <?php }; ?>
            <!-- 到下一頁，最後一頁按鈕不能按 -->
            <li class="page-item <?= $page == $total_page ? 'disabled' : '' ?>">
              <a class="page-link" href="?<?= 'state_sid=' . $state_sid . '&page=' . $page + 1 ?>">
                <i class="fa-solid fa-circle-arrow-right"></i>
              </a>
            </li>
          </ul>
        </nav>

      <?php }; ?>



      <?php elseif (isset($_GET['search'])) :


      if (isset($_GET['orderby'])) { ?>
        <!-- 檢索 -->
        <nav aria-label="Page navigation example" class="d-flex justify-content-center mt-3">
          <ul class="pagination">
            <!-- 回上一頁，第一頁按鈕不能按 -->
            <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
              <a class="page-link" href="?orderby=1&<?= 'search=' . $search . '&page=' . $page - 1 ?>">
                <i class="fa-solid fa-circle-arrow-left"></i>
              </a>
            </li>
            <!-- 跑迴圈帶出頁碼，當前頁數往前5頁+往後5頁 -->
            <?php for ($i = $page - 5; $i <= $page + 5; $i++) {
              // 設定$i的範圍是在1~總頁數才會顯示(不然會出現負數頁或超出總頁數)
              if ($i >= 1 and $i <= $total_page) {  ?>
                <li class="page-item <?= $page == $i ? 'active' : '' ?> ">
                  <a class="page-link" href="?orderby=1&<?= 'search=' . $search . '&page=' . $i ?>"><?= $i ?></a>
                </li>
              <?php }; ?>
            <?php }; ?>
            <!-- 到下一頁，最後一頁按鈕不能按 -->
            <li class="page-item <?= $page == $total_page ? 'disabled' : '' ?>">
              <a class="page-link" href="?orderby=1&<?= 'search=' . $search . '&page=' . $page + 1 ?>">
                <i class="fa-solid fa-circle-arrow-right"></i>
              </a>
            </li>
          </ul>
        </nav>
      <?php  } else { ?>

        <nav aria-label="Page navigation example" class="d-flex justify-content-center mt-3">
          <ul class="pagination">
            <!-- 回上一頁，第一頁按鈕不能按 -->
            <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
              <a class="page-link" href="?<?= 'search=' . $search . '&page=' . $page - 1 ?>">
                <i class="fa-solid fa-circle-arrow-left"></i>
              </a>
            </li>
            <!-- 跑迴圈帶出頁碼，當前頁數往前5頁+往後5頁 -->
            <?php for ($i = $page - 5; $i <= $page + 5; $i++) {
              // 設定$i的範圍是在1~總頁數才會顯示(不然會出現負數頁或超出總頁數)
              if ($i >= 1 and $i <= $total_page) {  ?>
                <li class="page-item <?= $page == $i ? 'active' : '' ?> ">
                  <a class="page-link" href="?<?= 'search=' . $search . '&page=' . $i ?>"><?= $i ?></a>
                </li>
              <?php }; ?>
            <?php }; ?>
            <!-- 到下一頁，最後一頁按鈕不能按 -->
            <li class="page-item <?= $page == $total_page ? 'disabled' : '' ?>">
              <a class="page-link" href="?<?= 'search=' . $search . '&page=' . $page + 1 ?>">
                <i class="fa-solid fa-circle-arrow-right"></i>
              </a>
            </li>
          </ul>
        </nav>

      <?php }; ?>


      <?php else :
      if (isset($_GET['orderby'])) { ?>
        <nav aria-label="Page navigation example" class="d-flex justify-content-center mt-3">
          <ul class="pagination">
            <!-- 回上一頁，第一頁按鈕不能按 -->
            <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
              <a class="page-link" href="?orderby=1&page=<?= $page - 1 ?>">
                <i class="fa-solid fa-circle-arrow-left"></i>
              </a>
            </li>
            <!-- 跑迴圈帶出頁碼，當前頁數往前5頁+往後5頁 -->
            <?php for ($i = $page - 5; $i <= $page + 5; $i++) {
              // 設定$i的範圍是在1~總頁數才會顯示(不然會出現負數頁或超出總頁數)
              if ($i >= 1 and $i <= $total_page) {  ?>
                <li class="page-item <?= $page == $i ? 'active' : '' ?> ">
                  <a class="page-link" href="?orderby=1&page=<?= $i ?>"><?= $i ?></a>
                </li>
              <?php }; ?>
            <?php }; ?>
            <!-- 到下一頁，最後一頁按鈕不能按 -->
            <li class="page-item <?= $page == $total_page ? 'disabled' : '' ?>">
              <a class="page-link" href="?orderby=1&page=<?= $page + 1 ?>">
                <i class="fa-solid fa-circle-arrow-right"></i>
              </a>
            </li>
          </ul>
        </nav>
      <?php  } else { ?>

        <nav aria-label="Page navigation example" class="d-flex justify-content-center mt-3">
          <ul class="pagination">
            <!-- 回上一頁，第一頁按鈕不能按 -->
            <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
              <a class="page-link" href="?page=<?= $page - 1 ?>">
                <i class="fa-solid fa-circle-arrow-left"></i>
              </a>
            </li>
            <!-- 跑迴圈帶出頁碼，當前頁數往前5頁+往後5頁 -->
            <?php for ($i = $page - 5; $i <= $page + 5; $i++) {
              // 設定$i的範圍是在1~總頁數才會顯示(不然會出現負數頁或超出總頁數)
              if ($i >= 1 and $i <= $total_page) {  ?>
                <li class="page-item <?= $page == $i ? 'active' : '' ?> ">
                  <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
              <?php }; ?>
            <?php }; ?>
            <!-- 到下一頁，最後一頁按鈕不能按 -->
            <li class="page-item <?= $page == $total_page ? 'disabled' : '' ?>">
              <a class="page-link" href="?page=<?= $page + 1 ?>">
                <i class="fa-solid fa-circle-arrow-right"></i>
              </a>
            </li>
          </ul>
        </nav>
      <?php }; ?>
    <?php endif; ?>



    <!-- 資料表 -->

    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">編號<i class="fa-solid fa-caret-down ms-2" onclick="location.href ='<?php if (isset($_GET['state_sid'])) {
                                                                                              echo '?orderby=1&state_sid=' . $_GET['state_sid'] . '&page=' . $page;
                                                                                            } else if (isset($_GET['search'])) {
                                                                                              echo '?orderby=1&search=' . $_GET['search'] . '&page=' . $page;
                                                                                            } else {
                                                                                              echo '?orderby=1';
                                                                                            } ?>'"></i></th>
          <th scope="col">信箱</th>
          <th scope="col">姓名</th>
          <th scope="col">手機</th>
          <th scope="col">地址</th>
          <th scope="col">狀態</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $r) { ?>
          <tr>
            <td><?= $r['sid'] ?></td>
            <td><?= $r['member_email'] ?></td>
            <td><?= $r['member_name'] ?></td>
            <td><?= $r['member_mobile'] ?></td>
            <td><?= $r['member_address_1'] . $r['member_address_2'] . $r['member_address_3'] ?></td>
            <td><?php
                switch ($r['member_state_sid']) {
                  case $state[0]['sid']:
                    echo $state[0]['member_state'];
                    break;
                  case $state[1]['sid']:
                    echo $state[1]['member_state'];
                    break;
                  case $state[2]['sid']:
                    echo $state[2]['member_state'];
                }
                ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>





<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
  //搜尋功能
  const nameSearch = () => {
    let search = form1.search.value;
    location.href = `member-list.php?search=${search}`;

  }
</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>