<div class="col-md-9 mainWeb">
    <?php
    include '../connect/config.php';

    // Lấy thông tin tìm kiếm từ ô tìm kiếm
    if (isset($_GET['timkiemdulieuUM'])) {
        $noidungtimkiem = $_GET['timkiemdulieuUM'];
    }
    //echo $noidungtimkiem;
    $sql_search = "SELECT DISTINCT khachhang.SDT, khachhang.HOTEN, khachhang.EMAIL, dulieukhachhang.SDTBA, dulieukhachhang.SDTME, dulieukhachhang.SDTZALO 
    FROM phanquyen, khachhang, dulieukhachhang
    WHERE khachhang.SDT = dulieukhachhang.SDT 
    AND phanquyen.SDT = $SDT
    AND phanquyen.MATRUONG = khachhang.MATRUONG
    AND khachhang.SDT LIKE '%$noidungtimkiem%' 
    OR khachhang.HOTEN LIKE '%$noidungtimkiem%' 
    OR khachhang.EMAIL LIKE '%$noidungtimkiem%'";
    $query_search = mysqli_query($conn, $sql_search);
    ?>

    <h3>Danh sách dữ liệu</h3>
    <!-- Ô tìm kiếm dữ liệu -->
    <form class="d-flex" style="width: 400px; float: right;" method="GET"
        action="usermanager.php?route=timkiemdulieuUM">
        <input class="form-control me-2 shadow-none" type="text" placeholder="Tìm kiếm người dùng?"
            name="timkiemdulieuUM">
        <button class="btn btn-success" type="submit">Tìm</button>
    </form><br><br>

    <!-- Bảng dánh sách người dùng -->
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
        while ($row = mysqli_fetch_array($query_search)) {
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
            </td>
        </tr>
        <?php
        }
        ?>



    </table>
    <!-- Phân trang -->
    <nav aria-label="Page navigation example" style="float: right;">
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
    </nav>
</div>