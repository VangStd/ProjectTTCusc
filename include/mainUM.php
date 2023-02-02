<?php
if($ad != 1){
    if(isset($_GET['route'])){
         $tam= $_GET['route'];
    }else{
        $tam= ''   ;
    }
    if($tam=='hienthinguoidung'){
         include("../quanlynguoidung/hienthinguoidung.php");
    }
    elseif($tam=='themnguoidung'){
        include("../quanlynguoidung/themnguoidung.php");
    }
    elseif($tam=='xulythemnguoidung'){
        include("../quanlynguoidung/themnguoidung.php");
    }
    elseif($tam=='xemthongtincanhan'){
        include("../quanlythongtincanhan/xemthongtincanhan.php");
    }
    elseif($tam== 'suanguoidung'){
        include("../quanlynguoidung/suanguoidung.php");
    }
    elseif($tam== 'chitietnguoidung'){
        include("../quanlynguoidung/xemchitietnguoidung.php");
    }
    elseif($tam== 'xoanguoidung'){
        include("../quanlynguoidung/xoanguoidung.php");
    }
    elseif($tam== 'phanquyennguoidung'){
        include("../quanlynguoidung/phanquyennguoidung.php");
    }
    elseif($tam== 'suathongtincanhan'){
        include("../quanlythongtincanhan/suathongtincanhan.php");
    }
    elseif($tam== 'danhsachdulieu'){
        include("../quanlydulieu/danhsachdulieuUM.php");
    }
    elseif($tam== 'danhsachdulieumisscall'){
        include("../quanlydulieu/danhsachdulieumisscall.php");
    }
    elseif($tam== 'danhsachdulieustatus'){
        include("../quanlydulieu/danhsachdulieustatus.php");
    }
    elseif($tam== 'themdulieu'){
        include("../quanlydulieu/themdulieu.php");
    }
    elseif($tam== 'phanchiadulieu'){
        include("../quanlydulieu/phanchiadulieu.php");
    }
    elseif($tam== 'tkdl-theongay'){
        include("../thongkedulieu/thongkedulieutheongay.php");
    }
    elseif($tam== 'tkdl-theokqkt'){
        include("../thongkedulieu/tkdl-theokqkt.php");
    }
    elseif($tam== 'tkdl-theotrangthai'){
        include("../thongkedulieu/tkdl-theotrangthai.php");
    }
    elseif ($tam == 'tongthoigiandangnhap') {
        include("../tongthoigiandangnhap/tongthoigiandangnhap.php");
    }
    elseif($tam== 'xemnhatky'){
        include("../xemnhatky/xemnhatky.php");
    }
    elseif($tam== 'chitietdulieuUM'){
        include("../quanlydulieu/chitietdulieu.php");
    }
    elseif($tam== 'suadulieu'){
        include("../quanlydulieu/suadulieu.php");
    }
    elseif($tam== 'xoadulieu'){
        include("../quanlydulieu/xoadulieu.php");
    }elseif($tam== 'misscall'){
        include("../misscall/misscall.php");
    }elseif($tam== 'xoamisscall'){
        include("../misscall/xoamisscall.php");
    }elseif($tam== 'timkiemmisscall'){
        include("../misscall/timkiemmisscall.php");
    }elseif($tam=='trangchu'){
        include("homeUM.php");
    }elseif($tam=='xoaghichu'){
        include("../ghichu/xoaghichu.php");
    }elseif($tam=='danhsachhoso'){
        include("../hoso/danhsachhoso.php");
    }elseif($tam=='xoahoso'){
        include("../hoso/xoahoso.php");
    }
    elseif(isset($_GET['timkiemdulieuUM'])){
        include("../quanlydulieu/timkiemdulieuUM.php");
    }
    else if(isset($_GET['timkiemnguoidung'])) {
        include("../quanlynguoidung/timkiemnguoidung.php");
    }
    elseif(isset($_GET['usermanager'])){
        include("../thongkedulieu/tkdl-theotrangthai.php");
    }elseif (isset($_GET['timkiemdanhsachtheott']) ) {
        include("../quanlydulieu/danhsachdulieustatus.php");
    }
    elseif (isset($_GET['timkiemdshoso'])) {
        include("../hoso/danhsachhoso.php");
    }
    else{
        include("homeUM.php");
    };
}
