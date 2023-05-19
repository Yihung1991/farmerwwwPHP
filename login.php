<?php require __DIR__ . '/parts/connect_db.php';

$pageName = 'login';
$title = '登入';

// 如果已經登入，跳轉到首頁
if (isset($_SESSION['admin'])) {
  header('Location: index.php');
  exit;
}

?>


<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/css-style.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>
<?php include __DIR__ . '/parts/sidebars.php' ?>


<div class="container">
  <div class="row justify-content-center align-items-center" style="height:95vh;">
    <div class="col-lg-4">
      <div class="card">
        <div class="card-body text-center">
          <h5 class="card-title">管理者登入</h5>
          <form name="form1" onsubmit="checkForm(event)" novalidate>

            <div class="mb-3">
              <label for="account" class="form-label">帳號</label>
              <input type="text" class="form-control" id="account" name="account" required>
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">密碼</label>
              <input type="password" class="form-control" id="password" name="password" required>
              <div class="form-text"></div>
            </div>
            <button type="submit" class="btn btn-primary">登入</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
  const checkForm = (event) => {
    event.preventDefault();

    // 如果輸入正確，欄位外觀恢復原來的樣子
    document.form1.querySelectorAll('input').forEach((el) => {
      el.style.border = '1px solid #CCCCCC';
      el.nextElementSibling.innerHTML = '';
    });

    // 前端資料驗證
    let isPass = true;


    // 驗證帳號
    let field = document.form1.account;
    if (!field.value.length) {
      isPass = false;
      field.style.border = '2px solid red';
      field.nextElementSibling.innerHTML = '請輸入帳號'
    }

    //驗證密碼
    field = document.form1.password;
    if (!field.value.length) {
      isPass = false;
      field.style.border = '2px solid red';
      field.nextElementSibling.innerHTML = '請輸入密碼'
    }



    if (isPass) {
      const fd = new FormData(document.form1);

      fetch('login-api.php', {
          method: 'POST',
          body: fd
        })
        .then(r => r.json())
        .then(obj => {
          console.log(obj);
          if (obj.success) {
            alert('登入成功!')
            //跳轉頁面   
            window.location.href = 'index.php';
          } else {
            alert('帳密錯誤!')
          };
        })
    }

  }
</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>