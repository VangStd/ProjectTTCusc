<div class="col-md-9 mainWeb">
    <!-- Breakdrumb -->
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="bread" href="admin.php?route=home">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Danh sách dữ liệu</li>
            </ol>
        </nav>
    </div>
    <!-- End breakdrumb -->
    <h2>Danh sách người dùng</h2>
    <!-- Ô tìm kiếm người  dùng -->
    <form class="d-flex" style="width: 400px; float: right;" action="admin.php?route=timkiemnguoidung" method="GET">
        <input class="form-control me-2 shadow-none" name="timkiemnguoidung" type="search" placeholder="Tìm kiếm người dùng?" aria-label="Search">
        <button class="btn btn-success shadow-none" name="submit" type="submit">Tìm</button>
    </form><br><br>

    <!-- Bảng dánh sách người dùng -->
    <table class="table table-success table-striped" style="position:relative;">
        <tr class="tieude">
            <th>STT</th>
            <th>Loại Người Dùng</th>
            <th>SDT</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>Giới tính</th>
            <th>Địa chỉ</th>
            <th>Tùy chọn</th>
        </tr>
        <?php
        //  session_start();
        require_once "../function/function.php";
        $conn = connect();
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            if ($page <= 0) {
                $page = 1;
            }
        } else {
            $page = 1;
        }
        $so_dong_can_phan = 10;
        layDanhSachNguoiDung($conn, $danhsachAdmin, $danhsachUserManager);
        $i = 0;
        $dem = 0;
        $danhsach = array_merge($danhsachAdmin, $danhsachUserManager);
        if ($danhsach != null) {
            for ($i = ($page - 1) * $so_dong_can_phan; $i < count($danhsach); $i++) {
                if ($dem >= $so_dong_can_phan) {
                    break;
                }
                echo
                "<tr>
                <td>" . ($i + 1) . "</td>
                <td>" . $danhsach[$i]['loaitk'] . "</td>
                <td>" . $danhsach[$i]['SDT'] . "</td>
                <td>" . $danhsach[$i]['HOTEN'] . "</td>
                <td>" . $danhsach[$i]['EMAIL'] . "</td>
                <td>" . $danhsach[$i]['GIOITINH'] . "</td>
                <td>" . $danhsach[$i]['DIACHI'] . "</td>";
                if ($danhsach[$i]['loaitk'] === 'Admin') {
                    echo "
                <td><a href='admin.php?route=chitietnguoidung&&sdt=" . $danhsach[$i]['SDT'] . "&&user=admin'>Chi tiết</a><br>
                </td>";
                } else {
                    echo "
                <td>
                  <a href='admin.php?route=chitietnguoidung&&sdt=" . $danhsach[$i]['SDT'] . "&&user=usermanager'>Chi tiết</a><br>
                  <a href='admin.php?route=xoanguoidung&&sdt=" . $danhsach[$i]['SDT'] . "'>Xóa</a><br>
                  <a href='admin.php?route=suanguoidung&&sdt=" . $danhsach[$i]['SDT'] . "'>Sửa</a>
                </td>";
                }
                echo
                "</tr>";
                $dem++;
            }
            $_SESSION['sotrang'] = ceil(count($danhsach) / 10);
        }
        // if($danhsachUserManager !=null){
        //     foreach ( $danhsachUserManager as $value1){
        //         if($i<10){
        //             $i="0".$i;
        //         }
        //         echo"<tr>
        //         <td>".$i."</td>
        //         <td>User Manager</td>
        //         <td>".$value1['SDT']."</td>
        //         <td>".$value1['HOTEN']."</td>
        //         <td>".$value1['EMAIL']."</td>
        //         <td>".$value1['GIOITINH']."</td>
        //         <td>".$value1['DIACHI']."</td>
        //         <td>
        //             <a href='admin.php?route=chitietnguoidung&&sdt=".$value1['SDT']."&&user=usermanager'>Chi tiết</a><br>";
        //         echo" <a href='admin.php?route=xoanguoidung&&sdt=".$value1['SDT']."'>Xóa</a>
        //         </td>
        //    </tr>";
        //    $i=$i+1;
        //     }
        // }
        ?>
    </table>
    <!-- Phân trang -->
    <nav aria-label="Page navigation example" style="float: right;">
        <ul class="pagination">
            <?php
            $i = 0;
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            }
            if ($page != 1) {
                echo " 
           <li class='page-item'>
                <a class='page-link shadow-none' href='admin.php?route=hienthinguoidung&&page=" . ($page - 1) . "' aria-label='Previous'>
                    <span aria-hidden='true'>&laquo;</span>
                    <span class='sr-only'>Previous</span>
                </a>
            </li>";
            }
            for ($i = 0; $i < $_SESSION['sotrang']; $i++) {
                echo "<li class='page-item";
                if ($page == ($i + 1)) {
                    echo " active";
                }
                echo "'><a class='page-link shadow-none' href='admin.php?route=hienthinguoidung&&page=" . ($i + 1) . "'>" . ($i + 1) . "</a></li>";
            }
            if ($page < $_SESSION['sotrang']) {
                echo "
            <li class='page-item'>
                <a class='page-link shadow-none' href='admin.php?route=hienthinguoidung&&page=" . ($page + 1) . "' aria-label='Next'>
                    <span aria-hidden='true'>&raquo;</span>
                    <span class='sr-only'>Next</span>
                </a>
           </li>";
            }
            ?>
        </ul>
    </nav>
</div>