<?php
require_once "../function/functionH.php";

function xoaKiTuTiengViet($str)
{
    $unicode = array(
        'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
        'd' => 'đ',
        'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        'i' => 'í|ì|ỉ|ĩ|ị',
        'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
        'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'D' => 'Đ',
        'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
        'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
    );
    foreach ($unicode as $nonUnicode => $uni) {
        $str = preg_replace("/($uni)/i", $nonUnicode, $str);
    }
    return $str;
}
if (isset($_POST['submit'])) {
    require_once "../connect/config.php";
    require_once "../function/function.php";
    // $tendangnhap=$_POST['tendangnhap'];
    // $mk=$_POST['matkhau'];
    //$rmk=$_POST['nhaplaimatkhau'];
    $sdt = $_POST['sdt'];
    $hoten = $_POST['hoten'];
    $diachi = $_POST['diachi'];
    $email = $_POST['email'];
    $nguoidung = $_POST['nguoidung'];
    $gioitinh = $_POST['gioitinh'];
    $tendangnhap = $sdt;
    // $tendangnhap=xoaKiTuTiengViet($tendangnhap);
    //echo$gioitinh;
    $ds = laySDTAdminVaUsermn($conn);
    $dsemail = layDanhSachEmail($conn);
    $mk = randomPassword();
    if ($nguoidung === '1') {
        if (timKiemSDT($sdt, $ds) == 0) {
            if (timKiemEmail($email, $dsemail) == 0) {
                themNguoiDung($conn, $tendangnhap, md5($mk), $sdt, $hoten, $diachi, $email, $nguoidung, $gioitinh);
                echo "<script>alert('Tạo Người Dùng Thành Công Tên Đăng Nhập:" . $tendangnhap . " Mật khẩu:" . $mk . "');</script>";
                echo "<script>location.href='admin.php?route=hienthinguoidung';</script>";
            } else {
                echo "<script>alert('Email Bị Trùng Vui Lòng Thử Địa Chỉ Email Khác');history.back();</script>";
            }
        } else {
            echo "<script>alert('Số Điện Thoại Bị Trùng Vui Lòng Thử Số Khác'); history.back();</script>";
        }
    } else {
        if (timKiemSDT($sdt, $ds) == 0) {
            if (timKiemEmail($email, $dsemail) == 0) {
                themNguoiDung($conn, $tendangnhap, md5($mk), $sdt, $hoten, $diachi, $email, $nguoidung, $gioitinh);
                echo "<script>alert('Tạo Người Dùng Thành Công Tên Đăng Nhập:" . $tendangnhap . " Mật Khẩu:" . $mk . "');</script>";
                echo "<script>location.href='admin.php?route=hienthinguoidung';</script>";
            } else {
                echo "<script>alert('Email Bị Trùng Vui Lòng Thử Địa Chỉ Email Khác'); history.back();</script>";
            }
        } else {
            echo "<script>alert('Số Điện Thoại Bị Trùng Vui Lòng Thử Số Khác');history.back();</script>";
        }
    }
}
?>
<div class="col-md-9 mainWeb">
    <!-- Breakdrumb -->
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="bread" href="admin.php?route=home">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Thêm người dùng mới</li>
            </ol>
        </nav>
    </div>
    <!-- End breakdrumb -->
    <h3>Thêm người dùng mới</h3>
    <div class="formThemNguoiDung">
        <form action="admin.php?route=xulythemnguoidung" method="POST">
            <br>
            <div class="row">
                <div class="col-md-6" style="margin: auto;">
                    <br>
                    <h3 style="color:red; text-align: center;">THÔNG TIN NGƯỜI DÙNG</h3><br>
                    <div class="col-md-12">
                        <label>Nhóm người dùng:</label>
                        <select class="form-select shadow-none" name="nguoidung" required autofocus>
                            <option selected>Chọn nhóm người dùng</option>
                            <option value="1">User Manager</option>
                            <option value="2">Admin</option>
                        </select>
                        <label>Số điện thoại:</label>
                        <input type="text" class="form-control shadow-none" name="sdt" required>
                        <label>Họ và tên:</label>
                        <input type="text" class="form-control shadow-none" name="hoten" required><br>

                        <label>Giới tính: &nbsp;</label>
                        <input type="radio" name="gioitinh" value="Nam" checked="true"> Nam&nbsp;
                        <input type="radio" name="gioitinh" value="Nu"> Nữ <br><br>

                        <label>Email:</label>
                        <input type="email" class="form-control shadow-none" name="email" required>
                        <label>Địa chỉ:</label>
                        <input type="text" class="form-control shadow-none" name="diachi" required>
                        <br>
                        <button type="submit" name="submit" class="btn btn-success">
                            <i class="fa-solid fa-plus">&nbsp;</i>Thêm người dùng
                        </button>
                    </div>
                </div>
            </div>
            <br>
        </form>
    </div>
</div>