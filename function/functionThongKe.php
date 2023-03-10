<?php
function connect()
{
    $host = "localhost";
    $user = "root";
    $pass = "";
    $database = "htqltuyensinh";
    $conn = new mysqli($host, $user, $pass, $database);
    return $conn;
}
function tongSoDongmisscall($conn, &$SDT)
{
    $select = "SELECT COUNT(*) as tong
    FROM phanquyen, khachhang, dulieukhachhang, chitietpq, truong, misscall
    WHERE phanquyen.SDT = '$SDT'
    AND phanquyen.MaPQ = chitietpq.MaPQ
    AND dulieukhachhang.SDT = khachhang.SDT AND khachhang.TRANGTHAIKHACHHANG = 1
    AND khachhang.MATRUONG = truong.MATRUONG
    AND chitietpq.SDT = khachhang.SDT
    AND misscall.SDT = khachhang.sdt
    AND misscall.SDT = dulieukhachhang.sdt
                    ";
    $query = mysqli_query($conn, $select);
    $tongsodong = mysqli_fetch_array($query);
    return $tongsodong['tong'];
}
function tongSoDong($conn, &$SDT)
{
    $select = "SELECT  COUNT(*) as tong
                    FROM phanquyen, khachhang, dulieukhachhang, chitietpq
                    WHERE phanquyen.SDT = '$SDT'
                    AND phanquyen.MaPQ = chitietpq.MaPQ
                    AND dulieukhachhang.SDT = khachhang.SDT
                    AND chitietpq.SDT = khachhang.SDT";
    $query = mysqli_query($conn, $select);
    $tongsodong = mysqli_fetch_array($query);
    return $tongsodong['tong'];
}

function tongDongChuaLienHe($conn, $SDT)
{
    $select = "SELECT DISTINCT khachhang.SDT, khachhang.HOTEN, khachhang.EMAIL, dulieukhachhang.SDTBA,  dulieukhachhang.SDTME, dulieukhachhang.SDTZALO,phieudkxettuyen.MAPHIEUDK, truong.TENTRUONG
            FROM phanquyen, khachhang, dulieukhachhang, lienhe, phieudkxettuyen, chitietpq, truong
            WHERE phanquyen.SDT = '$SDT'
            AND khachhang.SDT = phieudkxettuyen.SDT 
            AND khachhang.SDT=chitietpq.SDT
            AND phanquyen.MaPQ = chitietpq.MaPQ
            AND khachhang.MATRUONG = truong.MATRUONG
            AND dulieukhachhang.SDT = khachhang.SDT 
            and phieudkxettuyen.MAPHIEUDK NOT IN (SELECT lienhe.MAPHIEUDK FROM lienhe);";
    $query = mysqli_query($conn, $select);
    $data = [];
    while ($row = mysqli_fetch_array($query)) {
        $data[] = $row;
    }
    $sodongchualienhe = count($data);
    return $sodongchualienhe;
}

function tongDongLienHeLan($conn, &$SDT, &$lan)
{
    $select = "SELECT DISTINCT count(*) as tong
                FROM khachhang, dulieukhachhang, phanquyen, phieudkxettuyen, chitietpq, truong,
                (SELECT * FROM lienhe) as a
                WHERE phanquyen.SDT = '$SDT'
                AND khachhang.SDT = dulieukhachhang.SDT
                AND khachhang.SDT = phieudkxettuyen.SDT
                AND a.MAPHIEUDK = phieudkxettuyen.MAPHIEUDK
                AND phanquyen.MaPQ = chitietpq.MaPQ
                AND khachhang.MATRUONG = truong.MATRUONG
                AND chitietpq.SDT = khachhang.SDT
                and a.LAN = '$lan'";
    $query = mysqli_query($conn, $select);
    $tongsodonglan1 = mysqli_fetch_array($query);
    return $tongsodonglan1['tong'];
}

function themGhiChuUM($conn, &$SDT, &$noidung)
{
    $sql = "INSERT INTO `ghichu`(`SDT`, `NOIDUNG`) VALUES ('" . $SDT . "','" . $noidung . "')";
    $qr = mysqli_query($conn, $sql);
}

function themGhiChuAD($conn, &$MAADMIN, &$noidung)
{
    $sql = "INSERT INTO `ghichu`(`MAADMIN`, `NOIDUNG`) VALUES ('" . $MAADMIN . "','" . $noidung . "')";
    $qr = mysqli_query($conn, $sql);
}

function xoaGhiChu($conn, &$ID)
{
    $sql = "DELETE FROM `ghichu` WHERE STT= '$ID' ";
    $qr = mysqli_query($conn, $sql);
}

function convert_name($str)
{
    $str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???)/", 'a', $str);
    $str = preg_replace("/(??|??|???|???|???|??|???|???|???|???|???)/", 'e', $str);
    $str = preg_replace("/(??|??|???|???|??)/", 'i', $str);
    $str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???)/", 'o', $str);
    $str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???)/", 'u', $str);
    $str = preg_replace("/(???|??|???|???|???)/", 'y', $str);
    $str = preg_replace("/(??)/", 'd', $str);
    $str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???)/", 'A', $str);
    $str = preg_replace("/(??|??|???|???|???|??|???|???|???|???|???)/", 'E', $str);
    $str = preg_replace("/(??|??|???|???|??)/", 'I', $str);
    $str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???)/", 'O', $str);
    $str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???)/", 'U', $str);
    $str = preg_replace("/(???|??|???|???|???)/", 'Y', $str);
    $str = preg_replace("/(??)/", 'D', $str);
    $str = preg_replace("/(\???|\???|\???|\???|\,|\!|\&|\;|\@|\#|\%|\~|\`|\=|\_|\'|\]|\[|\}|\{|\)|\(|\+|\^)/", '-', $str);
    $str = preg_replace("/( )/", '', $str);
    return $str;
}
function alert($msg)
{
    echo "<script type='text/javascript'>alert('$msg');</script>";
}
