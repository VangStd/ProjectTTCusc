<?php
include '../connect/config.php';
require_once "../function/functionH.php";
$mapq = $_GET['mapq'];
echo "<script>location.href='admin.php?route=route=chitietphandoanroute=chitietphandoan&mapq=" . $mapq . ">;</script>";
?>
<div class="col-md-9 mainWeb">
    <!-- <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="bread" href="admin.php?route=home">Trang chủ</a></li>
                <li class="breadcrumb-item">
                    <a class="bread" href="<?php if ($ad == 0) {
                                                echo "usermanager.php?";
                                            } else {
                                                echo "admin.php?";
                                            } ?>route=<?php if ($ad == 0) {
                                                            echo "danhsachdulieuUM";
                                                        } else {
                                                            echo "danhsachdulieu";
                                                        } ?>">
                        Danh sách dữ liệu
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Chi tiết dữ liệu</li>
            </ol>
        </nav> -->
    <h3 style="text-align:center;">Danh sách dữ liệu đoạn <?php echo $mapq ?></h3>
    <div class="col-md-12">
        <!-- Ô tìm kiếm dữ liệu -->
        <form class="d-flex" style="float: right; margin-bottom: 10px;" method="GET">
            <input class="form-control me-2 shadow-none" type="text" placeholder="Tìm kiếm đoạn dữ liệu?" name="timkiemctpd">
            <input type="hidden" name="mapq" value="<?php echo $mapq ?>">
            <button class="btn btn-success" name="timkiemchitietphandoan" type="submit">Tìm</button>
        </form>
    </div>
    <!-- Bảng dánh sách dữ liệu -->
    <table class="table table-success table-striped">
        <tr>
            <th>STT</th>
            <th>SDT</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>SDT BA</th>
            <th>SDT MẸ</th>
            <th>ZALO</th>
            <th>Tên Trường</th>
        </tr>
        <?php
        $stt = 1;
        $item_per_page = !empty($_GET['per_page_ct']) ? $_GET['per_page_ct'] : 20;
        $current_page = !empty($_GET['page']) ? $_GET['page'] : 1;; //Trang hiện tại
        $offset = ($current_page - 1) * $item_per_page;
        if (isset($_GET['timkiemchitietphandoan'])) {
            $timkiem = $_GET['timkiemctpd'];
            $mapq = $_GET['mapq'];
            $tong = tongdulieutrongchitietdoan($conn, $mapq, $timkiem);
            $totalPages = ceil($tong / $item_per_page);
            $a = chitietdoan($conn, $mapq, $timkiem, $item_per_page, $offset);
        } else if (!isset($_GET['timkiemchitietphandoan'])) {
            $tong = tongdulieutrongchitietdoan($conn, $mapq, '');
            $totalPages = ceil($tong / $item_per_page);
            $a = chitietdoan($conn, $mapq, '', $item_per_page, $offset);
        }
        if ($tong != 0) {
            foreach ($a as $value) {
                $sdt = "$value[0]";
                $ten = "$value[1]";
                $email = "$value[2]";
                $sdtba = "$value[3]";
                $sdtme = "$value[4]";
                $zalo = "$value[5]";
                $truong = "$value[6]";

        ?>
                <tr>
                    <td><?php echo $stt ?></td>
                    <td><?php echo $sdt ?></td>
                    <td><?php echo $ten ?></td>
                    <td><?php echo $email ?></td>
                    <td><?php echo $sdtba ?></td>
                    <td><?php echo $sdtme ?></td>
                    <td><?php echo $zalo ?></td>
                    <td><?php echo $truong ?></td>
                </tr>
            <?php
                $stt++;
            }
        } else {
            ?>
            <tr>
                <th>0</th>
                <th>Không có dữ liệu</th>
                <th>Không có dữ liệu</th>
                <th>Không có dữ liệu</th>
                <th>Không có dữ liệu</th>
                <th>Không có dữ liệu</th>
                <th>Không có dữ liệu</th>
                <th>Không có dữ liệu</th>
            </tr>
        <?php } ?>
    </table>

    <!-- Phân trang -->
    <!-- Phân trang -->
    <nav aria-label="Page navigation example" style="float: right;">
        <ul class="pagination">
            <li class="page-item"><?php require_once "../function/phantrang/paginationct.php"; ?></li>
        </ul>

    </nav>


</div>