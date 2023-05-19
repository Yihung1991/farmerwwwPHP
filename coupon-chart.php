<?php
require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin-required.php';

$pageName = '優惠劵使用分析表';
$title = '優惠劵使用分析表';
$pageSid = 6;


$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 1;
if ($sid < 1) {
    header('Location:coupon-details.php');
    exit;
}

// 持有總數
$t_sql = sprintf("SELECT COUNT(1) FROM coupon_details WHERE `coupon_sid` = %s", $sid);
$totalHold = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

// 已使用數量
$u_sql = sprintf("SELECT COUNT(1) FROM `coupon_details` WHERE `coupon_used` = 1 AND`coupon_sid` = %s", $sid);
$totalUsed = $pdo->query($u_sql)->fetch(PDO::FETCH_NUM)[0];
// 未使用數量
$n_sql = sprintf("SELECT COUNT(1) FROM `coupon_details` WHERE `coupon_used` = 2 AND`coupon_sid` = %s", $sid);
$totalNoUsed = $pdo->query($n_sql)->fetch(PDO::FETCH_NUM)[0];
// 已過期數量
$e_sql = sprintf("SELECT COUNT(1) FROM `coupon_details` WHERE `coupon_used` = 3 AND`coupon_sid` = %s", $sid);
$totalEnd = $pdo->query($e_sql)->fetch(PDO::FETCH_NUM)[0];

//名稱
$Cd = [];
$Cd_sql = sprintf("SELECT * FROM coupon_details WHERE `coupon_sid` = %s", $sid);
$Cd = $pdo->query($Cd_sql)->fetchAll();


$C_sql = sprintf("SELECT * FROM coupon WHERE `sid` = %s", $sid);
$C = $pdo->query($C_sql)->fetch();
$C_j = json_encode($C);


//取得使用者生日
$birthdays = [];
$B_sql = sprintf("SELECT `member_birthday` FROM `members`WHERE `sid` IN (SELECT `member_sid`FROM `coupon_details`WHERE `coupon_used` = 1 AND `coupon_sid` = %s)", $sid);
$birthdays = $pdo->query($B_sql)->fetchAll();

$result = $pdo->query($B_sql);
if ($result === false) {
    // 如果查詢失敗，输出错误信息
    echo "Error: " . $pdo->errorInfo();
}

// 建立一個空的年齡陣列
$ages = [];

// 遍歷生日陣列
foreach ($birthdays as $obj) {


    $birthday = $obj['member_birthday'];

    $date = new DateTime($birthday);

    $diff = $date->diff(new DateTime());

    $ages[] = $diff->y;
}

// $A = print_r($ages);
$A_J = json_encode($ages);
// echo $A_J;
?>


<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/css-style.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>
<?php include __DIR__ . '/parts/sidebars.php' ?>

<div class="container w-75">
    <div class="row">
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb" class="mt-3 ms-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">首頁</a></li>
                <li class="breadcrumb-item"><a href="coupon-list.php">優惠劵管理</a></li>
                <li class="breadcrumb-item active" aria-current="page">優惠劵使用率分析</li>
            </ol>
        </nav>
        <div class="row d-flex flex-column justify-content-center">
            <div class="mt-5">
                <h2 class="text-center"><?= $C['coupon_name'] ?></h2>
            </div>
            <div class="wrapper mt-3 d-flex gap-5 justify-content-center align-items-center">
                <div class="pie-charts">
                    <div class="pieID--operations pie-chart--wrapper">
                        <h3>優惠卷使用率</h3>

                        <div class="pie-chart">
                            <div class="pie-chart__pie"></div>
                            <ul class="pie-chart__legend">
                                <li><em>未使用</em><span><?= $totalNoUsed ?></span></li>
                                <li><em>已使用</em><span><?= $totalUsed ?></span></li>
                                <li><em>已到期</em><span><?= $totalEnd ?></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <script type="text/javascript" src="https://www.google.com/jsapi"></script>
                <div style="width:300px;">
                    <h3>使用者年齡分布</h3>
                    <div id="bar-chart"></div>
                </div>
            </div>
        </div>
    </div>
</div>





