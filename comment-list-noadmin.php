<?php
require __DIR__ . '/parts/connect_db.php';
$pageName = 'list';
$title = '評論區';
$pageSid = '7';
$perPage = 5; // 每一頁最多有幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header('Location: ?page=1');
    exit;
}

$t_sql = "SELECT COUNT(1) FROM comment";
// 取得總筆數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
// 總頁數
$totalPages = ceil($totalRows / $perPage);

$rows = []; // 資料
if ($totalRows > 0) {
    if ($page > $totalPages) {
        header('Location: ?page=' . $totalPages);
        exit;
    }

    $sql = sprintf("SELECT * FROM `comment` ORDER BY `sid` DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
    $rows = $pdo->query($sql)->fetchAll();
}

$members = [];
$members_sql = "SELECT * FROM `members`";
$members = $pdo->query($members_sql)->fetchAll();

$cates = [];
$cates_sql = "SELECT * FROM `all_category`";
$cates = $pdo->query($cates_sql)->fetchAll();

$lesson = [];
$lesson_sql = "SELECT * FROM lesson";
$lesson = $pdo->query($lesson_sql)->fetchAll();

$product = [];
$product_sql = "SELECT * FROM product";
$product = $pdo->query($product_sql)->fetchAll();

?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/css-style.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>
<?php include __DIR__ . '/parts/sidebars.php' ?>

<div class="container">
    <div class="row">
        <div class="col">
            <nav aria-label="Page navigation example" class="d-flex justify-content-center">
                <ul class="pagination">
                    <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page - 1 ?>">
                            <i class="fa-solid fa-circle-arrow-left"></i>
                        </a>
                    </li>
                    <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
                        if ($i >= 1 and $i <= $totalPages) :
                    ?>
                            <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                    <?php
                        endif;
                    endfor; ?>
                    <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">
                            <i class="fa-solid fa-circle-arrow-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th scope="col">會員</th>
                <th scope="col">產品&課程</th>
                <th scope="col">名稱</th>
                <th scope="col">評價</th>
                <th scope="col">評論內容</th>
                <th scope="col">上架時間</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $r) : ?>

                <tr>

                    <td><?php for ($i = 0; $i <= 99; $i++) {
                            if ($r['member_sid'] === "{$members[$i]['sid']}") {
                                echo "{$members[$i]['member_name']}";
                            }
                        } ?></td>

                    <td><?php if ($r['all_category_sid'] === "{$cates[0]['sid']}") {
                            echo "{$cates[0]['name']}";
                        } else if ($r['all_category_sid'] === "{$cates[1]['sid']}") {
                            echo "{$cates[1]['name']}";
                        }
                        ?></td>

                    <td><?php
                        if ($r['all_category_sid'] === $cates[0]['sid']) {
                            for ($k = 0; $k <= 9; $k++) {
                                if ($r['lesson_sid'] === "{$lesson[$k]['sid']}") {
                                    echo "{$lesson[$k]['lesson_name']}";
                                }
                            }
                        } else {
                            for ($k = 0; $k <= 54; $k++) {
                                if ($r['product_sid'] === "{$product[$k]['sid']}") {
                                    echo "{$product[$k]['product_name']}";
                                }
                            }
                        }
                        ?></td>
                    <td><?= $r['comment_value'] ?></td>
                    <td><?= $r['comment_content'] ?></td>
                    <td><?= $r['comment_publish_date'] ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>

    </table>
</div>
<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>