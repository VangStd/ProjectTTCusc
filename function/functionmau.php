<?php
    function sosanhngay($ngay){
        $kt = "1900-01-01";
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $today = date("Y-m-d");
        if(strtotime($today) > strtotime($ngay)) $kt = $ngay;
        else $kt = $today;
        return $kt;
    }

    function ngay($date,$songay){
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $today = date("Y-m-d");
        $a[0][0]=1;
        $j=0;
        $f = 0 ;
        for($i=0;$i<$songay;$i++){
            $ngay = strtotime('+'.$i.' day',strtotime($date));    //+ tính từ ngày nào đó.
            // echo date("d/m/Y", $ngay);
            // echo " ";
            $thoigian= date("Y-m-d", $ngay);
            if (strtotime($today) >= strtotime($thoigian)){
                $a[0][$j] = $thoigian;
                $j++; 
            }
            else break;
        }
        return $a;
    }

    function congthoigian($mysqli,$date){
        $a[0][0]=1;
        $begin = date_create($date);
        $ngay=date_format($begin,"Y-m-d");
        
        $sql1 = "select count(TONGTHOIGIAN) from THOIGIANDANGNHAP where date(dangnhap) ='".$ngay."'   ";
        $result= mysqli_query($mysqli, $sql1);

        
        $a=0;
        //DANGNHAP = '".$ngay."'
        while($row = mysqli_fetch_assoc($result)){
            $a = $row['count(TONGTHOIGIAN)'];
        }
        return $a;
    }   

    function congthoigianthang($mysqli,$date){
        $a[0][0]=1;
        // $thang=month($date);
        
        $sql1 = "select sum(TONGTHOIGIAN) from THOIGIANDANGNHAP where month(dangnhap) ='".$date."'   ";
        $result= mysqli_query($mysqli, $sql1);
        $a=0;
        while($row = mysqli_fetch_assoc($result)){
            $a = $row['sum(TONGTHOIGIAN)'];
        }
        return $a;
       
    }   

    function congthoigianngay($mysqli,$date){
        $a[0][0]=1;
        // $thang=month($date);
        
        $sql1 = "select sum(TONGTHOIGIAN) from THOIGIANDANGNHAP where day(dangnhap) ='".$date."'   ";
        $result= mysqli_query($mysqli, $sql1);
        $a=0;
        while($row = mysqli_fetch_assoc($result)){
            $a = $row['sum(TONGTHOIGIAN)'];
        }
        return $a;
       
    }   
    
    function hienbang($mysqli,$date){

        $begin = date_create($date);
        $ngay=date_format($begin,"Y-m-d");
  

        $sql = "SELECT MAADMIN,SDT,DANGNHAP,DANGXUAT,TONGTHOIGIAN FROM THOIGIANDANGNHAP where  date(dangnhap)='".$ngay."'  ";
        $result= mysqli_query($mysqli, $sql);
        $a[0][0]=1;
        $i = 0;
        while($row = mysqli_fetch_assoc($result)){
            $a[$i][0] = $row['MAADMIN'];
            $a[$i][1] = $row['SDT'];
            $a[$i][2] = $row['DANGNHAP'];
            $a[$i][3] = $row['DANGXUAT'];
            $a[$i][4] = $row['TONGTHOIGIAN'];
            $i++;
        }
        return $a;

    }
    function hienbangthang($mysqli,$date){

        $a[0][0]=1;
        // $thang=month($date);
  

        $sql = "SELECT MAADMIN,SDT,DANGNHAP,DANGXUAT,TONGTHOIGIAN FROM THOIGIANDANGNHAP where  month(dangnhap) ='".$date."'  ";
        $result= mysqli_query($mysqli, $sql);
        
        $i = 0;
        while($row = mysqli_fetch_assoc($result)){
            $a[$i][0] = $row['MAADMIN'];
            $a[$i][1] = $row['SDT'];
            $a[$i][2] = $row['DANGNHAP'];
            $a[$i][3] = $row['DANGXUAT'];
            $a[$i][4] = $row['TONGTHOIGIAN'];
            $i++;
        }
        return $a;

    }
    function hienbangngay($mysqli,$date){

        $a[0][0]=1;
        // $thang=month($date);
  

        $sql = "SELECT MAADMIN,SDT,DANGNHAP,DANGXUAT,TONGTHOIGIAN FROM THOIGIANDANGNHAP where  day(dangnhap) ='".$date."'  ";
        $result= mysqli_query($mysqli, $sql);
        
        $i = 0;
        while($row = mysqli_fetch_assoc($result)){
            $a[$i][0] = $row['MAADMIN'];
            $a[$i][1] = $row['SDT'];
            $a[$i][2] = $row['DANGNHAP'];
            $a[$i][3] = $row['DANGXUAT'];
            $a[$i][4] = $row['TONGTHOIGIAN'];
            $i++;
        }
        return $a;

    }
    function songay($ngaybatdau,$ngayketthuc){
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $i = 1;
        $today = date("Y-m-d");
        if(strtotime($today)<=strtotime($ngayketthuc)){
            $i = floor((strtotime($today)-strtotime($ngaybatdau))/(60*60*24))+1;

        }
        else{
            $i = floor((strtotime($ngayketthuc)-strtotime($ngaybatdau)) / (60*60*24)+2);
        }
        return $i;
    }
?>