<?php
include '../connect/config.php';
$sql_dsdl = "SELECT khachhang.SDT, khachhang.HOTEN, khachhang.EMAIL, dulieukhachhang.SDTBA, dulieukhachhang.SDTME,dulieukhachhang.SDTZALO, truong.TENTRUONG
FROM khachhang, dulieukhachhang, truong
WHERE khachhang.SDT = dulieukhachhang.SDT 
AND khachhang.MATRUONG = truong.MATRUONG";
$query_dsdl = mysqli_query($conn, $sql_dsdl);

//Phân trang
$query_dsdl_2 = mysqli_query($conn, $sql_dsdl);
$data = [];
while ($row = mysqli_fetch_array($query_dsdl_2)) {
    $data[] = $row;
}
$default_page = 100;
// tổng số trang: 
$pages = ceil(count($data) / $default_page);
$page = 1;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
if ($page <= 0) {
    $page = 1;
}
$currentIndex = ($page - 1) * $default_page;
if ($page > 0) {
    $sql_dsdl = "SELECT khachhang.SDT, khachhang.HOTEN, khachhang.EMAIL, dulieukhachhang.SDTBA, dulieukhachhang.SDTME,dulieukhachhang.SDTZALO, truong.TENTRUONG
    FROM khachhang, dulieukhachhang, truong
    WHERE khachhang.SDT = dulieukhachhang.SDT AND khachhang.TRANGTHAIKHACHHANG = 1
    AND khachhang.MATRUONG = truong.MATRUONG LIMIT $currentIndex, $default_page";
    $query_dsdl = mysqli_query($conn, $sql_dsdl);
}
// Phân trang

?>
<div class="col-md-9 mainWeb">

    <!-- Breakdrumb -->
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="admin.php?route=home">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Danh sách dữ liệu</li>
            </ol>
        </nav>
    </div>
    <!-- End breakdrumb -->
    <h3>Danh sách dữ liệu Admin</h3>
    <div class="row">
        <form class="col-md-3" action="../quanlydulieu/xulixuatExcel.php" method="POST">
            <button type="submit" class="btn btn-success shadow-none" name="xuatdulieu">
                <i class="fa-solid fa-file-export"></i>
                &nbsp;Xuất DS dữ liệu
            </button>
        </form>
        <div class="col-md-9">
            <!-- Ô tìm kiếm dữ liệu -->
            <form class="d-flex" style="width: 400px; float: right;" method="GET"
                action="admin.php?route=timkiemdulieu">
                <input class="form-control me-2 shadow-none" type="text" placeholder="Tìm kiếm người dùng?"
                    name="timkiemdulieu">
                <button class="btn btn-success" type="submit">Tìm</button>
            </form>
        </div>
    </div>
    <br>

    <!-- Bảng dánh sách người dùng -->
    <table class="table table-success table-striped" style="position:relative;">
        <tr class="tieude">
            <th>STT</th>
            <th>SDT</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>SDT BA</th>
            <th>SDT MẸ</th>
            <th>ZALO</th>
            <th>Tên Trường</th>
            <th>Tùy chọn</th>

        </tr>
        <?php
        $i = 0;
        while ($row = mysqli_fetch_array($query_dsdl)) {
            $i++;
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row['SDT']; ?></td>
            <td><?php echo $row['HOTEN']; ?></td>
            <td><?php echo $row['EMAIL']; ?></td>
            <td><?php echo $row['SDTBA']; ?></td>
            <td><?php echo $row['SDTME']; ?></td>
            <td><?php echo $row['SDTZALO']; ?></td>
            <td><?php echo $row['TENTRUONG']; ?></td>
            <td>
                <a href="admin.php?route=chitietdulieu&id=<?php echo $row['SDT']; ?>">Chi tiết</a><br>
                <a href="admin.php?route=xoadulieu&id=<?php echo $row['SDT']; ?>">Xóa</a>
            </td>
        </tr>
        <?php
        }
        ?>



    </table>
    <!-- Phân trang -->
    <nav aria-label="Page navigation example" style="float: right;">
        <ul class="pagination">
            <!-- <li class="page-item">
                <a class="page-link shadow-none" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li> -->

            <?php


            for ($i = 1; $i <= $pages; $i++) {
                if (!isset($_GET['page'])) {
                    $_GET['page'] = 1;
                }
                if ($i == $_GET['page']) {
                    echo ' <li class="page-item active"><a class="page-link shadow-none" href="admin.php?route=danhsachdulieu&page=' . $i . '">' . $i
                        . '</a></li>';
                } else {
                    echo ' <li class="page-item"><a class="page-link shadow-none" href="admin.php?route=danhsachdulieu&page=' . $i . '">' . $i
                        . '</a></li>';
                }
            } ?>

            <!-- <li class="page-item"><a class="page-link shadow-none" href="#">1</a></li>
            <li class="page-item"><a class="page-link shadow-none" href="#">2</a></li>
            <li class="page-item"><a class="page-link shadow-none" href="#">3</a></li> -->
            <!-- <li class="page-item">
                <a class="page-link shadow-none" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li> -->
        </ul>
    </nav>
</div>