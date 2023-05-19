<?php
require __DIR__ . '/parts/connect_db.php';
// require __DIR__ . '/parts/admin-required.php';
$pageName = 'edit';
$title = '修改評論';
$pageSid = '7';
//選到哪一個然後要編輯
$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
    header('Location: comment-list.php');
    exit;
}

$comments_sql = "SELECT c.comment_value, c.comment_content, c.sid, all_category.name as category_name, l.lesson_name, p.product_name, m.member_name FROM `comment` c JOIN all_category ON c.all_category_sid = all_category.sid LEFT JOIN lesson l ON c.lesson_sid=l.sid LEFT JOIN product p ON c.product_sid = p.sid JOIN members m ON c.member_sid = m.sid where c.sid = $sid;";
$r = $pdo->query($comments_sql)->fetch();
// $comment_j = json_encode($r, JSON_UNESCAPED_UNICODE);
// echo $r_j;
if (empty($r)) {
    header('Location: comment-list.php');
    exit;
}

// $members_sql = "SELECT * FROM `members`";
// $members = $pdo->query($members_sql)->fetchAll();
// $members_j = json_encode($members, JSON_UNESCAPED_UNICODE);
// echo $members_j;

?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/css-style.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>

<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">

                <div class="card-body">
                    <h5 class="card-title">修改資料</h5>
                    <form name="form1" onsubmit="checkForm(event)">
                        <input readonly type="hidden" name="sid" value="<?= $r['sid'] ?>">
                        <!--丟給後端去查看 -->

                        <!-- <div class="mb-3">
                            <label for="member_sid" class="form-label">會員編號</label>
                            <input type="text" class="form-control" id="member_sid" name="member_sid" required value="<?= htmlentities($members['member_name']) ?>">
                            <div class="form-text"></div>
                        </div> -->

                        <div class="mb-3">
                            <label for="member_sid" class="form-label">會員名稱</label>
                            <input disabled type="text" class="form-control" id="member_sid" name="member_sid" value="<?= $r['member_name'] ?>">
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="all_category_sid" class="form-label">項目</label>
                            <input disabled type="text" class="form-control" id="all_category_sid" name="all_category_sid" value="<?= $r['category_name'] ?>">
                            <div class="form-text"></div>
                        </div>

                        <?php if ($r['category_name'] == "lesson") : ?>
                            <div class="mb-3">
                                <label for="lesson_sid" class="form-label">課程名稱</label>
                                <input disabled type="text" class="form-control" id="lesson_sid" name="lesson_sid" value="<?= $r['lesson_name'] ?>">
                                <div class="form-text"></div>
                            </div>
                        <?php else : ?>
                            <div class="mb-3">
                                <label for="product_sid" class="form-label">產品名稱</label>
                                <input disabled type="text" class="form-control" id="product_sid" name="product_sid" value="<?= $r['product_name'] ?>">
                                <div class="form-text"></div>
                            </div>
                        <?php endif ?>
                        <div class="mb-3">
                            <label for="comment_value" class="form-label">評價分數</label>
                            <input required min="1" max="5" type="number" class="form-control" id="comment_value" name="comment_value" value="<?= $r['comment_value'] ?>">
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="comment_content" class="form-label">評論內容</label>
                            <textarea class="form-control" name="comment_content" id="comment_content" cols="50" rows="3" required><?= $r['comment_content'] ?></textarea>
                            <div class="form-text"></div>
                        </div>
                        <!-- <div class="mb-3">
                            <label for="comment_re" class="form-label">回覆內容</label>
                            <textarea class="form-control" name="comment_re" id="comment_re" cols="50" rows="3"><?= $r['comment_re'] ?></textarea>
                            <div class="form-text"></div>
                        </div> -->
                        <button type="submit" class="btn btn-primary">修改</button>
                        <br>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
    // const rowData = <? json_encode($r, JSON_UNESCAPED_UNICODE) ?>;

    const checkForm = function(event) {
        event.preventDefault();
        // 欄位外觀回復原來的樣子
        document.form1.querySelectorAll('input').forEach(function(el) {
            el.style.border = '1px solid #CCCCCC';
            // el.nextElementSibling.innerHTML = '';
        });

        const fd = new FormData(document.form1);

        fetch('comment-edit-api.php', {
            method: 'POST',
            body: fd,
        }).then(r => r.json()).then(obj => {
            console.log(obj);
            if (obj.success) {
                alert('修改成功');
                // 跳轉到列表頁
                location.href = "comment-list-admin.php";
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