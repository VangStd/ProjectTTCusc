<?php
include '../connect/config.php';
require_once "../function/functionH.php";

$MaTruong = "0";
$kt = false;
$khoabt = true;
if (isset($_POST['chontruong'])) {
    $MaTruong = $_POST['truongcanphandoan'];
    $sophieu = sokhachhangtheotruong($conn, $MaTruong);
    $khoabt  = false;
    $kt = true;
}
// echo $MaTruong;
if (isset($_POST['xacnhanphandoan'])) {
    $MaTruong = $_POST['matruong'];
    $sodong = $_POST['sodong'];
    TaoPQ($conn, $MaTruong, $sodong);
    echo "<script>location.href='admin.php?route=phandoandulieu';</script>";
}
if (isset($_GET['xoa'])) {
    $mapq = $_GET['mapq'];
    $dk = $_GET['xoa'];
    dkxoa($dk, $mapq);
    if ($dk == "yes") {
        xoadoan($conn, $mapq);
        echo "<script>location.href='admin.php?route=phandoandulieu';</script>";
    } else if ($dk == "no") {
        echo "<script>location.href='admin.php?route=phandoandulieu';</script>";
    }
}
?>

<div class="col-md-9 mainWeb">
    <!-- Breakdrumb -->
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="bread" href="admin.php?route=home">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Phân đoạn dữ liệu</li>
            </ol>
        </nav>
    </div>
    <!-- End breakdrumb -->
    <div class="row phandoandulieu">
        <h3 style="text-align:center; color: red;">Phân đoạn dữ liệu</h3>
        <!-- Chọn trường -->
        <div class="col-md-6">
            <form method="POST" enctype="multipart/form-data">
                <div class="row">
                    <label>Chọn tên trường:</label>
                    <div class="col-md-8">
                        <select class="form-select shadow-none" aria-label="Default select example" name="truongcanphandoan">
                            <?php
                            $truong = Matruong($conn);
                            foreach ($truong as $value) {
                                $matruong = "$value[0]";
                                $Tentruong = "$value[1]";
                            ?>
                                <option <?php if ($kt == true) {
                                            if ($matruong  == $MaTruong) echo 'selected';
                                        } ?> value="<?php echo  $matruong; ?>">
                                    <?php echo $Tentruong; ?>
                                <?php } ?>
                                </option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <!-- Btn xác nhận phân đoạn -->
                        <button class="btn btn-success shadow-none" type="submit" name="chontruong">Chọn</button>
                        <br>
                    </div>
                    <?php if ($kt == true) { ?><p style="color: red;">Có: <b><?php echo $sophieu ?> </b>dòng</p><?php } ?>
                </div>
            </form>
        </div>
        <!-- Chọn loại đoạn -->
        <div class="col-md-4">
            <form method="POST" enctype="multipart/form-data">
                <div class="row">
                    <label>Chọn loại đoạn:</label>
                    <div class="col-md-7">
                        <select class="form-select shadow-none" aria-label="Default select example" name="sodong" <?php if ($khoabt  == true) { ?> disabled <?php } ?>>
                            <option value="999999999"> Tất cả</option>
                            <?php
                            for ($i = 1; $i <= 250; $i++) {
                            ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?> dòng</option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type='hidden' name="matruong" value='<?php echo $MaTruong; ?>'>
                    <!-- Btn xác nhận phân đoạn -->
                    <div class="col-md-5">
                        <button class="btn btn-success shadow-none" type="submit" name="xacnhanphandoan" <?php if ($khoabt == true) { ?> disabled <?php } ?>>Xác nhận</button>
                    </div>

                </div>
            </form>
        </div>
    </div>


    <!-- bảng kết quả phân đoạn -->
    <br>
    <div class="row">
        <h3 style="text-align:center;">Danh sách đã phân đoạn</h3>
        <div class="row">
            <div class="col-md-12">
                <!-- Ô tìm kiếm dữ liệu -->
                <form class="d-flex" style="float: right; margin-bottom: 10px;" method="get">
                    <input class="form-control me-2 shadow-none" type="text" placeholder="Tìm kiếm đoạn dữ liệu?" name="timkiemphandoan">
                    <button class="btn btn-success" type="submit" name="Timkiemdoan">Tìm</button>
                </form>
            </div>

        </div>

        <div class="row">
            <!-- Bảng dánh sách dữ liệu -->
            <table class="table table-success table-striped">
                <tr>
                    <th>STT</th>
                    <th>Mã đoạn</th>
                    <th>Tên trường</th>
                    <th>Số dòng</th>
                    <th>Tùy chọn</th>
                </tr>
                <?php

                $item_per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : 20;
                $current_page = !empty($_GET['page']) ? $_GET['page'] : 1;; //Trang hiện tại
                $offset = ($current_page - 1) * $item_per_page;
                $i = 1;
                if (isset($_GET['Timkiemdoan'])) {
                    $timkiem = $_GET['timkiemphandoan'];
                    $t = demso($conn, $timkiem);
                    $totalPages = ceil($t / $item_per_page);
                    $a = dsphanquyen($conn, $timkiem, $item_per_page, $offset);
                    //echo "<script>location.href='admin.php?route=phandoandulieu';</script>";
                } else if (!isset($_GET['Timkiemdoan'])) {
                    $t = demso($conn, '');
                    $totalPages = ceil($t / $item_per_page);
                    $a = dsphanquyen($conn, '', $item_per_page, $offset);
                }

                if ($t > 0) {
                    foreach ($a as $value) {
                        $maqp = "$value[0]";
                        $tentruong = "$value[1]";
                        $sodong = "$value[2]";
                ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $maqp  ?></td>
                            <td><?php echo $tentruong ?></td>
                            <td><?php echo $sodong ?></td>
                            <td>
                                <a href="admin.php?route=chitietphandoan&mapq=<?php echo $maqp; ?>">Chi tiết</a><br>
                                <a href="admin.php?route=phandoandulieu&&xoa=KT&mapq=<?php echo $maqp; ?>">Xóa</a>
                            </td>
                        </tr>
                    <?php
                        $i++;
                    }
                } else {
                    ?>
                    <tr>
                        <th>0</th>
                        <th>Không có dữ liệu</th>
                        <th>Không có dữ liệu</th>
                        <th>0</th>
                        <th></th>
                    </tr>
                <?php
                }
                unset($_POST['Timkiemdoan']);
                ?>
            </table>

            <!-- Phân trang -->
            <nav aria-label="Page navigation example" style="float: right;">
                <ul class="pagination">
                    <li class="page-item"><?php require_once "../function/phantrang/pagination.php"; ?></li>
                </ul>

            </nav>
        </div>
    </div>
</div>
<?php
?>