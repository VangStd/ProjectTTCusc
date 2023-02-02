<?php
//index.php
include '../connect/config.php';
require_once "../function/functionH.php";
$chart_data = '';
$ngaybd = 0;
$ngaykt = 0;
$b = 0;
if (isset($_GET['hienthinhatky'])) {
    $ngaybd = $_GET['ngaybd'];

    $ngaykt = $_GET['ngaykt'];

    $begin = date_create($ngaybd);
    $ngaybatdau = date_format($begin, "Y-m-d");
    $end = date_create($ngaykt);
    $ngayketthuc = sosanhngayHT(date_format($end, "Y-m-d"));

    // $b = songay($ngaybd, $ngaykt);  

}
?>
<div class="col-md-9 mainWeb">
    <!-- Breakdrumb -->
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="admin.php?route=home">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Nhật ký thay đổi</li>
            </ol>
        </nav>
    </div>
    <!-- End breakdrumb -->
    <h2>Nhật ký thay đổi</h2>
    <form method="GET" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-9" style="margin: auto;">
                <div class="col-md-6">
                    <label>Chọn ngày BD: </label>
                    <div id="datepickerBD" class="input-group date" data-date-format="dd-mm-yyyy">
                        <input class="form-control shadow-none" readonly="" type="text" name="ngaybd">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-calendar"></i>
                        </span>
                    </div>
                </div>

                <div class="col-md-6">
                    <label>Chọn ngày KT: </label>
                    <div id="datepickerKT" class="input-group date" data-date-format="dd-mm-yyyy">
                        <input class="form-control shadow-none" readonly="" type="text" name="ngaykt">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-calendar"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div style="text-align:center; margin-top:10px; margin-bottom:20px;">
                <button class="btn btn-success shadow-none" type="submit" name="hienthinhatky">Chọn</button>
            </div>
        </div>
    </form>
    <?php
    if ($ngaybd != 0) {
    ?>
        <table class="table table-success table-striped" style="position:relative;">
            <tr class="tieude">
                <th>STT</th>
                <th>Loại người dùng</th>
                <th>Tên người dùng</th>
                <th>Thời gian</th>
                <th>Nội dung</th>

            </tr>
            <?php
            $item_per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : 20;
            $current_page = !empty($_GET['page']) ? $_GET['page'] : 1;; //Trang hiện tại
            $offset = ($current_page - 1) * $item_per_page;
            if ($b != -1) {
                $kt = false;

                $t = tongnhatky($conn, $ngaybatdau, $ngayketthuc);
                $totalPages = ceil($t / $item_per_page);

                $a = nhatkythaydoi($conn, $ngaybatdau, $ngayketthuc, $item_per_page, $offset);
                $stt = 1;
                foreach ($a as $value) {
                    $thoigian = "$value[0]";
                    if ($thoigian != 0) {
                        $maadmin = "$value[1]";
                        $sdt = "$value[2]";
                        $hanhdong = "$value[3]";
                        $tenuser = layTenNguoiDung($conn, $maadmin, $sdt);
                        $loai = layloainguoidung($maadmin, $sdt);


            ?>
                        <tr>
                            <td><?php echo $stt ?></td>
                            <td><?php echo $loai ?></td>
                            <td><?php echo $tenuser ?></td>
                            <td><?php echo date_format(date_create($thoigian), "d-m-Y H:i:s") ?></td>
                            <td><?php echo $hanhdong ?></td>
                        </tr>
                    <?php
                        $stt++;
                        $kt = true;
                    }
                }

                if ($kt == false) {
                    ?>
                    <tr>
                        <td>0</td>
                        <td>Không có dữ liệu</td>
                        <td>Không có dữ liệu</td>
                        <td>00-00-0000 00:00:00</td>
                        <td>Không có dữ liệu</td>
                    </tr>
            <?php
                }
            }
            ?>
        </table>

        <!-- Phân trang -->
        <nav aria-label="Page navigation example" style="float: right;">
            <ul class="pagination">
                <li class="page-item"><?php require_once "../function/phantrang/paginationnk.php"; ?></li>
            </ul>

        </nav>
    <?php
    }
    ?>
    <!-- Function điều kiển lịch -->
</div>
<!-- Function điều kiển lịch -->
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


<link data-require="bootstrap@3.3.2" data-semver="3.3.2" rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" />
<script data-require="bootstrap@3.3.2" data-semver="3.3.2" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script data-require="jquery@2.1.3" data-semver="2.1.3" src="http://code.jquery.com/jquery-2.1.3.min.js"></script>
<link rel="stylesheet" href="style.css" />
<script src="moment-2.10.3.js"></script>
<script src="bootstrap-datetimepicker.js"></script>