<?php
require __DIR__ . '/parts/connect_db.php';
// require __DIR__ . '/parts/admin-required.php';
$pageName = 'add';
$title = '新增評論';
$pageSid = '7';
// $state_sql = "SELECT * FROM `all_category`";
// $state = $pdo->query($state_sql)->fetchAll();
// $statej = json_encode($state, JSON_UNESCAPED_UNICODE);
// echo $statej;

// $comment_sql = "SELECT * FROM `comment`";
// $comment = $pdo->query($comment_sql)->fetchAll();
// $commentj = json_encode($comment, JSON_UNESCAPED_UNICODE);

// $members_sql = "SELECT * FROM `members`";
// $members = $pdo->query($members_sql)->fetchAll();
// $membersj = json_encode($members, JSON_UNESCAPED_UNICODE);

$lesson_sql = "SELECT * FROM `lesson`";
$lesson = $pdo->query($lesson_sql)->fetchAll();
$lessonj = json_encode($lesson, JSON_UNESCAPED_UNICODE);

$product_sql = "SELECT * FROM `product`";
$product = $pdo->query($product_sql)->fetchAll();
$productj = json_encode($product, JSON_UNESCAPED_UNICODE);

?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/css-style.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>
<?php include __DIR__ . '/parts/sidebars.php' ?>
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">新增資料5</h5>
                    <form name="form1" onsubmit="checkForm(event)">

                        <div class="mb-3">
                            <label for="member_sid" class="form-label">請輸入會員名稱</label>
                            <input readonly type="hidden" id="member_sid" name="member_sid">
                            <!--丟給後端去查看 -->
                            <input list="member-results" id="autocomplete_member_input" type="text" class="form-control" name="member_name">
                            <ul class="dropdown-menu" id="member_dropdown_menu"></ul>
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="all_category_sid" class="form-label">項目</label>
                            <select required class="form-select" id="cate" name="all_category_sid" onchange="makeChoice(this.options[this.selectedIndex].value)">
                            </select>
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3" style="display : none" id="lesson_choice">
                            <!-- onchange="cate_tpl2() -->
                            <label for="lesson_sid" class="form-label">課程名稱</label>
                            <select class="form-select" id="cate2" name="lesson_sid"></select>
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3" style="display : none" id="product_choice">
                            <!-- onchange="cate_tpl3()" -->
                            <label for="product_sid" class="form-label">產品名稱</label>
                            <select class="form-select" id="cate3" name="product_sid"></select>
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label required min="1" max="5" for="comment_value" class="form-label">評價分數</label>
                            <input type="number" class="form-control" id="comment_value" name="comment_value" required min="1" max="5">
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="comment_content" class="form-label">評論內容</label>
                            <textarea class="form-control" name="comment_content" id="comment_content" cols="50" rows="3"></textarea>
                            <div class="form-text"></div>
                        </div>
                        <button type="submit" class="btn btn-primary">新增</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <br>
</div>
<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
    const autocomplete_input = document.getElementById("autocomplete_member_input");
    autocomplete_input.addEventListener("keydown", (e) => {
        fetch('comment-autocomplete-search-api.php?search_term=' + e.target.value, {
            method: 'GET',
        }).then(r => r.json()).then(resp => {
            if (resp.length == 0) {
                return;
            }
            const selected_elem = document.getElementById("member_dropdown_menu");
            selected_elem.innerHTML = "";
            for (let i in resp) {
                const li_element = document.createElement('LI');
                li_element.innerHTML = "<a class='dropdown-item' href='#'>" + resp[i].member_name + "</a>";
                li_element.addEventListener('click', function(event) {
                    document.getElementById("autocomplete_member_input").value = resp[i].member_name;
                    document.getElementById("member_sid").value = resp[i].sid;
                    selected_elem.style.display = "none";
                })
                // // Add index to option_elem
                // option_elem.value = resp[i].sid;

                // Add element HTML
                // Append option_elem to select_elem
                selected_elem.appendChild(li_element);
            }
            selected_elem.style.display = "block";

        })
    });

    const cates = [{
            sid: "",
            name: "請選擇"
        }, {
            sid: "1",
            name: "lesson"
        },
        {
            sid: "2",
            name: "product"
        }
    ];
    const cate_tpl = () => {
        const ar = cates.map(
            (el) => `<option value="${el.sid}">${el.name}</option>`
        );
        return ar.join("");
    };
    cate.innerHTML = cate_tpl();

    //lesson
    const lesson = <?= $lessonj ?>;
    console.log(lesson);
    const cate_tp2 = () => {
        const ar2 = lesson.map(
            (el) => `<option value="${el.sid}">${el.lesson_name}</option>`
        );
        return ar2.join("");
    };
    cate2.innerHTML = cate_tp2();
    //product
    const product = <?= $productj ?>;
    const cate_tp3 = () => {
        const ar3 = product.map(
            (el) => `<option value="${el.sid}">${el.product_name}</option>`
        );
        return ar3.join("");
    };
    cate3.innerHTML = cate_tp3();

    const makeChoice = function(event) {
        console.log(event);
        if (event === '1') {
            document.getElementById('lesson_choice').style.display = 'block';
            document.getElementById('cate2').disabled = false;
            document.getElementById('product_choice').style.display = 'none';
            document.getElementById('cate3').disabled = true;
        } else if (event === '2') {
            document.getElementById('lesson_choice').style.display = 'none';
            document.getElementById('cate2').disabled = true;
            document.getElementById('product_choice').style.display = 'block';
            document.getElementById('cate3').disabled = false;
        } else {
            document.getElementById('lesson_choice').style.display = 'none';
            document.getElementById('cate2').disabled = true;
            document.getElementById('product_choice').style.display = 'none';
            document.getElementById('cate3').disabled = true;
        }

    }

    const checkForm = function(event) {
        event.preventDefault(); //不要用傳統的表單送出
        //TODO:欄位檢查

        const fd = new FormData(document.form1); //這是沒有外觀只有資料的Form,所以在裡面要下document.fom1來複製form1的外觀

        fetch('comment-add-api.php', {
            method: 'POST',
            body: fd,
            //這邊會輸出json檔案,所以第一個then一定是用下面那個,第二個then才是自己需要的內容
        }).then(r => r.json()).then(obj => {
            console.log(obj);
            if (obj.success) {
                alert('新增成功');
                //跳轉列表頁
                location.href = "list.php";

            } else {
                for (let id in obj.errors) {
                    const field = document.querySelector(`
                #$ {
                    id
                }
                `);
                    field.style.border = '2px solid red';
                    // field.closest('.mb-3').querySelector('.form-text').innerHTML = obj.errors[id];
                    field.nextElementSibling.innerHTML = obj.errors[id];
                }
            }
        })

    }
</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>