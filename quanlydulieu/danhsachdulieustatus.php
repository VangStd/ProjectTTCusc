<?php
include '../connect/config.php';
require_once "../function/functionH.php";


$user = $_GET['maus'];
$matt = $_GET['matt'];
$lan = $_GET['lan'];
$tentt = tentrangthai($conn, $matt);
// $kt = false;

$item_per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : 20;
$current_page = !empty($_GET['page']) ? $_GET['page'] : 1;; //Trang hiện tại
$offset = ($current_page - 1) * $item_per_page;

if (isset($_GET['timkiemdanhsachtheott'])) {
    $user = $_GET['maus'];
    $matt = $_GET['matt'];
    $lan = $_GET['lan'];
    $tentt = tentrangthai($conn, $matt);
    $timkiem = $_GET['timkiemtheott'];
    if (isset($_POST['chondieukien'])) {
        $lan = $_POST['dieukienloc'];

        $tong = tongdstheott($conn, $user, $matt, $lan, $timkiem);

        $totalPages = ceil($tong / $item_per_page);
        // $kt = true;
        $a = danhsachtheott($conn, $user, $matt, $lan, $timkiem, $item_per_page, $offset);
    } else {
        $tong = tongdstheott($conn, $user, $matt, $lan, $timkiem);
        $totalPages = ceil($tong / $item_per_page);
        $a = danhsachtheott($conn, $user, $matt, $lan, $timkiem, $item_per_page, $offset);
    }
} else {
    if (isset($_POST['chondieukien'])) {
        $lan = $_POST['dieukienloc'];
        // $kt = true;
        $tong = tongdstheott($conn, $user, $matt, $lan, '');
        $totalPages = ceil($tong / $item_per_page);
        $a = danhsachtheott($conn, $user, $matt, $lan, '', $item_per_page, $offset);
    } else {
        $tong = tongdstheott($conn, $user, $matt, $lan, '');
        $totalPages = ceil($tong / $item_per_page);
        $a = danhsachtheott($conn, $user, $matt, $lan, '', $item_per_page, $offset);
    }
}
?>
<div class="col-md-9 mainWeb">
    <h3>Danh sách dữ liệu: <span><?php echo $tentt ?></span>
    </h3><br>
    <div class="row">
        <form class="col-md-3" action="../quanlydulieu/xulixuatExcel.php?user=<?php echo$user; ?>&&tt=<?php echo $matt; ?> && lan=<?php echo$lan; ?>" method="POST">
            <button type="submit" class="btn btn-success shadow-none" name="xuatdulieutheotrangthaiAdmin" data-bs-target="#dieukienxuards"
                data-bs-toggle="modal">
                <i class="fa-solid fa-file-export"></i>
                &nbsp;Xuất DS dữ liệu
            </button>
        </form>
    </div>
    <div class="row">
        <label>Chọn điều kiện lọc:</label>

        <div class="col-md-8">
            <form method="POST" enctype="multipart/form-data">
                <div class="row">
                    <!-- Ô dropdown input chọn điều kiện -->

                    <div class="col-md-4">
                        <select id="select" class="form-select shadow-none suanghenghiep" name="dieukienloc" required autofocus style="">
                            <option <?php if ($lan == 0) echo 'selected'; ?> value="0">Toàn bộ dữ liệu</option>
                            <option <?php if ($lan == 1) echo 'selected'; ?> value="1">Liên hệ lần 1</option>
                            <option <?php if ($lan == 2) echo 'selected'; ?> value="2">Liên hệ làn 2</option>
                            <option <?php if ($lan == 3) echo 'selected'; ?> value="3">Liên hệ lần 3</option>
                        </select>
                    </div>

                    <!-- Btn xác nhận chọn -->
                    <div class="col-md-7">
                        <button class="btn btn-success shadow-none" name="chondieukien" type="submit">Chọn</button>
                    </div>

                </div>
            </form>
        </div>

        <div class="col-md-4">
            <!-- Ô tìm kiếm dữ liệu -->
            <form class="d-flex" style="width: 400px; float: right;" method="GET">
                <input class="form-control me-2 shadow-none" type="text" placeholder="Tìm kiếm người dùng?" name="timkiemtheott">
                <input type="hidden" name="maus" value="<?php echo $user ?>">
                <input type="hidden" name="matt" value="<?php echo $matt ?>">
                <input type="hidden" name="lan" value="<?php echo $lan ?>">
                <button class="btn btn-success" type="submit" name="timkiemdanhsachtheott">Tìm</button>
            </form><br><br>
        </div>
    </div>


    <!-- Bảng dánh sách dữ liệu -->
    <table class="table table-success table-striped" style="position:relative;">
        <tr class="tieude">
            <th>STT</th>
            <th>SDT</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>SDT BA</th>
            <th>SDT MẸ</th>
            <th>ZALO</th>
            <th>Tùy chọn</th>

        </tr>
        <?php
        $i = 1;
        foreach ($a as $value) {
            $sdt = "$value[0]";
            if ($sdt != 0) {
                $ten = "$value[1]";
                $mail = "$value[2]";
                $sdtba = "$value[3]";
                $sdtme = "$value[4]";
                $zalo = "$value[5]";
        ?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo $sdt ?></td>
                    <td><?php echo $ten ?></td>
                    <td><?php echo $mail ?></td>
                    <td><?php echo $sdtba ?></td>
                    <td><?php echo $sdtme ?></td>
                    <td><?php echo $zalo ?></td>
                    <td>
                        <a href="<?php if ($ad == 1) { ?>?route=chitietdulieu&id=<?php echo $sdt;
                                                                            } else { ?>?route=chitietdulieuUM&id=<?php echo $sdt;
                                                                                                                                } ?>">Chi tiết</a><br>
                        <?php if ($ad == 1) { ?>
                            <a href="admin.php?route=suadulieu&id=<?php echo $sdt ?>">Sửa</a><br>
                            <a href="admin.php?route=xoadulieu&id=<?php echo $sdt ?>">Xóa</a>
                        <?php } ?>
                    </td>
                </tr>
        <?php
                $i++;
            }
        }

        ?>



    </table>
    <!-- Phân trang -->
    <nav aria-label="Page navigation example" style="float: right;">
        <ul class="pagination">
            <li class="page-item"><?php require_once "../function/phantrang/paginationtheott.php"; ?></li>
        </ul>

    </nav>
</div>