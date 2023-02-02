<?php
include "../connect/config.php";
include "../function/functionThongKe.php";
$a = false;

// Trả về SDT khi user thực hiện nộp phiếu đăng ký
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $SDT = $_GET['sdt'];
    $sql = "SELECT * FROM khachhang WHERE SDT LIKE '%$SDT%'";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query);
    if ($row > 0 && $SDT != "") {
        $sql_chitiet = "SELECT khachhang.SDT, khachhang.HOTEN, khachhang.EMAIL, 
            dulieukhachhang.SDTBA, dulieukhachhang.SDTME, 
            dulieukhachhang.SDTZALO, dulieukhachhang.FACEBOOK ,truong.TENTRUONG, tinh.TENTINH, 
            nghenghiep.TENNGHENGHIEP, hinhthucthuthap.TENHINHTHUC, 
            kenhnhanthongbao.TENKENH, khoahocquantam.TENLOAIKHOAHOC, phieudkxettuyen.HOSO, ketquatotnghiep.KETQUA
            FROM khachhang, dulieukhachhang, truong, tinh, nghenghiep, hinhthucthuthap, kenhnhanthongbao, 
            phieudkxettuyen, khoahocquantam, ketquatotnghiep
            WHERE khachhang.SDT = dulieukhachhang.SDT AND khachhang.MATRUONG = truong.MATRUONG 
            AND phieudkxettuyen.MAKETQUA = ketquatotnghiep.MAKETQUA
            AND khachhang.MANGHENGHIEP = nghenghiep.MANGHENGHIEP 
            AND khachhang.MAHINHTHUC = hinhthucthuthap.MAHINHTHUC AND kenhnhanthongbao.MAKENH = phieudkxettuyen.MAKENH 
            AND khoahocquantam.MALOAIKHOAHOC = phieudkxettuyen.MALOAIKHOAHOC
            AND khachhang.SDT = $SDT";
        $query_chitiet = mysqli_query($conn, $sql_chitiet);
        $item = mysqli_fetch_array($query_chitiet);

        $sql_lan1 = "SELECT lienhe.CHITIETTRANGTHAI, lienhe.THOIGIAN, lienhe.KETQUA, lienhe.MATRANGTHAI
            FROM lienhe, phieudkxettuyen, khachhang
            WHERE phieudkxettuyen.MAPHIEUDK = lienhe.MAPHIEUDK
            AND khachhang.SDT = phieudkxettuyen.SDT
            AND lienhe.LAN= 1
            AND khachhang.SDT ='$SDT'";
        $query_lan1 = mysqli_query($conn, $sql_lan1);
        $item_lan1 = mysqli_fetch_array($query_lan1);

        $sql_lan2 = "SELECT lienhe.CHITIETTRANGTHAI, lienhe.THOIGIAN, lienhe.KETQUA, lienhe.MATRANGTHAI
            FROM lienhe, phieudkxettuyen, khachhang
            WHERE phieudkxettuyen.MAPHIEUDK = lienhe.MAPHIEUDK
            AND khachhang.SDT = phieudkxettuyen.SDT
            AND lienhe.LAN= 2
            AND khachhang.SDT ='$SDT'";
        $query_lan2 = mysqli_query($conn, $sql_lan2);
        $item_lan2 = mysqli_fetch_array($query_lan2);

        $sql_lan3 = "SELECT lienhe.CHITIETTRANGTHAI, lienhe.THOIGIAN, lienhe.KETQUA, lienhe.MATRANGTHAI
            FROM lienhe, phieudkxettuyen, khachhang
            WHERE phieudkxettuyen.MAPHIEUDK = lienhe.MAPHIEUDK
            AND khachhang.SDT = phieudkxettuyen.SDT
            AND lienhe.LAN= 3
            AND khachhang.SDT ='$SDT'";
        $query_lan3 = mysqli_query($conn, $sql_lan3);
        $item_lan3 = mysqli_fetch_array($query_lan3);

        $sql_nganh = "SELECT nganh.TENNGANH
            FROM khachhang, nganh, nganhyeuthich
            WHERE khachhang.SDT = nganhyeuthich.SDT
            AND nganh.MANGANH = nganhyeuthich.MANGANH
            AND khachhang.SDT = '$SDT'";
        $query_nganh = mysqli_query($conn, $sql_nganh);
        $item_nganh = mysqli_fetch_array($query_nganh);
    }
}

