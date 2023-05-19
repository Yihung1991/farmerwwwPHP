<?php
require __DIR__ . '/parts/connect_db.php'; ?>
<?php
$pageSid = 1;
?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/css-style.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>
<?php include __DIR__ . '/parts/sidebars.php' ?>

<div class="w-100 h-100 position-absolute" style="background-image: url('/ALL/imgupload/index/2481769-01.png');background-position: center; background-size: auto; z-index:-1;">
</div>
<div class="container w-75">
    <div class="row">
        <!-- Header-->
        <!-- <div class="text-center my-5">
            <img class="img-fluid rounded-circle mb-4" src="/ALL/imgupload/index/duck.png" style="width:150px;height:150px;">
            <h1 class="text-white fs-3 fw-bolder">小農管理者</h1>
            <h1 class="text-white fs-3 fw-bolder mt-3">嗨，歡迎來到小農樂活管理站</h1>
        </div> -->
        <!-- Page Content-->
        <section class="pt-4">

            <div class="container px-lg-5">
                <!-- Page Features-->
                <div class="row gx-lg-5">
                    <div class="col-lg-6 col-xxl-4 mb-5">
                        <a href="product-list.php" class="a-i">
                            <div class="card bg-light border-0 h-100">
                                <div class="card-body p-4 p-lg-5 pt-0 pt-lg-0 ">
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-5 mt-n4"><i class="bi bi-collection"></i></div>
                                    <h2 class="fs-4 fw-bold">產品管理</h2>
                                    <p class="mb-0">在產品管理專區，您能輕鬆的上架商品、查詢商品資訊，呈現優質的內容。</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-6 col-xxl-4 mb-5">
                        <a href="lesson-list.php" class="a-i">
                            <div class="card bg-light border-0 h-100">
                                <div class="card-body p-4 p-lg-5 pt-0 pt-lg-0">
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-5 mt-n4"><i class="bi bi-cloud-download"></i></div>
                                    <h2 class="fs-4 fw-bold">課程管理</h2>
                                    <p class="mb-0">在課程管理專區，您能輕鬆的上架課程、查詢課程資訊，呈現優質的內容。</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-6 col-xxl-4 mb-5">
                        <a href="myorder.php" class="a-i">
                            <div class="card bg-light border-0 h-100">
                                <div class="card-body p-4 p-lg-5 pt-0 pt-lg-0">
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-5 mt-n4"><i class="bi bi-card-heading"></i></div>
                                    <h2 class="fs-4 fw-bold">訂單管理</h2>
                                    <p class="mb-0">在訂單管理專區，您能查詢訂單、檢視出送貨狀態、即時辦理每個訂單事項。</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-6 col-xxl-4 mb-5">
                        <a href="member-list.php" class="a-i">
                            <div class="card bg-light border-0 h-100">
                                <div class="card-body p-4 p-lg-5 pt-0 pt-lg-0">
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-5 mt-n4"><i class="bi bi-bootstrap"></i></div>
                                    <h2 class="fs-4 fw-bold">會員管理</h2>
                                    <p class="mb-0">在會員管理專區，您能更改會員狀態、新增會員、查看會員資訊，達成企業客戶分析。</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-6 col-xxl-4 mb-5">
                        <a href="coupon-list.php" class="a-i">
                            <div class="card bg-light border-0 h-100">
                                <div class="card-body p-4 p-lg-5 pt-0 pt-lg-0">
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-5 mt-n4"><i class="bi bi-code"></i></div>
                                    <h2 class="fs-4 fw-bold">優惠劵管理</h2>
                                    <p class="mb-0">在優惠劵管理專區，您能新增優惠劵、查看優惠劵使用狀態，檢視行銷成果。</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-6 col-xxl-4 mb-5">
                        <a href="comment-list.php" class="a-i">
                            <div class="card bg-light border-0 h-100">
                                <div class="card-body p-4 p-lg-5 pt-0 pt-lg-0">
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-5 mt-n4"><i class="bi bi-patch-check"></i></div>
                                    <h2 class="fs-4 fw-bold">評論管理</h2>
                                    <p class="mb-0">在評論管理專區，您能檢視每筆評論、管理評論內容、及時回復客戶，與客戶良好的互動。</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<?php include __DIR__ . '/parts/scripts.php' ?>
<?php include __DIR__ . '/parts/html-foot.php' ?>