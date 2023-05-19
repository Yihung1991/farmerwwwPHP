<?php
require __DIR__ . '/parts/connect_db.php';

require __DIR__ . '/parts/admin-required.php';

$pageName = 'list_more';
$title = '會員詳細資訊';
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
      <li class="breadcrumb-item active" aria-current="page"><?=$title?></li>
    </ol>
  </nav>
  <div class="row">

    <div class="card mt-3">
      <div class="card-body">
        <h4 class="card-title text-center">會員詳細資訊（編號：<?= $sid ?>）</h4>
        <form name="form1">
          <div class="d-flex justify-content-between gap-5">
            <div class="mb-3 w-100">
              <label for="email" class="form-label">信箱</label>
              <input type="email" class="form-control" id="email" name="email" value="<?= $r['member_email'] ?>" disabled>
              <div class="form-text"></div>
            </div>
            <div class="mb-3 w-100">
              <label for="password" class="form-label">密碼</label>
              <input type="password" class="form-control " id="password" name="password" value="<?= $r['member_password_hash'] ?>" disabled>
              <div class="form-text"></div>
            </div>
          </div>
          <div class="d-flex justify-content-between gap-5">
            <div class="mb-3 w-100">
              <label for="name" class="form-label">姓名</label>
              <input type="text" class="form-control" id="name" name="name" value="<?= $r['member_name'] ?>" disabled>
              <div class="form-text"></div>
            </div>
            <div class="mb-3 w-100">
              <label for="nickname" class="form-label">暱稱</label>
              <input type="text" class="form-control" id="nickname" name="nickname" value="<?= $r['member_nickname'] ?>" disabled>
              <div class="form-text"></div>
            </div>
            <div class="mb-3 w-100">
              <label for="birthday" class="form-label">生日</label>
              <input type="date" class="form-control" id="birthday" name="birthday" value="<?= $r['member_birthday'] ?>" disabled>
              <div class="form-text"></div>
            </div>
          </div>
          <div class="d-flex justify-content-between gap-5">
            <div class="w-100">
              <div class="mb-3 w-100">
                <label for="mobile" class="form-label">手機</label>
                <input type="text" class="form-control" id="mobile" name="mobile" value="<?= $r['member_mobile'] ?>" disabled>
                <div class="form-text"></div>
              </div>
              <div class="mb-3 w-100">
                <label for="address" class="form-label">地址</label>
                <div class="d-flex justify-content-between w-75 gap-2 mb-3">
                  <select class="form-select" aria-label="Default select example" id="add1" name="add1" disabled>
                    <option><?= $r['member_address_1'] ?></option>
                  </select>
                  <select class="form-select" aria-label="Default select example" id="add2" name="add2" disabled>
                    <option><?= $r['member_address_2'] ?></option>
                  </select>
                </div>
                <textarea class="form-control" name="address" id="address" cols="50" rows="2" disabled><?= $r['member_address_3'] ?></textarea>
                <div class="form-text"></div>
              </div>
            </div>
            <div class="w-100">
              <div class="mb-3">
                <label for="member_state" class="form-label">會員狀態</label>
                <select class="form-select" aria-label="Default select example" id="member_state" name="member_state" disabled>
                  <option><?php
                          switch ($r['member_state_sid']) {
                            case $state[0]['sid']:
                              echo $state[0]['member_state'];
                              break;
                            case $state[1]['sid']:
                              echo $state[1]['member_state'];
                              break;
                            case $state[2]['sid']:
                              echo $state[2]['member_state'];
                          } ?></option>
                </select>
              </div>
              <div class="mb-3 w-100">
                <label for="member_publish" class="form-label">註冊時間</label>
                <input type="text" class="form-control" id="member_publish" name="member_publish" value="<?= $r['member_publish_date'] ?>" disabled>
              </div>
              <div class="mb-3 w-100">
                <label for="member_update" class="form-label">異動時間</label>
                <input type="text" class="form-control" id="member_update" name="member_update" value="<?= $r['member_update_date'] ?>" disabled>
              </div>
            </div>

            <div class="mb-3 w-100">
              <label for="memberimg" class="form-label d-block">照片</label>
              <div style="border:1px dashed grey; border-radius:20px; width:200px;  height:200px; overflow:hidden; text-align:center;" onclick="memberimg.click()">
                <img id="myImg" src="/ALL/imgupload/member/<?= $r['member_img'] ?>" alt="" width="100%" style="object-fit:cover;">
                <span classs="w-100" style="line-height:200px; color:gray">沒有照片</span>
              </div>
              <input style="display: none" type="text" name="memberimgname" id="memberimgname" />
              <div class="form-text"></div>
            </div>


          </div>
        </form>
        <div class="d-flex justify-content-center">
          <button type="submit" class="btn btn-secondary d-block mx-auto" onclick="location.href ='member-list.php'">返回會員清單</button>
          <button type="submit" class="btn btn-warning d-block mx-auto" onclick="location.href ='member-comment.php?sid=<?= $sid ?>'">顯示會員評論</button>
          <button type="submit" class="btn btn-danger d-block mx-auto" onclick="location.href ='javascript: delet_it(<?= $r['sid'] ?>)'">永久刪除會員</button>
          <button type="submit" class="btn btn-primary d-block mx-auto" onclick="location.href ='member-edit.php?sid=<?= $sid ?>'">修改會員資料</button>

        </div>
      </div>
    </div>

  </div>
</div>

<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
  const delet_it = (sid) => {
    if (confirm(`是否要永久刪除編號${sid}的會員資料？`)) {
      location.href = 'member-delete.php?sid=' + sid;
    };
  }
</script>

<?php include __DIR__ . '/parts/html-foot.php' ?>