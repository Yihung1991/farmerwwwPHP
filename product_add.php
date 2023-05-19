<?php
require __DIR__ . '/parts/connect_db.php';

$pageSid = '1';
$pageName = 'product-add';
$title = '新增產品';

?>


<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/css/product.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>
<?php include __DIR__ . '/parts/sidebars.php' ?>


<div class="container">
  <!-- 麵包屑 -->
  <section class="mt-2">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="product_list-admin.php">產品列表</a></li>
          <li class="breadcrumb-item active" aria-current="page">新增產品</li>
        </ol>
      </nav>

      <section class="mt-2">
        <div class="container w-75 pe-4">
          <div class="product_title shadow w-100">
            新增產品
          </div>
          <div class="card" style="border-radius:0px 0px 5px 5px;">
            <div class="card-body m-0">

              <form id="form1" name="form1" onsubmit="checkForm(event)" novalidate>
                <div class="d-flex flex-wrap">
                  <div class="dropdown mb-3 col-12 pe-2">
                    <label class="form-label">產品名稱</label>
                    <input type="text" class="form-control" id="product_name" name="product_name" required>
                    <div class="form-text"></div>
                  </div>
                  <div class="dropdown mb-3 col-4 pe-2">
                    <label for="brand" class="form-label">品牌</label>
                    <div class="dropdown">
                      <select class="form-select col-12 " aria-label="Default select example" id="product_brand" name="product_brand">
                        <option selected>請選擇</option>

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
                      <select class="form-select col-12" aria-label="Default select example" id="product_category" name="product_category">
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
                      <select class="form-select col-12 " aria-label="Default select example" id="product_state" name="product_state">
                        <option selected>請選擇</option>

                        <?php
                        $ctgsql = ("SELECT * FROM `products_brand_category` where nid = 2");
                        $category = $pdo->query($ctgsql)->fetchAll(); ?>

                        <?php foreach ($category as $c) : ?>
                          <option value="<?= $c['name'] ?>"><?= $c['name'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                  </div>
                  <div class="mb-3 col-4 pe-2">
                    <label for="price" class="form-label">金額</label>
                    <input type="text" class="form-control" id="product_price" name="product_price">
                    <div class="form-text"></div>
                  </div>
                  <div class="mb-3 col-4 pe-2">
                    <label for="publish" class="form-label">上架時間</label>
                    <input type="date" class="form-control" id="product_publish_date" name="product_publish_date" min="<?= date('Y-m-d'); ?>">

                    <div class="form-text"></div>
                  </div>
                  <div class="mb-3 col-4 pe-2">
                    <label for="enddate" class="form-label">下架時間</label>
                    <input type="date" class="form-control" id="product_end_date" name="product_end_date" min="<?= date('Y-m-d'); ?>">
                    <div class="form-text"></div>
                  </div>
                </div>
                <div class="card-body m-0 ps-0 pe-1">
                  <div class="d-flex flex-grow-1 flex-wrap">
                    <div class="mb-3 col-4 pe-2">
                      <label for="productimg" class="form-label d-block">照片</label>
                      <div style="border:1px dashed grey; border-radius:20px;   height:200px; overflow:hidden; text-align:center;" onclick="productimg.click()">
                        <img id="myImg" src="" alt="" width="100%" style="object-fit:cover;">
                        <span classs="w-100" style="line-height:200px; color:gray">上傳照片</span>
                      </div>
                      <input style="display: none" type="text" name="productimgname" id="productimgname" />
                      <div class="form-text"></div>
                    </div>
                    <div class="col-4  pe-2">
                      <p class="p-title" style="margin-bottom: 8px;">產品規格</p>
                      <textarea name="product_spec_introduction" id="product_spec_introduction" rows="10" style="height:200px;width:100%;"></textarea>
                    </div>
                    <div class="col-4  pe-2">
                      <p class="p-title" style="margin-bottom: 8px;">產品設定</p>
                      <textarea name="product_introduction" id="product_introduction" rows="10" style="height:200px;width:100%;"></textarea>
                    </div>

                  </div>
                </div>
                <div class="card-body m-0 w-100 px-0">

                  <button type="submit" class="btn btn-primary d-block mx-auto">送出</button>
              </form>
            </div>

            <!-- 隱藏上傳圖片的form -->
            <form name="form2" style="display: none">
              <input type="file" name="productimg" id="productimg" accept="image/*" />

            </form>
          </div>

        </div>


    </div>

    <?php include __DIR__ . '/parts/scripts.php' ?>
    <script>
      const productimg = document.form2.productimg;
      // 當input-memberimg 有變化(上傳圖片)時觸發事件
      productimg.onchange = function(event) {
        const fd = new FormData(document.form2)
        fetch('upload_productimg.php', {
          method: 'POST',
          body: fd
        }).then(r => r.json()).then(obj => {
          console.log(obj);
          if (obj.success) {
            myImg.src = '/ALL/imgupload/product/' + obj.filename;
            productimgname.value = obj.filename;
          }
        })
      }


      <?php
      if (isset($_POST['get_date'])) {
        echo '<hr>' . 'get_date : ' . $_POST['get_date'];
      }
      ?>


      const checkForm = function(event) {
        event.preventDefault();
        // 欄位外觀回復原來的樣子
        document.form1.querySelectorAll('input').forEach(function(el) {
          el.style.border = '1px solid #CCCCCC';
          el.nextElementSibling.innerHTML = '';
        });


        // TODO: 欄位檢查
        let isPass = true;
        let field = document.form1.product_name;
        if (field.value.length < 2) {
          isPass = false;
          field.style.border = '2px solid red';
          field.nextElementSibling.innerHTML = '請填寫正確的產品名稱，至少2個以上字元。';
        }

        // field = document.form1.email;
        // if (!email_re.test(field.value)) {
        //   isPass = false;
        //   field.style.border = '2px solid red';
        //   field.nextElementSibling.innerHTML = '請填寫正確的 Email 格式';
        // }

        // field = document.form1.mobile;
        // if (!mobile_re.test(field.value)) {
        //   isPass = false;
        //   field.style.border = '2px solid red';
        //   field.nextElementSibling.innerHTML = '請填寫正確的手機號碼';
        // }



        if (isPass) {
          const fd = new FormData(document.form1);
          console.log(fd)
          fetch('product_add-api.php', {
            method: 'POST',
            body: fd,
          }).then(r => r.json()).then(obj => {
            console.log(obj);
            if (obj.success) {
              alert('新增成功');
              // 跳轉到列表頁
              location.href = 'product_list-admin.php';
            } else {
              for (let id in obj.errors) {
                const field = document.querySelector(`#${id}`);
                field.style.border = '2px solid red';
                // field.closest('.mb-3').querySelector('.form-text').innerHTML = obj.errors[id];
                field.nextElementSibling.innerHTML = obj.errors[id];
              }
            }

          })
        }


      };
    </script>
    <?php include __DIR__ . '/parts/html-foot.php' ?>