// User tra cứu thông tin
if (isset($_POST['tracuu'])) {
    $SDT = $_POST['noidungtim'];
    if (strlen($SDT) < 10) {
        header("Location: ../index.php");
    } else {
        $sql = "SELECT * FROM khachhang WHERE SDT LIKE '%$SDT%'";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($query);
        if ($row > 0 && $SDT != "") {
            $sql_chitiet = "SELECT khachhang.SDT, khachhang.HOTEN, khachhang.EMAIL, 
            dulieukhachhang.SDTBA, dulieukhachhang.SDTME, 
            dulieukhachhang.SDTZALO, dulieukhachhang.FACEBOOK ,truong.TENTRUONG, tinh.TENTINH, 
            nghenghiep.TENNGHENGHIEP, hinhthucthuthap.TENHINHTHUC, 
            kenhnhanthongbao.TENKENH, khoahocquantam.TENLOAIKHOAHOC, phieudkxettuyen.HOSO, ketquatotnghiep.KETQUA
            FROM khachhang, dulieukhachhang, truong, tinh, nghenghiep, hinhthucthuthap, kenhnhanthongbao, 
            phieudkxettuyen, khoahocquantam, ketquatotnghiep
            WHERE khachhang.SDT = dulieukhachhang.SDT AND khachhang.MATRUONG = truong.MATRUONG 
            AND phieudkxettuyen.MAKETQUA = ketquatotnghiep.MAKETQUA
            AND khachhang.MANGHENGHIEP = nghenghiep.MANGHENGHIEP 
            AND khachhang.MAHINHTHUC = hinhthucthuthap.MAHINHTHUC AND kenhnhanthongbao.MAKENH = phieudkxettuyen.MAKENH 
            AND khoahocquantam.MALOAIKHOAHOC = phieudkxettuyen.MALOAIKHOAHOC
            AND khachhang.SDT = $SDT";
            $query_chitiet = mysqli_query($conn, $sql_chitiet);
            $item = mysqli_fetch_array($query_chitiet);

            $sql_lan1 = "SELECT lienhe.CHITIETTRANGTHAI, lienhe.THOIGIAN, lienhe.KETQUA, lienhe.MATRANGTHAI
            FROM lienhe, phieudkxettuyen, khachhang
            WHERE phieudkxettuyen.MAPHIEUDK = lienhe.MAPHIEUDK
            AND khachhang.SDT = phieudkxettuyen.SDT
            AND lienhe.LAN= 1
            AND khachhang.SDT ='$SDT'";
            $query_lan1 = mysqli_query($conn, $sql_lan1);
            $item_lan1 = mysqli_fetch_array($query_lan1);

            $sql_lan2 = "SELECT lienhe.CHITIETTRANGTHAI, lienhe.THOIGIAN, lienhe.KETQUA, lienhe.MATRANGTHAI
            FROM lienhe, phieudkxettuyen, khachhang
            WHERE phieudkxettuyen.MAPHIEUDK = lienhe.MAPHIEUDK
            AND khachhang.SDT = phieudkxettuyen.SDT
            AND lienhe.LAN= 2
            AND khachhang.SDT ='$SDT'";
            $query_lan2 = mysqli_query($conn, $sql_lan2);
            $item_lan2 = mysqli_fetch_array($query_lan2);

            $sql_lan3 = "SELECT lienhe.CHITIETTRANGTHAI, lienhe.THOIGIAN, lienhe.KETQUA, lienhe.MATRANGTHAI
            FROM lienhe, phieudkxettuyen, khachhang
            WHERE phieudkxettuyen.MAPHIEUDK = lienhe.MAPHIEUDK
            AND khachhang.SDT = phieudkxettuyen.SDT
            AND lienhe.LAN= 3
            AND khachhang.SDT ='$SDT'";
            $query_lan3 = mysqli_query($conn, $sql_lan3);
            $item_lan3 = mysqli_fetch_array($query_lan3);

            $sql_nganh = "SELECT nganh.TENNGANH
            FROM khachhang, nganh, nganhyeuthich
            WHERE khachhang.SDT = nganhyeuthich.SDT
            AND nganh.MANGANH = nganhyeuthich.MANGANH
            AND khachhang.SDT = '$SDT'";
            $query_nganh = mysqli_query($conn, $sql_nganh);
            $item_nganh = mysqli_fetch_array($query_nganh);
        } else {
            echo
            "<script>
            alert('Vui lòng nhập đúng số điện thoại');
        </script>";
            header("Location: ../index.php");
        }
    }
    $sql_kt = "SELECT COUNT(*) as KiemTra FROM phieudkxettuyen WHERE SDT = '$SDT'";
    $query_kt = mysqli_query($conn, $sql_kt);
    $row_kt = mysqli_fetch_array($query_kt);
    if ($row_kt['KiemTra'] == 0) {
        $nopphieu = 0;
    } else {
        $nopphieu = 1;
    }
}

