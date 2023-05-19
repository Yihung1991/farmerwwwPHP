<?php
require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin-required.php';

$pageName = '新增優惠劵';
$title = '新增優惠劵';
$pageSid = 6;
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
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb" class="mt-3 ms-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">首頁</a></li>
        <li class="breadcrumb-item"><a href="coupon-list.php">優惠劵清單</a></li>
        <li class="breadcrumb-item active" aria-current="page">新增優惠卷</li>
      </ol>
    </nav>
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title mb-5">新增優惠卷</h5>
          <form name="form1" onsubmit="checkForm(event)" novalidate>
            <div class="d-flex justify-content-between gap-5 mb-5">
              <div class="mb-3 w-50">
                <label for="a" class="form-label">優惠劵名稱</label>
                <input type="text" class="form-control" name="a" id="name" required>
                <div class="form-text hint" id="form-text" style="display:none;">最多20字</div>
              </div>

              <div class="mb-3 w-50">
                <label for="b" class="form-label">關鍵字</label>
                <input type="text" class="form-control" name="b" id="keywords" required>
                <div class="form-text hint" id="form-text" style="display: none;">最多20字，不可包含特殊符號，例如:@~!、</div>
              </div>
            </div>

            <div class="d-flex gap-5">
              <div class="mb-3 w-30">
                <label for="cate" class="form-label">優惠種類</label>
                <select id="cate" name="cate" onchange="Connect()" class="form-select" aria-label="Default select example">
                  <option value="0">請選擇</option>
                  <option value="1">NTD折抵現金</option>
                  <option value="2">%折扣</option>
                </select>
                <div class="form-text hint" id="form-text" style="display: none;">未選擇種類</div>
              </div>

              <div class="mb-3 q w-40" id="q" style="display: none;">
                <label for="quota" class="quota" class="form-label">折扣額度</label>
                <input type="number" class="form-control quota" name="quota" id="quota" required>
                <div class="form-text hintQ" id="form-text3" style="display: none;">數值最低為1最高10000</div>
              </div>

              <div class="mb-3 w-30">
                <label for="expiry" class="form-label">使用期限(天)</label>
                <input type="numbers" class="form-control" id="expiry" name="expiry" required>
                <div class="form-text hint" id="form-text4" style="display: none;"></div>
              </div>

              <div class="mb-3 w-30">
                <label for="minimum" class="form-label">最低消費門檻</label>
                <input type="numbers" class="form-control" id="minimum" name="minimum" required>
                <div class="form-text hint" id="form-text6" style="display: none;"></div>
              </div>

              <div class="mb-3 w-30">
                <label for="status" class="form-label">優惠券狀態</label>
                <select id="status" name="status" class="form-select" aria-label="Default select example">
                  <option value="1">目前無效</option>
                  <option value="2">目前有效</option>
                </select>
              </div>
            </div>


            <div class="d-flex justify-content-between gap-5">
              <div class="mb-3 w-50">
                <label for="description" class="form-label">內容描述 *限300字內</label>
                <textarea class="form-control" name="description" id="description" cols="50" rows="3" required></textarea>
                <div class="form-text hintQ" id="form-text5" style="display: none;"></div>
              </div>

              <div class="mb-3 w-50">
                <label for="couponimg" class="form-label d-block">照片</label>
                <div style="border:1px dashed grey; border-radius:20px; width:200px;  height:200px; overflow:hidden; text-align:center;" onclick="couponimg.click()">
                  <img id="myImg" src="" alt="" width="100%" style="object-fit:cover;">
                  <span classs="w-100" style="line-height:200px; color:gray">上傳照片</span>
                </div>
                <input style="display: none" type="text" name="couponimgname" id="couponimgname" />
                <div class="form-text"></div>
              </div>
            </div>

            <button type="submit" class="btn btn-primary">新增</button>
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
    const q = document.getElementById("q");
    const qinput = document.getElementById("quota");
    const hintQ = document.getElementById("form-text3");
    if (c === "1") {
      q.style.display = "block";
      qinput.setAttribute("min", "1");
      qinput.setAttribute("max", "10000");
      hintQ.innerHTML = "數值最低為1最高10000";
      //如果value=1，顯示輸入折抵現金的欄位
    } else if (c === "2") {
      q.style.display = "block";
      qinput.setAttribute("min", "10");
      qinput.setAttribute("max", "100");
      hintQ.innerHTML = "數值最低為10最高100";
    } else {
      q.style.display = "none";
    }
  }

  //前端提醒
  const inputField = document.querySelectorAll('input');
  inputField.forEach(function(inputField) {
    inputField.addEventListener('focus', function(event) {
      inputField.nextElementSibling.style.display = 'block';
    });
    inputField.addEventListener('blur', function(event) {
      inputField.nextElementSibling.style.display = 'none';
    });
  });



  const checkForm = function(event) {
    event.preventDefault();
    // 欄位外觀回復原來的樣子
    document.form1.querySelectorAll('input').forEach(function(el) {
      el.style.border = '1px solid #CCCCCC';
      // el.nextElementSibling.innerHTML = '';
    });


    // TODO: 欄位檢查
    let isPass = true;
    let field = document.form1.name;
    if (field.value.length > 20) {
      isPass = false;
      field.style.border = '2px solid red';
      field.nextElementSibling.style.display = 'block';
      field.nextElementSibling.innerHTML = '長度超出20字';
    } else if (field.value == "") {
      isPass = false;
      field.style.border = '2px solid red';
      field.nextElementSibling.style.display = 'block';
      field.nextElementSibling.innerHTML = '未填寫';
    }

    const regex = /^[a-zA-Z0-9 ]*$/;
    field = document.form1.keywords;
    if (field.value.length > 20) {
      isPass = false;
      field.style.border = '2px solid red';
      field.nextElementSibling.style.display = 'block';
      field.nextElementSibling.innerHTML = '長度超出20字';
    } else if (field.value == "") {
      isPass = false;
      field.style.border = '2px solid red';
      field.nextElementSibling.style.display = 'block';
      field.nextElementSibling.innerHTML = '未填寫';
    } else if (!regex.test(field.value)) {
      field.style.border = '2px solid red';
      field.nextElementSibling.style.display = 'block';
      field.nextElementSibling.innerHTML = '不可包含@,~!#等特殊符號';
    }

    field = document.form1.cate;
    if (field.value == 0) {
      isPass = false;
      field.style.border = '2px solid red';
      field.nextElementSibling.style.display = 'block';
    }

    field = document.form1.quota;
    const quotaInput = document.getElementById('quota');
    const min = quotaInput.getAttribute('min');
    const max = quotaInput.getAttribute('max');
    console.log(min);
    if (min !== null && max !== null && quotaInput.value < min || quotaInput.value > max) {
      isPass = false;
      field.style.border = '2px solid red';
      field.nextElementSibling.style.display = 'block';
      field.nextElementSibling.innerHTML = '輸入的數值必須在 ' + min + ' 和 ' + max + ' 之間';
    } else if (field.value = "") {
      isPass = false;
      field.style.border = '2px solid red';
      field.nextElementSibling.style.display = 'block';
      field.nextElementSibling.innerHTML = '未填寫';
    }

    field = document.form1.expiry;
    if (field.value == "") {
      isPass = false;
      field.style.border = '2px solid red';
      field.nextElementSibling.style.display = 'block';
      field.nextElementSibling.innerHTML = '未填寫';
    }

    field = document.form1.description;
    if (field.value.length > 300) {
      isPass = false;
      field.style.border = '2px solid red';
      field.nextElementSibling.style.display = 'block';
      field.nextElementSibling.innerHTML = '長度超出300字';
    } else if (field.value == "") {
      isPass = false;
      field.style.border = '2px solid red';
      field.nextElementSibling.style.display = 'block';
      field.nextElementSibling.innerHTML = '未填寫';
    }

    field = document.form1.minimum;
    if (field.value == "") {
      isPass = false;
      field.style.border = '2px solid red';
      field.nextElementSibling.style.display = 'block';
      field.nextElementSibling.innerHTML = '未填寫';
    }

    if (isPass) {
      const fd = new FormData(document.form1);

      fetch('coupon-add-api.php', {
        method: 'POST',
        body: fd,
      }).then(r => r.json()).then(obj => {
        console.log(obj);
        if (obj.success) {
          document.form1.querySelectorAll('input').forEach(function(el) {
            el.style.border = '1px solid #CCCCCC';
            // el.nextElementSibling.innerHTML = '';
          })
          window.alert('新增成功');
          window.location.href = 'coupon-list.php';
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
  }
</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>