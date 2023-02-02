<?php
// include '../connect/config.php';
// $sql_dsdl = "SELECT khachhang.SDT, khachhang.HOTEN, khachhang.EMAIL, dulieukhachhang.SDTBA, dulieukhachhang.SDTME,dulieukhachhang.SDTZALO 
// FROM khachhang, dulieukhachhang
// WHERE khachhang.SDT = dulieukhachhang.SDT";
// $query_dsdl = mysqli_query($conn, $sql_dsdl);
?>
<div class="col-md-9 mainWeb">
    <h3>Danh sách dữ liệu: MISSCALL </h3><br>
    <div class="row">
        <div class="col-md-3">
            <button type="submit" class="btn btn-success shadow-none" name="xuatdulieu" data-bs-target="#dieukienxuards"
                data-bs-toggle="modal">
                <i class="fa-solid fa-file-export"></i>
                &nbsp;Xuất DS dữ liệu
            </button>
        </div>
    </div>
    <div class="row">
        <label>Chọn điều kiện lọc:</label>
        <div class="col-md-8">
            <div class="row">
                <!-- Ô dropdown input chọn điều kiện -->
                <div class="col-md-5">
                    <select id="select" class="form-select shadow-none suanghenghiep" name="dieukienloc" required
                        autofocus style="">
                        <option value="alldl" selected>Toàn bộ dữ liệu</option>
                        <option value="1">Đã liên hệ 1 lần</option>
                        <option value="2">Đã liên hệ 2 lần</option>
                        <option value="2">Đã liên hệ 3 lần</option>
                    </select>
                </div>

                <!-- Btn xác nhận chọn -->
                <div class="col-md-7">
                    <button class="btn btn-success shadow-none" name="chondieukien" type="submit">Chọn</button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <!-- Ô tìm kiếm dữ liệu -->
            <form class="d-flex" style="width: 400px; float: right;" method="GET"
                action="admin.php?route=timkiemdulieu">
                <input class="form-control me-2 shadow-none" type="text" placeholder="Tìm kiếm người dùng?"
                    name="timkiemdulieu">
                <button class="btn btn-success" type="submit">Tìm</button>
            </form><br><br>
        </div>
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
            <th>Tùy chọn</th>

        </tr>
        <!-- <?php
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
                <a href="#">Chi tiết</a><br>
                <a href="admin.php?route=suadulieu&id=<?php echo $row['SDT']; ?>">Sửa</a><br>
                <a href="admin.php?route=xoadulieu&id=<?php echo $row['SDT']; ?>">Xóa</a>
            </td>
        </tr>
        <?php
        }
        ?> -->



    </table>
    <!-- Phân trang -->
    <nav aria-label="Page navigation example" style="float: right;">
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
    </nav>
</div>