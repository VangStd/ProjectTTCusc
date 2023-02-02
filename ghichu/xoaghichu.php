<?php
    include("../connect/config.php");
    include("../function/functionThongKe.php");
    $ID= $_GET['ID'];
    xoaGhiChu($conn, $ID);

    if ($ad== 1) {
        echo "<script>location.href='admin.php?route=home';</script>";
    }else{
        echo "<script>location.href='usermanager.php?route=home';</script>";
    }
?>