// Xử lý đăng ký
  if(isset($_POST['xacnhanpdkxt'])){
    $sodienthoai = $_POST['sodienthoai'];
    $kh = $_POST['khoahoc'];
    $kenhnhan = $_POST['kenhnhan'];
    $cddh = $_POST['cddh'];
    $zalo = $_POST['zalo'];
    $nganhdk = $_POST['nganhdk'];


    // Check khi chỉ upload hồ sơ mà không thêm phiếu dk
    if($zalo){
            // Lấy mã ngành yêu thich
            $nganh = $_POST['Nganh'];
            for($i = 0 ; $i< count($nganh); $i++){
                $nganh[$i] = $nganh[$i];
                $sql_nganh = "INSERT INTO `nganhyeuthich`(`SDT`, `MANGANH`, `CHITIET`) VALUES ('$sodienthoai','$nganh[$i]','')";
                $query_nganh = mysqli_query($conn, $sql_nganh);
            }
            $madk = "DK".random_int(50,10000);
            // echo $madk;
            // echo $kh;
            // echo $kenhnhan;
            // echo  $sodienthoai;
            // echo $zalo;
        
        
            $sql_ins = "INSERT INTO `phieudkxettuyen`(`MAPHIEUDK`, `MALOAIKHOAHOC`, `MAKENH`, `SDT`, `MAKETQUA`, `SDTZALO`) 
                        VALUES ('".$madk."','1','".$kenhnhan."','".$sodienthoai."','1','".$zalo."')";
            $query_ins = mysqli_query($conn, $sql_ins);
        
            // Update ngành yêu thích
            $sql_update_nganhdk = "UPDATE `phieudkxettuyen` 
            SET `NGANHDK`='".$nganhdk."' WHERE SDT= '".$sodienthoai."'";
            $query_update_nganhdk = mysqli_query($conn, $sql_update_nganhdk);
    }

    
    // Lấy dữ liệu file
    $file= $_FILES['filename'];
    $checkfilename= $file['name'];
    
    if($checkfilename){
        // Lấy tên file
        $filename= $file['name'];
        $sizeAllow= 10; //10MB
        $err= [];
        // Kết nối lấy họ tên 
        $sql="SELECT HOTEN as HOTEN FROM khachhang WHERE SDT= '$sodienthoai'";
        $qr= mysqli_query($conn, $sql);
        $layten= mysqli_fetch_array($qr);
        $hoten = $layten['HOTEN'];
        // Đổi tên
        $filename= explode('.', $filename);
        $endfilename= end($filename);
            $newname= $sodienthoai .'-' .convert_name($hoten) .uniqid(). '.' .$endfilename; //tên lưu về CSDL
        // Kiểm tra định dạng
        $allowEndFile= ['pdf', 'png', 'jpg', 'jpeg'];
        if(in_array($endfilename, $allowEndFile)){
         // Kiểm tra dung lượng
        $size= $file['size']/1024/1024;    
        if ($size <= $sizeAllow) {
             // Đủ điều kiện
            $upload= move_uploaded_file($file['tmp_name'], '../dulieupdf/'.$newname);
            $url= 'dulieupdf/'.$newname;
    
            if(!$upload){
                $err[]= 'err_upload';
            }
        }else {
                $err[]= 'err_size';
        }
        }else{
                $err[]= 'err_endfile';
        }

        // Hiển thị lỗi
        if (!empty($err)) {
            $mess= '';
            if (in_array('err_upload', $err)) {
                $mess= "Lỗi upload file vào lúc này!";
                alert($mess);
            
            }elseif (in_array('err_size', $err)) {
                $mess= "Lỗi kích thước file quá lớn!";
                alert($mess);
            }elseif (in_array('err_endfile', $err)) {
                $mess= "Lỗi định dạng file!";
                alert($mess);
            }
        }else{
            $mess= "Upload thành công! vui lòng chờ kết quả!";
            alert($mess);
        };
        // Kết nối lấy mã phiếu dk
        $sql="SELECT MAPHIEUDK as MAPHIEUDK FROM phieudkxettuyen WHERE SDT= '$sodienthoai'";
        $qr= mysqli_query($conn, $sql);
        $laymaphieudk= mysqli_fetch_array($qr);
        $maphieudk = $laymaphieudk['MAPHIEUDK'];
        $sql_update_hoso = "UPDATE `phieudkxettuyen` SET `HOSO`='".$url."' WHERE MAPHIEUDK = '".$maphieudk."'";
        $query_update_nganhdk = mysqli_query($conn, $sql_update_hoso);
    }

    echo "<script>location.href='./thongtinkhachhang.php?sdt=".$sodienthoai."';</script>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="shortcut icon" type="image/png" href="../images/iconLogo.png">
    <title>HTQL Tuyển sinh CUSC</title>
</head>

<body>
    <!-- Logo Website -->
    <div class="container logoWeb">
        <img src="../images/logo.png" alt="logoweb">
    </div>

    <!-- Phần nội dung Website -->
    <div class="homeWed_user">
        <h2 style="text-align:center; color: #0052cc; margin:5px;">Thông tin khách hàng</h2>
        <div class="row3">
            <div class="ttkh" style="padding:10px;">
                <div>
                    <h4>Thông tin cá nhân </h4>
                    <table class="bangchitiet">
                        <tr>
                            <td>Họ và tên: </td>
                            <td>A</td>

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
                            <td><?php if (!empty($item['SDTBA'])) {
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
                            <td><?php
                                $sql_phieu = "SELECT SDTZALO FROM phieudkxettuyen WHERE SDT = '".$SDT."'";
                                $query_phieu = mysqli_query($conn, $sql_phieu);
                                $row_phieu = mysqli_fetch_array($query_phieu);
                                if (!empty($row_phieu['SDTZALO'])) {
                                    echo  $row_phieu['SDTZALO'];
                                } else {
                                    echo "Không có";
                                }  ?></td>
                        </tr>
                        <tr>
                            <td>FaceBook:</td>
                            <td><?php echo $item['FACEBOOK'] ?></td>
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
                                <p style="color:black;">Đồng ý</p>
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
                                $sql_nganh = "SELECT nganh.TENNGANH
                            FROM khachhang, nganh, nganhyeuthich
                            WHERE khachhang.SDT = $SDT 
                            AND khachhang.SDT = nganhyeuthich.SDT
                            AND nganh.MANGANH = nganhyeuthich.MANGANH";
                                $query_nganh = mysqli_query($conn, $sql_nganh);

                                $i = 0;
                                while ($row = mysqli_fetch_array($query_nganh)) {
                                    $row['TENNGANH'];
                                    $i++;
                                ?>
                                <p style="color:black;"><?php echo $row['TENNGANH']; ?></p>
                                <?php
                                }
                                $item_nganh = mysqli_fetch_array($query_nganh);

                                // if (!empty($item_nganh['TENNGANH'])) {
                                //     echo $item_nganh['TENNGANH'];
                                // } else {
                                //     echo "Chưa có";
                                // }
                                ?>
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
                        AND khachhang.SDT = '$SDT'";
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
                        }?>
                            </td>

                        </tr>
                    </table>

                </div>
                <div>
                    <h4>Phiếu đăng kí xét tuyển</h4>
                    <table class="bangchitiet">
                        <tr>
                            <td>Kênh nhận thông báo: </td>
                            <td><?php echo $item['TENKENH'] ?></td>

                        </tr>
                        <tr>
                            <td>Khóa học quan tâm: </td>
                            <td><?php

                                $sql_up = "SELECT khoahocquantam.TENLOAIKHOAHOC as KHOAHOC FROM phieudkxettuyen, khoahocquantam WHERE phieudkxettuyen.MALOAIKHOAHOC = khoahocquantam.MALOAIKHOAHOC AND phieudkxettuyen.SDT = '" . $SDT . "'";
                                $query_up = mysqli_query($conn, $sql_up);
                                $khoahoc = mysqli_fetch_array($query_up);
                                if (!empty($khoahoc['KHOAHOC'])) {
                                    echo $khoahoc['KHOAHOC'];
                                } else {
                                    echo 'Chưa có';
                                }

                                ?></td>
                        </tr>
                        <tr>
                            <td>Hồ sơ:</td>
                            <td>
                                <?php
                                if (!empty($item['HOSO'])) {
                                    echo $item['HOSO'];
                                } else {
                                    echo "Chưa nộp";
                                } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Kết quả Cao đẳng/Đại học:</td>
                            <td>
                                <p style="color:black;"><?php echo $item['KETQUA'] ?></p>
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
                            AND khachhang.SDT = '$SDT'
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
                            <td>Chi tiết:</td>
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
                            AND khachhang.SDT = '$SDT'
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
                            AND khachhang.SDT = '$SDT'
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

            <div class="container2">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                    Phiếu đăng kí xét tuyển
                </button>
            </div>

            <!-- Phieu dang ki xet tuyen -->
            <div class="modal" id="myModal">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title"> Phiếu đăng kí xét tuyển</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <!-- Modal body -->
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div style="<?php if ($nopphieu == 1){
                                                        echo "display: none;";
                                                    }else if($nopphieu== 0){
                                                        echo "display: block;";
                                                    }?>">
                                    <table class="bctpdkxt">
                                        <tr>
                                            <td></td>
                                            <td>
                                                <input type="text" name="sodienthoai" style="display:none;"
                                                    value="<?php echo $SDT ?>" a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Khóa học quan tâm: </td>
                                            <td>
                                                <input type="radio" name="khoahoc" value="1"> Dài hạn
                                                <input type="radio" name="khoahoc" value="2"> Arena <br>
                                                <input type="radio" name="khoahoc" value="3"> Aptech
                                                <input type="radio" name="khoahoc" value="4"> ACN Pro
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Kênh nhận thông báo: </td>
                                            <td>
                                                <select class="form-select shadow-none kntb" name="kenhnhan"
                                                    style="width: 73%;">
                                                    <option value="kenhzl">Zalo</option>
                                                    <option value="kenhem">Email</option>
                                                </select>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>Số Zalo:</td>
                                            <td><input type="text" name="zalo" style="width: 73%;"></td>
                                        </tr>
                                        <tr>
                                            <td>Kết quả Cao đẳng/Đại học:</td>
                                            <td>
                                                <select class="form-select shadow-none kqCDDH" name="cddh"
                                                    style="width: 73%;">
                                                    <option value="1">Đậu </option>
                                                    <option value="2">Không đậu</option>
                                                    <option value="3">Đang chờ kết quả </option>
                                                    <option value="4">Không thi Cao đẳng/Đại học </option>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Ngành yêu thích: </td>
                                            <td>
                                                <input type="checkbox" name="Nganh[]" value="NG01">
                                                <label>APTECH </label><br>
                                                <input type="checkbox" name="Nganh[]" value="NG02">
                                                <label> APTECH + CAO ĐẲNG</label><br>
                                                <input type="checkbox" name="Nganh[]" value="NG03">
                                                <label>APTECH + ĐH CẦN THƠ</label><br>
                                                <input type="checkbox" name="Nganh[]" value="NG04">
                                                <label>APTECH + LIÊN THÔNG</label><br>
                                                <input type="checkbox" name="Nganh[]" value="NG05">
                                                <label> ACN Pro</label><br>
                                                <input type="checkbox" name="Nganh[]" value="NG06">
                                                <label> ARENA</label><br>
                                                <input type="checkbox" name="Nganh[]" value="NG07">
                                                <label> ARENA + CAO ĐẲNG</label><br>
                                                <input type="checkbox" name="Nganh[]" value="NG08">
                                                <label> ARENA + LIÊN THÔNG</label><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Ngành đăng ký: </td>
                                            <td>
                                                <select class="form-select shadow-none kntb" name="nganhdk"
                                                    style="width: 73%;">
                                                    <option value="N01">APTECH</option>
                                                    <option value="N02">APTECH + CAO ĐẲNG</option>
                                                    <option value="N03">APTECH + ĐH CẦN THƠ</option>
                                                    <option value="N04">APTECH + LIÊN THÔNG</option>
                                                    <option value="N05">ACN Pro</option>
                                                    <option value="N06">ARENA</option>
                                                    <option value="N07">ARENA + CAO ĐẲNG</option>
                                                    <option value="N08">ARENA + LIÊN THÔNG</option>
                                                </select>
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                                <br>
                                <div>
                                    <label>Chọn file cần upload: </label>
                                    <input type="file" name="filename"><br><br>
                                </div>
                            </div>
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger" name="xacnhanpdkxt">Gửi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="container-fluid footerWeb">
        <div class="row">
            <div class="col-md-8 thongtinfooter">
                <h3>TRUNG TÂM CÔNG NGHỆ PHẦN MỀM ĐẠI HỌC CẦN THƠ</h3>
                <p><i class="fa-solid fa-location-dot"></i>&nbsp; Khu III, Đại Học Cần Thơ, 01 Lý Tự Trọng, Q. Ninh
                    Kiều,
                    TP. Cần Thơ</p>
                <p><i class="fa-solid fa-phone"></i>&nbsp;Điện thoại: 0292 383 5581</p>
                <p>Zalo: 0868 952 535</p>
                <p><i class="fa-solid fa-envelope"></i>&nbsp;Mail: tuyensinh@cusc.ctu.edu.vn</p>

            </div>

            <div class="col-md-4 thongtinfooter">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3928.7933383849145!2d105.77767954957537!3d10.033905575169303!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a0881f9a732075%3A0xfa43fbeb2b00ca73!2sCUSC%20-%20Cantho%20University%20Software%20Center!5e0!3m2!1svi!2s!4v1654614294824!5m2!1svi!2s"
                    width="100%" height="180" style="border:0; margin-top: 10px; " allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 coppyright" style="text-align: center;">
                <h4>CUSC APTECH © 2022</h4>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="../include/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/js/bootstrap.min.js"></script>
</body>

</html>