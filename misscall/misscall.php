<?php
include '../connect/config.php';

if(isset($_POST['themmisscall'])){
    $sdt=$_POST['sdtmisscall'];
    $sql1="insert into misscall values('','$sdt',now()) ";
    mysqli_query($conn,$sql1);
}

$sql_dsdl = "SELECT khachhang.SDT, khachhang.HOTEN, khachhang.EMAIL, dulieukhachhang.SDTBA, 
    dulieukhachhang.SDTME, dulieukhachhang.SDTZALO, truong.TENTRUONG
    FROM phanquyen, khachhang, dulieukhachhang, chitietpq, truong, misscall
    WHERE phanquyen.SDT = '$SDT'
    AND phanquyen.MaPQ = chitietpq.MaPQ
    AND dulieukhachhang.SDT = khachhang.SDT AND khachhang.TRANGTHAIKHACHHANG = 1
    AND khachhang.MATRUONG = truong.MATRUONG
    AND chitietpq.SDT = khachhang.SDT
    AND misscall.SDT = khachhang.sdt
    AND misscall.SDT = dulieukhachhang.sdt ";
    $query_dsdl = mysqli_query($conn, $sql_dsdl);


?>

<div class="col-md-9 mainWeb">
    <!-- Breakdrumb -->
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="usermanager.php?route=home">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Misscall</li>
            </ol>
        </nav>
    </div>
    <!-- End breakdrumb -->

    <h3 style="text-align:center; color: red;">Quản lý MISSCALL</h3>
    <!-- Thêm misscall -->
    <div class="row">
        <div class="col-md-6" style="margin: auto;">
            <div class="row">
                <form action="" method="POST">
                    <label>Số điện thoại:</label>
                    <input type="text" class="form-control shadow-none" name="sdtmisscall">
                    

                    <button class=" btn btn-success nutthemchuyende" name="themmisscall" type="submit"
                        style="width: 18%; margin-top: 15px;"><i class="fa-solid fa-plus">&nbsp;</i>Thêm
                    </button>
                </form>
            </div>
        </div>
    </div>
    <hr>

    <!-- Danh sách misscall -->
    <div class="row">
        <div class="row">
            <h3 style="text-align: center;">Danh sách dữ liệu</h3>
        </div>

        <!-- Ô tìm kiếm dữ liệu -->
        <div class="row">
            <div class="col-md-4" style="float: right;">
                <div class="row">
                    <form class="d-flex" style="width: 400px; float: right;" action="usermanager.php?route=timkiemmisscall" method="GET">
        <input class="form-control me-2 shadow-none" name="timkiem" type="search" placeholder="Tìm kiếm số điện thoại?" aria-label="Search">
        <button class="btn btn-success shadow-none" name="submit" type="submit">Tìm</button>
    </form>
                </div>
            </div>
        </div><br><br>

        <!-- Bảng dánh sách dữ liệu -->
        <div class="row">
            <table class="table table-success table-striped">
                <tr>
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
                    <td>
                        <a href="usermanager.php?route=chitietdulieuUM&id=<?php echo $row['SDT']; ?>">Chi tiết</a><br>
                        <a href="usermanager.php?route=suadulieu&id=<?php echo $row['SDT']; ?>">Sửa</a><br>
                        <a href='usermanager.php?route=xoamisscall&sdt=<?php echo $row['SDT']; ?>'>Xóa khỏi danh sách</a><br>
                    </td>
                </tr>
                <?php
            }
            ?>
            </table>

            <!-- Phân trang -->
            <!-- <nav aria-label="Page navigation example" style="float: right;">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link shadow-none" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link shadow-none" href="#">1</a></li>
                    <li class="page-item"><a class="page-link shadow-none" href="#">2</a></li>
                    <li class="page-item"><a class="page-link shadow-none" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link shadow-none" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
            </nav> -->
        </div>
    </div>
</div>