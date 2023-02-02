<?php
require_once "../function/functionH.php";
if (isset($_POST['smsuanguoidung'])) {
    //  $sdt=$_POST[];
    $hoten = $_POST['hoten'];
    $gioitinh = $_POST['gioitinh'];
    $email = $_POST['email'];
    $diachi = $_POST['diachi'];
    $sdt = $_POST['sdt'];
    // echo$sdt;
    require_once "../function/function.php";
    require_once "../connect/config.php";

    $dsemail = layDanhSachEmail($conn);
    if (timKiemEmail($email, $dsemail) == 0) {
        themNguoiDung($conn, $tendangnhap, md5($mk), $sdt, $hoten, $diachi, $email, $nguoidung, $gioitinh);
        echo "<script>alert('Tạo Người Dùng Thành Công Tên Đăng Nhập:" . $tendangnhap . " Mật khẩu:" . $mk . "');</script>";
        echo "<script>location.href='admin.php?route=hienthinguoidung';</script>";
    } else {
        echo "<script>alert('Email Bị Trùng Vui Lòng Thử Địa Chỉ Email Khác');history.back();</script>";
    }

    function timKiemEmail($email, $danhsachEmail) {
        foreach ($danhsachEmail as $values) {
            if ($values['email'] === $email) {
                return 1;
            }
        }
        return 0;
    }

    suaThongTinNguoiDung($conn, $hoten, $gioitinh, $email, $diachi, $sdt);
    echo "<script>location.href='admin.php?timkiemnguoidung=" . $sdt . "&&submit=';</script>";
}
?>
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
                <li class="breadcrumb-item active" aria-current="page">Sửa người dùng</li>
            </ol>
        </nav>
    </div>
    <!-- End breakdrumb -->
    <h3>Sửa người dùng</h3>
    <div class="formThemNguoiDung">
        <form action="admin.php?route=suanguoidung" method="POST" style="padding-left: 320px;">
            <h3 style="color:red;">THÔNG TIN NGƯỜI DÙNG</h3><br>
            <div class="col-md-6">
                <?php
                require_once "../function/function.php";
                $conn = connect();
                $sdt = $_GET['sdt'];
                $DSTT = layThongTinNguoiDung($conn, $sdt);
                echo " <label></label>Số điện thoại:</label>
               <input type='text' class='form-control shadow-none' name='sdt' value='" . $DSTT['SDT'] . " 'readonly>
               <label></label>Họ và tên:</label>
               <input type='text' class='form-control shadow-none' name='hoten' value='" . $DSTT['HOTEN'] . "'>
               <label>Giới tính:</label> &nbsp;";
                if (strtoupper($DSTT['GIOITINH']) === 'NAM') {
                    echo "  <input type='radio' name='gioitinh' value='Nam' checked>Nam&nbsp;
               <input type='radio' name='gioitinh' value='Nu' > Nữ<br><br>";
                } else {
                    echo "  <input type='radio' name='gioitinh' value='Nam'>Nam&nbsp;
                <input type='radio' name='gioitinh' value='Nu' checked> Nữ<br><br>";
                }

                echo " <label></label>Email:</label>
               <input type='email' class='form-control shadow-none' name='email' value='" . $DSTT['EMAIL'] . "'>
               <label></label>Địa chỉ:</label>
               <input type='text' class='form-control shadow-none' name='diachi' value='" . $DSTT['DIACHI'] . "'>";
                ?>

                <br>
                <button type="submit" name="smsuanguoidung" class="btn btn-success">
                    <i class="fa-solid fa-plus">&nbsp;</i>Sửa thông tin
                </button>
            </div>
        </form>
    </div>
</div>