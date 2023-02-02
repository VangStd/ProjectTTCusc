 <?php
  include "../connect/config.php";
  $t = 0;

  if(isset($_POST['xacnhanpdkxt'])){
    $sodienthoai = $_POST['sodienthoai'];
    $kh = $_POST['khoahoc'];
    $kenhnhan = $_POST['kenhnhan'];
    $cddh = $_POST['cddh'];
    $zalo = $_POST['zalo'];
    $nganh = $_POST['Nganh'];
    $nganhdk = $_POST['nganhdk'];
    for($i = 0 ; $i< count($nganh); $i++){
        $nganh[$i] = $nganh[$i];
        $sql_nganh = "INSERT INTO `nganhyeuthich`(`SDT`, `MANGANH`, `CHITIET`) VALUES ('$sodienthoai','$nganh[$i]','')";
        $sql_nganh;
        $query_nganh = mysqli_query($conn, $sql_nganh);
    }
    $madk = "DK".random_int(50,10000);
    $sql_ins = "INSERT INTO `phieudkxettuyen`(`MAPHIEUDK`, `MALOAIKHOAHOC`, `MAKENH`, `SDT`, `MAKETQUA`, `SDTZALO`, `HOSO`,`NGANHDK`) 
                VALUES ('".$madk."','".$kh."','".$kenhnhan."','".$sodienthoai."','".$cddh."','".$zalo."','NULL', 'NULL')";
    $query_ins = mysqli_query($conn, $sql_ins);

    $sql_update = "UPDATE `phieudkxettuyen` SET `MALOAIKHOAHOC`='".$kh."' WHERE SDT = '".$sodienthoai."'";
    $query_update = mysqli_query($conn, $sql_update);  
    
    $sql_update_nganhdk = "UPDATE `phieudkxettuyen` SET `NGANHDK`='".$nganhdk."' WHERE SDT = '".$sodienthoai."'";
    $query_update_nganhdk = mysqli_query($conn, $sql_update_nganhdk);
  }
  header("Location: ../thongtinkhachhang/thongtinkhachhang.php?sdt=$sodienthoai");
?>
