<?php
require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin-required.php';

$pageName = '發送優惠卷';
$title = '發送優惠卷';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
  header('Location: coupon-list.php'); // 轉向到列表頁
  exit;
}
$pageSid = 6;


$sql = "SELECT * FROM `coupon` WHERE sid=$sid";
$r = $pdo->query($sql)->fetch();
$r_j = json_encode($r, JSON_UNESCAPED_UNICODE);

if (empty($r)) {
  header('Location: coupon-list.php'); // 轉向到列表頁
  exit;
}

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

<div class="flex-column" style="width:95%;padding-top:3%;">
  <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb" class="mt-3 ms-3">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">首頁</a></li>
      <li class="breadcrumb-item active" aria-current="page">優惠劵清單</li>
    </ol>
  </nav>
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title mb-5"><?= $r['coupon_name'] ?></h5>
            <form name="form1" onsubmit="checkForm(event)" novalidate>
              <input type="hidden" name="coupon_sid" value="<?= $r['sid'] ?>">
              <input type="hidden" name="coupon_used" value="2">
              <input type="hidden" name="order_category" value="<?= $r['coupon_category'] ?>">

              <div class="mb-3">
                <label for="giftcate" class="form-label">設置為:</label>
                <input type="radio" id="giftcate1" name="giftcate" value="giftcate1" checked onclick="showSend()">不設置</option>
                <input type="radio" id="giftcate2" name="giftcate" value="giftcate2" onclick="hideSend()">註冊禮</option>
                <input type="radio" id="giftcate3" name="giftcate" value="giftcate3" onclick="hideSend()">生日禮</option>
                <input type="radio" id="giftcate4" name="giftcate" value="giftcate4" onclick="hideSend()">首購禮</option>
                </select>
                <div class="form-text"></div>
              </div>

              <div class="mb-3" id="sendMember" style="display: block">
                <label for="toMember" class="form-label">發送給:</label>
                <div class="mb-3">
                  <input type="radio" id="radio1" name="forMember" value="1" onclick="hideInput()">
                  <label for="radio1" onclick="checkRadio(this)">全館會員</label>
                </div>
                <div class="mb-3">
                  <input type="radio" id="radio2" name="forMember" value="2" onclick="showInput()">
                  <label for="radio2" onclick="checkRadio(this)">指定會員</label>
                </div>
                <div class="form-text"></div>
              </div>
              <div class="mb-3">
                <label for="certainMember" id="cMlabel" class="form-label" style="display: none;">請輸入會員編號:</label>
                <input type="text" id="certainMember" name="certainMember" class="form-control" style="display: none;">
              </div>
              <div class="mb-3">
                <h6>有效時間設置:</h6>
                <label for="sDate">開始時間</label>
                <input type="date" id="sDate" name="sDate">
                <div class="form-text"></div>
              </div>
              <div class="mb-3">
                <label for="eDate">結束時間</label>
                <input type="date" id="eDate" name="eDate">
              </div>
              <button type="submit" class="btn btn-primary">發送</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
  const showSend = () => {
    document.getElementById('sendMember').style.display = 'block';
  }
  const hideSend = () => {
    document.getElementById('sendMember').style.display = 'none';
  }
  const showInput = () => {
    document.getElementById('certainMember').style.display = 'block';
    document.getElementById('cMlabel').style.display = 'block';
  }
  const hideInput = () => {
    document.getElementById('certainMember').style.display = 'none';
    document.getElementById('cMlabel').style.display = 'none';
  }
  const checkRadio = (label) => {
    let radio = document.getElementById(label.htmlFor);
    radio.checked = true;
  }

  const checkForm = function(event) {
    event.preventDefault();
    // 欄位外觀回復原來的樣子
    document.form1.querySelectorAll('input.form-control').forEach(function(el) {
      el.style.border = '1px solid #CCCCCC';
      // el.nextElementSibling.innerHTML = '';
    });


    let isPass = true;

    if (isPass) {
      const fd = new FormData(document.form1);

      fetch('coupon-send-api.php', {
        method: 'POST',
        body: fd,
      }).then(r => r.json()).then(obj => {
        console.log(obj);
        if (obj.success) {
          alert('發送成功');
          // 跳轉到列表頁
        } else {
          for (let id in obj.errors) {}
        }

      })
    }
  };
</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>