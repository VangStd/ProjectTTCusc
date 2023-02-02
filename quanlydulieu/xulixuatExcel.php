<?php
    session_start();
    if(isset($_POST['xuatdulieu'])){
        require_once "../function/PHPExcel-1.8/Classes/PHPExcel.php";
        require_once "../function/function.php";
        $conn=connect();
        $danhsach=danhdachSdtKH($conn);
        xuatfileExcel($conn,$danhsach);;
    }
    if(isset($_POST['xacnhanxuatdsdl'])){
        require_once "../function/PHPExcel-1.8/Classes/PHPExcel.php";
        require_once "../function/function.php";
        $conn=connect();
        $sdt = $_SESSION['login'];
        $dk=$_POST['dieukienloc'];
        $danhsach=danhSachSDTkhachhangLienHeCuaserManager($conn,$dk,$sdt);
        xuatfileExcel($conn,$danhsach);
    }
    if(isset($_POST['xuatdulieutheotrangthaiAdmin'])){
        require_once "../function/PHPExcel-1.8/Classes/PHPExcel.php";
        require_once "../function/function.php";
        $conn=connect();
        $user=$_GET['user'];
        $tt=$_GET['tt'];
        $lan=$_GET['lan'];
        $danhsach=danhSachSDTkhachhangLienHe($conn,$tt,$lan,$user);
        xuatfileExcel($conn,$danhsach);
    }
?>