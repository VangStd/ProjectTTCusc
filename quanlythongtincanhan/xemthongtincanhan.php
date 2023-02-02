<?php
//session_start();
include "../connect/config.php";
$id = $_GET['id'];
//echo $id;
$ad = 0;
if (strlen($id) > 10) {
    $sql = "SELECT admin.MAADMIN, admin.HOTEN, admin.GIOITINH, admin.SDT, admin.DIACHI, admin.EMAIL, taikhoan.TENDANGNHAP, taikhoan.MATKHAU 
            FROM admin, taikhoan 
            WHERE admin.MAADMIN = taikhoan.MAADMIN AND  admin.MAADMIN = '" . $id . "'";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query);
    $hoten = $row['HOTEN'];
    $sdtadmin= $row['SDT'];
    $ad = 1;
} else {
    $sql = "SELECT * FROM usermanager,taikhoan WHERE usermanager.SDT = taikhoan.SDT AND usermanager.SDT = '" . $id . "'";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query);
    $hoten = $row['HOTEN'];
}
if (isset($_POST['xacnhandoimatkhau'])) {
    $password_old = md5($_POST['matkhaucu']);
    $password_new = md5($_POST['matkhaumoi']);
    $password_Confirm = md5($_POST['xacnhanmatkhaumoi']);
    if ($ad == 1) {
        $sql = "UPDATE taikhoan SET MATKHAU = '$password_new' WHERE MAADMIN = '" . $id . "'";
        $query = mysqli_query($conn, $sql);
    } else {
        $sql = "UPDATE taikhoan SET MATKHAU = '$password_new' WHERE SDT = '" . $id . "'";
        $query = mysqli_query($conn, $sql);
    }
}
?>
<div class="col-md-9 mainWeb">
    <!-- Breakdrumb -->
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="bread" href="admin.php?route=home">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Thông tin cá nhân</li>
            </ol>
        </nav>
    </div>
    <!-- End breakdrumb -->
    <h3>Xem thông tin cá nhân</h3>
    <!-- Ảnh đại diện và background -->
    <div class="row">
        <div class="col-md-12 avtxemthongtincanhan">
            <img src="../images/logo.png" alt="" style="width: 100%;height: 90%; margin-top: 7px;">
        </div>
    </div>

    <!-- Thông tin cá nhân -->
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-md-12 thongtincanhan">
            <!-- Bảng thông tin -->
            <table class=" table">
                <tr>
                    <td><b>Mã tài khoản</b></td>
                    <td><?php
                        if (strlen($id) > 10) {
                            echo $row['MAADMIN'];
                        } else {
                            echo $row['SDT'];
                        }

                        ?></td>
                </tr>
                <tr>
                    <td><b>Họ và tên</b></td>
                    <td><?php echo $row['HOTEN'] ?></td>
                </tr>
                <tr>
                    <td><b>Giới tính</b></td>
                    <td><?php echo $row['GIOITINH'] ?></td>
                </tr>
                <tr>
                    <td><b>Số điện thoại</b></td>
                    <td><?php 
                        if (strlen($id) > 10) {
                            echo $sdtadmin;
                        } else {
                            echo $row['SDT'];
                        }
                     ?></td>
                </tr>
                <tr>
                    <td><b>Địa chỉ</b></td>
                    <td><?php echo $row['DIACHI'] ?></td>
                </tr>
                <tr>
                    <td><b>Email</b></td>
                    <td><?php echo $row['EMAIL'] ?></td>
                </tr>
                <tr>
                    <td><b>Tên đăng nhập</b></td>
                    <td><?php echo $row['TENDANGNHAP']; ?></td>
                </tr>
                <tr>
                    <td><b>Mật khẩu</b></td>
                    <td>
                        <?php


                        for ($i = 0; $i <  strlen(md5($row['MATKHAU'])); $i++) {   ?>
                        <span>
                            <?php
                                echo '*';
                                ?>
                        </span>
                        <?php } ?>

                        <button type="submit" id="doimatkhau" style="float: right;">
                            <i class="fa-solid fa-pen-to-square"></i>&nbsp;</i>
                            Đổi mật khẩu
                        </button>

                        <div class="doimatkhau">
                            <form method="POST">
                                <input type="password" name="matkhaucu" placeholder="Mật khẩu cũ"><br><br>
                                <input type="password" name="matkhaumoi" placeholder="Mật khẩu mới" required
                                    onkeyup="ktpass_new()"><br>
                                <span class="Matkhaumoi"></span><br>
                                <input type="password" name="xacnhanmatkhaumoi" placeholder="Xác nhận mật khẩu mới"
                                    required onkeyup="ktpass_confirm()"><br>
                                <span class="Xacnhanmatkhaumoi"></span><br>
                                <button type="submit" class="btn btn-outline-success" name="xacnhandoimatkhau">Xác
                                    nhận</button>
                            </form>
                        </div>
                    </td>
                </tr>
            </table><br>

            <!-- Nút Sửa thông tin -->
            <button type="submit" class="btn btn-success btnsuathongtin">
                <i class="fa-solid fa-pen-to-square"></i>&nbsp;</i>
                <a href="<?php if ($ad == 0) echo "usermanager.php" ?>?route=suathongtincanhan&id=<?php echo $id ?>"
                    style="text-decoration: none; color: white;">
                    Sửa thông tin</a>
            </button>
        </div>
    </div>
    <script>
    var pass_new = document.querySelector('input[name="matkhaumoi"]');
    var pass_Confirm = document.querySelector('input[name="xacnhanmatkhaumoi"]');
    var pass_news = document.querySelector('.Matkhaumoi');
    var pass_Confirms = document.querySelector('.Xacnhanmatkhaumoi');

    function ktpass_new() {
        if (pass_new.value.length < 8) {
            pass_new.setAttribute('style', 'border-color: red');
            pass_news.innerText = 'Vui lòng nhập mật khẩu trên 8 ký tự';
        } else {
            pass_new.setAttribute('style', 'border-color: #000');
            pass_news.innerText = '';
        }
    }

    function ktpass_confirm() {
        if (pass_new.value != pass_Confirm.value) {
            pass_Confirm.setAttribute('style', 'border-color: red');
            pass_Confirms.innerText = 'Nhập khẩu nhập lại không trùng khớp';
        } else {
            pass_Confirm.setAttribute('style', 'border-color: #000');
            pass_Confirms.innerText = '';
        }
    }

    // Hiển thị thẻ div sửa mật khẩu
    const hienthiinput = document.querySelector('#doimatkhau')
    const doimatkhau = document.querySelector('.doimatkhau')
    hienthiinput.addEventListener('click', () => {
        doimatkhau.style.display = 'block'
    })
    </script>

</div>