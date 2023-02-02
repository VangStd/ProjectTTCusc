<?php
include '../connect/config.php';
require_once "../function/functionH.php";
$kt = false;
$khoabt = true;
if (isset($_POST['xacnhanchon'])) {
    $MaTruong = $_POST['xacnhantruong'];
    if ($MaTruong != "0") {
        $khoabt = false;
    }
    $kt = true;
}
if (isset($_POST['Xacnhanphandulieu'])) {
    $sdt = $_POST['usermanager'];
    $Mapq = $_POST['doandulieu'];
    phandulieuchoUM($conn, $Mapq, $sdt);
    echo "<script>location.href='admin.php?route=phanchiadulieu';</script>";
}
if (isset($_GET['xoa'])) {
    $mapq = $_GET['mapq'];
    $dk = $_GET['xoa'];
    dkthuhoi($dk, $mapq);
    if ($dk == "yes") {
        thuhoidulieu($conn, $mapq);
        echo "<script>location.href='admin.php?route=phanchiadulieu';</script>";
    } else if ($dk == "no") {
        echo "<script>location.href='admin.php?route=phanchiadulieu';</script>";
    }
}
?>
<div class="col-md-9 mainWeb">
    <!-- Breakdrumb -->
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="bread" href="admin.php?route=home">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Phân chia dữ liệu</li>
            </ol>
        </nav>
    </div>
    <!-- End breakdrumb -->
    <div class="row phanchiadulieu">
        <h3 style="text-align:center; color: red;"> PHÂN CHIA DỮ LIỆU</h3>
        <div class="col-md-4" style="margin: auto;">
            <form method="POST" enctype="multipart/form-data">
                <label>Chọn trường:</label>
                <div class="row">
                    <div class="col-md-9">
                        <select class="form-select shadow-none" aria-label="Default select example" name="xacnhantruong">
                            <?php
                            $truong = Matruongdaphandoan($conn);
                            foreach ($truong as $value) {
                                $Matruong = "$value[0]";
                                $Tentruong = "$value[1]";
                            ?>
                                <option <?php if ($kt == true) {
                                            if ($Matruong  == $MaTruong) echo 'selected';
                                        } ?> value="<?php echo  $Matruong; ?>">
                                    <?php echo $Tentruong; ?>
                                <?php } ?>
                                </option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-success shadow-none" style="margin-top: auto;" type="submit" name="xacnhanchon">Chọn</button>
                    </div>
                </div>
            </form>
        </div>

        <form method="POST" enctype="multipart/form-data">
            <div class="col-md-4" style="margin: auto;">
                <label>Chọn User Manager:</label>
                <select class="form-select shadow-none" aria-label="Default select example" name="usermanager" <?php if ($khoabt == true) { ?> disabled <?php } ?>>
                    <?php
                    $um =  usermanagerchuaphanquyen($conn);
                    foreach ($um as $value) {
                        $SDT = "$value[0]";
                        $TenUM = "$value[1]";
                    ?>
                        <option value="<?php echo  $SDT; ?>">
                            <?php echo $TenUM; ?>
                        <?php } ?>
                        </option>
                </select>
            </div>

            <div class="col-md-4" style="margin: auto;">
                <label>Chọn đoạn dữ liệu:</label>
                <select class="form-select shadow-none" aria-label="Default select example" name="doandulieu" <?php if ($khoabt == true) { ?> disabled <?php } ?>>
                    <?php
                    if ($kt == true) {
                        echo $kt;
                        $doan = laydoanpq($conn, $MaTruong);
                        foreach ($doan as $value) {
                            $MaPQ = "$value[0]";
                            $Tendoan = "$value[1]";
                    ?>
                            <option value="<?php echo  $MaPQ; ?>">
                                <?php echo $Tendoan; ?>
                            <?php } ?>

                            </option>
                        <?php } ?>
                </select>
            </div>

            <div style="text-align:center; margin-top:10px; margin-bottom:20px;">
                <button class="btn btn-success shadow-none" style="margin-top: auto;" type="submit" name="Xacnhanphandulieu" <?php if ($khoabt == true) { ?> disabled <?php } ?>>
                    Xác nhận</button>
            </div>
        </form>
    </div>

    <br>
    <div class="row">
        <h3 style="text-align:center;">Danh sách phân chia dữ liệu</h3>
        <div class="row">
            <div class="col-md-5" style="float: right;">
                <!-- Ô tìm kiếm người dùng -->
                <div class="row">
                    <form class="d-flex" method="GET">
                        <div class="col-md-9">
                            <input class="form-control me-2 shadow-none" name="timkiemdulieudachia" type="search" placeholder="Nhập UserManager, Trường?" aria-label="Search">
                        </div>

                        <div class="col-md-3">
                            <button class="btn btn-success shadow-none" name="timkiemphanchia" type="submit">Tìm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <table class="table table-success table-striped">
            <tr>
                <th>STT</th>
                <th>Họ tên User Manager</th>
                <th>Thời gian được phân</th>
                <th>Tên trường</th>
                <th>Mã đoạn</th>
                <th>Số dòng dữ liệu</th>
                <th>Tùy chọn</th>
            </tr>
            <?php
            $item_per_page = !empty($_GET['per_page_phan_chia']) ? $_GET['per_page_phan_chia'] : 20;
            $current_page = !empty($_GET['page']) ? $_GET['page'] : 1;; //Trang hiện tại
            $offset = ($current_page - 1) * $item_per_page;
            if (isset($_GET['timkiemphanchia'])) {
                $tk = $_GET['timkiemdulieudachia'];
                $test = sodoandaduocphan($conn, $tk);
                $totalPages = ceil($test / $item_per_page);
                $a = danhsachphandulieu($conn, $tk, $item_per_page, $offset);
            } else if (!isset($_GET['timkiemphanchia'])) {
                $test = sodoandaduocphan($conn, '');
                $totalPages = ceil($test / $item_per_page);
                $a = danhsachphandulieu($conn, '', $item_per_page, $offset);
            }
            // $test = sodoandaduocphan($conn);
            // $a = danhsachphandulieu($conn);
            if ($test > 0) {
                $stt = 1;
                foreach ($a as $value) {
                    $hoten = "$value[0]";
                    $thoigian = "$value[1]";
                    $truong = "$value[2]";
                    $madoan = "$value[3]";
                    $sodong = "$value[4]";

            ?>
                    <tr>
                        <th><?php echo $stt ?></th>
                        <th><?php echo $hoten ?></th>
                        <th><?php echo date_format(date_create($thoigian), "d-m-Y H:i:s") ?></th>
                        <th><?php echo $truong ?></th>
                        <th><?php echo $madoan ?></th>
                        <th><?php echo $sodong ?></th>
                        <th><a href="admin.php?route=phanchiadulieu&&xoa=KT&&mapq=<?php echo $madoan; ?>">Thu hồi</a></th>
                    </tr>
                <?php
                    $stt++;
                }
            } else {
                ?>
                <tr>
                    <th>0</th>
                    <th>Không có dữ liệu</th>
                    <th>00-00-0000 00:00:00</th>
                    <th>Không có dữ liệu</th>
                    <th>Không có dữ liệu</th>
                    <th>0</th>
                    <th></th>
                </tr>
            <?php   } ?>
        </table>

        <!-- Phân trang -->
        <nav aria-label="Page navigation example" style="float: right;">
            <ul class="pagination">
                <li class="page-item"><?php require_once "../function/phantrang/paginationpt.php"; ?></li>
            </ul>
        </nav>
    </div>
</div>