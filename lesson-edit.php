<?php

require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin-required.php';
$pageName = 'edit';
$title = '修改課程';
$pageSid = '3';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
    header('Location: lesson-list.php'); // 轉向到列表頁
    exit;
}

$sql = "SELECT * FROM lesson WHERE sid=$sid";
$r = $pdo->query($sql)->fetch();
if (empty($r)) {
    header('Location:  lesson-list.php'); // 轉向到列表頁
    exit;
}

$category_sql = "SELECT * FROM `lesson_category`";
$category = $pdo->query($category_sql)->fetchAll();

$categoryj = json_encode($category, JSON_UNESCAPED_UNICODE);


$teacher_sql = "SELECT * FROM `lesson_teacher`";
$teacher = $pdo->query($teacher_sql)->fetchAll();

$teacherj = json_encode($teacher, JSON_UNESCAPED_UNICODE);


$onsale_sql = "SELECT * FROM `lesson_onsale`";
$onsale = $pdo->query($onsale_sql)->fetchAll();

$onsalej = json_encode($onsale, JSON_UNESCAPED_UNICODE);


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
                    <h5 class="card-title">修改資料</h5>
                    <form class="row g-3" name="form1" onsubmit="checkForm(event)" novalidate>
                        <input type="hidden" name="sid" value="<?= htmlentities($r['sid']) ?>">
                        <div class="col-md-3">
                            <label for="lesson_id" class="form-label">課程編號</label>
                            <input class="form-control" id="lesson_id" name="lesson_id" required value="<?= htmlentities($r['lesson_id']) ?>">
                            <div class="form-text"></div>
                        </div>

                        <div class="col-md-3">
                            <label for="lesson_name" class="form-label">課程名稱</label>
                            <input type="text" class="form-control" id="lesson_name" name="lesson_name" required value="<?= htmlentities($r['lesson_name']) ?>">
                            <div class="form-text"></div>
                        </div>

                        <div class="col-md-3">
                            <label for="lesson_category_sid" class="form-label">課程分類</label>
                            <select class="form-select" aria-label="Default select example" id="lesson_category_sid" name="lesson_category_sid">
                            </select>
                            <div class="form-text"></div>
                        </div>

                        <div class="col-md-3">
                            <label for="lesson_price" class="form-label">課程價格</label>
                            <input type="number" class="form-control" id="lesson_price" name="lesson_price" required value="<?= htmlentities($r['lesson_price']) ?>">
                            <div class="form-text"></div>
                        </div>

                        <div class="col-md-3">
                            <label for="lesson_publish_date	" class="form-label">開課日期</label>
                            <input type="datetime-local" class="form-control" id="lesson_publish_date	" name="lesson_publish_date	" required>
                            <div class="form-text"></div>
                        </div>
                        <!-- <div class="col-md-3">
                            <label for="lesson_end_date	" class="form-label">下架日期</label>
                            <input type="datetime-local" class="form-control" id="lesson_end_date	" name="lesson_end_date	" required>
                            <div class="form-text"></div> -->


                        <div class="col-md-3">
                            <label for="lesson_hours" class="form-label">課程時數</label>
                            <input type="number" class="form-control" id="lesson_hours" name="lesson_hours" value="<?= htmlentities($r['lesson_hours']) ?>">
                            <div class="form-text"></div>
                        </div>

                        <div class="col-md-3">
                            <label for="lesson_teacher_sid" class="form-label">老師</label>
                            <select class="form-select" aria-label="Default select example" id="lesson_teacher_sid" name="lesson_teacher_sid">
                                <!-- <option selected>請選擇</option>
                                <option value="1">李小名</option>
                                <option value="2">王春風</option>
                                <option value="3">陳美麗</option>
                                <option value="4">林又加</option>
                                <option value="5">郭大俠</option> -->
                            </select>
                            <div class="form-text"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="lesson_information" class="form-label">課程資訊</label>
                            <textarea class="form-control" name="lesson_information" id="lesson_information" cols="50" rows="3" value=""><?= htmlentities($r['lesson_information']) ?></textarea>
                            <div class="form-text"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="" class="form-label">課程照片</label>
                            <div class="btn btn-primary d-block" style="width:20%;" onclick="avatar.click()">上傳</div>
                            <img id="myimg" src="imgupload/lesson/<?= $r['lesson_img'] ?>" alt="" width="100px">
                            <input style="display: none;" type="text" name="memberimgname" id="memberimgname" value="<?= $r['lesson_img'] ?>" />
                            <div class="form-text"></div>
                        </div>

                        <div class="col-md-4">
                            <label for="lesson_uplimit	" class="form-label">人數上限</label>
                            <input type="number" class="form-control" id="lesson_uplimit	" name="lesson_uplimit" value="<?= htmlentities($r['lesson_uplimit']) ?>">
                            <div class="form-text"></div>
                        </div>

                        <div class="col-md-4">
                            <label for="lesson_lowerlimit" class="form-label">人數下限</label>
                            <input type="number" class="form-control" id="lesson_lowerlimit" name="lesson_lowerlimit" value="<?= htmlentities($r['lesson_lowerlimit']) ?>">
                            <div class="form-text"></div>
                        </div>

                        <div class="col-md-4">
                            <label for="lesson_onsale " class="form-label">上架狀態</label>
                            <select class="form-select" aria-label="Default select example" id="lesson_onsale_sid" name="lesson_onsale_sid">
                                <!-- <option selected>請選擇</option>
                                <option value="1">開放報名</option>
                                <option value="2">人數額滿</option>
                                <option value="3">課程取消</option>
                                <option value="4">課程結束</option> -->
                            </select>
                            <div class="form-text"></div>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">編輯</button>
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

    const ar_category = <?= $categoryj ?>;
    const category_info = () => {
        let ar = '';
        for (let i of ar_category) {
            ar += `<option id="sid${i.sid}" value="${i.sid}">${i.lesson_category}</option>`;
        }
        lesson_category_sid.innerHTML = ar;
        let op = document.querySelector('#sid<?= $r['lesson_category_sid'] ?>')
        op.setAttribute("selected", "selected")
    };
    category_info();

    const ar_teacher = <?= $teacherj ?>;
    const teacher_info = () => {
        let ar = '';
        for (let i of ar_teacher) {
            ar += `<option id="sid1${i.sid}" value="${i.sid}">${i.lesson_teacher}</option>`;
        }
        lesson_teacher_sid.innerHTML = ar;
        let op = document.querySelector('#sid1<?= $r['lesson_teacher_sid'] ?>')
        op.setAttribute("selected", "selected")
    };
    teacher_info();

    const ar_onsale = <?= $onsalej ?>;
    const onsale_info = () => {
        let ar = '';
        for (let i of ar_onsale) {
            ar += `<option id="sid2${i.sid}" value="${i.sid}">${i.lesson_onsale}</option>`;
        }
        lesson_onsale_sid.innerHTML = ar;
        let op = document.querySelector('#sid2<?= $r['lesson_onsale_sid'] ?>')
        op.setAttribute("selected", "selected")
    };
    onsale_info();

    const checkForm = function(event) {
        event.preventDefault();


        const fd = new FormData(document.form1);

        fetch('lesson-edit-api.php', {
            method: 'POST',
            body: fd,
        }).then(r => r.json()).then(obj => {
            console.log(obj);

            if (obj.success) {
                alert('修改成功');
                // 跳轉到列表頁
                window.location.href = 'lesson-list.php';
            } else {
                for (let id in obj.errors) {
                    const field = document.querySelector(`#${id}`);
                    field.style.border = '2px solid red';
                    field.nextElementSibling.innerHTML = obj.errors[id];
                }
            }

        })




    };
</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>