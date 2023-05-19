<?php

require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin-required.php';
$pageName = 'add';
$title = '新增課程';
$pageSid = '3';


?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<style>
  .form-text {
    color: red;
  }
</style>
<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/css-style.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>
<?php include __DIR__ . '/parts/sidebars.php' ?>

<div class="container">
  <div class="row mt-3">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">新增資料</h5>
          <form class="row g-3" name="form1" onsubmit="checkForm(event)" novalidate>


            <div class="col-md-3">
              <label for="lesson_id" class="form-label">課程編號</label>
              <input class="form-control" id="lesson_id" name="lesson_id" required>
              <div class="form-text"></div>
            </div>

            <div class="col-md-3">
              <label for="lesson_name" class="form-label">課程名稱</label>
              <input type="text" class="form-control" id="lesson_name" name="lesson_name" required>
              <div class="form-text"></div>
            </div>

            <div class="col-md-3">
              <label for="lesson_category_sid" class="form-label">課程分類</label>
              <select class="form-select" aria-label="Default select example" name="lesson_category_sid">
                <option selected>請選擇</option>
                <option value="1">烹飪</option>
                <option value="2">手工</option>
                <option value="3">戶外體驗</option>
              </select>
              <div class="form-text"></div>
            </div>

            <div class="col-md-3">
              <label for="lesson_price" class="form-label">課程價格</label>
              <input type="number" class="form-control" id="lesson_price" name="lesson_price" required>
              <div class="form-text"></div>
            </div>

            <div class="col-md-3">
              <label for="lesson_publish_date" class="form-label">開課日期</label>
              <input type="datetime-local" class="form-control" id="lesson_publish_date" name="lesson_publish_date" required>
              <div class="form-text"></div>
            </div>

            <!-- <div class="col-md-3">
              <label for="lesson_end_date" class="form-label">下架日期</label>
              <input type="datetime-local" class="form-control" id="lesson_end_date" name="lesson_end_date" required>
              <div class="form-text"></div>
            </div> -->

            <div class="col-md-3">
              <label for="lesson_hours" class="form-label">課程時數</label>
              <input type="number" class="form-control" id="lesson_hours" name="lesson_hours" required>
              <div class="form-text"></div>
            </div>


            <div class="col-md-3">
              <label for="lesson_teacher_sid" class="form-label">老師</label>
              <select class="form-select" aria-label="Default select example" name="lesson_teacher_sid">
                <option selected>請選擇</option>
                <option value="1">李小名</option>
                <option value="2">王春風</option>
                <option value="3">陳美麗</option>
                <option value="4">林又加</option>
                <option value="5">郭大俠</option>
              </select>
              <div class="form-text"></div>
            </div>

            <div class="col-md-6">
              <label for="lesson_information" class="form-label">課程資訊</label>
              <textarea class="form-control" name="lesson_information" id="lesson_information" cols="50" rows="3"></textarea>
              <div class="form-text"></div>
            </div>

            <div class="col-md-6">
              <label for="" class="form-label">課程照片</label>
              <div class="btn btn-primary d-block" style="width:20%;" onclick="avatar.click()">上傳</div>
              <img id="myimg" src="" alt="" width="300px">
              <input style="display: none;" type="text" name="memberimgname" id="memberimgname" />
              <div class="form-text"></div>
            </div>

            <div class="col-md-4">
              <label for="lesson_uplimit" class="form-label">人數上限</label>
              <input type="number" class="form-control" id="lesson_uplimit" name="lesson_uplimit" required>
              <div class="form-text"></div>
            </div>

            <div class="col-md-4">
              <label for="lesson_lowerlimit" class="form-label">人數下限</label>
              <input type="number" class="form-control" id="lesson_lowerlimit" name="lesson_lowerlimit" required>
              <div class="form-text"></div>
            </div>

            <div class="col-md-4">
              <label for="lesson_onsale" class="form-label">上架狀態</label>
              <select class="form-select" aria-label="Default select example" name="lesson_onsale_sid">
                <option selected>請選擇</option>
                <option value="1">開放報名</option>
                <option value="2">人數額滿</option>
                <option value="3">課程取消</option>
                <option value="4">課程結束</option>
              </select>
              <div class="form-text"></div>
            </div>

            <div class="col-12">
              <button type="submit" class="btn btn-primary">新增</button>
            </div>

          </form>
          <form name="form2" style="display: none;">
            <input type="file" name="avatar" accept="image/*" />
          </form>

        </div>
      </div>

    </div>
  </div>
</div>
<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
  const avatar = document.form2.avatar;
  avatar.onchange = function(event) {
    const fd = new FormData(document.form2);

    fetch('lesson-upload-single.php', {
      method: 'POST',
      body: fd
    }).then(r => r.json()).then(obj => {
      console.log(obj);
      if (obj.success) {
        myimg.src = '/ALL/imgupload/lesson/' + obj.filename;
        memberimgname.value = obj.filename;
      }
    })
  };

  // const mobile_re = /^09\d{2}-?\d{3}-?\d{3}$/;

  // const email_re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zAZ]{2,}))$/;

  const checkForm = function(event) {
    event.preventDefault();
    // 欄位外觀回復原來的樣子


    // document.form1.querySelectorAll('input').forEach(function(el) {
    //   el.style.border = '1px solid #CCCCCC';
    //   el.nextElementSibling.innerHTML = '';
    // });


    // TODO: 欄位檢查
    // let isPass = true;
    // let field = document.form1.name;
    // if (field.value.length < 2) {
    //   isPass = false;
    //   field.style.border = '2px solid red';
    //   field.nextElementSibling.innerHTML = '請填寫正確的姓名';
    // }

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

    const fd = new FormData(document.form1);

    fetch('lesson-add-api.php', {
      method: 'POST',
      body: fd,
    }).then(r => r.json()).then(obj => {
      console.log(obj);

      if (obj.success) {
        alert('新增成功');
        // 跳轉到列表頁
        window.location.href = 'lesson-list.php';
      } else {
        for (let id in obj.errors) {
          const field = document.querySelector(`#${id}`);
          field.style.border = '2px solid red';
          // field.closest('.mb-3').querySelector('.form-text').innerHTML = obj.errors[id];
          field.nextElementSibling.innerHTML = obj.errors[id];
        }
      }

    })




  };
</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>