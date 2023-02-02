<?php
session_start();
include "../connect/config.php";
$user=$_SESSION['login'];
    if(strlen($user) > 10){
        $sql1="update thoigiandangnhap set dangxuat=now() where maadmin='" . $user . "' and dangxuat='' ";
        mysqli_query($conn,$sql1);
        $sql2="update thoigiandangnhap set tongthoigian=unix_timestamp(dangxuat)-unix_timestamp(dangnhap)";
        mysqli_query($conn,$sql2);
        
        
    } else{
        $sql1="update thoigiandangnhap set dangxuat=now() where sdt='" . $user . "'  and dangxuat='' ";
        mysqli_query($conn,$sql1);
        $sql2="update thoigiandangnhap set tongthoigian=unix_timestamp(dangxuat)-unix_timestamp(dangnhap)";
        mysqli_query($conn,$sql2);
    }
    unset($_SESSION['login']);
    session_unset();
    header("Location: index.php"); 

?>