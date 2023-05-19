<?php
require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin-required.php';

$pageName = 'add';
$title = '新增會員';
$pageSid = '5';

?>


<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/css-style.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>
<?php include __DIR__ . '/parts/sidebars.php' ?>

<div class="container w-75">
  <div class="row">

    <div class="card mt-3">
      <div class="card-body">
        <h4 class="card-title text-center">新增會員</h4>
        <form name="form1" onsubmit="checkForm(event)" novalidate>
          <div class="d-flex justify-content-between gap-5">
            <div class="mb-3 w-100">
              <label for="email" class="form-label">信箱</label>
              <input type="email" class="form-control" id="email" name="email" required>
              <div class="form-text"></div>
            </div>
            <div class="mb-3 w-100">
              <label for="password" class="form-label">密碼</label>
              <input type="password" class="form-control " id="password" name="password" placeholder="請輸入6~20位數密碼" required>
              <div class="form-text"></div>
            </div>
          </div>
          <div class="d-flex justify-content-between gap-5">
            <div class="mb-3 w-100">
              <label for="name" class="form-label">姓名</label>
              <input type="text" class="form-control" id="name" name="name" required>
              <div class="form-text"></div>
            </div>
            <div class="mb-3 w-100">
              <label for="nickname" class="form-label">暱稱</label>
              <input type="text" class="form-control" id="nickname" name="nickname">
              <div class="form-text"></div>
            </div>
            <div class="mb-3 w-100">
              <label for="birthday" class="form-label">生日</label>
              <input type="date" class="form-control" id="birthday" name="birthday">
              <div class="form-text"></div>
            </div>
          </div>
          <div class="d-flex justify-content-between gap-5">
            <div class="w-100">
              <div class="mb-3 w-100">
                <label for="mobile" class="form-label">手機</label>
                <input type="text" class="form-control" id="mobile" name="mobile" pattern="09\d{8}">
                <div class="form-text"></div>
              </div>
              <div class="mb-3 w-100">
                <label for="address" class="form-label">地址</label>
                <div class="d-flex justify-content-between w-50 gap-2 mb-2">
                  <select class="form-select" aria-label="Default select example" id="add1" name="add1" onchange="render_add()"></select>
                  <select class="form-select" aria-label="Default select example" id="add2" name="add2"></select>
                </div>
                <textarea class="form-control" name="address" id="address" cols="50" rows="2"></textarea>
                <div class="form-text"></div>
              </div>
            </div>

            <div class="mb-3 w-100">
              <label for="memberimg" class="form-label d-block">照片</label>
              <div style="border:1px dashed grey; border-radius:20px; width:200px;  height:200px; overflow:hidden; text-align:center;" onclick="memberimg.click()">
                <img id="myImg" src="" alt="" width="100%" style="object-fit:cover;">
                <span classs="w-100" style="line-height:200px; color:gray">上傳照片</span>
              </div>
              <input style="display: none" type="text" name="memberimgname" id="memberimgname" />
              <div class="form-text"></div>
            </div>

          </div>
          <button type="submit" class="btn btn-primary d-block mx-auto">送出</button>



        </form>
        <!-- 隱藏上傳圖片的form -->
        <form name="form2" style="display: none">
          <input type="file" name="memberimg" id="memberimg" accept="image/*" />
        </form>
      </div>
    </div>

  </div>
</div>

