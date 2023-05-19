<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<?php
require __DIR__ . '/parts/connect_db.php';
$pageName = 'myorder_members';
$title = '商品訂單詳細資料';


?>
<?php include __DIR__ . '/parts/html-head.php' ?>

<body class="d-flex">
    <main class="d-flex flex-nowrap me-4">
        <h1 class="visually-hidden"></h1>

        <div class="d-flex flex-column p-3 text-bg-dark" style="width: 180px;">
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link text-white" aria-current="page">
                        <svg class="bi pe-none me-2" width="16" height="16">
                            <use xlink:href="#home" />
                        </svg>
                        產品管理
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white">
                        <svg class="bi pe-none me-2" width="16" height="16">
                            <use xlink:href="#speedometer2" />
                        </svg>
                        課程管理
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white active">
                        <svg class="bi pe-none me-2" width="16" height="16">
                            <use xlink:href="#table" />
                        </svg>
                        訂單管理
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white">
                        <svg class="bi pe-none me-2" width="16" height="16">
                            <use xlink:href="#grid" />
                        </svg>
                        會員管理
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white">
                        <svg class="bi pe-none me-2" width="16" height="16">
                            <use xlink:href="#people-circle" />
                        </svg>
                        優惠券管理
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white">
                        <svg class="bi pe-none me-2" width="16" height="16">
                            <use xlink:href="#people-circle" />
                        </svg>
                        客戶評論
                    </a>
                </li>
            </ul>

        </div>

        <div class="b-example-divider b-example-vr">
        </div>
    </main>
    <div>
        <div class="justify-content-center flex-wrap" style="width:80vw">
            <div class="m-3">
                <h2 class="m-3">訂單編號OOOO詳細資料
                    <span class="material-symbols-outlined">edit_square</span>
                </h2>
            </div>
            <div class=" justify-content-center flex-row-reverse" style="width: 100%; height: auto;">
                <div class=" gap-2 d-flex justify-content-between" style="width: auto; height: auto;">
                    <div class="card mb-4" style="width: 30%;">
                        <div id="order_menber_data" class="card-header">
                            收件人資料
                        </div>
                        <div class="card-body gap-5">
                            <div class="d-flex gap-1">
                                <h5 class="card-title">訂購人:</h5>
                                <p class="card-text">王曉明</p>
                            </div>
                            <div class="d-flex gap-1">
                                <h5 class="card-title">送貨地點:</h5>
                                <p class="card-text">台北市大安區忠孝路</p>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4" style="width: 30%;">
                        <div id="order_menber_data" class="card-header">
                            訂單成立與異動
                        </div>
                        <div class="card-body gap-5">
                            <div class="d-flex gap-1">
                                <h5 class="card-title">訂單成立日期:</h5>
                                <p class="card-text">2022-12-12 13:21:05</p>
                            </div>

                            <div class="d-flex gap-1">
                                <h5 class="card-title">訂單異動日期:</h5>
                                <p class="card-text">2022-12-12 13:21:05</p>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4" style="width: 22%;">
                        <div id="order_menber_data" class="card-header">
                            訂單價格結算
                        </div>
                        <div class="card-body d-\\\ gap-5">
                            <div class="d-flex gap-1">
                                <h5 class="card-title">適用優惠券:</h5>
                                <p class="card-text">新會員優惠8折</p>
                            </div>

                            <div class="d-flex gap-1">
                                <h5 class="card-title">訂單總價:</h5>
                                <p class="card-text">800元</p>
                            </div>

                        </div>
                    </div>

                    <div class="card mb-4" style="width: 20%;">
                        <div id="order_menber_data" class="card-header">
                            訂單狀態
                        </div>
                        <div class="card-body d-\\\ gap-5">
                            <div class="d-flex gap-1">
                                <h5 class="card-title">付款狀態:</h5>
                                <p class="card-text">已付款</p>
                            </div>

                            <div class="d-flex gap-1">
                                <h5 class="card-title">運送狀態:</h5>
                                <p class="card-text">運送中</p>
                            </div>

                            <div class="d-flex gap-1">
                                <h5 class="card-title">退款狀態:</h5>
                                <p class="card-text"></p>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div id="order_prodata_data" class="card-header">
                        訂購商品清單
                    </div>
                    <div class="card-product">
                        <table class="table table-striped table-bordered text-center">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">產品名稱</th>
                                    <th scope="col">產品編號</th>
                                    <th scope="col">品牌</th>
                                    <th scope="col">分類</th>
                                    <th scope="col">數量</th>
                                    <th scope="col">價格</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="col">1</th>
                                    <th scope="col">水果</th>
                                    <th scope="col">202212121</th>
                                    <th scope="col">福壽牌</th>
                                    <th scope="col">水果類</th>
                                    <th scope="col">2</th>
                                    <th scope="col">800元</th>
                                    </th>
                                </tr>

                                <tr>
                                    <th scope="col">1</th>
                                    <th scope="col">水果</th>
                                    <th scope="col">202212121</th>
                                    <th scope="col">福壽牌</th>
                                    <th scope="col">水果類</th>
                                    <th scope="col">2</th>
                                    <th scope="col">800元</th>
                                    </th>
                                </tr>
                            </tbody>
                    </div>
                </div>
            </div>
</body>

<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
    function delete_it(sid) {
        if (confirm(`編號為 ${sid} 的胖企鵝要被你刪掉囉! 確定?`)) {
            location.href = 'delete.php?sid=' + sid;
        }
    }
</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
</script>