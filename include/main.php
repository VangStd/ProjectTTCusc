<?php
if ($ad == 1) {
    if (isset($_GET['route'])) {
        $tam = $_GET['route'];
    } else {
        $tam = '';
    }
    if ($tam == 'hienthinguoidung') {
        include("../quanlynguoidung/hienthinguoidung.php");
    } elseif ($tam == 'themnguoidung') {
        include("../quanlynguoidung/themnguoidung.php");
    } elseif ($tam == 'xulythemnguoidung') {
        include("../quanlynguoidung/themnguoidung.php");
    } elseif ($tam == 'xemthongtincanhan') {
        include("../quanlythongtincanhan/xemthongtincanhan.php");
    } elseif ($tam == 'suanguoidung') {
        include("../quanlynguoidung/suanguoidung.php");
    } elseif ($tam == 'chitietnguoidung') {
        include("../quanlynguoidung/xemchitietnguoidung.php");
    } elseif ($tam == 'xoanguoidung') {
        include("../quanlynguoidung/xoanguoidung.php");
    } elseif ($tam == 'phanquyennguoidung') {
        include("../quanlynguoidung/phanquyennguoidung.php");
    } elseif ($tam == 'suathongtincanhan') {
        include("../quanlythongtincanhan/suathongtincanhan.php");
    } elseif ($tam == 'danhsachdulieu') {
        include("../quanlydulieu/danhsachdulieuAD.php");
    } elseif ($tam == 'danhsachdulieustatus') {
        include("../quanlydulieu/danhsachdulieustatus.php");
    } elseif ($tam == 'themdulieu') {
        include("../quanlydulieu/themdulieu.php");
    } elseif ($tam == 'phanchiadulieu') {
        include("../quanlydulieu/phanchiadulieu.php");
    } elseif ($tam == 'tkdl-theongay') {
        include("../thongkedulieu/thongkedulieutheongay.php");
    } elseif ($tam == 'tkdl-theotuan') {
        include("../thongkedulieu/thongkedulieutheotuan.php");
    } elseif ($tam == 'tkdl-theokqkt') {
        include("../thongkedulieu/tkdl-theokqkt.php");
    } elseif ($tam == 'tkdl-theotrangthai') {
        include("../thongkedulieu/tkdl-theotrangthai.php");
    } elseif ($tam == 'tongthoigiandangnhap') {
        include("../tongthoigiandangnhap/tongthoigiandangnhap.php");
    } elseif ($tam == 'xemnhatky') {
        include("../xemnhatky/xemnhatky.php");
    } elseif ($tam == 'chitietdulieu') {
        include("../quanlydulieu/chitietdulieu.php");
    } elseif ($tam == 'phandoandulieu') {
        include("../quanlydulieu/phandoandulieu.php");
    } elseif ($tam == 'chitietphandoan') {
        include("../quanlydulieu/chitietphandoan.php");
    } elseif ($tam == 'suadulieu') {
        include("../quanlydulieu/suadulieu.php");
    } elseif ($tam == 'xoadulieu') {
        include("../quanlydulieu/xoadulieu.php");
    } elseif ($tam == 'quanlychuyende') {
        include("../quanlychuyende/danhsachchuyende.php");
    } elseif ($tam == 'suachuyende') {
        include("../quanlychuyende/suachuyende.php");
    } elseif ($tam == 'danhsachhoso') {
        include("../hoso/danhsachhoso.php");
    } elseif ($tam == 'xoahoso') {
        include("../hoso/xoahoso.php");
    } elseif ($tam == 'xoaghichu') {
        include("../ghichu/xoaghichu.php");
    } elseif ($tam == 'trangchu') {
        include("home.php");
    } elseif (isset($_GET['timkiemdulieu'])) {
        include("../quanlydulieu/timkiemdulieu.php");
    } else if (isset($_GET['timkiemnguoidung'])) {
        include("../quanlynguoidung/timkiemnguoidung.php");
    } elseif (isset($_GET['usermanager'])) {
        include("../thongkedulieu/tkdl-theotrangthai.php");
    } elseif (isset($_GET['Timkiemdoan'])) {
        include("../quanlydulieu/phandoandulieu.php");
    } elseif (isset($_GET['timkiemphanchia'])) {
        include("../quanlydulieu/phanchiadulieu.php");
    } elseif (isset($_GET['timkiemchitietphandoan'])) {
        include("../quanlydulieu/chitietphandoan.php");
    } elseif (isset($_GET['timkiemdanhsachtheott']) && $ad == 1) {
        include("../quanlydulieu/danhsachdulieustatus.php");
    } elseif (isset($_GET['hienthinhatky'])) {
        include("../xemnhatky/xemnhatky.php");
    } elseif (isset($_GET['timkiemchuyende'])) {
        include("../quanlychuyende/danhsachchuyende.php");
    } elseif (isset($_GET['timkiemdshoso'])) {
        include("../hoso/danhsachhoso.php");
    } else {
        include("home.php");
    };
}
