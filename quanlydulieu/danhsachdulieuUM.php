<?php
include '../connect/config.php';
$sql_dsdl = "SELECT khachhang.SDT, khachhang.HOTEN, khachhang.EMAIL, dulieukhachhang.SDTBA, 
dulieukhachhang.SDTME, dulieukhachhang.SDTZALO
FROM phanquyen, khachhang, dulieukhachhang, chitietpq
WHERE phanquyen.SDT = '$SDT'
AND phanquyen.MaPQ = chitietpq.MaPQ
AND dulieukhachhang.SDT = khachhang.SDT AND khachhang.TRANGTHAIKHACHHANG = 1
AND chitietpq.SDT = khachhang.SDT";
$query_dsdl = mysqli_query($conn, $sql_dsdl);
$query_dsdl_2 = mysqli_query($conn, $sql_dsdl);

$data = [];
while ($row = mysqli_fetch_array($query_dsdl_2)) {
    $data[] = $row;
}
$default_page = 20;
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
    $sql_dsdl = "SELECT khachhang.SDT, khachhang.HOTEN, khachhang.EMAIL, dulieukhachhang.SDTBA, 
    dulieukhachhang.SDTME, dulieukhachhang.SDTZALO, truong.TENTRUONG
    FROM phanquyen, khachhang, dulieukhachhang, chitietpq, truong
    WHERE phanquyen.SDT = '$SDT'
    AND phanquyen.MaPQ = chitietpq.MaPQ
    AND dulieukhachhang.SDT = khachhang.SDT
    AND khachhang.MATRUONG = truong.MATRUONG
    AND chitietpq.SDT = khachhang.SDT LIMIT $currentIndex, $default_page";
    $query_dsdl = mysqli_query($conn, $sql_dsdl);
}

