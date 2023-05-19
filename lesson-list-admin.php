<?php
require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin-required.php';
$pageName = 'lesson-list';
$pageSid = '3';

$perPage = 5; // 每一頁最多有幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
  header('Location: ?page=1');
  exit;
}

$t_sql = "SELECT COUNT(1) FROM lesson";
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

  $sql = sprintf("SELECT * FROM `lesson` ORDER BY `sid` DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
  $rows = $pdo->query($sql)->fetchAll();
}

$state_sql = "SELECT * FROM `lesson_category`";
$state = $pdo->query($state_sql)->fetchAll();

$state2_sql = "SELECT * FROM `lesson_teacher`";
$state2 = $pdo->query($state2_sql)->fetchAll();

$state3_sql = "SELECT * FROM `lesson_onsale`";
$state3 = $pdo->query($state3_sql)->fetchAll();

?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/css-style.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>
<?php include __DIR__ . '/parts/sidebars.php' ?>
<div class="container">


  <div class="row mt-3">
    <div class="col">
      <div class="d-flex mb-3 mt-3 justify-content-between">
        <div class="input-group rounded" style="width:350px">
          <input type="search" class="light-table-filter form-control rounded" data-table="order-table" placeholder="請輸入關鍵字" aria-label="Search" aria-describedby="search-addon" />
          <span class="input-group-text border-0" id="search-addon">
            <i class="fas fa-search"></i>
          </span>
        </div>
        <a href="lesson-add.php">
          <button type="button" class="btn btn-primary" style="width:120px;">新增課程</button>
        </a>

      </div>
      <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
          <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $page - 1 ?>">
              <i class="fa-solid fa-circle-arrow-left"></i>
            </a>
          </li>
          <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
            if ($i >= 1 and $i <= $totalPages) :
          ?>
              <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
              </li>
          <?php
            endif;
          endfor; ?>
          <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $page + 1 ?>">
              <i class="fa-solid fa-circle-arrow-right"></i>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
  <table class="table table-striped table-bordered order-table">
    <thead>
      <tr>
        <th scope="col">課程編號</th>
        <th scope="col">課程名稱</th>
        <th scope="col">課程分類</th>
        <th scope="col">課程價格</th>
        <!-- <th scope="col">上架日期</th>
        <th scope="col">下架日期</th> -->
        <th scope="col">課程時數</th>
        <th scope="col">老師</th>
        <!-- <th scope="col">課程資訊</th> -->
        <th scope="col">課程圖片</th>
        <th scope="col">人數上限</th>
        <th scope="col">人數下限</th>
        <th scope="col">上架狀態</th>
        <!-- <th scope="col">建立日期</th> -->
        <!-- <th scope="col">異動日期</th> -->
        <th scope="col">操作</th>
        <th scope="col">詳細資訊</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $r) : ?>
        <tr>
          <td><?= $r['lesson_id'] ?></td>
          <td><?= $r['lesson_name'] ?></td>
          <td><?php
              switch ($r['lesson_category_sid']) {
                case $state[0]['sid']:
                  echo $state[0]['lesson_category'];
                  break;
                case $state[1]['sid']:
                  echo $state[1]['lesson_category'];
                  break;
                case $state[2]['sid']:
                  echo $state[2]['lesson_category'];
              } ?>
          </td>
          <td><?= $r['lesson_price'] ?></td>
          <td><?= $r['lesson_hours'] ?></td>
          <td><?php
              switch ($r['lesson_teacher_sid']) {
                case $state2[0]['sid']:
                  echo $state2[0]['lesson_teacher'];
                  break;
                case $state2[1]['sid']:
                  echo $state2[1]['lesson_teacher'];
                  break;
                case $state2[2]['sid']:
                  echo $state2[2]['lesson_teacher'];
                  break;
                case $state2[3]['sid']:
                  echo $state2[3]['lesson_teacher'];
                  break;
                case $state2[4]['sid']:
                  echo $state2[4]['lesson_teacher'];
              } ?></td>
          <td><img src="/ALL/imgupload/lesson/<?= $r['lesson_img'] ?>" style="width:60px; height:60px;"></td>
          <td><?= $r['lesson_uplimit'] ?></td>

          <td><?= $r['lesson_lowerlimit'] ?></td>
          <td><?php
              switch ($r['lesson_onsale_sid']) {
                case $state3[0]['sid']:
                  echo $state3[0]['lesson_onsale'];
                  break;
                case $state3[1]['sid']:
                  echo $state3[1]['lesson_onsale'];
                  break;
                case $state3[2]['sid']:
                  echo $state3[2]['lesson_onsale'];
                  break;
                case $state3[3]['sid']:
                  echo $state3[3]['lesson_onsale'];
              } ?></td>
          <td>
            <div>
              <a href=" lesson-list-more.php?sid=<?= $r['sid'] ?>">
                <button type="button" class="btn btn-outline-secondary" style="width:120px;">詳細資訊</button>
              </a>
            </div>
          </td>
          <td>
            <a href=" lesson-edit.php?sid=<?= $r['sid'] ?>">
              <i class="fa-solid fa-pen-to-square"></i></a>
            <a href="javascript: delete_it(<?= $r['sid'] ?>)">
              <i class="fa-regular fa-trash-can" style="color: red;"></i></a>
          </td>

        </tr>
      <?php endforeach ?>
    </tbody>

  </table>
</div>
<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
  function delete_it(sid) {
    if (confirm(`是否要刪除?`)) {
      location.href = 'lesson-delete.php?sid=' + sid;
    }
  }
  (function(document) {
    'use strict';

    // 建立 LightTableFilter
    var LightTableFilter = (function(Arr) {

      var _input;

      // 資料輸入事件處理函數
      function _onInputEvent(e) {
        _input = e.target;
        var tables = document.getElementsByClassName(_input.getAttribute('data-table'));
        Arr.forEach.call(tables, function(table) {
          Arr.forEach.call(table.tBodies, function(tbody) {
            Arr.forEach.call(tbody.rows, _filter);
          });
        });
      }
      // 資料篩選函數，顯示包含關鍵字的列，其餘隱藏
      function _filter(row) {
        var text = row.textContent.toLowerCase(),
          val = _input.value.toLowerCase();
        row.style.display = text.indexOf(val) === -1 ? 'none' : 'table-row';
      }
      return {
        // 初始化函數
        init: function() {
          var inputs = document.getElementsByClassName('light-table-filter');
          Arr.forEach.call(inputs, function(input) {
            input.oninput = _onInputEvent;
          });
        }
      };
    })(Array.prototype);
    // 網頁載入完成後，啟動 LightTableFilter
    document.addEventListener('readystatechange', function() {
      if (document.readyState === 'complete') {
        LightTableFilter.init();
      }
    });

  })(document);
</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>