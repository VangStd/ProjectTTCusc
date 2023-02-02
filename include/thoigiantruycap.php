<?php
session_start();
$id=1;
include "../connect/config.php";
if (isset($_POST['login'])) {
    $username = $_POST['tendangnhap'];
    $password = $_POST['matkhau'];  
    $sql = "SELECT * FROM taikhoan WHERE TENDANGNHAP = '$username' AND MATKHAU = '$password'";
    $query = $conn->query($sql);
    $numrow = mysqli_fetch_array($query);

    if ($numrow['SDT'] != '' && empty($numrow['MAADMIN'])) {
        $row = mysqli_fetch_array($query);
        $_SESSION['login'] = $numrow['SDT'];
        $date= date("Y-m-d H:i:s");
        

        
    } else  ($numrow['MAADMIN'] != '' && empty($numrow['SDT'])) {
        $_SESSION['login'] = $numrow['MAADMIN'];
        $date= date("Y-m-d H:i:s");
        
    } 
}
?>