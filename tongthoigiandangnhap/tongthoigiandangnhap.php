<?php

include '../connect/config.php';
require_once "../function/functionmau.php";
$chart_data = '';
$ngaybd = 0;
$ngaykt = 0;
$b = 0;
if (isset($_POST['chonngaytinhtong'])) {
    $ngaybd = $_POST['ngaybd'];
    $ngaykt = $_POST['ngaykt'];


    $b = songay($ngaybd, $ngaykt);
    if ($b != -1) {
        $a =  ngay($ngaybd, $b);

        for ($i = 0; $i < $b; $i++) {
            foreach ($a as $value) {
                $ngay = "$value[$i]";
            }
            $c = congthoigian($conn, $ngay);
            $chart_data .= "{ date:'" . $ngay . "', NumberofCalls :" . $c . "}, ";
        }
        $chart_data = substr($chart_data, 0, -2);
    } else {
    }
}
?>
<div class="col-md-9 mainWeb">
    <!-- Breakdrumb -->
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?php if ($ad == 0) {
                                    echo "usermanager.php?";
                                } else {
                                    echo "admin.php?";
                                } ?>route=<?php if ($ad == 0) {
                                                echo "homeUM";
                                            } else {
                                                echo "home";
                                            } ?>">
                        Trang chủ
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Tổng thời gian đăng nhập</li>
            </ol>
        </nav>
    </div>
    <!-- End breakdrumb -->
    <h3>Tổng thời gian đăng nhập</h3>
    <br>


    <br>
    <div class="row">
        <div class="col-md-4" style="background-color:#adebeb;">
            <p style="color: black; font-size:17px;">Tổng: <span><?php $sl4 = "select count(*) as tongso from thoigiandangnhap";
                                                                    $kq4 = mysqli_query($conn, $sl4);
                                                                    $d4 = mysqli_fetch_array($kq4);
                                                                    echo $d4['tongso'];  ?>
                </span> lượt-
                <span><?php $sl4 = "select sum(tongthoigian) as tongso from thoigiandangnhap";
                        $kq4 = mysqli_query($conn, $sl4);
                        while ($rows = mysqli_fetch_array($kq4)) {
                            $tg = $rows['tongso'];
                        }

                        $ngay = (int)($tg / 86400);
                        $gio = (int)($tg / 3600 % 24);
                        $phut = (int)($tg / 60 % 60);
                        $giay = (int)$tg % 60;

                        echo "$ngay ngày $gio giờ $phut phút $giay giây";  ?>
                </span>
            </p>
        </div>

        <div class="col-md-4" style="background-color:antiquewhite;">
            <p style="color:black; font-size:17px; ">Admin: <span><?php $sl4 = "select count(*) as tongso from thoigiandangnhap where maadmin!=''";
                                                                    $kq4 = mysqli_query($conn, $sl4);
                                                                    $d4 = mysqli_fetch_array($kq4);
                                                                    echo $d4['tongso'];  ?></span> lượt-
                <span><?php $sl4 = "select sum(tongthoigian) as tongso from thoigiandangnhap where maadmin!=''";
                        $kq4 = mysqli_query($conn, $sl4);
                        while ($rows = mysqli_fetch_array($kq4)) {
                            $tg = $rows['tongso'];
                        }
                        $ngay = (int)($tg / 86400);
                        $gio = (int)($tg / 3600 % 24);
                        $phut = (int)($tg / 60 % 60);
                        $giay = (int)$tg % 60;

                        echo "$ngay ngày $gio giờ $phut phút $giay giây";  ?>
                </span>
        </div>

        <div class="col-md-4" style="background-color:#99e6ff;">
            <p style="color: black; font-size:17px;">User Manager: <span><?php $sl4 = "select count(*) as tongso from thoigiandangnhap where sdt!=''";
                                                                            $kq4 = mysqli_query($conn, $sl4);
                                                                            $d4 = mysqli_fetch_array($kq4);
                                                                            echo $d4['tongso'];  ?></span> lượt-
                <span><?php $sl4 = "select sum(tongthoigian) as tongso from thoigiandangnhap where sdt!=''";
                        $kq4 = mysqli_query($conn, $sl4);
                        while ($rows = mysqli_fetch_array($kq4)) {
                            $tg = $rows['tongso'];
                        }
                        $ngay = (int)($tg / 86400);
                        $gio = (int)($tg / 3600 % 24);
                        $phut = (int)($tg / 60 % 60);
                        $giay = (int)$tg % 60;

                        echo "$ngay ngày $gio giờ $phut phút $giay giây";  ?>
                </span>
        </div>
    </div>

    <form method="POST" enctype="multipart/form-data">
        <div class="row" style="margin-top:17px;">
            <div class="col-md-4">
                <label>Chọn ngày BD: </label>
                <div class="col-md-6">
                    <div id="datepickerBD" class="input-group date" data-date-format="dd-mm-yyyy">
                        <input class="form-control shadow-none" type="text" name="ngaybd">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-calendar"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <label>Chọn ngày KT: </label>
                <div class="col-md-6">
                    <div id="datepickerKT" class="input-group date" data-date-format="dd-mm-yyyy">
                        <input class="form-control shadow-none" type="text" name="ngaykt">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-calendar"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <br>
                <button class="btn btn-success shadow-none" type="submit" name="chonngaytinhtong">Chọn</button>
            </div>
        </div>
    </form>


    <!-- Biểu đồ đường thống kê -->
    <div class="container-fluid">
        <div class="container" style="width:1000px;">
            <br /><br />
            <div id="chart"></div>
        </div>
    </div>
    <table class="table table-success table-striped" style="position:relative;">
        <?php
        if ($ngaybd > 0) {
        ?>
        <tr class="tieude">
            <th>STT</th>
            <th>Mã Admin</th>
            <th>SDT(User Manager)</th>
            <th>Thời gian đăng nhập</th>
            <th>Thời gian đăng xuất</th>
            <th>Tổng thời gian(Giây)</th>
        </tr>
        <?php
            $d = ngay($ngaybd, $b);
            if ($b != -1) {
                $stt = 1;
                $e =  ngay($ngaybd, $b);
                $kt = false;
                for ($i = 0; $i < $b; $i++) {
                    foreach ($e as $value) {
                        $ngay = "$value[$i]";
                    }
                    $f = hienbang($conn, $ngay);
                    foreach ($f as $value) {
                        if ("$value[0]" != 1) {
                            $tg = "$value[0]";
                            $tenum = "$value[1]";
                            $sl = "$value[2]";
                            $sl1 = "$value[3]";
                            $sl2 = "$value[4]";
            ?>
        <tr>
            <th><?php echo $stt ?></th>
            <th><?php echo $tg ?></th>
            <th><?php echo $tenum ?></th>
            <th><?php echo $sl ?></th>
            <th><?php echo $sl1 ?></th>
            <th><?php echo $sl2 ?></th>
        </tr>

        <?php
                            $stt++;
                            $kt = true;
                        }
                    }
                }
                if ($kt == false) {
                    ?>
        <tr>
            <th>0</th>
            <th>0000-00-00</th>
            <th>Không có dữ liệu</th>
            <th>0</th>
            <th>0</th>
            <th>0</th>
        </tr>
        <?php
                }
            }
        }
        ?>
    </table>
