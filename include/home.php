<?php
//index.php
include '../connect/config.php';
require_once "../function/functionH.php";
$lan = 0;
$dc = 1;
?>

<?php
//index.php
$chart_data = '';
$ngaybd = 0;
$ngaykt = 0;
$b = 0;

//nhat ky

$date = date('Y-m-d');
$newdate = strtotime('-1 day', strtotime($date));

$ngaybatdau = date('Y-m-d', $newdate);
$ngayketthuc = $date;

?>
<?php

include("../function/functionThongKe.php");

if (isset($_POST['themghichu'])) {
    $noidung = $_POST['ghichu'];

    themGhiChuAD($conn, $user, $noidung);
}

if (isset($_POST['capnhatghichu'])) {
}
?>

<div class="col-md-9 mainWeb">
    <div class="row">
        <div class="col-md-4 kqkt">
            <div class="row2">
                <?php
                /* $user = 0; */
                if ($dc == 1) {
                    $tong = SophieuDK($conn,'',$lan);
                    if ($lan == 0) {
                        $phieudkxt = sophieuDKtheoTT($conn,'',$lan);
                        foreach ($phieudkxt as $value) {
                            $matt = "$value[0]";
                            $tentt = "$value[1]";
                            $sophieu = "$value[2]";
                            $thongke = thongketheoKQkhaithac($conn, '', $matt);
                ?>
                            <div class="col-md-12 kq">


                                <div class="theketquathongke2">
                                    <h3 class="box-title tentrangthaithongke2"><?php echo $tentt ?></h3>
                                    <div class="row">
                                        <div class="col-md-1">
                                            <i class="fa-solid fa-book-bookmark labelthongke"></i>
                                        </div>
                                        <div class="col-md-11">
                                            <h5><?php echo $sophieu  ?>/<span><?php echo $tong ?></span> phiếu</h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-1">
                                            <i class="fa-solid fa-square-phone labelthongke"></i>
                                        </div>
                                        <div class="col-md-11">
                                            <p>ĐÃ LIÊN HỆ: <?php echo $thongke ?>(Lần 1,2,3)</p>
                                        </div>
                                    </div>
                                </div><br>
                            </div>
                        <?php
                        }
                    } else if ($lan != 0) {
                        $phieudkxt = sophieuDKtheoTT($conn,'',$lan);
                        foreach ($phieudkxt as $value) {
                            $matt = "$value[0]";
                            $tentt = "$value[1]";
                            $sophieu = "$value[2]";
                            $thongke = thongketheoKQkhaithactheolan($conn,'', $matt, $lan);
                        ?>
                            <br>
                            <div class="col-md-12 kq">
                                <div class="theketquathongke2">
                                    <h3 class="box-title tentrangthaithongke"><?php echo $tentt ?></h3>
                                    <div class="row">
                                        <div class="col-md-1">
                                            <i class="fa-solid fa-book-bookmark labelthongke"></i>
                                        </div>
                                        <div class="col-md-11">
                                            <p>- <?php echo $tentt ?>: <?php echo $sophieu ?>/<?php echo $tong ?> phiếu XT</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-1">
                                            <i class="fa-solid fa-square-phone labelthongke"></i>
                                        </div>
                                        <div class="col-md-11">
                                            <p>- ĐÃ LIÊN HỆ: <?php echo $thongke ?> (Lần 1,2,3)</p>
                                        </div>
                                    </div>
                                </div><br>
                            </div>
                <?php
                        }
                    }
                }

                ?>
            </div>

        </div>

        <div class="col-md-8 left">
            <div class="row">
                <div class="col-md-12 xnk">
                    <h2>Nhật ký thay đổi (từ <?php echo $ngaybatdau ?> : <?php echo $ngayketthuc ?>)</h2>

                    <?php
                    if ($ngaybatdau != 0) {
                    ?>
                        <table class="table table-success table-striped">
                            <tr>
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
                                            <td><?php echo $thoigian ?></td>
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
                                        <td>0000-00-00 00:00:00</td>
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

                <div class="row">
                    <div class="col-md-9 tasks">
                        <h5 style="text-align: center; color: red;">GHI CHÚ</h5>
                        <!-- Form ghi chú -->
                        <form action="#" method="post">
                            <!-- Thêm ghi chú -->
                            <div class="row">
                                <form action="../function/functionThongKe.php" method="post">
                                    <div class="col-md-9">
                                        <input type="text" name="ghichu" placeholder="Thêm ghi chú" style="width: 99%;">
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn-success shadow-none" name="themghichu" style="width: 99%;">
                                            <i class="fa-solid fa-plus"></i>&nbsp;Thêm</button>
                                    </div>
                                </form>
                            </div>
                            <hr>
                            <div class="formghichu">
                                <?php
                                $sql = "SELECT * FROM ghichu WHERE MAADMIN= '" . $user . "'";
                                $qr = mysqli_query($conn, $sql);
                                $mangghichu = mysqli_fetch_array($qr);

                                if (!empty($mangghichu)) {
                                    $i = 0;
                                    while ($rows = mysqli_fetch_array($qr)) {
                                        $i++;
                                ?>
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        <input type="hidden" name="ghichu" <?php if ($rows['TRANGTHAI'] == 1) echo "checked" ?>>
                                        <label><?php echo $rows['NOIDUNG'] ?></label>
                                        <a href="<?php if ($ad == 0) {
                                                        echo "usermanager.php?";
                                                    } else {
                                                        echo "admin.php?";
                                                    } ?>route=xoaghichu&ID= <?php echo $rows['STT'] ?>">Xóa</a><br>
                                <?php
                                    }
                                } else {
                                    echo "Chưa có ghi chú nào!";
                                }
                                ?>

                            </div><br>

                        </form>
                        <hr>

                    </div>
                    <div class="col-md-3 lich">
                        <div class="lichthang2" style=" position: absolute;">
                            <script type="text/javascript" language="JavaScript" src="http://www.informatik.uni-leipzig.de/~duc/amlich/JavaScript/amlich-hnd.js">
                            </script>
                            <script language="JavaScript">
                                setOutputSize("small");
                                document.writeln(printSelectedMonth());
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </div>
</div>