<?php
require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin-required.php';

$pageName = '修改優惠劵';
$title = '修改優惠劵';
$pageSid = 6;


$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
  header('Location: coupon-list.php'); // 轉向到列表頁
  exit;
}

$sql = "SELECT * FROM `coupon` WHERE sid=$sid";
$r = $pdo->query($sql)->fetch();
$r_j = json_encode($r, JSON_UNESCAPED_UNICODE);

if (empty($r)) {
  header('Location: coupon-list.php'); // 轉向到列表頁
  exit;
}

$cate_sql = "SELECT * FROM `coupon_category`";
$cate = $pdo->query($cate_sql)->fetchAll();
$cate_j = json_encode($cate, JSON_UNESCAPED_UNICODE);

$status_sql = "SELECT * FROM `coupon_status`";
$status = $pdo->query($status_sql)->fetchAll();
$status_j = json_encode($status, JSON_UNESCAPED_UNICODE);
// echo $status_j;


?>



<?php include __DIR__ . '/parts/html-head.php' ?>
<style>
  .form-text {
    color: red;
  }
</style>
<?php include __DIR__ . '/parts/css-style.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>
<?php include __DIR__ . '/parts/sidebars.php' ?>


<div class="container w-75">
  <div class="row">
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb" class="mt-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">首頁</a></li>
        <li class="breadcrumb-item"><a href="coupon-list.php">優惠劵管理</a></li>
        <li class="breadcrumb-item active" aria-current="page">修改優惠劵</li>
      </ol>
    </nav>
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">修改優惠卷</h5>
          <form name="form1" onsubmit="checkForm(event)" novalidate>
            <input type="hidden" name="sid" value="<?= $r['sid'] ?>">
            <div class="d-flex justify-content-between gap-5 mb-5">

              <div class="mb-3 w-50">
                <label for="a" class="form-label">優惠劵名稱</label>
                <input type="text" class="form-control" name="a" id="name" required value="<?= htmlentities($r['coupon_name']) ?>">
                <div class="form-text hint" id="form-text" style="display:none;">最多20字</div>
              </div>

              <div class="mb-3 w-50">
                <label for="b" class="form-label">關鍵字</label>
                <input type="text" class="form-control" name="b" id="keywords" required value="<?= htmlentities($r['coupon_keywords']) ?>">
                <div class="form-text hint" id="form-text" style="display: none;">最多20字，不可包含特殊符號，例如:@~!、</div>
              </div>
            </div>

            <div class="d-flex gap-3 align-items-center">
              <div class="mb-3 w-30">
                <label for="cate" class="form-label">優惠種類</label>
                <select class="form-select" select id="cate" name="cate" onchange="Connect()">
                </select>
                <div class="form-text hint" id="form-text" style="display: none;">未選擇種類</div>
              </div>

              <div class="mb-3 q w-40" id="q">
                <label for="quota" class="quota" class="form-label">折扣額度</label>
                <input type="number" class="form-control quota" name="quota" id="quota" required value="<?= htmlentities($r['coupon_quota']) ?>">
                <div class="form-text hintQ" id="form-text3" style="display: none;">數值最低為1最高10000</div>
              </div>

              <div class="mb-3 w-30">
                <label for="expiry" class="form-label">使用期限(天)</label>
                <input type="numbers" class="form-control" id="expiry" name="expiry" required value="<?= htmlentities($r['coupon_quota']) ?>">
                <div class="form-text hint" id="form-text4" style="display: none;"></div>
              </div>

              <div class="mb-3 w-30">
                <label for="minimum" class="form-label">最低消費門檻</label>
                <input type="numbers" class="form-control" id="minimum" name="minimum" required value="<?= htmlentities($r['coupon_minimum']) ?>">
                <div class="form-text hint" id="form-text6" style="display: none;"></div>
              </div>

              <div class="mb-3 w-30">
                <label for="lesson_category_sid" class="form-label">優惠劵狀態</label>
                <select class="form-select" aria-label="Default select example" id="lesson_category_sid" name="status">
                </select>
              </div>

            </div>

            <div class="d-flex justify-content-between gap-5">
              <div class="mb-3 w-50">
                <label for="description" class="form-label">內容描述 *限300字內</label>
                <textarea class="form-control" name="description" id="description" cols="50" rows="3"><?= htmlentities($r['coupon_discription']) ?></textarea>
                <div class="form-text"></div>
              </div>

              <div class="mb-3 w-50">
                <label for="couponimg" class="form-label d-block">照片</label>
                <div style="border:1px dashed grey; border-radius:20px; width:200px;  height:200px; overflow:hidden; text-align:center; object-fit:cover;" onclick="couponimg.click()">
                  <img id="myImg" src="/ALL/imgupload/coupon/<?= $r['coupon_img'] ?>" alt="" width="100%" style="object-fit:cover;">
                  <span classs="w-100" style="line-height:200px; color:gray">上傳照片</span>
                </div>
                <input style="display: none" type="text" name="couponimgname" id="couponimgname" value="<?= $r['coupon_img'] ?>" />
                <div class="form-text"></div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">修改</button>
        </div>
        </form>
        <!-- 隱藏上傳圖片的form -->
        <form name="form2" style="display: none">
          <input type="file" name="couponimg" id="couponimg" accept="image/*" />
        </form>
      </div>
    </div>
  </div>