</div>

<script>
// Điều khiển biểu đồ
Morris.Line({
    element: 'chart',
    data: [<?php echo $chart_data; ?>],
    xkey: 'date',
    ykeys: ['NumberofCalls'],
    labels: ['NumberofCalls'],
    hideHover: 'auto',
    stacked: true
});
</script>

<?php
if ($ngaybd == 0 && $ngaykt == 0) {
?>
<script>
// Hàm điều khiển lịch
// Thời gian bắt đầu
$(function() {
    $("#datepickerBD").datepicker({
        autoclose: true,
        todayHighlight: true
    }).datepicker('update', new Date());
});

// Thời gian kết thúc
$(function() {
    $("#datepickerKT").datepicker({
        autoclose: true,
        todayHighlight: true
    }).datepicker('update', new Date());
});
</script>
<?php } else {
    $begin = date_create($ngaybd);
    $ngaybatdau = date_format($begin, "Y-m-d");
    $end = date_create($ngaykt);
    $ngayketthuc = sosanhngay(date_format($end, "Y-m-d"));

?>
<script>
// Hàm điều khiển lịch
// Thời gian bắt đầu
$(function() {
    $("#datepickerBD").datepicker({
        autoclose: true,
        todayHighlight: true
    }).datepicker('update', new Date('<?php echo $ngaybatdau ?>'));
});

// Thời gian kết thúc
$(function() {
    $("#datepickerKT").datepicker({
        autoclose: true,
        todayHighlight: true
    }).datepicker('update', new Date('<?php echo $ngayketthuc ?>'));
});
</script>
<?php } ?>