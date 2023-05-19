<?php
require __DIR__ . '/parts/connect_db.php';
$pageSid = '2';
$t_sql = "SELECT COUNT(1) FROM products_brand_category,product";
$brand_sql = "SELECT * FROM products_brand_category,product"





?>


<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/css/product.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>
<?php include __DIR__ . '/parts/sidebars.php' ?>
<div class="container position-relative">

  <?php
  $perPage = 10; // 每一頁最多有幾筆
  $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
  if ($page < 1) {
    header('Location: ?page=1');
    exit;
  }


  $brand_sql = "SELECT COUNT(1) FROM products_brand_category WHERE nid =1";

  // 取得總筆數
  $totalRows = $pdo->query($brand_sql)->fetch(PDO::FETCH_NUM)[0];
  // 總頁數
  $totalPages = Ceil($totalRows / $perPage);

  $rows = []; // 資料 預設無資料 設定空陣列
  if ($totalRows > 0) {
    if ($page > $totalPages) {
      header('Location: ?page=' . $totalPages); // 已經取得總頁數，判斷頁數是否超過 若超過則跳轉到最後一頁
      exit;
    }




    $brand_sql = sprintf("SELECT * FROM `products_brand_category`  WHERE nid =1 ORDER BY `sid` DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
    $rows = $pdo->query($brand_sql)->fetchALL(); // 字串要加 " ? "
  }


  ?>

  <?php
  /*刪除資料表內容*/
  if (isset($_POST['delete_staff'])) {
    $id3 = $_POST['delete_id'];
    $query3 = "DELETE FROM `products_brand_category` WHERE staff_id='$id3' ";
    $query_run3 = mysqli_query($con, $query3);
  }
  ?>


  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="product_list-admin.php">產品列表</a></li>
      <li class="breadcrumb-item active" aria-current="page">分類列表</li>
    </ol>
  </nav>
  <section class=" ">
    <!-- 頁碼 -->
    <div class="row">
      <div class="col">
        <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-center">
            <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>"><a class="page-link" href="?page=<?= 1 ?>"><i class="fa-solid fa-angles-left"></i></a></li>
            <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>"><a class="page-link" href="?page=<?= $page - 1 ?>"><i class="fa-solid fa-circle-arrow-left"></i></a></li>
            <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
              if ($i >= 1 and $i <= $totalPages) :
            ?>
                <li class="page-item <?= $page == $i ? 'active' : '' ?>"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
            <?php endif;
            endfor; ?>

            <li class="page-item"><a class="page-link <?= $page == $totalPages ? 'disabled' : '' ?>" href="?page=<?= $page + 1 ?>"><i class="fa-solid fa-circle-arrow-right"></i></a></li>
            <li class="page-item"><a class="page-link <?= $page == $totalPages ? 'disabled' : '' ?>" href="?page=<?= $totalPages ?>"><i class="fa-solid fa-angles-right"></i></a></li>
          </ul>
        </nav>
      </div>
    </div>
    <!-- 資料 -->
    <div class="mt-2">
      <div class="container">
        <div class="product_title shadow">
          品牌列表
          <button class="btn btn-success float-end me-3 my-0 py-0" onclick="location.href ='product_add-brand.php'">新增</button>

        </div>
        <div class="product_content shadow d-flex flex-wrap ps-0 mb-4">

          <table class="table table-striped table-bordered mt-4 text-center">
            <thead>
              <tr>
                <th scope="col">序號</th>
                <th scope="col">分類</th>
                <th scope="col">操作</th>
              </tr>
            </thead>
        </div>
      </div>
      <!-- 資料 -->
      <tbody>

        <?php

        ?>
        <?php foreach ($rows as $key => $r) : ?>
          <td><?= $key + ($page * $perPage) - 9 ?></td>

          <td><?= $r['name'] ?></td>
          <td>
            <a href="product_edit-category.php?sid=<?= $r['sid'] ?>">
              <i class="fa-solid fa-pen-to-square"></i>
            </a>
            &nbsp;
            <a id="<?= $r['sid'] ?>" value="<?= $r['name'] ?> " href="javascript: delete_it(<?= $r['sid'] ?>)">
              <i class="fa-solid fa-trash-can"></i>
            </a>
          </td>
          </td>
          </tr>
        <?php endforeach ?>
      </tbody>
      </table>

    </div>
  </section>
</div>
<?php include __DIR__ . '/parts/html-foot.php' ?>
<?php include __DIR__ . '/parts/scripts.php' ?>

<script>
  let listnum = document.getElementById("listnum");
  listnum => {
    let Table = document.getElementById("listnum");
    let rowsNum = Table.rows.length - 1;
    ID.innerHTML = rowsNum + 1;
  }
</script>

<script>
  function delete_it(sid) {
    let name = document.getElementById(sid).getAttribute('value');
    if (confirm('是否要刪除分類為' + name + '的資料?')) {
      location.href = 'product_delete-category.php?sid=' + sid;
    }
  }
</script>