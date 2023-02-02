<?php
include("../connect/config.php");
session_start();
$sdt = $_SESSION["login"];

if (isset($_GET['llh'])) {
    $llh = $_GET['llh'];
}


if ($llh == 'alldl') {
    $select = "SELECT khachhang.SDT, khachhang.HOTEN, khachhang.EMAIL, dulieukhachhang.SDTBA, 
                    dulieukhachhang.SDTME, dulieukhachhang.SDTZALO, truong.TENTRUONG
                    FROM phanquyen, khachhang, dulieukhachhang, chitietpq, truong
                    WHERE phanquyen.SDT = '$sdt'
                    AND phanquyen.MaPQ = chitietpq.MaPQ
                    AND dulieukhachhang.SDT = khachhang.SDT
                    AND khachhang.MATRUONG = truong.MATRUONG
                    AND khachhang.SDT NOT IN (SELECT khachhangcu.SDT FROM khachhangcu)
                    AND chitietpq.SDT = khachhang.SDT";
    $query = mysqli_query($conn, $select);
    $data = [];
    while ($row = mysqli_fetch_array($query)) {
        $data[] = $row;
    }
    echo json_encode($data);
} else if ($llh == 0) {
    $dem = "SELECT Count(MALIENHE) as dem  FROM lienhe";
    $result = mysqli_query($conn, $dem);
    $a = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $a = $row['dem'];
    }
    if ($a == 0) {
        $select = "SELECT DISTINCT khachhang.SDT, khachhang.HOTEN, khachhang.EMAIL, dulieukhachhang.SDTBA,  dulieukhachhang.SDTME, dulieukhachhang.SDTZALO,phieudkxettuyen.MAPHIEUDK, truong.TENTRUONG
            FROM phanquyen, khachhang, dulieukhachhang, phieudkxettuyen, chitietpq, truong
            WHERE phanquyen.SDT = '$sdt'
            AND khachhang.SDT = phieudkxettuyen.SDT 
            AND khachhang.SDT=chitietpq.SDT
            AND phanquyen.MaPQ = chitietpq.MaPQ
            AND khachhang.MATRUONG = truong.MATRUONG
            AND dulieukhachhang.SDT = khachhang.SDT";
        $query = mysqli_query($conn, $select);
        $data = [];
        while ($row = mysqli_fetch_array($query)) {
            $data[] = $row;
        }
        echo json_encode($data);
    } else if ($a > 0) {
        $select = "SELECT DISTINCT khachhang.SDT, khachhang.HOTEN, khachhang.EMAIL, dulieukhachhang.SDTBA,  dulieukhachhang.SDTME, dulieukhachhang.SDTZALO,phieudkxettuyen.MAPHIEUDK, truong.TENTRUONG
            FROM phanquyen, khachhang, dulieukhachhang, lienhe, phieudkxettuyen, chitietpq, truong
            WHERE phanquyen.SDT = '$sdt'
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
        echo json_encode($data);
    }
} else {
    $select = "SELECT DISTINCT khachhang.SDT, khachhang.HOTEN, khachhang.EMAIL, dulieukhachhang.SDTBA, 
    dulieukhachhang.SDTME, dulieukhachhang.SDTZALO, truong.TENTRUONG
    FROM khachhang, dulieukhachhang, phanquyen, phieudkxettuyen, chitietpq, truong,
    (SELECT MAPHIEUDK,COUNt(LAN) as tong FROM lienhe GROUP by MAPHIEUDK) as a
    WHERE phanquyen.SDT = '$sdt'
    AND khachhang.SDT = dulieukhachhang.SDT
    AND khachhang.SDT = phieudkxettuyen.SDT
    AND a.MAPHIEUDK = phieudkxettuyen.MAPHIEUDK
    AND phanquyen.MaPQ = chitietpq.MaPQ
    AND khachhang.MATRUONG = truong.MATRUONG
    AND chitietpq.SDT = khachhang.SDT and a.tong = '" . $llh . "'";
    $query = mysqli_query($conn, $select);
    $data = [];
    //$sdths = $data['SDT'];

    // //Định vị lần liên hệ
    // $sql = "SELECT max(lienhe.LAN) as landalienhe
    // FROM phieudkxettuyen, khachhang, lienhe
    // WHERE khachhang.SDT = phieudkxettuyen.SDT
    // AND lienhe.MAPHIEUDK = phieudkxettuyen.MAPHIEUDK
    // AND khachhang.SDT = $sdths";
    // $query = mysqli_query($conn, $sql);
    // $landalienhe = mysqli_fetch_array($query);

    // if ($landalienhe['landalienhe'] < $llh) {

    //     while ($row = mysqli_fetch_array($query)) {
    //         $data[] = $row;
    //     }
    //     echo json_encode($data);
    // }
    while ($row = mysqli_fetch_array($query)) {
        $data[] = $row;
    }
    echo json_encode($data);
}