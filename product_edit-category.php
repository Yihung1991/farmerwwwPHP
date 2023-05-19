<?php
require __DIR__ . '/parts/connect_db.php';

$pageSid = '2';
$pageName = 'category-edit';
$title = '修改品牌';


$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
    header('Location: product_list.php'); // 轉向到列表頁
    exit;
}

$sql = "SELECT * FROM products_brand_category WHERE sid = $sid";
$r = $pdo->query($sql)->fetch(); // 轉向到列表頁
if (empty($r)) {
    header('Location:product_list.php');
}

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
          <li class="breadcrumb-item active" aria-current="page">修改分類</li>
        </ol>
      </nav>

      <section class="mt-2">
        <div class="container w-50 pe-4">
          <div class="product_title shadow w-100">
            修改品牌
          </div>
          <div class="card" style="border-radius:0px 0px 5px 5px;">
            <div class="card-body m-0">

              <form id="form1" name="form1" onsubmit="checkForm(event)" novalidate>
                <div class="d-flex ">
                  <div class="dropdown mb-3 col-12 pe-2">
                    <label class="form-label">品牌名稱</label>
                    <input type="hidden" class="form-control" id="sid" name="sid"value="<?= $r['sid'] ?>">
                    <input type="hidden" class="form-control" id="nid" name="nid"value="1">
                    <input type="text" class="form-control" id="name" name="name"  value="<?= $r['name'] ?>" required>
                    <div class="form-text"></div>
                    <button type="submit" class="btn btn-primary d-block m-auto mt-3">修改</button>
                  </div>
              </form>
            </div>


          </div>

        </div>


    </div>







    <?php include __DIR__ . '/parts/scripts.php' ?>
    <script>
      const checkForm = function(event) {
        event.preventDefault();
        // 欄位外觀回復原來的樣子
        document.form1.querySelectorAll('input').forEach(function(el) {
          el.style.border = '1px solid #CCCCCC';
          el.nextElementSibling.innerHTML = '';
        });


        // TODO: 欄位檢查
        let isPass = true;
        let field = document.form1.name;
        if (field.value.length < 2) {
          isPass = false;
          field.style.border = '2px solid red';
          field.nextElementSibling.innerHTML = '請填寫正確的品牌名稱，至少2個以上字元。';
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
          fetch('product_edit-brand-api.php', {
            method: 'POST',
            body: fd,
          }).then(r => r.json()).then(obj => {
            console.log(obj);
            if (obj.success) {
              alert('修改成功');
              // 跳轉到列表頁
              location.href = 'product_list-category.php';
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