<?php

include "../connect/config.php";
$id = $_GET['id'];
if (strlen($id) > 10) {
    $sql = "SELECT * FROM admin WHERE MAADMIN = '" . $id . "'";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query);
    $hoten = $row['HOTEN'];
} else {
    $sql = "SELECT * FROM usermanager WHERE SDT = '" . $id . "'";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query);
    $hoten = $row['HOTEN'];
}
if (isset($_POST['suathongtincanhan'])) {
    $hoten = $_POST['hoten'];
    $gioitinh = $_POST['gioitinh'];
    $diachi = $_POST['diachi'];
    $email = $_POST['email'];
    if (strlen($id) > 10) {
        $sql = "UPDATE `admin` SET `HOTEN`='$hoten',`GIOITINH`='$gioitinh',`DIACHI`='$diachi',`EMAIL`='$email' WHERE MAADMIN = '" . $id . "'";
        $query = $conn->query($sql);
        echo "<script>location.href='admin.php?route=xemthongtincanhan&id=$id';</script>";
        // echo"<script>location.href='admin.php?route=xemthongtincanhan';</script>";
        // header("Location: admin.php");
    } else {
        $sql = "UPDATE `usermanager` SET `HOTEN`='$hoten',`GIOITINH`='$gioitinh',`EMAIL`='$email',`DIACHI`='$diachi' WHERE SDT = '" . $id . "'";
        $query = $conn->query($sql);
    }
}

?>

<div class="col-md-9 mainWeb">
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="bread" href="admin.php?route=home">Trang chủ</a></li>
                <li class="breadcrumb-item">
                    <a class="bread" href="<?php echo "admin.php?route=xemthongtincanhan" ?>">
                        Thông tin cá nhân
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Sửa thông tin cá nhân</li>
            </ol>
        </nav>
    </div>
    <h3>Sửa thông tin cá nhân</h3>
    <div class="formThemNguoiDung">
        <form action="#" method="POST" style="padding-left: 320px;">
            <br>
            <h3>THÔNG TIN CÁ NHÂN</h3><br>
            <div class="col-md-6">
                <label>Mã tài khoản:</label>
                <input type="text" class="form-control shadow-none" name="mataikhoan" value="<?php
                                                                                                if (strlen($id) > 10) {
                                                                                                    echo $row['MAADMIN'];
                                                                                                } else {
                                                                                                    echo $row['SDT'];
                                                                                                }

                                                                                                ?>" disabled>
                <label>Họ và tên:</label>
                <input type="text" class="form-control shadow-none" name="hoten"
                    value="<?php echo $row['HOTEN'] ?>"><br>
                <label>Giới tính:</label>
                <input type="radio" class="form-check-input shadow-none" name="gioitinh" value="Nam"
                    <?php echo ($row['GIOITINH'] == 'Nam') ?  "checked" : ""; ?>> Nam
                <input type="radio" class="form-check-input shadow-none" name="gioitinh" value="Nữ"
                    <?php echo ($row['GIOITINH'] == 'Nữ') ?  "checked" : ""; ?>> Nữ
                <br><br>
                <label>Số điện thoại:</label>
                <label class="form-control shadow-none"><?php echo $row['SDT'] ?></label>
                <label>Địa chỉ:</label>
                <input type="text" class="form-control shadow-none" name="diachi" value="<?php echo $row['DIACHI']; ?>">
                <label>Email:</label>
                <input type="email" class="form-control shadow-none" name="email" value="<?php echo $row['EMAIL']; ?>">

                <br>
                <button type="submit" name="suathongtincanhan" class="btn btn-success">
                    <i class="fa-solid fa-pen-to-square"></i>&nbsp;</i>Sửa thông tin
                </button>
            </div>
        </form>
    </div>
</div>