?>
<div class="col-md-9 mainWeb"><br>
    <!-- Breakdrumb -->
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="usermanager.php?route=homeUM">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Danh sách dữ liệu</li>
            </ol>
        </nav>
    </div>
    <!-- End breakdrumb -->

    <h3 style="text-align: center; color:red;">DANH SÁCH DỮ LIỆU</h3>
    <div class="row">
        <div class="col-md-3">
            <button type="submit" class="btn btn-success shadow-none" name="xuatdulieu" data-bs-target="#dieukienxuards"
                data-bs-toggle="modal">
                <i class="fa-solid fa-file-export"></i>
                &nbsp;Xuất DS dữ liệu
            </button>
        </div>

        <!-- The Modal -->
        <div class="modal" id="dieukienxuards">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Xuất dữ liệu sang file Excel</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                  <?php if(isset($_POST['dieukienloc'])) { echo $_POST['dieukienloc'];} ?>
                    <!-- Modal body -->
                    <form method="POST" action="../quanlydulieu/xulixuatExcel.php">
                        <div class="modal-body">
                            <label>Điều kiện:</label><br>
                            <input type="radio" name="dieukienloc" value="all">&nbsp; Toàn bộ Danh Sách <br>
                            <input type="radio" name="dieukienloc" value="1">&nbsp; Danh sách liên hệ lần 1 <br>
                            <input type="radio" name="dieukienloc" value="2">&nbsp; Danh sách liên hệ lần 2 <br>
                            <input type="radio" name="dieukienloc" value="3">&nbsp; Danh sách liên hệ lần 3 <br>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">

                            <button type="submit" class="btn btn-danger" name="xacnhanxuatdsdl">Xác nhận</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><br>

    <div class="row">
        <!-- Ô điều kiện lọc -->
        <div class="col-md-6">
            <label>Chọn điều kiện lọc:</label>
            <div class="row">
                <!-- Ô dropdown input chọn điều kiện -->
                <div class="col-md-8">
                    <select id="select" class="form-select shadow-none suanghenghiep" name="dieukienloc" required
                        autofocus style="">
                        <option value="alldl" selected>Toàn bộ dữ liệu</option>
                        <option value="0">Chưa liên hệ</option>
                        <option value="1">Đã liên hệ 1 lần</option>
                        <option value="2">Đã liên hệ 2 lần</option>
                    </select>
                </div>

                <!-- Btn xác nhận chọn -->
                <div class="col-md-4">
                    <button class="btn btn-success shadow-none" name="chondieukien" type="submit">Chọn</button>
                </div>
            </div>
        </div>

        <!-- Ô tìm kiểm -->
        <div class="col-md-6">
            <br>
            <form class="d-flex" style="width: 80%; float: right;" method="GET"
                action="usermanager.php?route=timkiemdulieuUM">
                <input class="form-control me-2 shadow-none" type="text" placeholder="Tìm kiếm người dùng?"
                    name="timkiemdulieuUM">
                <button class="btn btn-success shadow-none" type="submit">Tìm</button>
            </form>
        </div>
    </div>

    <br>
    <div class="row">
        <!-- Bảng dánh sách người dùng -->
        <table class="table table-success table-striped">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>SDT</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>SDT BA</th>
                    <th>SDT MẸ</th>
                    <th>ZALO</th>
                    <th>Trường</th>
                    <th>Tùy chọn</th>

                </tr>
            </thead>
            <tbody id="tr-list-user">
                <?php
                $i = 0;
                while ($row = mysqli_fetch_array($query_dsdl)) {
                    $i++;
                ?>

                <tr>
                    <td><?php echo  $i  ?></td>
                    <td><?php echo $row['SDT']; ?></td>
                    <td><?php echo $row['HOTEN']; ?></td>
                    <td><?php echo $row['EMAIL']; ?></td>
                    <td><?php echo $row['SDTBA']; ?></td>
                    <td><?php echo $row['SDTME']; ?></td>
                    <td><?php echo $row['SDTZALO']; ?></td>
                    <td><?php echo $row['TENTRUONG']; ?></td>
                    <td>
                        <a href="usermanager.php?route=chitietdulieuUM&id=<?php echo $row['SDT']; ?>">Chi tiết</a><br>
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        <!-- Phân trang -->
        <nav aria-label="Page navigation example" style="float: right;">
            <ul class="pagination">
                <!-- <li class="page-item">
                    <a class="page-link shadow-none" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a> -->
                <?php


                for ($i = 1; $i <= $pages; $i++) {
                    if (!isset($_GET['page'])) {
                        $_GET['page'] = 1;
                    }
                    if ($i == $_GET['page']) {
                        echo ' <li class="page-item active"><a class="page-link shadow-none" href="usermanager.php?route=danhsachdulieu&page=' . $i . '">' . $i
                            . '</a></li>';
                    } else {
                        echo ' <li class="page-item"><a class="page-link shadow-none" href="usermanager.php?route=danhsachdulieu&page=' . $i . '">' . $i
                            . '</a></li>';
                    }
                } ?>
            </ul>
        </nav>
    </div>
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="../include/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/js/bootstrap.min.js"></script> -->
</div>

<script>
const selectEl = document.getElementById('select')

if (selectEl) {
    selectEl.onchange = async (e) => {
        const filterValue = e.target.value;
        // console.log(filterValue);
        if (filterValue) {

            const res = fetch(`../quanlydulieu/filter.php?llh=${filterValue}`)
                .then(res => res.json())
                .then(
                    data => {
                        const trElement = document.getElementById('tr-list-user')
                        const paginationElement = document.querySelector('.pagination')
                        const result = data && data.map((item, index) => {
                            return (
                                `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${item.SDT}</td>
                                    <td>${item.HOTEN}</td>
                                    <td>${item.EMAIL}</td>
                                    <td>${item.SDTBA}</td>
                                    <td>${item.SDTME}</td>
                                    <td>${item.SDTZALO}</td>
                                    <td>${item.TENTRUONG}</td>
                                    <td>
                                        <a href="usermanager.php?route=chitietdulieuUM&id=${item.SDT}&lan=${filterValue}">Chi tiết</a><br>
                                    </td>
                                </tr>
                                `
                            )
                        })

                        trElement.innerHTML = result.join('')
                        if (data) {
                            paginationElement.style.display = 'none'
                        }
                    }
                )
                .catch(
                    err => console.log(err)
                )
        }
    }
}
</script>