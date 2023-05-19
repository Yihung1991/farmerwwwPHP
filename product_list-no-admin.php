<?php

require __DIR__ . '/parts/connect_db.php';
$pageSid = '2';
$t_sql = "SELECT COUNT(1) FROM products_brand_category,product";
$brand_sql = "SELECT * FROM products_brand_category,product";
?>


<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/css/product.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>
<?php include __DIR__ . '/parts/sidebars.php' ?>
<div class="container position-relative">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">產品列表</li>
    </ol>
  </nav>
  <section class="mt-2 mb-4 visually-hidden">
    <div class="container">
      <div class="product_title shadow">
        產品管理
      </div>
      <div class="product_content shadow d-flex flex-wrap ">
        <div class="dropdown mb-3 col-4 pe-2 visually-hidden">
          <label for="brand" class="form-label">品牌</label>
          <div class="dropdown">
            <select class="form-select col-12" aria-label="Default select example" id="product_brand" name="product_brand" disabled>
              <option value="" selected>請選擇</option>

              <?php
              $ctgsql = ("SELECT * FROM `products_brand_category` where nid = 0");
              $category = $pdo->query($ctgsql)->fetchAll(); ?>

              <?php foreach ($category as $c) : ?>
                <option value="<?= $c['name'] ?>"><?= $c['name'] ?></option>
              <?php endforeach ?>
            </select>
          </div>
        </div>


        <div class="dropdown mb-3 col-4 pe-2">
          <label for="category" class="form-label">分類</label>
          <div class="dropdown">
            <select class="form-select col-12" aria-label="Default select example" id="product_category" name="product_category" disabled>
              <option value="" selected>請選擇</option>

              <?php
              $ctgsql = ("SELECT * FROM `products_brand_category` where nid = 1");
              $category = $pdo->query($ctgsql)->fetchAll(); ?>

              <?php foreach ($category as $c) : ?>
                <option value="<?= $c['name'] ?>"><?= $c['name'] ?></option>
              <?php endforeach ?>
            </select>
          </div>
        </div>
        <div class="dropdown mb-3 col-4 pe-2">
          <label for="state" class="form-label">狀態</label>
          <div class="dropdown">
            <select class="form-select col-12" aria-label="Default select example" id="product_state" name="product_state" disabled>
              <option value="" selected>請選擇</option>

              <?php
              $ctgsql = ("SELECT * FROM `products_brand_category` where nid = 2");
              $category = $pdo->query($ctgsql)->fetchAll(); ?>

              <?php foreach ($category as $c) : ?>
                <option value="<?= $c['name'] ?>"><?= $c['name'] ?></option>
              <?php endforeach ?>
            </select>
          </div>
        </div>
        <div class="dropdown mb-3 col-4 pe-2">
          <label class="form-label">產品名稱</label>
          <input type="text" class="form-control" id="product_name" name="product_name" required placeholder="請輸入產品名稱或編號" disabled>
          <div class="form-text"></div>
        </div>

        <div class="mb-3 col-4 pe-2 visually-hidden">
          <label for="publish" class="form-label">上架時間</label>
          <input type="date" class="form-control" id="product_publish_date" name="product_publish_date" disabled>

          <div class="form-text"></div>
        </div>
        <div class="mb-3 col-4 pe-2 visually-hidden">
          <label for="publish" class="form-label">下架時間</label>
          <input type="date" class="form-control" id="product_publish_date" name="product_publish_date" disabled>

          <div class="form-text"></div>
        </div>

        <div>
          <button type="button" class="btn btn-secondary" disabled>重置</button>


          <button type="button" class="btn btn-primary ms-2" disabled>搜尋</button>
        </div>
      </div>
    </div>
  </section>
  <?php
  $perPage = 10; // 每一頁最多有幾筆
  $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
  if ($page < 1) {
    header('Location: ?page=1');
    exit;
  }


  $t_sql = "SELECT COUNT(1) FROM product";

  // 取得總筆數
  $totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
  // 總頁數
  $totalPages = Ceil($totalRows / $perPage);

  $rows = []; // 資料 預設無資料 設定空陣列
  if ($totalRows > 0) {
    if ($page > $totalPages) {
      header('Location: ?page=' . $totalPages); // 已經取得總頁數，判斷頁數是否超過 若超過則跳轉到最後一頁
      exit;
    }




    $sql = sprintf("SELECT * FROM `product` ORDER BY `sid` DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
    $rows = $pdo->query($sql)->fetchALL(); // 字串要加 " ? "
  }


  ?>

  <?php
  /*刪除資料表內容*/
  if (isset($_POST['delete_staff'])) {
    $id2 = $_POST['delete_id'];
    $query2 = "DELETE FROM `product` WHERE staff_id='$id2' ";
    $query_run2 = mysqli_query($con, $query2);
  }
  ?>



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
          產品列表
        </div>
        <div class="product_content shadow d-flex flex-wrap ps-0 mb-4">

          <table class="table table-striped table-bordered mt-4 text-center">

            <thead>
              <tr>
                <th scope="col">序號</th>
                <th scope="col">產品名稱</th>
                <th scope="col">產品編號</th>
                <th scope="col">品牌</th>
                <th scope="col">分類</th>
                <th scope="col">狀態</th>
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

          <td><?= $r['product_name'] ?></td>
          <td><?= $r['product_id'] ?></td>
          <td><?= $r['product_brand'] ?></td>
          <td><?= $r['product_category'] ?></td>
          <td><?= $r['product_state'] ?></td>
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