<div class="col-md-9 mainWeb">
    <?php
    $id = $_GET['id'];

    // Nhận dạng UM và AD
    $nguoidangnhap = $_SESSION['login'];
    $ad = 0;
    if (strlen($nguoidangnhap) > 10) {
        $ad = 1;
    }

    include '../connect/config.php';
    $sql_chitiet = "SELECT khachhang.SDT, khachhang.HOTEN, khachhang.EMAIL, dulieukhachhang.SDTBA, dulieukhachhang.SDTME, dulieukhachhang.SDTZALO, dulieukhachhang.FACEBOOK, tinh.TENTINH, truong.TENTRUONG, nghenghiep.TENNGHENGHIEP, hinhthucthuthap.TENHINHTHUC, kenhnhanthongbao.TENKENH, khoahocquantam.TENLOAIKHOAHOC, phieudkxettuyen.HOSO
    FROM khachhang, dulieukhachhang, tinh, truong, nghenghiep, hinhthucthuthap, kenhnhanthongbao, phieudkxettuyen,khoahocquantam
    WHERE khachhang.SDT = dulieukhachhang.SDT
    AND khachhang.MATINH = tinh.MATINH
    AND khachhang.MATRUONG = truong.MATRUONG
    AND khachhang.MANGHENGHIEP = nghenghiep.MANGHENGHIEP
    AND khachhang.MAHINHTHUC = hinhthucthuthap.MAHINHTHUC
    AND phieudkxettuyen.MAKENH = kenhnhanthongbao.MAKENH
    AND phieudkxettuyen.MALOAIKHOAHOC = khoahocquantam.MALOAIKHOAHOC
    AND khachhang.TRANGTHAIKHACHHANG = 1
    AND khachhang.SDT = $id";
    $query_chitiet = mysqli_query($conn, $sql_chitiet);
    $item = mysqli_fetch_array($query_chitiet);

    $sql_lan1 = "SELECT lienhe.CHITIETTRANGTHAI, lienhe.THOIGIAN, lienhe.KETQUA, lienhe.MATRANGTHAI
    FROM lienhe, phieudkxettuyen, khachhang
    WHERE phieudkxettuyen.MAPHIEUDK = lienhe.MAPHIEUDK
    AND khachhang.SDT = phieudkxettuyen.SDT
    AND lienhe.LAN= 1
    AND khachhang.SDT ='$id'";
    $query_lan1 = mysqli_query($conn, $sql_lan1);
    $item_lan1 = mysqli_fetch_array($query_lan1);

    $sql_lan2 = "SELECT lienhe.CHITIETTRANGTHAI, lienhe.THOIGIAN, lienhe.KETQUA, lienhe.MATRANGTHAI
    FROM lienhe, phieudkxettuyen, khachhang
    WHERE phieudkxettuyen.MAPHIEUDK = lienhe.MAPHIEUDK
    AND khachhang.SDT = phieudkxettuyen.SDT
    AND lienhe.LAN= 2
    AND khachhang.SDT ='$id'";
    $query_lan2 = mysqli_query($conn, $sql_lan2);
    $item_lan2 = mysqli_fetch_array($query_lan2);

    $sql_lan3 = "SELECT lienhe.CHITIETTRANGTHAI, lienhe.THOIGIAN, lienhe.KETQUA, lienhe.MATRANGTHAI
    FROM lienhe, phieudkxettuyen, khachhang
    WHERE phieudkxettuyen.MAPHIEUDK = lienhe.MAPHIEUDK
    AND khachhang.SDT = phieudkxettuyen.SDT
    AND lienhe.LAN= 3
    AND khachhang.SDT ='$id'";
    $query_lan3 = mysqli_query($conn, $sql_lan3);
    $item_lan3 = mysqli_fetch_array($query_lan3);

    $sql_nganh = "SELECT nganh.TENNGANH
    FROM khachhang, nganh, nganhyeuthich
    WHERE khachhang.SDT = nganhyeuthich.SDT
        AND nganh.MANGANH = nganhyeuthich.MANGANH
        AND khachhang.SDT = '$id'";
    $query_nganh = mysqli_query($conn, $sql_nganh);
    $item_nganh = mysqli_fetch_array($query_nganh);

    $sql_kqtn = "SELECT ketquatotnghiep.KETQUA
    FROM ketquatotnghiep, phieudkxettuyen, khachhang
    WHERE ketquatotnghiep.MAKETQUA = phieudkxettuyen.MAKETQUA
    AND khachhang.SDT = phieudkxettuyen.SDT
    AND khachhang.SDT = $id";
    $query_kqtn = mysqli_query($conn, $sql_kqtn);
    $item_kqtn = mysqli_fetch_array($query_kqtn);

    $sql_chuyende = "SELECT chitietchuyende.TRANGTHAI
    FROM chitietchuyende, phieudkxettuyen, khachhang, chuyende
    WHERE chitietchuyende.MAPHIEUDK = phieudkxettuyen.MAPHIEUDK
    AND chitietchuyende.MACHUYENDE = chuyende.MACHUYENDE
    AND phieudkxettuyen.SDT = khachhang.SDT
    AND khachhang.SDT = $id";
    $query_chuyende = mysqli_query($conn, $sql_chuyende);
    $item_chuyende = mysqli_fetch_array($query_chuyende);

    // var_dump($item)
    ?>
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
                                                            echo "danhsachdulieu";
                                                        } else {
                                                            echo "danhsachdulieu";
                                                        } ?>">
                        Danh sách dữ liệu
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Chi tiết dữ liệu</li>
            </ol>
        </nav>
    </div>
    <h2 style="text-align:center;">Chi tiết dữ liệu</h2>
    <div class="row">
        <div>
            <h4>Thông tin cá nhân </h4>
            <table class="bangchitiet">
                <tr>
                    <td>Họ và tên: </td>
                    <td>
                        <?php echo $item['HOTEN'] ?>
                    </td>
                </tr>
                <tr>
                    <td>Tỉnh/Thành phố: </td>
                    <td><?php echo $item['TENTINH'] ?></td>
                </tr>
                <tr>
                    <td>Trường: </td>
                    <td><?php echo $item['TENTRUONG'] ?></td>
                </tr>
            </table>
        </div>
        <div>
            <h4>Thông tin liên hệ</h4>
            <table class="bangchitiet">
                <tr>
                    <td>Điện thoại: </td>
                    <td><?php echo $item['SDT'] ?></td>
                </tr>
                <tr>
                    <td>Điện thoại ba:</td>
                    <td><?php
                        if (!empty($item['SDTBA'])) {
                            echo  $item['SDTBA'];
                        } else {
                            echo "Không có";
                        } ?></td>
                </tr>
                <tr>
                    <td>Điện thoại mẹ:</td>
                    <td><?php if (!empty($item['SDTME'])) {
                            echo  $item['SDTME'];
                        } else {
                            echo "Không có";
                        } ?></td>
                </tr>

                <tr>
                    <td>Số Zalo:</td>
                    <td><?php if (!empty($item['SDTZALO'])) {
                            echo  $item['SDTZALO'];
                        } else {
                            echo "Không có";
                        }  ?></td>
                </tr>
                <tr>
                    <td>Facebook:</td>
                    <td>
                        <?php
                        if (!empty($item['FACEBOOK'])) {
                            echo  $item['FACEBOOK'];
                        } else {
                            echo "Không có";
                        } ?>
                    </td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><?php echo $item['EMAIL'] ?></td>
                </tr>
            </table>
        </div>
        <div>
            <h4>Đối tượng</h4>
            <table class="bangchitiet">
                <tr>
                    <td>Tham gia Chuyên đề:</td>
                    <td>
                        <p style="color:black;">
                            <?php
                            if (!empty($item_chuyende['TRANGTHAI'])) {
                                echo $item_chuyende['TRANGTHAI'];
                            } else {
                                echo "Chưa liên hệ";
                            }
                            ?>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>Nghề nghiệp:</td>
                    <td><?php echo $item['TENNGHENGHIEP'] ?></td>
                </tr>
                <tr>
                    <td>Hình thức thu nhập:</td>
                    <td><?php echo $item['TENHINHTHUC'] ?></td>
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
                    <td>Ngành đăng kí:</td>
                    <td>
                        <?php
                        include '../connect/config.php';
                        $sql_nganhdangky = "SELECT phieudkxettuyen.NGANHDK
                        FROM phieudkxettuyen, khachhang
                        WHERE phieudkxettuyen.SDT = khachhang.SDT
                        AND khachhang.SDT = '$id'";
                        $query_nganhdangky = mysqli_query($conn, $sql_nganhdangky);
                        $item_nganhdangky = mysqli_fetch_array($query_nganhdangky);
                        // $item_manganh = $item_nganhdangky['MANGANH'];

                        // if ((!empty($item_nganhdangky['NGANHDK'])) && ($item_nganhdangky['NGANHDK'] == $row_ndk['MANGANH'])) {
                        //     echo $row_ndk['TENNGANH'];
                        // } else {
                        //     echo "Chưa có";
                        // }
                        if ((!empty($item_nganhdangky['NGANHDK']))) {
                            if ($item_nganhdangky['NGANHDK'] == 'NG03') {
                                echo "APTECH + ĐH CẦN THƠ";
                            }
                            if ($item_nganhdangky['NGANHDK'] == 'NG01') {
                                echo "APTECH";
                            }
                            if ($item_nganhdangky['NGANHDK'] == 'NG02') {
                                echo "APTECH + CAO ĐẲNG";
                            }
                            if ($item_nganhdangky['NGANHDK'] == 'NG04') {
                                echo "ACN Pro";
                            }
                            if ($item_nganhdangky['NGANHDK'] == 'NG05') {
                                echo "ARENA";
                            }
                            if ($item_nganhdangky['NGANHDK'] == 'NG06') {
                                echo "ARENA + CAO ĐẲNG";
                            }
                            if ($item_nganhdangky['NGANHDK'] == 'NG07') {
                                echo "ARENA + LIÊN THÔNG";
                            }
                            if ($item_nganhdangky['NGANHDK'] == 'NG08') {
                                echo "NGÀNH KHÁC";
                            }
                        } else {
                            echo "Chưa có";
                        }
                        ?>
                    </td>
                </tr>
            </table>

        </div>

        <div>
            <h4>Phiếu đăng kí xét tuyển</h4>
            <!-- Bảng Kênh nhận thông báo -->
            <table class="bangchitiet">
                <tr>
                    <td>Kênh nhận thông báo: </td>
                    <td>
                        <?php
                        include '../connect/config.php';
                        $sql_kenhnhanthongbao = "SELECT kenhnhanthongbao.MAKENH, kenhnhanthongbao.TENKENH 
                        FROM kenhnhanthongbao, khachhang, phieudkxettuyen
                        WHERE khachhang.SDT = phieudkxettuyen.SDT
                        AND phieudkxettuyen.MAKENH = kenhnhanthongbao.MAKENH
                        AND khachhang.SDT = '$id'";
                        $query_kenhnhanthongbao = mysqli_query($conn, $sql_kenhnhanthongbao);
                        $item_kenh = mysqli_fetch_array($query_kenhnhanthongbao);
                        if (!empty($item_kenh['TENKENH'])) {
                            echo  $item_kenh['TENKENH'];
                        } else {
                            echo "Chưa có phiếu đăng ký xét tuyển";
                        } ?>
                    </td>
                </tr>
                <tr>
                    <td>Khóa học quan tâm: </td>
                    <td><?php
                        include '../connect/config.php';
                        $sql_khoahocquantam = "SELECT khoahocquantam.MALOAIKHOAHOC, khoahocquantam.TENLOAIKHOAHOC 
                         FROM khoahocquantam, khachhang, phieudkxettuyen
                         WHERE khachhang.SDT = phieudkxettuyen.SDT
                         AND phieudkxettuyen.MALOAIKHOAHOC = khoahocquantam.MALOAIKHOAHOC
                         AND khachhang.SDT = '$id'";
                        $query_khoahocquantam = mysqli_query($conn, $sql_khoahocquantam);
                        $item_khoahocquantam = mysqli_fetch_array($query_khoahocquantam);
                        if (!empty($item_khoahocquantam['TENLOAIKHOAHOC'])) {
                            echo $item_khoahocquantam['TENLOAIKHOAHOC'];
                        } else {
                            echo "Chưa có phiếu đăng ký xét tuyển";
                        }
                        ?></td>
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
                        <p style="color:black;"><?php
                                                if (!empty($item_kqtn['KETQUA'])) {
                                                    echo $item_kqtn['KETQUA'];
                                                } else {
                                                    echo "Chưa có phiếu đăng ký";
                                                }
                                                ?></p>
                    </td>
                </tr>
            </table>
        </div>

        <div>
            <h4>Thống kê kết quả</h4>
            <!-- Bảng chi tiết liên hệ lần 1-->
            <table class="bangchitiet">

                <tr>
                    <h5>Lần 1</h5>
                    <td>Ngày/Tháng: </td>
                    <td>
                        <?php if (!empty($item_lan1['THOIGIAN'])) {
                            echo  $item_lan1['THOIGIAN'];
                        } else {
                            echo "Chưa liên hệ";
                        } ?>
                    </td>
                </tr>
                <tr>
                    <td>Trạng thái:</td>
                    <td>
                        <p style="color:black;">
                            <?php
                            include '../connect/config.php';
                            $sql_trangthailan1 = "SELECT trangthai.MATRANGTHAI, trangthai.TENTRANGTHAI
                            FROM trangthai, lienhe, phieudkxettuyen, khachhang
                            WHERE trangthai.MATRANGTHAI = lienhe.MATRANGTHAI
                            AND lienhe.MAPHIEUDK = phieudkxettuyen.MAPHIEUDK
                            AND phieudkxettuyen.SDT = khachhang.SDT
                            AND khachhang.SDT = '$id'
                            AND lienhe.LAN = 1";
                            $query_trangthailan1 = mysqli_query($conn, $sql_trangthailan1);
                            $item_trangthailan1 = mysqli_fetch_array($query_trangthailan1);
                            if ((!empty($item_lan1['MATRANGTHAI'])) && ($item_lan1['MATRANGTHAI'] == $item_trangthailan1['MATRANGTHAI'])) {
                                echo  $item_trangthailan1['TENTRANGTHAI'];
                            } else {
                                echo "Chưa liên hệ";
                            } ?>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>Chi tiết trạng thái:</td>
                    <td>
                        <?php if (!empty($item_lan1['CHITIETTRANGTHAI'])) {
                            echo  $item_lan1['CHITIETTRANGTHAI'];
                        } else {
                            echo "Chưa liên hệ";
                        } ?>
                    </td>
                </tr>
                <tr>
                    <td>Kết quả: </td>
                    <td>
                        <?php if (!empty($item_lan1['KETQUA'])) {
                            echo  $item_lan1['KETQUA'];
                        } else {
                            echo "Chưa liên hệ";
                        } ?>
                    </td>
                </tr>


            </table>

            <!-- Bảng chi tiết liên hệ lần 2 -->
            <table class="bangchitiet">
                <tr>
                    <h5>Lần 2</h5>
                    <td>Ngày/Tháng: </td>
                    <td>
                        <?php if (!empty($item_lan2['THOIGIAN'])) {
                            echo  $item_lan2['THOIGIAN'];
                        } else {
                            echo "Chưa liên hệ";
                        } ?>
                    </td>
                </tr>
                <tr>
                    <td>Trạng thái:</td>
                    <td>
                        <p style="color:black;">
                            <?php
                            include '../connect/config.php';
                            $sql_trangthailan2 = "SELECT trangthai.MATRANGTHAI, trangthai.TENTRANGTHAI
                            FROM trangthai, lienhe, phieudkxettuyen, khachhang
                            WHERE trangthai.MATRANGTHAI = lienhe.MATRANGTHAI
                            AND lienhe.MAPHIEUDK = phieudkxettuyen.MAPHIEUDK
                            AND phieudkxettuyen.SDT = khachhang.SDT
                            AND khachhang.SDT = '$id'
                            AND lienhe.LAN = 2";
                            $query_trangthailan2 = mysqli_query($conn, $sql_trangthailan2);
                            $item_trangthailan2 = mysqli_fetch_array($query_trangthailan2);
                            if ((!empty($item_lan2['MATRANGTHAI'])) && ($item_lan2['MATRANGTHAI'] == $item_trangthailan2['MATRANGTHAI'])) {
                                echo  $item_trangthailan2['TENTRANGTHAI'];
                            } else {
                                echo "Chưa liên hệ";
                            } ?>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>Chi tiết trạng thái:</td>
                    <td>
                        <?php if (!empty($item_lan2['CHITIETTRANGTHAI'])) {
                            echo  $item_lan2['CHITIETTRANGTHAI'];
                        } else {
                            echo "Chưa liên hệ";
                        } ?>
                    </td>
                </tr>
                <tr>
                    <td>Kết quả: </td>
                    <td>
                        <?php if (!empty($item_lan2['KETQUA'])) {
                            echo  $item_lan2['KETQUA'];
                        } else {
                            echo "Chưa liên hệ";
                        } ?>
                    </td>
                </tr>
            </table>

            <!-- Bảng chi tiết liên hệ lần 3-->
            <table class="bangchitiet">

                <tr>
                    <h5>Lần 3</h5>
                    <td>Ngày/Tháng: </td>
                    <td>
                        <?php if (!empty($item_lan3['THOIGIAN'])) {
                            echo  $item_lan3['THOIGIAN'];
                        } else {
                            echo "Chưa liên hệ";
                        } ?>
                    </td>
                </tr>
                <tr>
                    <td>Trạng thái:</td>
                    <td>
                        <p style="color:black;">
                            <?php
                            include '../connect/config.php';
                            $sql_trangthailan3 = "SELECT trangthai.MATRANGTHAI, trangthai.TENTRANGTHAI
                            FROM trangthai, lienhe, phieudkxettuyen, khachhang
                            WHERE trangthai.MATRANGTHAI = lienhe.MATRANGTHAI
                            AND lienhe.MAPHIEUDK = phieudkxettuyen.MAPHIEUDK
                            AND phieudkxettuyen.SDT = khachhang.SDT
                            AND khachhang.SDT = '$id'
                            AND lienhe.LAN = 3";
                            $query_trangthailan3 = mysqli_query($conn, $sql_trangthailan3);
                            $item_trangthailan3 = mysqli_fetch_array($query_trangthailan3);
                            if ((!empty($item_lan3['MATRANGTHAI'])) && ($item_lan3['MATRANGTHAI'] == $item_trangthailan3['MATRANGTHAI'])) {
                                echo  $item_trangthailan3['TENTRANGTHAI'];
                            } else {
                                echo "Chưa liên hệ";
                            } ?>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>Chi tiết trạng thái:</td>
                    <td>
                        <?php if (!empty($item_lan3['CHITIETTRANGTHAI'])) {
                            echo  $item_lan3['CHITIETTRANGTHAI'];
                        } else {
                            echo "Chưa liên hệ";
                        } ?>
                    </td>
                </tr>
                <tr>
                    <td>Kết quả: </td>
                    <td>
                        <?php if (!empty($item_lan3['KETQUA'])) {
                            echo  $item_lan3['KETQUA'];
                        } else {
                            echo "Chưa liên hệ";
                        } ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Nút Sửa thông tin -->
    <button type="submit" class="btn btn-success btnsuathongtin">
        <i class="fa-solid fa-pen-to-square"></i>&nbsp;</i>
        <a href="<?php if ($ad == 1) {
                        echo "admin.php";
                    } else {
                        echo "usermanager.php";
                    } ?>?route=suadulieu&id=<?php echo $item['SDT'] ?>" style="text-decoration: none; color: white;">
            Sửa thông tin</a>
    </button>
</div>


</div>
</div>