<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
  const memberimg = document.form2.memberimg;
  // 當input-memberimg 有變化(上傳圖片)時觸發事件
  memberimg.onchange = function(event) {
    const fd = new FormData(document.form2)
    fetch('upload_memberimg.php', {
      method: 'POST',
      body: fd
    }).then(r => r.json()).then(obj => {
      console.log(obj);
      if (obj.success) {
        myImg.src = '/ALL/imgupload/member/' + obj.filename;
        memberimgname.value = obj.filename;

      }
    })
  }






  const area = ['臺北市', '新北市', '基隆市', '桃園市', '新竹縣', '新竹市', '苗栗縣', '臺中市', '南投縣', '彰化縣', '雲林縣', '嘉義縣', '嘉義市', '臺南市', '高雄市', '屏東縣', '宜蘭縣', '花蓮縣', '臺東縣', '澎湖縣', '金門縣', '連江縣'];

  const area2 = [{
      name: '臺北市',
      children: ['中正區', '大同區', '中山區', '萬華區', '信義區', '松山區', '大安區', '南港區', '北投區', '內湖區', '士林區', '文山區']
    },
    {
      name: '新北市',
      children: [
        '板橋區', '新莊區', '泰山區', '林口區', '淡水區', '金山區', '八里區', '萬里區', '石門區', '三芝區', '瑞芳區', '汐止區', '平溪區', '貢寮區', '雙溪區', '深坑區', '石碇區', '新店區', '坪林區', '烏來區', '中和區', '永和區', '土城區', '三峽區', '樹林區', '鶯歌區', '三重區', '蘆洲區', '五股區'
      ]
    },
    {
      name: '基隆市',
      children: ['仁愛區', '中正區', '信義區', '中山區', '安樂區', '暖暖區', '七堵區']
    },
    {
      name: '桃園市',
      children: [
        '桃園區', '中壢區', '平鎮區', '八德區', '楊梅區', '蘆竹區', '龜山區', '龍潭區', '大溪區', '大園區', '觀音區', '新屋區', '復興區'
      ],
    },
    {
      name: '新竹縣',
      children: [
        '竹北市', '竹東鎮', '新埔鎮', '關西鎮', '峨眉鄉', '寶山鄉', '北埔鄉', '橫山鄉', '芎林鄉', '湖口鄉', '新豐鄉', '尖石鄉', '五峰鄉'
      ],
    },
    {
      name: '新竹市',
      children: [
        '東區', '北區', '香山區'
      ],
    },
    {
      name: '苗栗縣',
      children: [
        '苗栗市', '通霄鎮', '苑裡鎮', '竹南鎮', '頭份鎮', '後龍鎮', '卓蘭鎮', '西湖鄉', '頭屋鄉', '公館鄉', '銅鑼鄉', '三義鄉', '造橋鄉', '三灣鄉', '南庄鄉', '大湖鄉', '獅潭鄉', '泰安鄉'
      ],
    },
    {
      name: '臺中市',
      children: [
        '中區', '東區', '南區', '西區', '北區', '北屯區', '西屯區', '南屯區', '太平區', '大里區', '霧峰區', '烏日區', '豐原區', '后里區', '東勢區', '石岡區', '新社區', '和平區', '神岡區', '潭子區', '大雅區', '大肚區', '龍井區', '沙鹿區', '梧棲區', '清水區', '大甲區', '外埔區', '大安區'
      ],
    },
    {
      name: '南投縣',
      children: [
        '南投市', '埔里鎮', '草屯鎮', '竹山鎮', '集集鎮', '名間鄉', '鹿谷鄉', '中寮鄉', '魚池鄉', '國姓鄉', '水里鄉', '信義鄉', '仁愛鄉'
      ],
    },
    {
      name: '彰化縣',
      children: [
        '彰化市', '員林鎮', '和美鎮', '鹿港鎮', '溪湖鎮', '二林鎮', '田中鎮', '北斗鎮', '花壇鄉', '芬園鄉', '大村鄉', '永靖鄉', '伸港鄉', '線西鄉', '福興鄉', '秀水鄉', '埔心鄉', '埔鹽鄉', '大城鄉', '芳苑鄉', '竹塘鄉', '社頭鄉', '二水鄉', '田尾鄉', '埤頭鄉', '溪州鄉'
      ],
    },
    {
      name: '雲林縣',
      children: [
        '斗六市', '斗南鎮', '虎尾鎮', '西螺鎮', '土庫鎮', '北港鎮', '莿桐鄉', '林內鄉', '古坑鄉', '大埤鄉', '崙背鄉', '二崙鄉', '麥寮鄉', '臺西鄉', '東勢鄉', '褒忠鄉', '四湖鄉', '口湖鄉', '水林鄉', '元長鄉'
      ],
    },
    {
      name: '嘉義縣',
      children: [
        '太保市', '朴子市', '布袋鎮', '大林鎮', '民雄鄉', '溪口鄉', '新港鄉', '六腳鄉', '東石鄉', '義竹鄉', '鹿草鄉', '水上鄉', '中埔鄉', '竹崎鄉', '梅山鄉', '番路鄉', '大埔鄉', '阿里山鄉'
      ],
    },
    {
      name: '嘉義市',
      children: [
        '東區', '西區'
      ],
    },
    {
      name: '臺南市',
      children: [
        '中西區', '東區', '南區', '北區', '安平區', '安南區', '永康區', '歸仁區', '新化區', '左鎮區', '玉井區', '楠西區', '南化區', '仁德區', '關廟區', '龍崎區', '官田區', '麻豆區', '佳里區', '西港區', '七股區', '將軍區', '學甲區', '北門區', '新營區', '後壁區', '白河區', '東山區', '六甲區', '下營區', '柳營區', '鹽水區', '善化區', '大內區', '山上區', '新市區', '安定區'
      ],
    },
    {
      name: '高雄市',
      children: [
        '楠梓區', '左營區', '鼓山區', '三民區', '鹽埕區', '前金區', '新興區', '苓雅區', '前鎮區', '小港區', '旗津區', '鳳山區', '大寮區', '鳥松區', '林園區', '仁武區', '大樹區', '大社區', '岡山區', '路竹區', '橋頭區', '梓官區', '彌陀區', '永安區', '燕巢區', '田寮區', '阿蓮區', '茄萣區', '湖內區', '旗山區', '美濃區', '內門區', '杉林區', '甲仙區', '六龜區', '茂林區', '桃源區', '那瑪夏區'
      ],
    },
    {
      name: '屏東縣',
      children: [
        '屏東市', '潮州鎮', '東港鎮', '恆春鎮', '萬丹鄉', '長治鄉', '麟洛鄉', '九如鄉', '里港鄉', '鹽埔鄉', '高樹鄉', '萬巒鄉', '內埔鄉', '竹田鄉', '新埤鄉', '枋寮鄉', '新園鄉', '崁頂鄉', '林邊鄉', '南州鄉', '佳冬鄉', '琉球鄉', '車城鄉', '滿州鄉', '枋山鄉', '霧台鄉', '瑪家鄉', '泰武鄉', '來義鄉', '春日鄉', '獅子鄉', '牡丹鄉', '三地門鄉'
      ],
    },
    {
      name: '宜蘭縣',
      children: [
        '宜蘭市', '羅東鎮', '蘇澳鎮', '頭城鎮', '礁溪鄉', '壯圍鄉', '員山鄉', '冬山鄉', '五結鄉', '三星鄉', '大同鄉', '南澳鄉'
      ],
    },
    {
      name: '花蓮縣',
      children: [
        '花蓮市', '鳳林鎮', '玉里鎮', '新城鄉', '吉安鄉', '壽豐鄉', '秀林鄉', '光復鄉', '豐濱鄉', '瑞穗鄉', '萬榮鄉', '富里鄉', '卓溪鄉'
      ],
    },
    {
      name: '臺東縣',
      children: [
        '臺東市', '成功鎮', '關山鎮', '長濱鄉', '海端鄉', '池上鄉', '東河鄉', '鹿野鄉', '延平鄉', '卑南鄉', '金峰鄉', '大武鄉', '達仁鄉', '綠島鄉', '蘭嶼鄉', '太麻里鄉'
      ],
    },
    {
      name: '澎湖縣',
      children: [
        '馬公市', '湖西鄉', '白沙鄉', '西嶼鄉', '望安鄉', '七美鄉'
      ],
    },
    {
      name: '金門縣',
      children: [
        '金城鎮', '金湖鎮', '金沙鎮', '金寧鄉', '烈嶼鄉', '烏坵鄉'
      ],
    },
    {
      name: '連江縣',
      children: [
        '南竿鄉', '北竿鄉', '莒光鄉', '東引鄉'
      ]
    },
  ];


  const add1 = document.querySelector("#add1");
  const add2 = document.querySelector("#add2");


  //取得第一層選單的內容
  const add1_info = () => {
    let ar = '';
    for (let i of area) {
      ar += `<option value="${i}">${i}</option>`;
    }
    add1.innerHTML = ar;
  };

  //第二層選單的內容
  const render_add = () => {
    const c1 = add1.value;
    const c1_item = area2.find((el) => {
      return el.name === c1;
    });


    let ar = c1_item.children.map((el) => {
      return `<option value="${el}">${el}</option>`;
    });

    add2.innerHTML = ar.join("");

  };

  //顯示第一層選單
  add1_info();

  //顯示第二層選單
  render_add();



  // 定義手機跟信箱的格式
  const mobile_re = /^09\d{2}-?\d{3}-?\d{3}$/;

  const email_re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zAZ]{2,}))$/;

  const checkForm = (event) => {
    event.preventDefault();

    // 如果輸入正確，欄位外觀恢復原來的樣子
    document.form1.querySelectorAll('input').forEach((el) => {
      el.style.border = '1px solid #CCCCCC';
      el.nextElementSibling.innerHTML = '';
    });

    // 前端資料驗證
    let isPass = true;

    //驗證信箱
    let field = document.form1.email;
    if (!email_re.test(field.value)) {
      isPass = false;
      field.style.border = '2px solid red';
      field.nextElementSibling.innerHTML = '請輸入信箱'
    }


    // 驗證密碼
    field = document.form1.password;
    if (field.value.length < 6) {
      isPass = false;
      field.style.border = '2px solid red';
      field.nextElementSibling.innerHTML = '請輸入6~20位數密碼'
    }

    // 驗證姓名
    field = document.form1.name;
    if (field.value.length < 2) {
      isPass = false;
      field.style.border = '2px solid red';
      field.nextElementSibling.innerHTML = '請輸入完整姓名'
    }



    //驗證手機
    field = document.form1.mobile;
    if (!mobile_re.test(field.value)) {
      isPass = false;
      field.style.border = '2px solid red';
      field.nextElementSibling.innerHTML = '請輸入手機號碼'
    }

    //驗證地址
    field = document.form1.address;
    if (field.value.length < 3) {
      isPass = false;
      field.style.border = '2px solid red';
      field.nextElementSibling.innerHTML = '請輸入詳細地址'
    }


    if (isPass) {
      //以AJAX方式送出表單資料
      //FormData是一種沒有外觀的表單資料格式物件
      const fd = new FormData(document.form1);
      //傳送對象是'add-api.php'，傳送方式是POST，傳送內容是fd
      fetch('member-add-api.php', {
          method: 'POST',
          body: fd
        })
        .then(r => r.json())
        .then(obj => {
          console.log(obj);
          if (obj.success) {
            alert('新增成功!')
            //跳轉頁面
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