</div>
</div>
</div>
<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
  const couponimg = document.form2.couponimg;
  // 當input-memberimg 有變化(上傳圖片)時觸發事件
  couponimg.onchange = function(event) {
    const fd = new FormData(document.form2)
    fetch('coupon-img-upload.php', {
      method: 'POST',
      body: fd
    }).then(r => r.json()).then(obj => {
      console.log(obj);
      if (obj.success) {
        myImg.src = '/ALL/imgupload/coupon/' + obj.filename;
        couponimgname.value = obj.filename;

      }
    })
  }
  const Connect = () => {
    const c = cate.value;
    const qinput = document.getElementById("quota");
    if (c === "1") {
      qinput.setAttribute("min", "10");
      qinput.setAttribute("max", "100");
      //如果value=1，顯示輸入折抵現金的欄位
    } else {
      qinput.setAttribute("min", "1");
      qinput.setAttribute("max", "10000");
    }
  }


  const r = <?= $r_j ?>;
  const ar_cate = <?= $cate_j ?>;
  const cate_info = () => {

    let ar1 = '';
    for (let i of ar_cate) {
      ar1 += `<option id="cate${i.sid}" value="${i.sid}">${i.coupon_category}</option>`;
      console.log(ar1);
    }
    cate.innerHTML = ar1;
    let op1 = document.querySelector('#cate<?= $r['coupon_category'] ?>');
    console.log(op1);
    op1.setAttribute("selected", "selected");
  };
  cate_info();


  const ar_category = <?= $status_j ?>;
  const category_info = () => {
    let ar = '';
    for (let i of ar_category) {
      ar += `<option id="sid${i.sid}" value="${i.sid}">${i.coupon_status}</option>`;
    }
    lesson_category_sid.innerHTML = ar;
    let op = document.querySelector('#sid<?= $r['coupon_status'] ?>')
    op.setAttribute("selected", "selected")
  };
  category_info();




  const checkForm = function(event) {
    event.preventDefault();
    // 欄位外觀回復原來的樣子
    document.form1.querySelectorAll('input.form-control').forEach(function(el) {
      el.style.border = '1px solid #CCCCCC';
      el.nextElementSibling.innerHTML = '';
    });


    let isPass = true;

    if (isPass) {
      const fd = new FormData(document.form1);

      fetch('coupon-edit-api.php', {
        method: 'POST',
        body: fd,
      }).then(r => r.json()).then(obj => {
        console.log(obj);
        if (obj.success) {
          alert('修改成功');
          // 跳轉到列表頁
        } else {
          for (let id in obj.errors) {}
        }

      })
    }
  };
</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>