<?php
include("../connect/config.php");
    $SDT= $_GET['SDT'];
    
    $sql="DELETE FROM `phieudkxettuyen` WHERE SDT = '$SDT'";
    $qr= mysqli_query($conn, $sql);

    if ($ad== 1) {
        echo "<script>location.href='admin.php?route=danhsachhoso';</script>";
    }else{
        echo "<script>location.href='usermanager.php?route=danhsachhoso';</script>";
    }    
?>