<script>
    function sliceSize(dataNum, dataTotal) {
        return (dataNum / dataTotal) * 360;
    }

    function addSlice(id, sliceSize, pieElement, offset, sliceID, color) {
        $(pieElement).append("<div class='slice " + sliceID + "'><span></span></div>");
        var offset = offset - 1;
        var sizeRotation = -179 + sliceSize;

        $(id + " ." + sliceID).css({
            "transform": "rotate(" + offset + "deg) translate3d(0,0,0)"
        });

        $(id + " ." + sliceID + " span").css({
            "transform": "rotate(" + sizeRotation + "deg) translate3d(0,0,0)",
            "background-color": color
        });
    }

    function iterateSlices(id, sliceSize, pieElement, offset, dataCount, sliceCount, color) {
        var
            maxSize = 179,
            sliceID = "s" + dataCount + "-" + sliceCount;

        if (sliceSize <= maxSize) {
            addSlice(id, sliceSize, pieElement, offset, sliceID, color);
        } else {
            addSlice(id, maxSize, pieElement, offset, sliceID, color);
            iterateSlices(id, sliceSize - maxSize, pieElement, offset + maxSize, dataCount, sliceCount + 1, color);
        }
    }

    function createPie(id) {
        var
            listData = [],
            listTotal = 0,
            offset = 0,
            i = 0,
            pieElement = id + " .pie-chart__pie"
        dataElement = id + " .pie-chart__legend"

        color = [
            "cornflowerblue",
            "olivedrab",
            "orange",
            "tomato",
            "crimson",
            "purple",
            "turquoise",
            "forestgreen",
            "navy"
        ];

        color = shuffle(color);

        $(dataElement + " span").each(function() {
            listData.push(Number($(this).html()));
        });

        for (i = 0; i < listData.length; i++) {
            listTotal += listData[i];
        }

        for (i = 0; i < listData.length; i++) {
            var size = sliceSize(listData[i], listTotal);
            iterateSlices(id, size, pieElement, offset, i, 0, color[i]);
            $(dataElement + " li:nth-child(" + (i + 1) + ")").css("border-color", color[i]);
            offset += size;
        }
    }

    function shuffle(a) {
        var j, x, i;
        for (i = a.length; i; i--) {
            j = Math.floor(Math.random() * i);
            x = a[i - 1];
            a[i - 1] = a[j];
            a[j] = x;
        }

        return a;
    }

    function createPieCharts() {
        createPie('.pieID--micro-skills');
        createPie('.pieID--categories');
        createPie('.pieID--operations');
    }

    createPieCharts();
</script>

<script>
    const ages = <?= $A_J ?>;
    const ageGroups = ages.reduce((groups, age) => {
        if (age >= 20 && age < 25) {
            groups.group1++;
        } else if (age >= 25 && age < 30) {
            groups.group2++;
        } else if (age >= 30 && age < 35) {
            groups.group3++;
        } else if (age >= 35 && age < 40) {
            groups.group4++;
        }
        return groups;
    }, {
        group1: 0,
        group2: 0,
        group3: 0,
        group4: 0
    });

    console.log(ageGroups);

    let ageGroupArray = Object.entries(ageGroups).map(([key, value]) => [key, value]);
    ageGroupArray = ageGroupArray.map(([key, value]) => {
        switch (key) {
            case 'group1':
                return ['20~25', value];
            case 'group2':
                return ['25~30', value];
            case 'group3':
                return ['30~35', value];
            case 'group4':
                return ['40~45', value];
            default:
                return [key, value];
        }
    });

    ageGroupArray.unshift(['年齡', '數量']);
    console.log(ageGroupArray);



    google.load("visualization", "1", {
        packages: ["corechart"]
    });
    google.setOnLoadCallback(drawCharts);

    function drawCharts() {

        // BEGIN BAR CHART
        /*
  // create zero data so the bars will 'grow'
  var barZeroData = google.visualization.arrayToDataTable([
    ['Day', 'Page Views', 'Unique Views'],
    ['Sun',  0,      0],
    ['Mon',  0,      0],
    ['Tue',  0,      0],
    ['Wed',  0,      0],
    ['Thu',  0,      0],
    ['Fri',  0,      0],
    ['Sat',  0,      0]
  ]);
	*/
        // actual bar chart data
        var barData = google.visualization.arrayToDataTable(
            ageGroupArray
        );
        // set bar chart options
        var barOptions = {
            focusTarget: 'category',
            backgroundColor: 'transparent',
            colors: ['cornflowerblue', 'tomato'],
            fontName: 'Open Sans',
            chartArea: {
                left: 50,
                top: 10,
                width: '100%',
                height: '70%'
            },
            bar: {
                groupWidth: '80%'
            },
            hAxis: {
                textStyle: {
                    fontSize: 11
                }
            },
            vAxis: {
                minValue: 0,
                maxValue: 10,
                baselineColor: '#DDD',
                gridlines: {
                    color: '#DDD',
                    count: 5
                },
                textStyle: {
                    fontSize: 11
                }
            },
            legend: {
                position: 'bottom',
                textStyle: {
                    fontSize: 12
                }
            },
            animation: {
                duration: 1200,
                easing: 'out',
                startup: true
            }
        };
        // draw bar chart twice so it animates
        var barChart = new google.visualization.ColumnChart(document.getElementById('bar-chart'));
        //barChart.draw(barZeroData, barOptions);
        barChart.draw(barData, barOptions);
    }
</script>

<?php include __DIR__ . '/parts/scripts.php' ?>
<?php include __DIR__ . '/parts/html-foot.php' ?>