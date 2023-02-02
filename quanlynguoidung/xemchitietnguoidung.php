<div class="col-md-9 mainWeb">
    <!-- Breakdrumb -->
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="bread" href="admin.php?route=home">Trang chủ</a></li>
                <li class="breadcrumb-item">
                    <a class="bread" href="<?php echo "admin.php?route=hienthinguoidung" ?>">
                        Danh sách người dùng
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Chi tiết người dùng</li>
            </ol>
        </nav>
    </div>
    <!-- End breakdrumb -->
    <h3>Chi tiết người dùng</h3> <br>
    <hr>
    <div class="row">
        <!-- Thông tin cá nhân -->
        <div class="col-md-6 chitietthongtincanhan">
            <h5>THÔNG TIN CÁ NHÂN</h5>
            <table class=" table">
                <?php
                require_once "../connect/config.php";
                require_once "../function/function.php";
                $sdt = $_GET['sdt'];
                $user = $_GET['user'];
                if ($user === "usermanager") {
                    $chitietusermn = hienThiChiTietUserManager($conn, $sdt);
                    echo " 
               <tr>
                    <td><b>Loại người dùng</b></td>
                    <td>UserManager</td>
                </tr>
                <tr>
                    <td><b>SDT</b></td>
                    <td>" . $chitietusermn['SDT'] . "</td>
                </tr>
                <tr>
                    <td><b>Họ và tên</b></td>
                    <td>" . $chitietusermn['HOTEN'] . "</td>
                </tr>
                <tr>
                    <td><b>Giới tính</b></td>
                    <td>" . $chitietusermn['GIOITINH'] . "</td>
                </tr>
                <tr>
                    <td><b>Email</b></td>
                    <td>" . $chitietusermn['EMAIL'] . "</td>
                </tr>
                <tr>
                    <td><b>Địa chỉ</b></td>
                    <td>" . $chitietusermn['DIACHI'] . "</td>
                </tr>";
                } else {
                    $chitietad = hienThiChiTietAdmin($conn, $sdt);
                    echo " 
                    <tr>
                         <td><b>Loại người dùng</b></td>
                         <td>Admin</td>
                     </tr>
                     <tr>
                         <td><b>SDT</b></td>
                         <td>" . $chitietad['SDT'] . "</td>
                     </tr>
                     <tr>
                         <td><b>Họ và tên</b></td>
                         <td>" . $chitietad['HOTEN'] . "</td>
                     </tr>
                     <tr>
                         <td><b>Giới tính</b></td>
                         <td>" . $chitietad['GIOITINH'] . "</td>
                     </tr>
                     <tr>
                         <td><b>Email</b></td>
                         <td>" . $chitietad['EMAIL'] . "</td>
                     </tr>
                     <tr>
                         <td><b>Địa chỉ</b></td>
                         <td>" . $chitietad['DIACHI'] . "</td>
                     </tr>";
                }
                ?>
            </table><br>

            <!-- Nút Sửa thông tin -->
            <!-- <button type="submit" class="btn btn-success btnsuathongtin">
                <i class="fa-solid fa-pen-to-square"></i>&nbsp;</i>
                <a href="admin.php?route=suathongtincanhan&id=<?php echo $chitietusermn['SDT'] ?>"
                    style="text-decoration: none; color: white;">
                    Sửa thông tin</a>
            </button> -->
        </div>

        <!-- Danh sách trường được phân công -->
        <div class="col-md-6 dstruongduocphancong">
            <h5>DANH SÁCH TRƯỜNG ĐƯỢC PHÂN CÔNG</h5>
            <table class=" table">
                <?php
                require_once "../connect/config.php";
                require_once "../function/function.php";
                $sdt = $_GET['sdt'];
                $user = $_GET['user'];
                $dstentruong = layTenTruongDuocPhanQuyen($conn, $sdt);
                echo
                "<tr>
                  <th>STT</th>
                  <th>Tên trường</th>
               </tr>";
                if ($dstentruong == null) {
                    echo
                    "
                <tr>
                    <td></td>
                    <td>Chưa Được Phân Công</td>
                </tr>";
                } else {
                    $i = 1;
                    foreach ($dstentruong as $values) {
                        echo
                        "
                <tr>
                    <td>" . $i . "</td>
                    <td>" . $values['TENTRUONG'] . "</td>
                </tr>";
                        $i++;
                    }
                }
                ?>
            </table>
        </div>
    </div>
</div>