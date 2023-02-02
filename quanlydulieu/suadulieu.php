<div class="col-md-9 mainWeb">
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="bread" href="admin.php?route=home">Trang chủ</a></li>
                <li class="breadcrumb-item">
                    <a class="bread" href="<?php if ($ad == 0) {
                                                echo "usermanager.php?";
                                            } else {
                                                echo "admin.php?";
                                            } ?>route=<?php if ($ad == 0) {
                                                            echo "danhsachdulieuUM";
                                                        } else {
                                                            echo "danhsachdulieu";
                                                        } ?>">
                        Danh sách dữ liệu
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Sửa dữ liệu</li>
            </ol>
        </nav>
    </div>
    <h3>Sửa dữ liệu</h3>
    <?php
    $id = $_GET['id'];
    // echo $id;
    include '../connect/config.php';
    $sql_chitiet = "SELECT khachhang.SDT, khachhang.HOTEN, khachhang.EMAIL, dulieukhachhang.SDTBA, dulieukhachhang.SDTME, dulieukhachhang.SDTZALO, dulieukhachhang.FACEBOOK, truong.TENTRUONG, tinh.TENTINH, nghenghiep.TENNGHENGHIEP, hinhthucthuthap.TENHINHTHUC, kenhnhanthongbao.TENKENH, khoahocquantam.TENLOAIKHOAHOC
    FROM khachhang, dulieukhachhang, truong, tinh, nghenghiep, hinhthucthuthap, kenhnhanthongbao, phieudkxettuyen, khoahocquantam
    WHERE khachhang.SDT = dulieukhachhang.SDT AND khachhang.MATRUONG = truong.MATRUONG AND khachhang.MATINH = tinh.MATINH AND khachhang.MANGHENGHIEP = nghenghiep.MANGHENGHIEP AND khachhang.MAHINHTHUC = hinhthucthuthap.MAHINHTHUC AND kenhnhanthongbao.MAKENH = phieudkxettuyen.MAKENH AND khoahocquantam.MALOAIKHOAHOC = phieudkxettuyen.MALOAIKHOAHOC
    AND khachhang.SDT = $id LIMIT 1";
    $query_chitiet = mysqli_query($conn, $sql_chitiet);
    $item = mysqli_fetch_array($query_chitiet);

    //Lọc theo lần liên hệ 
    $sql_llh = "SELECT COUNT(lienhe.LAN) as soluong
    FROM phieudkxettuyen, lienhe
    WHERE phieudkxettuyen.SDT = '$id'
    AND lienhe.MAPHIEUDK = phieudkxettuyen.MAPHIEUDK";
    $query_llh = mysqli_query($conn, $sql_llh);
    $item_llh = mysqli_fetch_assoc($query_llh);

    //Định vị số lần
    if ($item_llh['soluong'] == 0) {
        $lan = 1;
    } else if ($item_llh['soluong'] == 1) {
        $lan = 2;
    } else if ($item_llh['soluong'] == 2) {
        $lan = 3;
    } else {
        $lan = 4;
    }

    $sql_lan1 = "SELECT lienhe.KETQUA, lienhe.THOIGIAN, trangthai.TENTRANGTHAI, lienhe.CHITIETTRANGTHAI
    FROM phieudkxettuyen, khachhang, lienhe, trangthai
    WHERE khachhang.SDT= phieudkxettuyen.SDT
        AND phieudkxettuyen.MAPHIEUDK= lienhe.MAPHIEUDK
        AND lienhe.MATRANGTHAI = trangthai.MATRANGTHAI
        AND khachhang.SDT ='$id' 
        AND lienhe.LAN= 1";
    $query_lan1 = mysqli_query($conn, $sql_lan1);
    $item_lan1 = mysqli_fetch_array($query_lan1);

    $sql_lan2 = "SELECT lienhe.KETQUA, lienhe.THOIGIAN, trangthai.TENTRANGTHAI, lienhe.CHITIETTRANGTHAI
    FROM phieudkxettuyen, khachhang, lienhe, trangthai
    WHERE khachhang.SDT= phieudkxettuyen.SDT
        AND phieudkxettuyen.MAPHIEUDK= lienhe.MAPHIEUDK
        AND lienhe.MATRANGTHAI = trangthai.MATRANGTHAI
        AND khachhang.SDT ='$id' 
        AND lienhe.LAN= 2";
    $query_lan2 = mysqli_query($conn, $sql_lan2);
    $item_lan2 = mysqli_fetch_array($query_lan2);

    $sql_lan3 = "SELECT lienhe.KETQUA, lienhe.THOIGIAN, trangthai.TENTRANGTHAI, lienhe.CHITIETTRANGTHAI
    FROM phieudkxettuyen, khachhang, lienhe, trangthai
    WHERE khachhang.SDT= phieudkxettuyen.SDT
        AND phieudkxettuyen.MAPHIEUDK= lienhe.MAPHIEUDK
        AND lienhe.MATRANGTHAI = trangthai.MATRANGTHAI
        AND khachhang.SDT ='$id' 
        AND lienhe.LAN= 3";
    $query_lan3 = mysqli_query($conn, $sql_lan3);
    $item_lan3 = mysqli_fetch_array($query_lan3);

    //Tìm mã liên hệ
    $sql_mlh = "SELECT phieudkxettuyen.MAPHIEUDK as maphieudk
    FROM phieudkxettuyen, khachhang
    WHERE khachhang.SDT= phieudkxettuyen.SDT
        AND khachhang.SDT ='$id'";
    $query_mlh = mysqli_query($conn, $sql_mlh);
    $mlh = mysqli_fetch_array($query_mlh);
    $maphieudk = $mlh['maphieudk'];

    //xóa sdt misscall
    $sql_misscall = "SELECT misscall.SDT FROM `misscall`";
    $query_misscall = mysqli_query($conn, $sql_misscall);
    $item_misscall = mysqli_fetch_array($query_misscall);

    // $sqlsoluonglienhe = "Select Count(MALIENHE) + 1 as sl from lienhe";
    // $query_llh1 = mysqli_query($conn, $sqlsoluonglienhe);
    // $item_llh1 = mysqli_fetch_assoc($query_llh1);
    if (isset($_POST['capnhatdulieu'])) {
        $hoten = $_POST['hoten'];
        // $tinh = $_POST['tinh'];
        // $truong = $_POST['truong'];
        $sdtba = $_POST['sdtba'];
        $sdtme = $_POST['sdtme'];
        $sdtzalo = $_POST['zalo'];
        $facebook = $_POST['facebook'];
        $email = $_POST['email'];
        $nghenghiep = $_POST['nghenghiep'];
        $nganhdangky = $_POST['nganhdangky'];
        $kenhnhanthongbao = $_POST['kenhnhanthongbao'];
        $khoahocquantam = $_POST['khoahocquantam'];
        $kqCDDH = $_POST['kqCDDH'];
        $thamgiachuyende = $_POST['chuyende'];


        // if (isset($_POST['capnhatdulieu'])) {
        //     echo "{$thamgiachuyende}";
        // }
        //Thực hiện sửa

        //Cập nhật Kết quả và ngày
        if ($lan == 1) {
            // $llh = 1;
            $ngaylienhelan1 = $_POST['ngaylienhelan1'];
            $ketqualienhelan1 = $_POST['ketqualienhelan1'];
            $matrangthailan1 = $_POST['trangthailan1'];
            $chitiettrangthailan1 = $_POST['chitiettrangthailan1'];
            $sql_sua = "INSERT INTO `lienhe` (`MAPHIEUDK`, `SDT`, `MATRANGTHAI`, `CHITIETTRANGTHAI`, `LAN`, `THOIGIAN`, `KETQUA`)
            VALUE ('$maphieudk', '$user', '$matrangthailan1', '$chitiettrangthailan1', '$lan', '$ngaylienhelan1', '$ketqualienhelan1')";
            $query_sua = mysqli_query($conn, $sql_sua);
        } else if ($lan == 2) {
            $ngaylienhelan2 = $_POST['ngaylienhelan2'];
            $ketqualienhelan2 = $_POST['ketqualienhelan2'];
            $matrangthailan2 = $_POST['trangthailan2'];
            $chitiettrangthailan2 = $_POST['chitiettrangthailan2'];
            $sql_sua = "INSERT INTO `lienhe` (`MAPHIEUDK`, `SDT`, `MATRANGTHAI`, `CHITIETTRANGTHAI`, `LAN`, `THOIGIAN`, `KETQUA`)
            VALUE ('$maphieudk', '$user', '$matrangthailan2', '$chitiettrangthailan2', '$lan', '$ngaylienhelan2', '$ketqualienhelan2')";
            $query_sua = mysqli_query($conn, $sql_sua);
        } else {
            $ngaylienhelan3 = $_POST['ngaylienhelan3'];
            $ketqualienhelan3 = $_POST['ketqualienhelan3'];
            $matrangthailan3 = $_POST['trangthailan3'];
            $chitiettrangthailan3 = $_POST['chitiettrangthailan3'];
            $sql_sua = "INSERT INTO `lienhe` (`MAPHIEUDK`, `SDT`, `MATRANGTHAI`, `CHITIETTRANGTHAI`, `LAN`, `THOIGIAN`, `KETQUA`)
            VALUE ('$maphieudk', '$user', '$matrangthailan3', '$chitiettrangthailan3', '$lan', '$ngaylienhelan3', '$ketqualienhelan3')";
            $query_sua = mysqli_query($conn, $sql_sua);
        }

        //Cập nhật thông tin cá nhân khách hàng
        $sql = "UPDATE `khachhang`, `truong`, `dulieukhachhang`
        SET `HOTEN` = '{$hoten}', `EMAIL` = '{$email}', `SDTBA` = '{$sdtba}', `SDTME` = '{$sdtme}', `SDTZALO` =
        '{$sdtzalo}', `FACEBOOK` = '{$facebook}', `MANGHENGHIEP` = '{$nghenghiep}'
        WHERE khachhang.MATRUONG = truong.MATRUONG
        AND khachhang.SDT = dulieukhachhang.SDT
        AND khachhang.TRANGTHAIKHACHHANG = 1
        AND khachhang.SDT = '$id'";
        if (mysqli_query($conn, $sql)) {
            require_once "../function/functionH.php";
            NhatKysuadulieu($conn, $id);
            echo "<script>
                            alert('Đã cập nhật')
                            location.replace('usermanager.php?route=suadulieu&id=$id');
            </script>";
        } else {
            echo "Lỗi:" . mysqli_errno($conn);
        }
        //Cập nhật phiếu đăng ký xét tuyển
        $sql_phieudkxettuyen = "UPDATE `khachhang`, `phieudkxettuyen`
        SET `MAKENH` = '$kenhnhanthongbao' , `MALOAIKHOAHOC` = '$khoahocquantam', `MAKETQUA` = '$kqCDDH', `NGANHDK` = '$nganhdangky'
        WHERE khachhang.SDT = phieudkxettuyen.SDT
        AND khachhang.SDT = '$id'";
        if (mysqli_query($conn, $sql_phieudkxettuyen)) {
            require_once "../function/functionH.php";
            NhatKysuadulieu($conn, $id);
            echo "<script>
                            alert('Đã cập nhật')
                            location.replace('usermanager.php?route=suadulieu&id=$id');
            </script>";
        } else {
            echo "Lỗi:" . mysqli_errno($conn);
        }
        //Cập nhật tham gia chuyên đề

        $macd = $_POST['macd'];
        $sql_thamgiachuyende = "INSERT INTO `chitietchuyende` (`MACHUYENDE`, `MAPHIEUDK`, `TRANGTHAI`)
            VALUE ('$macd','$maphieudk', '$thamgiachuyende')";
        $query_chuyende = mysqli_query($conn, $sql_thamgiachuyende);

        //Xóa sdt misscall
        if ($id == $item_misscall['SDT']) {
            $sql_mc = "UPDATE khachhang SET khachhang.TRANGTHAIKHACHHANG = 0 WHERE SDT = '$id'";
            if (mysqli_query($conn, $sql_mc)) {
                require_once "../function/functionH.php";
                NhatKysuadulieu($conn, $id);
                echo "<script>
                                alert('Đã cập nhật')
                                location.replace('usermanager.php?route=suadulieu&id=$id');
                </script>";
            } else {
                echo "Lỗi:" . mysqli_errno($conn);
            }
        }
    }

    ?>
    <h2 style="text-align:center;">Chi tiết dữ liệu</h2>
    <div class="row">
        <div>
            <h4>Thông tin cá nhân</h4>

            <!-- <p><?php echo $item_llh['soluong']; ?></p> -->
            <form action="" method="POST">
                <table class="bangchitiet">
                    <tr>

                        <td>Họ và tên:</td>
                        <td> <input required type="text" name="hoten" value="<?php echo $item['HOTEN'] ?>"
                                class="inputsuadulieu">

                        </td>
                    </tr>
                    <tr>
                        <td>Tỉnh/Thành phố: </td>
                        <td>
                            <select class="form-select shadow-none " name="tinh" required autofocus style="width: 73%;"
                                disabled>
                                <?php
                                include '../connect/config.php';
                                $sql_tinh = "SELECT tinh.MATINH, tinh.TENTINH FROM tinh, khachhang 
                            WHERE khachhang.MATINH = tinh.MATINH
                            AND khachhang.SDT = '$id'";
                                $query_tinh = mysqli_query($conn, $sql_tinh);
                                $num = mysqli_fetch_array($query_tinh);

                                $sql_tinh2 = "SELECT * FROM tinh";
                                $query_tinh2 = mysqli_query($conn, $sql_tinh2);
                                while ($row = mysqli_fetch_array($query_tinh2)) {
                                ?>
                                <option value="<?php echo $row['MATINH']; ?>" <?php
                                                                                    if ($row['MATINH'] == $num['MATINH']) {
                                                                                        echo "selected";
                                                                                    }
                                                                                    ?>><?php echo $row['TENTINH']; ?>
                                </option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Trường: </td>
                        <td>
                            <select class="form-select shadow-none " name="truong" style="width: 73%;" disabled>
                                <?php
                                include '../connect/config.php';
                                $sql_truong = "SELECT truong.MATRUONG, truong.TENTRUONG FROM truong, khachhang 
                            WHERE khachhang.MATRUONG = truong.MATRUONG
                            AND khachhang.SDT = '$id'";
                                $query_truong = mysqli_query($conn, $sql_truong);
                                $num = mysqli_fetch_array($query_truong);

                                $sql_truong2 = "SELECT * FROM truong";
                                $query_truong2 = mysqli_query($conn, $sql_truong2);
                                while ($row = mysqli_fetch_array($query_truong2)) {
                                ?>
                                <option value="<?php echo $row['MATRUONG']; ?>" <?php
                                                                                    if ($row['MATRUONG'] == $num['MATRUONG']) {
                                                                                        echo "selected";
                                                                                    }
                                                                                    ?>>
                                    <?php echo $row['TENTRUONG']; ?>
                                </option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                </table>
        </div>
        <div>
            <h4>Thông tin liên hệ</h4>
            <table class="bangchitiet">
                <tr>
                    <td>Điện thoại: </td>
                    <td><input required type="text" name="sdt" value="<?php echo $item['SDT'] ?>" class="inputsuadulieu"
                            disabled>
                    </td>
                </tr>
                <tr>
                    <td>Điện thoại ba:</td>
                    <td><input type="text" name="sdtba" value="<?php if (!empty($item['SDTBA'])) {
                                                                    echo  $item['SDTBA'];
                                                                } else {
                                                                    echo "Không có";
                                                                } ?>" style="width: 73%;"></td>
                </tr>
                <tr>
                    <td>Điện thoại mẹ:</td>
                    <td><input type="text" name="sdtme" value="<?php if (!empty($item['SDTME'])) {
                                                                    echo  $item['SDTME'];
                                                                } else {
                                                                    echo "Không có";
                                                                } ?>" style="width: 73%;"></td>
                </tr>
                <tr>
                    <td>Số Zalo:</td>
                    <td><input type="text" name="zalo" value="<?php if (!empty($item['SDTZALO'])) {
                                                                    echo  $item['SDTZALO'];
                                                                } else {
                                                                    echo "Không có";
                                                                } ?>" style="width: 73%;"></td>
                </tr>
                <tr>
                    <td>Facebook:</td>
                    <td><input required type="facebook" name="facebook" value="<?php if (!empty($item['FACEBOOK'])) {
                                                                                    echo  $item['FACEBOOK'];
                                                                                } else {
                                                                                    echo "Không có";
                                                                                } ?>" style="width: 73%;"></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input type="email" name="email" value="<?php echo $item['EMAIL'] ?>" style="width: 73%;"></td>
                </tr>
            </table>
        </div>
        <div>
            <h4>Đối tượng</h4>
            <table class="bangchitiet">

                <?php
                include '../connect/config.php';
                // $sql_chuyende = "SELECT chitietchuyende.TRANGTHAI
                //     FROM chitietchuyende, phieudkxettuyen, khachhang, chuyende
                //     WHERE chitietchuyende.MAPHIEUDK = phieudkxettuyen.MAPHIEUDK
                //     AND chitietchuyende.MACHUYENDE = chuyende.MACHUYENDE
                //     AND phieudkxettuyen.SDT = khachhang.SDT
                //     AND khachhang.SDT = $id";
                // $query_chuyende = mysqli_query($conn, $sql_chuyende);
                // $item_chuyende = mysqli_fetch_array($query_chuyende);
                $sql_cdgn = "SELECT THOIGIANTOCHUCCHUYENDE FROM `chuyende` WHERE THOIGIANTOCHUCCHUYENDE>CURRENT_DATE";
                $query_cdgn = mysqli_query($conn, $sql_cdgn);
                $item_cdgn = mysqli_fetch_array($query_cdgn);
                if (!empty($item_cdgn)) {
                    $sql_tenchuyende = "SELECT * FROM `chuyende` WHERE THOIGIANTOCHUCCHUYENDE >= ALL(SELECT THOIGIANTOCHUCCHUYENDE FROM `chuyende` WHERE THOIGIANTOCHUCCHUYENDE>CURRENT_DATE)";
                    $query_tenchuyende = mysqli_query($conn, $sql_tenchuyende);
                    $item_tenchuyende = mysqli_fetch_array($query_tenchuyende);

                    if (!empty($item_tenchuyende) && $maphieudk != NULL) {
                        $macd = $item_tenchuyende['MACHUYENDE'];

                        $sql_ctchuyende = "SELECT chitietchuyende.TRANGTHAI FROM `chitietchuyende`,phieudkxettuyen 
                            WHERE chitietchuyende.MACHUYENDE='$macd' and 
                            chitietchuyende.MAPHIEUDK=phieudkxettuyen.MAPHIEUDK and phieudkxettuyen.SDT='$id'";
                        $query_ctchuyende = mysqli_query($conn, $sql_ctchuyende);
                        $item_ctchuyende = mysqli_fetch_array($query_ctchuyende);

                ?>
                <input required type="hidden" name="macd" value="<?php echo $macd ?>">
                <tr>
                    <td>Tham gia chuyền đề:</td>
                    <td>

                        <select class="form-select shadow-none chuyende" name="chuyende" required autofocus
                            style="width: 73%;" <?php if (!empty($item_ctchuyende)) { ?> disable <?php } ?>>
                            <option value="dongy"
                                <?php if ($item_ctchuyende['TRANGTHAI'] == "dongy") echo "selected" ?>>
                                Đồng ý: <?php echo $item_tenchuyende['TENCHUYENDE']; ?>
                            </option>
                            <option value="kodongy"
                                <?php if (empty($item_ctchuyende) || $item_ctchuyende['TRANGTHAI'] == "kodongy") echo "selected" ?>>
                                Không đồng ý: <?php echo $item_tenchuyende['TENCHUYENDE']; ?>
                            </option>
                            <option value="xemlai"
                                <?php if ($item_ctchuyende['TRANGTHAI'] == "xemlai") echo "selected" ?>>Xem lại
                            </option>

                    </td>
                </tr>
                <?php }
                } ?>
                <tr>
                    <td>Nghề nghiệp:</td>
                    <td>
                        <select class="form-select shadow-none suanghenghiep" name="nghenghiep" required autofocus
                            style="width: 73%;">
                            <?php
                            include '../connect/config.php';
                            $sql_nghenghiep = "SELECT nghenghiep.MANGHENGHIEP, nghenghiep.TENNGHENGHIEP
                                FROM khachhang, nghenghiep
                                WHERE khachhang.MANGHENGHIEP = nghenghiep.MANGHENGHIEP
                                AND khachhang.SDT = '$id'";
                            $query_nghenghiep = mysqli_query($conn, $sql_nghenghiep);
                            $num = mysqli_fetch_array($query_nghenghiep);

                            $sql_nghenghiep2 = "SELECT * FROM nghenghiep";
                            $query_nghenghiep2 = mysqli_query($conn, $sql_nghenghiep2);
                            while ($row = mysqli_fetch_array($query_nghenghiep2)) {
                            ?>
                            <option value="<?php echo $row['MANGHENGHIEP']; ?>" <?php
                                                                                    if ($row['MANGHENGHIEP'] == $num['MANGHENGHIEP']) {
                                                                                        echo "selected";
                                                                                    }
                                                                                    ?>>
                                <?php echo $row['TENNGHENGHIEP']; ?>
                            </option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Ngành yêu thích: </td>
                    <td>
                        <?php
                        include '../connect/config.php';
                        $sql_nganhyeuthich = "SELECT nganhyeuthich.CHITIET
                        FROM nganhyeuthich, khachhang
                        WHERE nganhyeuthich.SDT = khachhang.SDT
                        AND khachhang.SDT = ' $id'";
                        $query_nganhyeuthich = mysqli_query($conn, $sql_nganhyeuthich);
                        $item_nganhyeuthich = mysqli_fetch_array($query_nganhyeuthich);
                        ?>
                        <p style="color:black;"><?php
                                                if (!empty($item_nganhyeuthich['CHITIET'])) {
                                                    echo $item_nganhyeuthich['CHITIET'];
                                                } else {
                                                    echo "Chưa có";
                                                } ?></p>
                    </td>
                </tr>
                <tr>
                    <td>Ngành đăng kí: </td>
                    <td>
                        <select class="form-select shadow-none chuyende" name="nganhdangky" required autofocus
                            style="width: 73%;">
                            <?php
                            include '../connect/config.php';
                            $sql_nganhdangky = "SELECT phieudkxettuyen.NGANHDK as MANGANH
                            FROM phieudkxettuyen, khachhang
                            WHERE phieudkxettuyen.SDT = khachhang.SDT
                            AND khachhang.SDT = '$id'";
                            $query_nganhdangky = mysqli_query($conn, $sql_nganhdangky);
                            $item_nganhdangky = mysqli_fetch_array($query_nganhdangky);

                            $sql_nganhdangky_2 = "SELECT * FROM nganh";
                            $query_nganhdangky_2 = mysqli_query($conn, $sql_nganhdangky_2);
                            while ($row_nganhdangky = mysqli_fetch_array($query_nganhdangky_2)) {
                            ?>
                            <option value="<?php echo $row_nganhdangky['MANGANH'] ?>"
                                <?php if (($item_nganhdangky['MANGANH'] != NULL) && ($item_nganhdangky['MANGANH'] == $row_nganhdangky['MANGANH'])) echo "selected"; ?>>
                                <?php echo $row_nganhdangky['TENNGANH']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Hình thức thu nhập:</td>
                    <td><?php echo $item['TENHINHTHUC'] ?></td>
                </tr>
            </table>
            <br>
        </div>

        <div>
            <h4>Phiếu đăng kí xét tuyển</h4>
            <table class="bangchitiet">
                <tr>
                <tr>
                    <td>Kênh nhận thông báo:</td>
                    <td>
                        <select class="form-select shadow-none suanghenghiep" name="kenhnhanthongbao" required autofocus
                            style="width: 73%;">
                            <?php
                            include '../connect/config.php';
                            $sql_kenhthongbao = "SELECT kenhnhanthongbao.MAKENH, kenhnhanthongbao.TENKENH
                            FROM kenhnhanthongbao, dulieukhachhang, phieudkxettuyen, khachhang
                            WHERE khachhang.SDT = '$id'
                            AND khachhang.SDT = dulieukhachhang.SDT
                            AND phieudkxettuyen.MAKENH = kenhnhanthongbao.MAKENH
                            AND khachhang.SDT = phieudkxettuyen.SDT";
                            $query_kenhthongbao = mysqli_query($conn, $sql_kenhthongbao);
                            $num = mysqli_fetch_array($query_kenhthongbao);

                            $sql_kenhthongbao2 = "SELECT * FROM kenhnhanthongbao";
                            $query_kenhthongbao2 = mysqli_query($conn, $sql_kenhthongbao2);
                            while ($row = mysqli_fetch_array($query_kenhthongbao2)) {
                            ?>
                            <option value="<?php echo $row['MAKENH'] ?>" <?php
                                                                                if ($row['MAKENH'] == $num['MAKENH']) {
                                                                                    echo "selected";
                                                                                }
                                                                                ?>>
                                <?php echo $row['TENKENH'] ?>
                            </option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>

                </tr>
                </tr>
                <tr>
                    <td>Khóa học quan tâm: </td>
                    <td>
                        <select class="form-select shadow-none suanghenghiep" name="khoahocquantam" required autofocus
                            style="width: 73%;">
                            <?php
                            include '../connect/config.php';
                            $sql_khoahoc = "SELECT khoahocquantam.MALOAIKHOAHOC, khoahocquantam.TENLOAIKHOAHOC
                            FROM khoahocquantam, phieudkxettuyen, khachhang
                            WHERE phieudkxettuyen.MALOAIKHOAHOC = khoahocquantam.MALOAIKHOAHOC
                            AND khachhang.SDT = phieudkxettuyen.SDT
                            AND khachhang.SDT = '$id'";
                            $query_khoahoc = mysqli_query($conn, $sql_khoahoc);
                            $num = mysqli_fetch_array($query_khoahoc);

                            $sql_khoahoc2 = "SELECT * FROM khoahocquantam";
                            $query_khoahoc2 = mysqli_query($conn, $sql_khoahoc2);
                            while ($row = mysqli_fetch_array($query_khoahoc2)) {
                            ?>
                            <option value="<?php echo $row['MALOAIKHOAHOC'] ?>" <?php
                                                                                    if ($row['MALOAIKHOAHOC'] == $num['MALOAIKHOAHOC']) {
                                                                                        echo "selected";
                                                                                    }
                                                                                    ?>>
                                <?php echo $row['TENLOAIKHOAHOC'] ?>
                            </option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>

                </tr>
                <tr>
                    <td>Hồ sơ:</td>
                    <td>
                        <?php
                        include '../connect/config.php';
                        $sql_hoso = "SELECT phieudkxettuyen.HOSO
                             FROM phieudkxettuyen, khachhang
                             WHERE phieudkxettuyen.SDT = khachhang.SDT
                             AND khachhang.SDT = '$id'";
                        $query_hoso = mysqli_query($conn, $sql_hoso);
                        $item_hoso = mysqli_fetch_array($query_hoso);
                        ?>
                        <p style="color:black;"><?php if (!empty($item_hoso)) {
                                                    echo $item_hoso['HOSO'];
                                                } else {
                                                    echo "Chưa có phiếu đăng ký";
                                                } ?></p>
                    </td>
                </tr>
                <tr>
                    <td>Kết quả Cao đẳng/Đại học:</td>
                    <td>
                        <select class="form-select shadow-none kqCDDH" name="kqCDDH" required autofocus
                            style="width: 73%;">
                            <?php
                            include '../connect/config.php';
                            $sql_kqCDDH = "SELECT ketquatotnghiep.KETQUA, ketquatotnghiep.MAKETQUA
                                FROM ketquatotnghiep, phieudkxettuyen, khachhang
                                WHERE ketquatotnghiep.MAKETQUA = phieudkxettuyen.MAKETQUA
                                AND phieudkxettuyen.SDT = khachhang.SDT
                                AND khachhang.SDT = '$id'";
                            $query_kqCDDH = mysqli_query($conn, $sql_kqCDDH);
                            $num_kqCDDH = mysqli_fetch_array($query_kqCDDH);

                            $sql_kqCDDH2 = "SELECT * FROM ketquatotnghiep";
                            $query_kqCDDH2 = mysqli_query($conn, $sql_kqCDDH2);
                            while ($row_kqCDDH = mysqli_fetch_array($query_kqCDDH2)) {
                            ?>
                            <option value="<?php echo $row_kqCDDH['MAKETQUA'] ?>" <?php if ($row_kqCDDH['MAKETQUA'] == $num_kqCDDH['MAKETQUA']) {
                                                                                            echo "selected";
                                                                                        } ?>>
                                <?php echo $row_kqCDDH['KETQUA']; ?>
                            </option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
            </table>
        </div>

        <div>
            <h4>Thống kê kết quả</h4>
            <table class="bangchitiet">

                <tr>
                    <h5>Lần 1</h5>
                    <td>Ngày/Tháng: </td>
                    <td><input type="date" name="ngaylienhelan1" value="<?php if (!empty($item_lan1['THOIGIAN'])) {
                                                                            echo  $item_lan1['THOIGIAN'];
                                                                        } else {
                                                                            echo "Chưa liên hệ";
                                                                        } ?>" style="width: 73%;" <?php
                                                                                                    if ($lan == 2 || $lan == 3 || $lan == 4) {
                                                                                                        echo "disabled";
                                                                                                    }
                                                                                                    ?>></td>
                </tr>
                <tr>
                    <td>Trạng thái:</td>
                    <td>
                        <?php
                        if ($lan == 2 || $lan == 3 || $lan == 4) {
                            include '../connect/config.php';
                            $sql_trangthailan1 = "SELECT trangthai.MATRANGTHAI, trangthai.TENTRANGTHAI
                            FROM trangthai, lienhe, phieudkxettuyen, khachhang
                            WHERE trangthai.MATRANGTHAI = lienhe.MATRANGTHAI
                            AND lienhe.MAPHIEUDK = phieudkxettuyen.MAPHIEUDK
                            AND phieudkxettuyen.SDT = khachhang.SDT
                            AND khachhang.SDT = '$id'
                            AND lienhe.LAN = 1";
                            $query_trangthailan1 = mysqli_query($conn, $sql_trangthailan1);
                            $num_trangthailan1 = mysqli_fetch_array($query_trangthailan1);

                            $sql_trangthailan1_2 = "SELECT * FROM trangthai";
                            $query_trangthailan1_2 = mysqli_query($conn, $sql_trangthailan1_2);

                            echo "<select class='form-select shadow-none kqCDDH' name='trangthailan1' style='width: 73%;' disabled      >";
                            while ($row_trangthailan1 = mysqli_fetch_array($query_trangthailan1_2)) {
                                echo "<option value='" . $row_trangthailan1["MATRANGTHAI"] . "'";
                                if ($row_trangthailan1["MATRANGTHAI"] == $num_trangthailan1["MATRANGTHAI"]) echo "selected";
                                echo ">"
                                    . $row_trangthailan1["TENTRANGTHAI"] .
                                    "</option>";
                            }
                            echo "</select>";
                        }
                        ?>
                        <select class="form-select shadow-none kqCDDH" name="trangthailan1" style="width: 73%; 
                        <?php
                        if ($lan == 2 || $lan == 3 || $lan == 4) {
                            echo "display: none;";
                        }
                        ?>
                        ">
                            <option value="tt01">Quan tâm</option>
                            <option value="tt02">Theo dõi</option>
                            <option value="tt03">Hẹn nộp phiếu DKXT</option>
                            <option value="tt04">Chưa gặp</option>
                            <option value="tt05">Đóng</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Chi tiết trạng thái: </td>
                    <td><input type="text" name="chitiettrangthailan1" value="<?php if (!empty($item_lan1['CHITIETTRANGTHAI'])) {
                                                                                    echo  $item_lan1['CHITIETTRANGTHAI'];
                                                                                } else {
                                                                                    echo "Chưa liên hệ";
                                                                                } ?>" style="width: 73%;" <?php
                                                                                                            if ($lan == 2 || $lan == 3 || $lan == 4) {
                                                                                                                echo "disabled";
                                                                                                            }
                                                                                                            ?>></td>
                </tr>
                <tr>
                    <td>Kết quả: </td>
                    <td><input type="text" name="ketqualienhelan1" value="<?php if (!empty($item_lan1['KETQUA'])) {
                                                                                echo  $item_lan1['KETQUA'];
                                                                            } else {
                                                                                echo "Chưa liên hệ";
                                                                            } ?>" style="width: 73%;" <?php
                                                                                                        if ($lan == 2 || $lan == 3 || $lan == 4) {
                                                                                                            echo "disabled";
                                                                                                        }
                                                                                                        ?>></td>
                </tr>
            </table>

            <table class="bangchitiet">

                <tr>
                    <h5>Lần 2</h5>
                    <td>Ngày/Tháng: </td>
                    <td><input type="date" name="ngaylienhelan2" value="<?php if (!empty($item_lan2['THOIGIAN'])) {
                                                                            echo  $item_lan2['THOIGIAN'];
                                                                        } else {
                                                                            echo "Chưa liên hệ";
                                                                        } ?>" style="width: 73%;" <?php
                                                                                                    if ($lan == 1 || $lan == 3 || $lan == 4) {
                                                                                                        echo "disabled";
                                                                                                    }
                                                                                                    ?>></td>
                </tr>
                <tr>
                    <td>Trạng thái:</td>
                    <td>
                        <?php
                        if ($lan == 1 || $lan == 3 || $lan == 4) {
                            include '../connect/config.php';
                            $sql_trangthailan2 = "SELECT trangthai.MATRANGTHAI, trangthai.TENTRANGTHAI
                            FROM trangthai, lienhe, phieudkxettuyen, khachhang
                            WHERE trangthai.MATRANGTHAI = lienhe.MATRANGTHAI
                            AND lienhe.MAPHIEUDK = phieudkxettuyen.MAPHIEUDK
                            AND phieudkxettuyen.SDT = khachhang.SDT
                            AND khachhang.SDT = '$id'
                            AND lienhe.LAN = 2";
                            $query_trangthailan2 = mysqli_query($conn, $sql_trangthailan2);
                            $num_trangthailan2 = mysqli_fetch_array($query_trangthailan2);

                            $sql_trangthailan2_2 = "SELECT * FROM trangthai";
                            $query_trangthailan2_2 = mysqli_query($conn, $sql_trangthailan2_2);

                            echo "<select class='form-select shadow-none kqCDDH' name='trangthailan2' style='width: 73%;' disabled      >";
                            while ($row_trangthailan2 = mysqli_fetch_array($query_trangthailan2_2)) {
                                echo "<option value='" . $row_trangthailan2["MATRANGTHAI"] . "'";
                                if ($row_trangthailan2["MATRANGTHAI"] == $num_trangthailan2["MATRANGTHAI"]) echo "selected";
                                echo ">"
                                    . $row_trangthailan2["TENTRANGTHAI"] .
                                    "</option>";
                            }
                            echo "</select>";
                        }
                        ?>
                        <select class="form-select shadow-none kqCDDH" name="trangthailan2" style="width: 73%; 
                        <?php
                        if ($lan == 1 || $lan == 3 || $lan == 4) {
                            echo "display: none;";
                        }
                        ?>
                        ">
                            <option value="tt01">Quan tâm</option>
                            <option value="tt02">Theo dõi</option>
                            <option value="tt03">Hẹn nộp phiếu DKXT</option>
                            <option value="tt04">Chưa gặp</option>
                            <option value="tt05">Đóng</option>
                        </select>
                    </td>

                </tr>
                <tr>
                    <td>Chi tiết trạng thái: </td>
                    <td><input type="text" name="chitiettrangthailan2" value="<?php if (!empty($item_lan2['CHITIETTRANGTHAI'])) {
                                                                                    echo  $item_lan2['CHITIETTRANGTHAI'];
                                                                                } else {
                                                                                    echo "Chưa liên hệ";
                                                                                } ?>" style="width: 73%;" <?php
                                                                                                            if ($lan == 1 || $lan == 3 || $lan == 4) {
                                                                                                                echo "disabled";
                                                                                                            }
                                                                                                            ?>></td>
                </tr>
                <tr>
                    <td>Kết quả: </td>
                    <td><input type="text" name="ketqualienhelan2" value="<?php if (!empty($item_lan2['KETQUA'])) {
                                                                                echo  $item_lan2['KETQUA'];
                                                                            } else {
                                                                                echo "Chưa liên hệ";
                                                                            } ?>" style="width: 73%;" <?php
                                                                                                        if ($lan == 1 || $lan == 3 || $lan == 4) {
                                                                                                            echo "disabled";
                                                                                                        }
                                                                                                        ?>></td>
                </tr>
            </table>

            <table class="bangchitiet">

                <tr>
                    <h5>Lần 3</h5>
                    <td>Ngày/Tháng: </td>
                    <td><input type="date" name="ngaylienhelan3" value="<?php if (!empty($item_lan3['THOIGIAN'])) {
                                                                            echo  $item_lan3['THOIGIAN'];
                                                                        } else {
                                                                            echo "Chưa liên hệ";
                                                                        } ?>" style="width: 73%;" <?php
                                                                                                    if ($lan == 1 || $lan == 2 || $lan == 4) {
                                                                                                        echo "disabled";
                                                                                                    }
                                                                                                    ?>></td>
                </tr>
                <tr>
                    <td>Trạng thái:</td>
                    <td>
                        <?php
                        if ($lan == 1 || $lan == 2 || $lan == 4) {
                            include '../connect/config.php';
                            $sql_trangthailan3 = "SELECT trangthai.MATRANGTHAI, trangthai.TENTRANGTHAI
                            FROM trangthai, lienhe, phieudkxettuyen, khachhang
                            WHERE trangthai.MATRANGTHAI = lienhe.MATRANGTHAI
                            AND lienhe.MAPHIEUDK = phieudkxettuyen.MAPHIEUDK
                            AND phieudkxettuyen.SDT = khachhang.SDT
                            AND khachhang.SDT = '$id'
                            AND lienhe.LAN = 3";
                            $query_trangthailan3 = mysqli_query($conn, $sql_trangthailan3);
                            $num_trangthailan3 = mysqli_fetch_array($query_trangthailan3);

                            $sql_trangthailan3_2 = "SELECT * FROM trangthai";
                            $query_trangthailan3_2 = mysqli_query($conn, $sql_trangthailan3_2);

                            echo "<select class='form-select shadow-none kqCDDH' name='trangthailan3' style='width: 73%;' disabled      >";
                            while ($row_trangthailan3 = mysqli_fetch_array($query_trangthailan3_2)) {
                                echo "<option value='" . $row_trangthailan3["MATRANGTHAI"] . "'";
                                if ($row_trangthailan3["MATRANGTHAI"] == $num_trangthailan3["MATRANGTHAI"]) echo "selected";
                                echo ">"
                                    . $row_trangthailan3["TENTRANGTHAI"] .
                                    "</option>";
                            }
                            echo "</select>";
                        }
                        ?>
                        <select class="form-select shadow-none kqCDDH" name="trangthailan3" style="width: 73%; 
                        <?php
                        if ($lan == 1 || $lan == 2 || $lan == 4) {
                            echo "display: none;";
                        }
                        ?>
                        ">
                            <option value="tt01">Quan tâm</option>
                            <option value="tt02">Theo dõi</option>
                            <option value="tt03">Hẹn nộp phiếu DKXT</option>
                            <option value="tt04">Chưa gặp</option>
                            <option value="tt05">Đóng</option>
                        </select>
                    </td>

                </tr>
                <tr>
                    <td>Chi tiết trạng thái: </td>
                    <td><input type="text" name="chitiettrangthailan3" value="<?php if (!empty($item_lan3['CHITIETTRANGTHAI'])) {
                                                                                    echo  $item_lan3['CHITIETTRANGTHAI'];
                                                                                } else {
                                                                                    echo "Chưa liên hệ";
                                                                                } ?>" style="width: 73%;" <?php
                                                                                                            if ($lan == 1 || $lan == 2 || $lan == 4) {
                                                                                                                echo "disabled";
                                                                                                            }
                                                                                                            ?>></td>
                </tr>
                <tr>
                    <td>Kết quả: </td>
                    <td><input type="text" name="ketqualienhelan3" value="<?php if (!empty($item_lan3['KETQUA'])) {
                                                                                echo  $item_lan3['KETQUA'];
                                                                            } else {
                                                                                echo "Chưa liên hệ";
                                                                            } ?>" style="width: 73%;" <?php
                                                                                                        if ($lan == 1 || $lan == 2 || $lan == 4) {
                                                                                                            echo "disabled";
                                                                                                        }
                                                                                                        ?>></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row" style="float: right;">
        <div class="col-md-3" style="width: 98%; margin: 10px;">
            <button class="btn btn-success shadow-none" name="capnhatdulieu">Cập nhật dữ liệu</button>
        </div>
        </form>
    </div>
</div>