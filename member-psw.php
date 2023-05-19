<?php
require __DIR__ . '/parts/admin-required.php';

require __DIR__ . '/parts/connect_db.php';


$pageName = 'psw';
$title = '修改密碼';
$pageSid = '5';

//檢查GET參數sid是否有設定
$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

//如果是空字串，轉回列表頁
if (empty($sid)) {
  header('Location: member-list.php');
  exit;
};

$sql = "SELECT * FROM `members` WHERE `sid`=$sid";
$r = $pdo->query($sql)->fetch();  //取得指定sid的資料，是陣列

// 如果在資料庫找不到對應sid的資料，轉回列表頁
if (empty($r)) {
  header('Location: member-list.php');
  exit;
}

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
      <li class="breadcrumb-item active" aria-current="page"><a href="member-list.php">會員管理</a></li>
      <li class="breadcrumb-item active" aria-current="page"><a href="member-edit.php?sid=<?=$sid?>">編輯會員資訊</a></li>
      <li class="breadcrumb-item active" aria-current="page"><?=$title?></li>
    </ol>
  </nav>
  <div class="row">

    <div class="card mt-3">
      <div class="card-body">
        <h4 class="card-title text-center">修改密碼（編號：<?= $sid ?>）</h4>
        <form name="form1" onsubmit="checkForm(event)" novalidate>
          <!-- 用來存放sid的隱藏欄 -->
          <input type="hidden" name="sid" id="sid" value="<?= $r['sid'] ?>">
          <div class="d-flex justify-content-between gap-5">
            <div class="mb-3 w-100">
              <label for="oldpsw" class="form-label">舊密碼</label>
              <input type="password" class="form-control" id="oldpsw" name="oldpsw" placeholder="請輸入目前的密碼" required>
              <div class="form-text"></div>
            </div>
            <div class="mb-3 w-100">
              <label for="password" class="form-label">新密碼</label>
              <input type="password" class="form-control " id="password" name="password" placeholder="請輸入6~20位數新密碼" required>
              <div class="form-text"></div>
            </div>
          </div>

          <button type="submit" class="btn btn-primary d-block mx-auto">送出</button>
        </form>
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
      // el.nextElementSibling.innerHTML = '';
    });


    // 前端資料驗證
    let isPass = true;

    // 驗證舊密碼
    let field1 = document.form1.oldpsw;
    let field2 = document.form1.password;
    if (field1.value.length < 6) {
      isPass = false;
      field1.style.border = '2px solid red';
      field1.nextElementSibling.innerHTML = '請輸入目前的密碼'
    }

    // 驗證新密碼
    if (field2.value.length < 6) {
      isPass = false;
      field2.style.border = '2px solid red';
      field2.nextElementSibling.innerHTML = '請輸入6~20位數新密碼'
    }


    if (isPass) {
      //以AJAX方式送出表單資料
      //FormData是一種沒有外觀的表單資料格式物件
      const fd = new FormData(document.form1);
      //傳送對象是'add-api.php'，傳送方式是POST，傳送內容是fd
      fetch('member-psw-api.php', {
          method: 'POST',
          body: fd
        })
        .then(r => r.json())
        .then(obj => {
          console.log(obj);
          if (obj.success) {
            alert('修改成功!')
            //跳轉頁面:    
            window.location.href = 'member-list.php';

          } else {
            for (v in obj.errors) {
              const field = document.querySelector(`#${v}`);
              field.style.border = '2px solid red';
              // field.closest('.mb-3').querySelector('.form-text').innerHTML = obj.errors[v];
              field.nextElementSibling.innerHTML = obj.errors[v]
            };
          };
        })
    }
  }
</script>

<?php include __DIR__ . '/parts/html-foot.php' ?>