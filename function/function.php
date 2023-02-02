<?php
    /* Vinh*/
    function connect(){
        $host="localhost";
        $user="root";
        $pass="";
        $database="htqltuyensinh";
        $conn=new mysqli($host,$user,$pass,$database);
        return $conn;
    }
    function soTrang($tong_so_dong,$so_dong_trong_trang){
        return ceil($tong_so_dong/$so_dong_trong_trang);
    }
    function tinhOffset($page,$so_dong_can_phan){
        return $page*$so_dong_can_phan;
    }
    function layDanhSachNguoiDung($conn,&$danhsachAdmin,&$danhsachUserManager){
       // $limit1=$limit;
        // $offset=tinhOffset($page,$so_dong_can_phan);
        $sql1="SELECT * FROM admin where TRANGTHAIADMIN=1";
        $sql2="SELECT * FROM usermanager where TRANGTHAIUM=1";
        $rs1=$conn->query($sql1);
        $rs2=$conn->query($sql2);
        $i=0;
        $danhsach[$i]=0;
        while ($result1=$rs1->fetch_assoc()){
            $danhsachAdmin[$i]=$result1;
            $danhsachAdmin[$i]['loaitk']='Admin';
            $i=$i+1;
        }
        while ($result2=$rs2->fetch_assoc()){
            $danhsachUserManager[$i]=$result2;
            $danhsachUserManager[$i]['loaitk']='User Manager';
            $i=$i+1;
        }
    }
    function layDanhSachNguoiDungUser($conn,&$danhsachUserManager,$page,$so_dong_can_phan){
        $offset=tinhOffset($page,$so_dong_can_phan);
       // $sql1="SELECT * FROM admin where TRANGTHAIADMIN=1 limit $offset,$so_dong_can_phan";
        $sql2="SELECT * FROM usermanager where TRANGTHAIUM=1 limit $offset,$so_dong_can_phan";
        //$rs1=$conn->query($sql1);
        $rs2=$conn->query($sql2);
        // $i=0;
        $danhsach=null;
        // while ($result1=$rs1->fetch_assoc()){
        //     $danhsachAdmin[$i]=$result1;
        //     $i=$i+1;
        // }
        while ($result2=$rs2->fetch_assoc()){
            $danhsachUserManager[$i]=$result2;
            $i=$i+1;
        }

    }
    function timKiemNguoiDung($conn,$thongtin){
        $thongtin=trim($thongtin);
       if(strpos(strtoupper('User Manager'),strtoupper($thongtin)) !== false){
            $sql="SELECT * FROM `usermanager` where TRANGTHAIUM=1";
            $timkiem1=$conn->query($sql);
            $danhsachtimkiem=[];
            $i=0;
        while ($ketquatiemkiem1=$timkiem1->fetch_assoc()){
            $danhsachtimkiem[$i]=$ketquatiemkiem1;
            $danhsachtimkiem[$i]['loaitk']='User Manager';
            $i=$i+1;
        }
       }
       else if(strpos(strtoupper('Admin'),strtoupper($thongtin)) !== false){
        $sql="SELECT * FROM `Admin` where TRANGTHAIADMIN=1";
        $timkiem1=$conn->query($sql);
        $danhsachtimkiem=[];
        $i=0;
      while ($ketquatiemkiem1=$timkiem1->fetch_assoc()){
        $danhsachtimkiem[$i]=$ketquatiemkiem1;
        $danhsachtimkiem[$i]['loaitk']='Admin';
        $i=$i+1;
    }
       }
       else{
        $sql1="SELECT SDT,HOTEN,GIOITINH,EMAIL,DIACHI  FROM admin WHERE (admin.HOTEN like '%$thongtin%' or admin.SDT like '%$thongtin%'
        or admin.email like '%$thongtin%' or admin.DIACHI like '%$thongtin%' or admin.GIOITINH like '%$thongtin%') and TRANGTHAIADMIN=1 ";
        $sql2="SELECT SDT,HOTEN,GIOITINH,EMAIL,DIACHI FROM usermanager WHERE ( usermanager.HOTEN like '%$thongtin%' or usermanager.SDT like '%$thongtin%' or usermanager.email like '%$thongtin%' 
        or usermanager.DIACHI like '%$thongtin%' or usermanager.GIOITINH like '%$thongtin%') and TRANGTHAIUM=1";
        $timkiem1=$conn->query($sql1);
        $timkiem2=$conn->query($sql2);
        $danhsachtimkiem=[];
        $i=0;
        while ($ketquatiemkiem1=$timkiem1->fetch_assoc()){
            $danhsachtimkiem[$i]=$ketquatiemkiem1;
            $danhsachtimkiem[$i]['loaitk']='Admin';
            $i=$i+1;
        }
        while ($ketquatiemkiem2=$timkiem2->fetch_assoc()){
            $danhsachtimkiem[$i]=$ketquatiemkiem2;
            $danhsachtimkiem[$i]['loaitk']='User Manager';
            $i=$i+1;
        }
    }
        return $danhsachtimkiem;
    }
    function themNguoiDung($conn,$tendangnhap,$mk,$sdt,$hoten,$diachi,$email,$nguoidung,$gioitinh){
        if($nguoidung==='1'){
            $them_tk_usermn="INSERT INTO `taikhoan`(`TENDANGNHAP`,`SDT`,`MATKHAU`)
            VALUES ('$tendangnhap','$sdt','$mk')";
            $them_thong_tin_usermn="INSERT INTO `usermanager`(`SDT`, `HOTEN`,`GIOITINH`,`EMAIL`,`DIACHI`,`TRANGTHAIUM`)
            VALUES ('$sdt','$hoten','$gioitinh','$email','$diachi',1)";
            $conn->query($them_thong_tin_usermn);
            $conn->query($them_tk_usermn);
            NhatKythemnguoidung($conn,"User Manager",$sdt,$hoten);
            // if($conn->query($them_thong_tin_usermn)){
            //    if($conn->query($them_tk_usermn)){
            //     echo"<script>alert('Thêm Người Dùng Thành Công');</script>";
            //    }
            //    else{
            //     xoaThongTinUserManager($conn,$sdt);
            //     echo"<script>alert('Tên Tài Khoản Đã Được Sử Dụng Vui Lòng Sử Dụng Tài Khoản Khác');</script>";
            //     echo"<script>location.href = 'admin.php?route=themnguoidung';</script>";
            //    }
            // }
            // else{
            //    echo"<script>alert('Số Điện Thoại Đã Được Sử Dụng Vui Lòng Sử Dụng SĐT Khác');</script>";
            //    echo"<script>location.href = 'admin.php?route=themnguoidung';</script>";
            // }
          }
         else{
            $maadmin="AD".$sdt;
            $them_thong_tin_admin="INSERT INTO `admin`(`MAADMIN`, `HOTEN`, `GIOITINH`, `SDT`, `DIACHI`, `EMAIL`,`TRANGTHAIADMIN`)
             VALUES ('$maadmin','$hoten','$gioitinh','$sdt','$diachi','$email',1)";
            $them_tai_khoan_admin="INSERT INTO `taikhoan`(`TENDANGNHAP`, `MAADMIN`,`MATKHAU`)
             VALUES ('$tendangnhap','$maadmin','$mk')";
             $conn->query( $them_thong_tin_admin);
             $conn->query($them_tai_khoan_admin);
             NhatKythemnguoidung($conn,"Admin",$sdt,$hoten);
            // if($conn->query( $them_thong_tin_admin)){
            //     if( $conn->query($them_tai_khoan_admin)){
            //        echo"<script>alert('Thêm Người Dùng Thành Công');</script>";
            //     }
            //     else{
            //        xoaThongTinAdmin($conn,$maadmin);
            //        echo"<script>alert('Tên Tài Khoản Đã Được Sử Dụng Vui Lòng Sử Dụng Tài Khoản Khác');</script>";
            //        echo"<script>location.href = 'admin.php?route=themnguoidung';</script>";
            //     }
            // }
            // else{
            //    echo"<script>alert('Số Điện Thoại Đã Được Sử Dụng Vui Lòng Sử Dụng SDT Khác');</script>";
            //    echo"<script>location.href = 'admin.php?route=themnguoidung';</script>";
            // }
          }
       }
    function xoaThongTinAdmin($conn,$maadm){
         $sql="DELETE FROM `admin` WHERE admin.maadmin='$maadm'";
         $conn->query($sql);
       }
    function xoaThongTinUserManager($conn,$sdt){
        $sql="DELETE FROM `usermanager` WHERE usermanager.SDT='$sdt'";
        $conn->query($sql);
    }
    function suaThongTinNguoiDung($conn,$hoten,$gioitinh,$email,$diachi,$sdt){
       $sql="UPDATE `usermanager` 
       SET `HOTEN`='$hoten',`GIOITINH`='$gioitinh',`EMAIL`='$email',`DIACHI`='$diachi'
       WHERE `SDT`='$sdt'";
       if($conn->query($sql)){
        NhatKysuanguoidung($conn,$sdt);
        echo"<script>alert('Chỉnh Sữa Thành Công')</script>"; 
       }
       else{
        echo"<script>alert('Chỉnh Sữa Thất Bại')</script>"; 
       }
    }
    function layThongTinNguoiDung($conn,$sdt){
        $sql="SELECT `SDT`, `HOTEN`, `GIOITINH`, `EMAIL`, `DIACHI` FROM `usermanager` WHERE SDT='$sdt'";
        $result=$conn->query($sql);
        $row=$result->fetch_assoc();
        return $row;
    }
    function hienThiChiTietUserManager($conn,$sdt){
       $sql="SELECT * FROM  usermanager where usermanager.SDT='$sdt'";
    //$sql1="SELECT truong.TENTRUONG FROM phanquyen,truong WHERE phanquyen.MATRUONG=truong.MATRUONG and phanquyen.SDT='$sdt'";
       $thong_tin_usermanager=$conn->query($sql);
    //    $danh_sach_truong_duoc_phan_cong=$conn->query($sql1);
    $i=0;
    $tt=$thong_tin_usermanager->fetch_assoc();
    return $tt;
    }
    function layTenTruongDuocPhanQuyen($conn,$sdt){
        $sql1="SELECT truong.TENTRUONG FROM phanquyen,truong 
        WHERE phanquyen.MATRUONG=truong.MATRUONG and phanquyen.SDT='$sdt'";
        $danh_sach_truong_duoc_phan_cong=$conn->query($sql1);
        $i=0;
        $a=null;
        while($danhsach=$danh_sach_truong_duoc_phan_cong->fetch_assoc()){
            $a[$i]=$danhsach;
            $i++;
        }
       return $a;
    }
    function hienThiChiTietAdmin ($conn,$sdt){
        $sql="SELECT * FROM `admin` WHERE admin.sdt='$sdt'";
        $thong_tin_admin=$conn->query($sql);
        $tt=$thong_tin_admin->fetch_assoc();
        return $tt;
    }
    function laySDTAdminVaUsermn($conn){
        $sql="SELECT SDT from Admin";
        $sql1="SELECT SDT FROM usermanager";
        $result=$conn->query($sql);
        $result1=$conn->query($sql1);
        $danhsachSDT=null;
        $i=0;
        while($row=$result->fetch_assoc()){
            $danhsachSDT[$i]=$row;
            $i++;
        }
        while($row1=$result1->fetch_assoc()){
            $danhsachSDT[$i]=$row1;
            $i++;
        }
        return $danhsachSDT;
    }
    function timKiemSDT($sdt,$danhsachSdt){
        foreach($danhsachSdt as $values){
            if($values['SDT']===$sdt){return 1;}
        }
        return 0;
    }
    function layDanhSachEmail($conn){
        $sql="SELECT email FROM `usermanager`" ;
        $sql1="SELECT email  FROM Admin";
        $result=$conn->query($sql);
        $result1=$conn->query($sql1);
        $danhsachEmail=null;
        $i=0;
        while($row=$result->fetch_assoc()){
            $danhsachEmail[$i]=$row;
            $i++;
        }
        while($row1=$result1->fetch_assoc()){
            $danhsachEmail[$i]=$row1;
            $i++;
        }
        return $danhsachEmail;
    }
    function timKiemEmail($email,$danhsachEmail){
        foreach($danhsachEmail as $values){
            if($values['email']===$email){return 1;}
        }
        return 0;
    }
    function timTrangThaiNguoiDung($conn,$sdt){
        $sql="SELECT TRANGTHAIUM FROM usermanager where SDT='".$sdt."'";
        $sql1="SELECT TRANGTHAIADMIN FROM admin where SDT='".$sdt."'";
    }
    function randomPassword() {
        // $kitu=array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u",
        // "w","x","y","z","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","W","X","Y","Z","0","1","2","3","4","5","6","7","8","9","@");
        $pass=[];
        $kitu= "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        for ($i = 0; $i < 8; $i++) {
            $n = Rand(0, strlen($kitu)-1);
           // echo $k[$n];
            $pass[$i] = $kitu[$n];
        }
         return implode($pass);
    }
    function chucaiExcel(){
        $begin='A';
        $char=$begin;
        $charArray[0]=$char;
        $i=1;
        while(ord($char)<=90){
             $char=chr(ord($char)+1);
             $charArray[$i]=$char;
             $i++;
        }
        $begin1='AA';
        $charArray1[0]=$begin1;
        $char1='A';
        $dem=0;
        $kitu=65;
        for($i=0;$i<2; $i++){
             $char1=chr($kitu);
             for($j=65; $j<=90; $j++){
                 $char1=chr($kitu);
                 $char1=$char1.chr($j);
                 $charArray1[$dem]=$char1;
                 $dem=$dem+1;
             }
             $kitu++;
        }
        $array_new=array_merge($charArray,$charArray1);
        return $array_new;
       }
       function thongtinKhachHang($conn,$sdt){
        $sql="SELECT khachhang.HOTEN,tinh.TENTINH,truong.TENTRUONG,khachhang.SDT,dulieukhachhang.SDTBA,dulieukhachhang.SDTME,dulieukhachhang.SDTZALO,dulieukhachhang.FACEBOOK,khachhang.EMAIL,nghenghiep.TENNGHENGHIEP,hinhthucthuthap.TENHINHTHUC,nganh.TENNGANH,kenhnhanthongbao.TENKENH,khoahocquantam.TENLOAIKHOAHOC ,lienhe.THOIGIAN,lienhe.LAN,trangthai.TENTRANGTHAI,lienhe.KETQUA,lienhe.CHITIETTRANGTHAI,chitietchuyende.TRANGTHAI as trangthaichuyende ,phieudkxettuyen.HOSO,ketquatotnghiep.KETQUA AS ketquatotnghiep,lop.LOP,chucvu.tenchucvu,nganhyeuthich.CHITIET  FROM
        khachhang LEFT join dulieukhachhang on khachhang.SDT=dulieukhachhang.SDT 
        left join nghenghiep on khachhang.MANGHENGHIEP=nghenghiep.MANGHENGHIEP 
        left join nganhyeuthich on nganhyeuthich.SDT=khachhang.SDT
        LEFT join nganh on nganhyeuthich.MANGANH=nganh.MANGANH 
        left join phieudkxettuyen on phieudkxettuyen.SDT=khachhang.SDT
        left join lienhe ON phieudkxettuyen.MAPHIEUDK=lienhe.MAPHIEUDK 
        left join kenhnhanthongbao on kenhnhanthongbao.MAKENH=phieudkxettuyen.MAKENH 
        LEFT join ketquatotnghiep on ketquatotnghiep.MAKETQUA=phieudkxettuyen.MAKETQUA 
        left join khoahocquantam on phieudkxettuyen.MALOAIKHOAHOC=khoahocquantam.MALOAIKHOAHOC 
        LEFT join truong on truong.MATRUONG=khachhang.MATRUONG 
        LEFT join tinh on tinh.MATINH=khachhang.MATINH LEFT join hinhthucthuthap on hinhthucthuthap.MAHINHTHUC=khachhang.MAHINHTHUC
        LEFT join chitietchuyende on phieudkxettuyen.MAPHIEUDK=chitietchuyende.MAPHIEUDK 
        LEFT join trangthai on trangthai.MATRANGTHAI=lienhe.MATRANGTHAI
        LEFT join chucvu on chucvu.SDT=khachhang.SDT
        left join lop on lop.STT=chucvu.STT
        where khachhang.sdt='$sdt'";
        $result=$conn->query($sql);
        $chitietKH=[];
        $i=0;
        while($row=$result->fetch_assoc()){
           $chitietKH[$i]=$row;
           $i++;
        }
        return $chitietKH;
     }
     function danhdachSdtKH($conn){
        $sql="SELECT *FROM KHACHHANG";
        $result=$conn->query($sql);
        $danhsachSdt=[];
        $i=0;
        while($row=$result->fetch_assoc()){
           $danhsachSdt[$i]=$row;
           $i++;
        }
        return $danhsachSdt;
     }
     function danhdachSdtKH1($conn,$dieukien){
        if($dieukien==1 || $dieukien==2 || $dieukien==3){
            $sql="SELECT DISTINCT  khachhang.SDT FROM
            khachhang LEFT join dulieukhachhang on khachhang.SDT=dulieukhachhang.SDT 
            left join nghenghiep on khachhang.MANGHENGHIEP=nghenghiep.MANGHENGHIEP 
            left join nganhyeuthich on nganhyeuthich.SDT=khachhang.SDT
            LEFT join nganh on nganhyeuthich.MANGANH=nganh.MANGANH 
            left join phieudkxettuyen on phieudkxettuyen.SDT=khachhang.SDT
            left join lienhe ON phieudkxettuyen.MAPHIEUDK=lienhe.MAPHIEUDK 
            left join kenhnhanthongbao on kenhnhanthongbao.MAKENH=phieudkxettuyen.MAKENH 
            LEFT join ketquatotnghiep on ketquatotnghiep.MAKETQUA=phieudkxettuyen.MAKETQUA 
            left join khoahocquantam on phieudkxettuyen.MALOAIKHOAHOC=khoahocquantam.MALOAIKHOAHOC 
            LEFT join truong on truong.MATRUONG=khachhang.MATRUONG 
            LEFT join tinh on tinh.MATINH=khachhang.MATINH LEFT join hinhthucthuthap on hinhthucthuthap.MAHINHTHUC=khachhang.MAHINHTHUC
            LEFT join chitietchuyende on phieudkxettuyen.MAPHIEUDK=chitietchuyende.MAPHIEUDK 
            LEFT join trangthai on trangthai.MATRANGTHAI=lienhe.MATRANGTHAI
            LEFT join chucvu on chucvu.SDT=khachhang.SDT
            left join lop on lop.STT=chucvu.STT
            LEFT JOIN chitietpq on chitietpq.SDT=khachhang.SDT
            LEFT join phanquyen on phanquyen.MaPQ=chitietpq.MaPQ
            WHERE phanquyen.SDT='$SDT' and lienhe.LAN='$dk'";
        }
        else {
            $sql="SELECT DISTINCT  khachhang.SDT FROM
            khachhang LEFT join dulieukhachhang on khachhang.SDT=dulieukhachhang.SDT 
            left join nghenghiep on khachhang.MANGHENGHIEP=nghenghiep.MANGHENGHIEP 
            left join nganhyeuthich on nganhyeuthich.SDT=khachhang.SDT
            LEFT join nganh on nganhyeuthich.MANGANH=nganh.MANGANH 
            left join phieudkxettuyen on phieudkxettuyen.SDT=khachhang.SDT
            left join lienhe ON phieudkxettuyen.MAPHIEUDK=lienhe.MAPHIEUDK 
            left join kenhnhanthongbao on kenhnhanthongbao.MAKENH=phieudkxettuyen.MAKENH 
            LEFT join ketquatotnghiep on ketquatotnghiep.MAKETQUA=phieudkxettuyen.MAKETQUA 
            left join khoahocquantam on phieudkxettuyen.MALOAIKHOAHOC=khoahocquantam.MALOAIKHOAHOC 
            LEFT join truong on truong.MATRUONG=khachhang.MATRUONG 
            LEFT join tinh on tinh.MATINH=khachhang.MATINH LEFT join hinhthucthuthap on hinhthucthuthap.MAHINHTHUC=khachhang.MAHINHTHUC
            LEFT join chitietchuyende on phieudkxettuyen.MAPHIEUDK=chitietchuyende.MAPHIEUDK 
            LEFT join chucvu on chucvu.SDT=khachhang.SDT
            left join lop on lop.STT=chucvu.STT
            LEFT join trangthai on trangthai.MATRANGTHAI=lienhe.MATRANGTHAI";
        }
        $result=$conn->query($sql);
        $danhsachSdt=[];
        $i=0;
        while($row=$result->fetch_assoc()){
           $danhsachSdt[$i]=$row;
           $i++;
        }
        return $danhsachSdt;
     }
     function danhSachSDTkhachhangLienHeCuaserManager($conn,$dieukien,$sdt){
        if($dieukien==1 || $dieukien==2 || $dieukien==3){
        $sql="SELECT DISTINCT  khachhang.SDT FROM
        khachhang LEFT join dulieukhachhang on khachhang.SDT=dulieukhachhang.SDT 
        left join nghenghiep on khachhang.MANGHENGHIEP=nghenghiep.MANGHENGHIEP 
        left join nganhyeuthich on nganhyeuthich.SDT=khachhang.SDT
        LEFT join nganh on nganhyeuthich.MANGANH=nganh.MANGANH 
        left join phieudkxettuyen on phieudkxettuyen.SDT=khachhang.SDT
        left join lienhe ON phieudkxettuyen.MAPHIEUDK=lienhe.MAPHIEUDK 
        left join kenhnhanthongbao on kenhnhanthongbao.MAKENH=phieudkxettuyen.MAKENH 
        LEFT join ketquatotnghiep on ketquatotnghiep.MAKETQUA=phieudkxettuyen.MAKETQUA 
        left join khoahocquantam on phieudkxettuyen.MALOAIKHOAHOC=khoahocquantam.MALOAIKHOAHOC 
        LEFT join truong on truong.MATRUONG=khachhang.MATRUONG 
        LEFT join tinh on tinh.MATINH=khachhang.MATINH LEFT join hinhthucthuthap on hinhthucthuthap.MAHINHTHUC=khachhang.MAHINHTHUC
        LEFT join chitietchuyende on phieudkxettuyen.MAPHIEUDK=chitietchuyende.MAPHIEUDK 
        LEFT join trangthai on trangthai.MATRANGTHAI=lienhe.MATRANGTHAI
        LEFT JOIN chitietpq on chitietpq.SDT=khachhang.SDT
        LEFT join phanquyen on phanquyen.MaPQ=chitietpq.MaPQ
        LEFT join chucvu on chucvu.SDT=khachhang.SDT
        left join lop on lop.STT=chucvu.STT
        WHERE phanquyen.SDT='$sdt' and lienhe.LAN='$dieukien'";
        }
        else{
            $sql="SELECT DISTINCT  khachhang.SDT FROM
            khachhang LEFT join dulieukhachhang on khachhang.SDT=dulieukhachhang.SDT 
            left join nghenghiep on khachhang.MANGHENGHIEP=nghenghiep.MANGHENGHIEP 
            left join nganhyeuthich on nganhyeuthich.SDT=khachhang.SDT
            LEFT join nganh on nganhyeuthich.MANGANH=nganh.MANGANH 
            left join phieudkxettuyen on phieudkxettuyen.SDT=khachhang.SDT
            left join lienhe ON phieudkxettuyen.MAPHIEUDK=lienhe.MAPHIEUDK 
            left join kenhnhanthongbao on kenhnhanthongbao.MAKENH=phieudkxettuyen.MAKENH 
            LEFT join ketquatotnghiep on ketquatotnghiep.MAKETQUA=phieudkxettuyen.MAKETQUA 
            left join khoahocquantam on phieudkxettuyen.MALOAIKHOAHOC=khoahocquantam.MALOAIKHOAHOC 
            LEFT join truong on truong.MATRUONG=khachhang.MATRUONG 
            LEFT join tinh on tinh.MATINH=khachhang.MATINH LEFT join hinhthucthuthap on hinhthucthuthap.MAHINHTHUC=khachhang.MAHINHTHUC
            LEFT join chitietchuyende on phieudkxettuyen.MAPHIEUDK=chitietchuyende.MAPHIEUDK 
            LEFT join trangthai on trangthai.MATRANGTHAI=lienhe.MATRANGTHAI
            LEFT join chucvu on chucvu.SDT=khachhang.SDT
            left join lop on lop.STT=chucvu.STT
            LEFT JOIN chitietpq on chitietpq.SDT=khachhang.SDT
            LEFT join phanquyen on phanquyen.MaPQ=chitietpq.MaPQ
            WHERE phanquyen.SDT='$sdt'";

        }
        $result=$conn->query($sql);
        $danhsachSdt=[];
        $i=0;
        while($row=$result->fetch_assoc()){
           $danhsachSdt[$i]=$row;
           $i++;
        }
        return $danhsachSdt;
     }
     function danhSachSDTkhachhangLienHe($conn,$tt,$lan,$user){
        if($user=='' && $lan==0){
            $sql="SELECT DISTINCT  khachhang.SDT FROM
            khachhang LEFT join dulieukhachhang on khachhang.SDT=dulieukhachhang.SDT 
            left join nghenghiep on khachhang.MANGHENGHIEP=nghenghiep.MANGHENGHIEP 
            left join nganhyeuthich on nganhyeuthich.SDT=khachhang.SDT
            LEFT join nganh on nganhyeuthich.MANGANH=nganh.MANGANH 
            left join phieudkxettuyen on phieudkxettuyen.SDT=khachhang.SDT
            left join lienhe ON phieudkxettuyen.MAPHIEUDK=lienhe.MAPHIEUDK 
            left join kenhnhanthongbao on kenhnhanthongbao.MAKENH=phieudkxettuyen.MAKENH 
            LEFT join ketquatotnghiep on ketquatotnghiep.MAKETQUA=phieudkxettuyen.MAKETQUA 
            left join khoahocquantam on phieudkxettuyen.MALOAIKHOAHOC=khoahocquantam.MALOAIKHOAHOC 
            LEFT join truong on truong.MATRUONG=khachhang.MATRUONG 
            LEFT join tinh on tinh.MATINH=khachhang.MATINH LEFT join hinhthucthuthap on hinhthucthuthap.MAHINHTHUC=khachhang.MAHINHTHUC
            LEFT join chitietchuyende on phieudkxettuyen.MAPHIEUDK=chitietchuyende.MAPHIEUDK 
            LEFT join chucvu on chucvu.SDT=khachhang.SDT
            left join lop on lop.STT=chucvu.STT
            LEFT join trangthai on trangthai.MATRANGTHAI=lienhe.MATRANGTHAI
            LEFT JOIN chitietpq on chitietpq.SDT=khachhang.SDT
            LEFT join phanquyen on phanquyen.MaPQ=chitietpq.MaPQ
            WHERE  trangthai.MATRANGTHAI='$tt'";
        }
        else if($user=='' && $lan != 0 ){
            $sql="SELECT DISTINCT  khachhang.SDT FROM
            khachhang LEFT join dulieukhachhang on khachhang.SDT=dulieukhachhang.SDT 
            left join nghenghiep on khachhang.MANGHENGHIEP=nghenghiep.MANGHENGHIEP 
            left join nganhyeuthich on nganhyeuthich.SDT=khachhang.SDT
            LEFT join nganh on nganhyeuthich.MANGANH=nganh.MANGANH 
            left join phieudkxettuyen on phieudkxettuyen.SDT=khachhang.SDT
            left join lienhe ON phieudkxettuyen.MAPHIEUDK=lienhe.MAPHIEUDK 
            left join kenhnhanthongbao on kenhnhanthongbao.MAKENH=phieudkxettuyen.MAKENH 
            LEFT join ketquatotnghiep on ketquatotnghiep.MAKETQUA=phieudkxettuyen.MAKETQUA 
            left join khoahocquantam on phieudkxettuyen.MALOAIKHOAHOC=khoahocquantam.MALOAIKHOAHOC 
            LEFT join truong on truong.MATRUONG=khachhang.MATRUONG 
            LEFT join tinh on tinh.MATINH=khachhang.MATINH LEFT join hinhthucthuthap on hinhthucthuthap.MAHINHTHUC=khachhang.MAHINHTHUC
            LEFT join chitietchuyende on phieudkxettuyen.MAPHIEUDK=chitietchuyende.MAPHIEUDK 
            LEFT join trangthai on trangthai.MATRANGTHAI=lienhe.MATRANGTHAI
            LEFT join chucvu on chucvu.SDT=khachhang.SDT
            left join lop on lop.STT=chucvu.STT
            LEFT JOIN chitietpq on chitietpq.SDT=khachhang.SDT
            LEFT join phanquyen on phanquyen.MaPQ=chitietpq.MaPQ
            WHERE  trangthai.MATRANGTHAI='$tt'
            and lienhe.LAN='$lan'";
        }
        else if($user !='' && $lan==0) {
            $sql="SELECT DISTINCT  khachhang.SDT FROM
            khachhang LEFT join dulieukhachhang on khachhang.SDT=dulieukhachhang.SDT 
            left join nghenghiep on khachhang.MANGHENGHIEP=nghenghiep.MANGHENGHIEP 
            left join nganhyeuthich on nganhyeuthich.SDT=khachhang.SDT
            LEFT join nganh on nganhyeuthich.MANGANH=nganh.MANGANH 
            left join phieudkxettuyen on phieudkxettuyen.SDT=khachhang.SDT
            left join lienhe ON phieudkxettuyen.MAPHIEUDK=lienhe.MAPHIEUDK 
            left join kenhnhanthongbao on kenhnhanthongbao.MAKENH=phieudkxettuyen.MAKENH 
            LEFT join ketquatotnghiep on ketquatotnghiep.MAKETQUA=phieudkxettuyen.MAKETQUA 
            left join khoahocquantam on phieudkxettuyen.MALOAIKHOAHOC=khoahocquantam.MALOAIKHOAHOC 
            LEFT join truong on truong.MATRUONG=khachhang.MATRUONG 
            LEFT join tinh on tinh.MATINH=khachhang.MATINH LEFT join hinhthucthuthap on hinhthucthuthap.MAHINHTHUC=khachhang.MAHINHTHUC
            LEFT join chitietchuyende on phieudkxettuyen.MAPHIEUDK=chitietchuyende.MAPHIEUDK 
            LEFT join trangthai on trangthai.MATRANGTHAI=lienhe.MATRANGTHAI
            LEFT join chucvu on chucvu.SDT=khachhang.SDT
            left join lop on lop.STT=chucvu.STT
            LEFT JOIN chitietpq on chitietpq.SDT=khachhang.SDT
            LEFT join phanquyen on phanquyen.MaPQ=chitietpq.MaPQ
            WHERE  trangthai.MATRANGTHAI='$tt'
            and phanquyen.SDT='$user'";
        }
        else {
            $sql="SELECT DISTINCT  khachhang.SDT FROM
            khachhang LEFT join dulieukhachhang on khachhang.SDT=dulieukhachhang.SDT 
            left join nghenghiep on khachhang.MANGHENGHIEP=nghenghiep.MANGHENGHIEP 
            left join nganhyeuthich on nganhyeuthich.SDT=khachhang.SDT
            LEFT join nganh on nganhyeuthich.MANGANH=nganh.MANGANH 
            left join phieudkxettuyen on phieudkxettuyen.SDT=khachhang.SDT
            left join lienhe ON phieudkxettuyen.MAPHIEUDK=lienhe.MAPHIEUDK 
            left join kenhnhanthongbao on kenhnhanthongbao.MAKENH=phieudkxettuyen.MAKENH 
            LEFT join ketquatotnghiep on ketquatotnghiep.MAKETQUA=phieudkxettuyen.MAKETQUA 
            left join khoahocquantam on phieudkxettuyen.MALOAIKHOAHOC=khoahocquantam.MALOAIKHOAHOC 
            LEFT join truong on truong.MATRUONG=khachhang.MATRUONG 
            LEFT join tinh on tinh.MATINH=khachhang.MATINH LEFT join hinhthucthuthap on hinhthucthuthap.MAHINHTHUC=khachhang.MAHINHTHUC
            LEFT join chitietchuyende on phieudkxettuyen.MAPHIEUDK=chitietchuyende.MAPHIEUDK 
            LEFT join trangthai on trangthai.MATRANGTHAI=lienhe.MATRANGTHAI
            LEFT join chucvu on chucvu.SDT=khachhang.SDT
            left join lop on lop.STT=chucvu.STT
            LEFT JOIN chitietpq on chitietpq.SDT=khachhang.SDT
            LEFT join phanquyen on phanquyen.MaPQ=chitietpq.MaPQ
            WHERE  trangthai.MATRANGTHAI='$tt'
            and lienhe.LAN='$lan'
            and phanquyen.SDT='$user'";
        }

        $result=$conn->query($sql);
        $danhsachSdt=[];
        $i=0;
        while($row=$result->fetch_assoc()){
           $danhsachSdt[$i]=$row;
           $i++;
        }
        return $danhsachSdt;
     }
     function xuatfileExcel($conn,$danhsachsdt){
//         require_once "connect.php";
//    require_once "PHPExcel-1.8/Classes/PHPExcel.php";
   $chucaiexcel=chucaiExcel();
   $chucaiexcel1=chucaiExcel();
  
   $conn=connect();
   $mangtieudechinh=['THÔNG TIN CÁ NHÂN','THÔNG TIN LIÊN HỆ','ĐỐI TƯỢNG','NGÀNH YÊU THÍCH','PHIẾU ĐĂNG KÝ XÉT TUYỂN','FOLLOW1','FOLLOW2','FOLLOW3'];
   $mangtieudephu['THÔNG TIN CÁ NHÂN']=['Họ và tên','Tỉnh/Thành phố','Trường'];
   $mangtieudephu['THÔNG TIN LIÊN HỆ']=['Điện thoại','Điện thoại ba','Điện thoại mẹ','Số Zalo','Facebook','Email'];
   $mangtieudephu['ĐỐI TƯỢNG']=['Nghề nghiệp','Hình thức thu nhập','HS lớp/ SV năm','Chức vụ'];
   $nganhSql="SELECT `MANGANH`, `TENNGANH` FROM `nganh` WHERE 1";
   $mangtieudephu['NGÀNH YÊU THÍCH']=[];
   $resultnganh=$conn->query($nganhSql);
   $i=0;
   while($row=$resultnganh->fetch_assoc()){
    $mangtieudephu['NGÀNH YÊU THÍCH'][$i]=$row['TENNGANH'];
    $i++;
   }
   $mangtieudephu['PHIẾU ĐĂNG KÝ XÉT TUYỂN']=['Kênh Nhận Thông Báo','Khóa Học Quan Tâm','Kết Qủa Đại Học/Cao Đẳng'];
   $mangtieudephu['FOLLOW1']=['Ngày/Tháng','Trạng Thái','Chi Tiết Trạng Thái','Kết Qủa'];
   $mangtieudephu['FOLLOW2']=['Ngày/Tháng','Trạng Thái','Chi Tiết Trạng Thái','Kết Qủa'];
   $mangtieudephu['FOLLOW3']=['Ngày/Tháng','Trạng Thái','Chi Tiết Trạng Thái','Kết Qủa'];

   $mangtieudeSQL['Họ và tên']='HOTEN';
   $mangtieudeSQL['Tỉnh/Thành phố']='TENTINH';
   $mangtieudeSQL['Trường']='TENTRUONG';
   $mangtieudeSQL['Điện thoại']='SDT';
   $mangtieudeSQL['Điện thoại ba']='SDTBA';
   $mangtieudeSQL['Điện thoại mẹ']='SDTME';
   $mangtieudeSQL['Số Zalo']='SDTZALO';
   $mangtieudeSQL['Facebook']='FACEBOOK';
   $mangtieudeSQL['Email']='EMAIL';
//    $mangtieudeSQL['Tham gia Chuyên đề']='trangthaichuyende';
   $mangtieudeSQL['Nghề nghiệp']='TENNGHENGHIEP';
   $mangtieudeSQL['Hình thức thu nhập']='TENHINHTHUC';
   $mangtieudeSQL['HS lớp/ SV năm']='LOP';
   $mangtieudeSQL['Chức vụ']='tenchucvu';
   $mangtieudeSQL['Kênh Nhận Thông Báo']='TENKENH';
   $mangtieudeSQL['Khóa Học Quan Tâm']='TENLOAIKHOAHOC';
//    $mangtieudeSQL['Hồ Sơ']='HOSO';
   $mangtieudeSQL['Kết Qủa Đại Học/Cao Đẳng']='ketquatotnghiep';
   $mangtieudeSQL['Ngày/Tháng']='THOIGIAN';
   $mangtieudeSQL['Trạng Thái']='TENTRANGTHAI';
   $mangtieudeSQL['Chi Tiết Trạng Thái']='CHITIETTRANGTHAI';
   $mangtieudeSQL['Kết Qủa']='KETQUA';

   $excel = new PHPExcel();
	//Chọn trang cần ghi (là số từ 0->n)
   $excel->setActiveSheetIndex(0);
	//Tạo tiêu đề cho trang. (có thể không cần)
   $excel->getActiveSheet()->setTitle('dulieukhachhang');
   $dem=1;
   $index=3;
   $stt=1;
   $beginrowforsubtitle=2;
   $beginrowformaintile=1;
   $beginchar=1;
   $begincharformaintile=1;
   $excel->getActiveSheet()->mergeCells('A1:A2');
   $excel->getActiveSheet()->setCellValue('A1','STT');
   for($i=0; $i<count($mangtieudechinh); $i++){
      $excel->getActiveSheet()->setCellValue($chucaiexcel[$begincharformaintile].$beginrowformaintile,$mangtieudechinh[$i]);
      for($j=0; $j<count($mangtieudephu[$mangtieudechinh[$i]]); $j++){
          $excel->getActiveSheet()->setCellValue($chucaiexcel[$dem].$beginrowforsubtitle,$mangtieudephu[$mangtieudechinh[$i]][$j]);
          $chucaiexcel[$dem]++;
      }
   }
   // $danhsachtt=thongtinKhachHang($conn,$sdt);
   $begincontent=3;
  // $index=0;
   $index=3;
   $dem=1;
   foreach($danhsachsdt as $value){
      $sdt=$value['SDT'];
      $ttkh=thongtinKhachHang($conn,$sdt);
      $excel->getActiveSheet()->setCellValue('A'.$index,$dem);
      $index++;
      $dem++;
      $chucaiexcel1[1]='B';
      for($j=0; $j<count($mangtieudechinh); $j++){
         for($k=0; $k<count($mangtieudephu[$mangtieudechinh[$j]]);$k++){
            if($mangtieudechinh[$j] !='NGÀNH YÊU THÍCH' &&$mangtieudechinh[$j] !='FOLLOW1' && $mangtieudechinh[$j] !='FOLLOW2' && $mangtieudechinh[$j] !='FOLLOW3'){
               $excel->getActiveSheet()->setCellValue($chucaiexcel1[1].$begincontent, $ttkh[0][$mangtieudeSQL[$mangtieudephu[$mangtieudechinh[$j]][$k]]]);
               $chucaiexcel1[1]++;
            }
            else if($mangtieudechinh[$j] ==='FOLLOW1'||$mangtieudechinh[$j] ==='FOLLOW2'||$mangtieudechinh[$j] ==='FOLLOW3'){
               for($a=0;$a<count($ttkh); $a++){
                  if($mangtieudechinh[$j] ==='FOLLOW1' && $a==0){
                     $excel->getActiveSheet()->setCellValue($chucaiexcel1[1].$begincontent, $ttkh[0][$mangtieudeSQL[$mangtieudephu[$mangtieudechinh[$j]][$k]]]);
                     $chucaiexcel1[1]++;
                  }
                  else if($mangtieudechinh[$j] ==='FOLLOW2' && $a==1){
                     $excel->getActiveSheet()->setCellValue($chucaiexcel1[1].$begincontent, $ttkh[1][$mangtieudeSQL[$mangtieudephu[$mangtieudechinh[$j]][$k]]]);
                     $chucaiexcel1[1]++;
                  }
                  else if($mangtieudechinh[$j] ==='FOLLOW3' && $a==2){
                     $excel->getActiveSheet()->setCellValue($chucaiexcel1[1].$begincontent, $ttkh[2][$mangtieudeSQL[$mangtieudephu[$mangtieudechinh[$j]][$k]]]);
                     $chucaiexcel1[1]++;
                  }
               }
            }
            else if ($mangtieudechinh[$j] =='NGÀNH YÊU THÍCH'){
               $k=count($mangtieudephu[$mangtieudechinh[$j]]);
               $nganhkhac='';
               foreach($ttkh as $values_ttkh){
                  for($l=0; $l<count(($mangtieudephu['NGÀNH YÊU THÍCH']));$l++){
                     if($values_ttkh['TENNGANH']== $mangtieudephu['NGÀNH YÊU THÍCH'][$l] && $values_ttkh['TENNGANH'] !='NGÀNH KHÁC')
                       { 
                        $excel->getActiveSheet()->setCellValue($chucaiexcel1[1].$begincontent,'x');
                         
                        }
                  if($values_ttkh['TENNGANH']=='NGÀNH KHÁC'){
                           $nganhkhac=$values_ttkh['CHITIET'];
                    }
                        $chucaiexcel1[1]++;
                        $index1= $chucaiexcel1[1];
            }
           
            $chucaiexcel1[1]='P';
          
         }
         $end=$index1;
         $end--;
         if($nganhkhac !=null){
            $excel->getActiveSheet()->setCellValue('V'.$begincontent,$nganhkhac);
        }
         $chucaiexcel1[1]=$index1;
      }
   }
}
   $begincontent++;
}
   
   header('Content-type: application/vnd.ms-excel');
   header('Content-Disposition: attachment; filename="dulieuKH.xlsx"');
   PHPExcel_IOFactory::createWriter($excel, 'Excel2007')->save('php://output');
     }
    ?>