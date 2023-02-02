<?php
    ini_set ("memory_limit", "32M");
    //Người làm: Nguyễn Thế Hùng;
    function sosanhngayHT($ngay){
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

    function thongke($mysqli,$date,$user){
        $a[0][0]=1;
        $begin = date_create($date);
        $ngay=date_format($begin,"Y-m-d");
        
        $sql = "select COUNT(MALIENHE) from lienhe where SDT like '%".$user."%' and THOIGIAN = '".$ngay."' GROUP BY THOIGIAN";
        $result= mysqli_query($mysqli, $sql);
        $a=0;
        
        while($row = mysqli_fetch_assoc($result)){
            $a = $row['COUNT(MALIENHE)'];
        }
        return $a;
    }   
    function soluonglienhetheonguoi($mysqli,$date){

        $begin = date_create($date);
        $ngay=date_format($begin,"Y-m-d");
        
        $sql = "Select THOIGIAN,HOTEN,COUNT(MALIENHE)  FROM lienhe,usermanager where lienhe.SDT=usermanager.SDT and lienhe.THOIGIAN='".$ngay."' GROUP bY usermanager.SDT";
        $result= mysqli_query($mysqli, $sql);
        $a[0][0]=1;
        $i = 0;
        while($row = mysqli_fetch_assoc($result)){
            $a[$i][0] = $row['THOIGIAN'];
            $a[$i][1] = $row['HOTEN'];
            $a[$i][2] = $row['COUNT(MALIENHE)'];
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
    //echo ngay($conn,"2022-06-02",3)
    function thongketheoTT($mysqli,$user){
        $sql = "select t.TENTRANGTHAI as tentt, tong from trangthai t LEFT JOIN 
        (SELECT  COUNT(MALIENHE) as tong, MATRANGTHAI FROM phieudkxettuyen,lienhe,usermanager where 
        phieudkxettuyen.MAPHIEUDK=lienhe.MAPHIEUDK and lienhe.SDT=usermanager.SDT and lienhe.SDT like'%".$user."%' 
        and phieudkxettuyen.SDT not in (SELECT SDT FROM khachhangcu)
        GROUP BY MATRANGTHAI) b 
        ON t.MATRANGTHAI=b.MATRANGTHAI GROUP BY t.MATRANGTHAI;";
        $result= mysqli_query($mysqli, $sql);
        $a[0][0]=0;
        $i=0;
        while($row = mysqli_fetch_assoc($result)){
            $a[$i][0] = $row['tentt'];
            if($row['tong']!=NULL) $a[$i][1] = $row['tong'];
            else $a[$i][1]=0;
            $i++;
        }
        return $a;
    }   
    function sophieuDKtheoTT($mysqli,$user,$lan){
        if($lan == 0){
            $sql = "select t.MATRANGTHAI as matt,t.TENTRANGTHAI as tentt, tong from trangthai t 
                    LEFT JOIN (SELECT usermanager.SDT,MATRANGTHAI,COUNT(DISTINCT phieudkxettuyen.MAPHIEUDK) as tong
                    from phieudkxettuyen,lienhe,usermanager where phieudkxettuyen.MAPHIEUDK=lienhe.MAPHIEUDK 
                    and lienhe.SDT=usermanager.SDT and lienhe.SDT like'%".$user."%'
                    and phieudkxettuyen.SDT not in (SELECT SDT FROM khachhangcu) 
                    GROUP BY MATRANGTHAI) b  ON t.MATRANGTHAI=b.MATRANGTHAI GROUP BY t.MATRANGTHAI";
            $result= mysqli_query($mysqli, $sql);
            $a[0][0]=0;
            $i=0;
            while($row = mysqli_fetch_assoc($result)){
                $a[$i][0] = $row['matt'];
                $a[$i][1] = $row['tentt'];
                if($row['tong']!=NULL) $a[$i][2] = $row['tong'];
                else $a[$i][2]=0;
                $i++;
            }
        }
        else{
            $sql = "select t.MATRANGTHAI as matt,t.TENTRANGTHAI as tentt, tong from trangthai t 
            LEFT JOIN (SELECT usermanager.SDT,MATRANGTHAI,COUNT(DISTINCT phieudkxettuyen.MAPHIEUDK) as tong
            from phieudkxettuyen,lienhe,usermanager where phieudkxettuyen.MAPHIEUDK=lienhe.MAPHIEUDK 
            and lienhe.SDT=usermanager.SDT and lienhe.SDT like'%".$user."%' and lienhe.Lan ='".$lan."'
            and phieudkxettuyen.SDT not in (SELECT SDT FROM khachhangcu) 
            GROUP BY MATRANGTHAI) b  ON t.MATRANGTHAI=b.MATRANGTHAI GROUP BY t.MATRANGTHAI";
    $result= mysqli_query($mysqli, $sql);
    $a[0][0]=0;
    $i=0;
    while($row = mysqli_fetch_assoc($result)){
        $a[$i][0] = $row['matt'];
        $a[$i][1] = $row['tentt'];
        if($row['tong']!=NULL) $a[$i][2] = $row['tong'];
        else $a[$i][2]=0;
        $i++;
    }
        }
    return $a;
    }
    function thongketheoKQkhaithac($mysqli,$user,$matt){
        $sql = "SELECT COUNT(lienhe.MALIENHE) as tong from phieudkxettuyen,lienhe,usermanager 
        where phieudkxettuyen.MAPHIEUDK=lienhe.MAPHIEUDK and lienhe.SDT=usermanager.SDT and lienhe.MATRANGTHAI='".$matt."' and lienhe.SDT like'%".$user."%'
        and phieudkxettuyen.SDT not in (SELECT SDT FROM khachhangcu)";
        $result= mysqli_query($mysqli, $sql);
        $a=0;

        while($row = mysqli_fetch_assoc($result)){
            $a = $row['tong'];
        }
        return $a;
    } 
    function SophieuDK($mysqli,$user,$lan){
        if($lan == 0){
            $sql = "SELECT COUNT(DISTINCT phieudkxettuyen.MAPHIEUDK) as tong
            from phieudkxettuyen,lienhe,usermanager where phieudkxettuyen.MAPHIEUDK=lienhe.MAPHIEUDK and lienhe.SDT=usermanager.SDT and lienhe.SDT like'%".$user."%' 
            and phieudkxettuyen.SDT not in (SELECT SDT FROM khachhangcu)";
            $result= mysqli_query($mysqli, $sql);
            while($row = mysqli_fetch_assoc($result)){
                $a=$row['tong'];
            }
        }
        else{
            $sql = "SELECT COUNT(DISTINCT phieudkxettuyen.MAPHIEUDK) as tong
            from phieudkxettuyen,lienhe,usermanager where phieudkxettuyen.MAPHIEUDK=lienhe.MAPHIEUDK and lienhe.SDT=usermanager.SDT and lienhe.SDT like'%".$user."%' 
            and lienhe.Lan ='".$lan."' and phieudkxettuyen.SDT not in (SELECT SDT FROM khachhangcu)";
            $result= mysqli_query($mysqli, $sql);
            while($row = mysqli_fetch_assoc($result)){
                $a=$row['tong'];
            }
        }
        return $a;
    }
    function thongketheoKQkhaithactheolan($mysqli,$user,$matt,$lan){
        $sql = "SELECT COUNT(lienhe.MALIENHE) as tong from phieudkxettuyen,lienhe,usermanager 
        where phieudkxettuyen.MAPHIEUDK=lienhe.MAPHIEUDK and lienhe.SDT=usermanager.SDT and lienhe.MATRANGTHAI='".$matt."' and lienhe.SDT like'%".$user."%' and lan ='".$lan."'
        and phieudkxettuyen.SDT not in (SELECT SDT FROM khachhangcu)";
        $result= mysqli_query($mysqli, $sql);
        $a=0;

        while($row = mysqli_fetch_assoc($result)){
            $a = $row['tong'];
            
        }
        return $a;
    }
    function MaUM($mysqli){
        $sql = "select SDT,HOTEN from usermanager";
        $result = mysqli_query($mysqli,$sql);
        $a[0][0]=0;
        $i=0;
        while($row = mysqli_fetch_assoc($result)){
            $a[$i][0] = $row['SDT'];
            $a[$i][1] = $row['HOTEN'];
            $i++;
        }
        return $a;
    }  

    function laUserManager($mysqli){
        $user = $_SESSION['login'];
        $kt = false;
        if (mysqli_num_rows(mysqli_query($mysqli,"select SDT FROM usermanager WHERE SDT='".$user."'")) == 0){
            $kt = true;
        }
        return $kt;   
    }

    //Lấy dữ liệu khách hàng
    function laytrung($mysqli,$file,$sdtKT){
        $objReader = PHPExcel_IOFactory::createReaderForFile($file);
        $objReader ->setloadSheetsOnly('khachhang');

        $objExcel = $objReader ->load($file);
        $sheetData = $objExcel ->getActiveSheet()->toArray('null', true, true, true);

        $highestRow = $objExcel->setActiveSheetIndex()->getHighestRow();
        $i = 0;
        for($row = 2; $row<=$highestRow; $row++){
                $sdt = $sheetData[$row]['A'];
                //echo $sdt;
                //echo $sdtKT;
                if($sdt==$sdtKT){ $i++;}
            
        }
        return $i;
   }  
   function dongtrungDT($mysqli,$file,$sdtKT){
        $objReader = PHPExcel_IOFactory::createReaderForFile($file);
        $objReader ->setloadSheetsOnly('khachhang');

        $objExcel = $objReader ->load($file);
        $sheetData = $objExcel ->getActiveSheet()->toArray('null', true, true, true);

        $highestRow = $objExcel->setActiveSheetIndex()->getHighestRow();
        $i = 0;
        for($row = 2; $row<=$highestRow; $row++){
                $sdt = $sheetData[$row]['A'];
                //echo $sdt;
                //echo $sdtKT;
                if($sdt==$sdtKT){ $i = $row; break;}
            
        }
    return $i;
    } 

    function layMatruong($mysqli,$tentruong){
        $a = 0;
        if($tentruong == "null"){ $a = "TR00";} 
        else{
            $sql = "select count(MATRUONG),MATRUONG from truong where TENTRUONG = '$tentruong' ";
            $result= mysqli_query($mysqli, $sql); 
            while($row = mysqli_fetch_assoc($result)){
                if($row['count(MATRUONG)']>0){$a = $row['MATRUONG'];}
                else{
                    $a = themtruong($mysqli,$tentruong);
                }
            }
        }
        return $a;
    }
    function themtruong($mysqli,$tentruong){
       
        $matruong = 0;
        $a = 0;
        $sql1 = "select count(MATRUONG) as tong from truong";
        $result= mysqli_query($mysqli, $sql1); 
        while($row = mysqli_fetch_assoc($result)){
            $matruong = 'TR'.$row['tong'];
        }
        $sqlinsert = "INSERT INTO `truong`(`MATRUONG`, `TENTRUONG`) VALUES ('$matruong','$tentruong')";
            if (mysqli_query($mysqli, $sqlinsert)){					
                $a =  $matruong ;    
            }
            else {}
        return $a;
    }

    function layMaHT($mysqli,$TENHINHTHUC){
        $a = 0;
        $sql = "select count(MAHINHTHUC),MAHINHTHUC from hinhthucthuthap where TENHINHTHUC = '$TENHINHTHUC' ";
        $result= mysqli_query($mysqli, $sql); 
        while($row = mysqli_fetch_assoc($result)){
            if($row['count(MAHINHTHUC)']>0){$a = $row['MAHINHTHUC'];}
            else{
                $a = themhinhthuc($mysqli,$TENHINHTHUC);
            }
        }
        
        return $a;
    }

    function themhinhthuc($mysqli,$TENHINHTHUC){
        $MAHINHTHUC = 0;
        $a = 0;
        $sql1 = "select count(MAHINHTHUC)+1 as tong from hinhthucthuthap";
        $result= mysqli_query($mysqli, $sql1); 
        while($row = mysqli_fetch_assoc($result)){
            $MAHINHTHUC = 'HT'.$row['tong'];
        }
        $sqlinsert = "INSERT INTO `hinhthucthuthap`(`MAHINHTHUC`, `TENHINHTHUC`) VALUES ('$MAHINHTHUC','$TENHINHTHUC')";
            if (mysqli_query($mysqli, $sqlinsert)){					
                $a =  $MAHINHTHUC ;    
            }
            else {}
        return $a;
    }

    function layMaNN($mysqli,$nghenghiep){
        $a = 0;
        $sql = "select count(MANGHENGHIEP),MANGHENGHIEP from nghenghiep where TENNGHENGHIEP = '$nghenghiep' ";
        $result= mysqli_query($mysqli, $sql); 
        while($row = mysqli_fetch_assoc($result)){
            if($row['count(MANGHENGHIEP)']>0){$a = $row['MANGHENGHIEP'];}
            else{
                $a = "NN03";
            }
        }
        return $a;
    }
    function laymatinh($mysqli,$tentinh){
        $a = 0;
        $sql = "select MATINH from tinh where TENTINH = '$tentinh'";
        $result= mysqli_query($mysqli, $sql); 
        while($row = mysqli_fetch_assoc($result)){
            $a = $row['MATINH'];
        }
        return $a;
    }
    function themkhachhangcu($mysqli,$file){
        $objReader = PHPExcel_IOFactory::createReaderForFile($file);
        $objReader ->setloadSheetsOnly('khachhangcu');

        $objExcel = $objReader ->load($file);
        $sheetData = $objExcel ->getActiveSheet()->toArray('null', true, true, true);

        $highestRow = $objExcel->setActiveSheetIndex()->getHighestRow();
        $a = 1;
        $b = true;
        $sodongduocthem=0;
        for($row = 2; $row<=$highestRow; $row++){
            $sdt = $sheetData[$row]['A'];
            $HOTEN = $sheetData[$row]['B'];
            if($sdt!="null" && $HOTEN!="null"){
                if(mysqli_num_rows(mysqli_query($mysqli,"select SDT  FROM khachhangcu WHERE SDT='$sdt'")) == 0){
                    $sql = "INSERT INTO `khachhangcu`(`SDT`, `HOTEN`) VALUES ('$sdt','$HOTEN')";
                    if (mysqli_query($mysqli, $sql)){
                        $sodongduocthem++;					
                        $b = true;        
                    }
                    else {
                        $a=$sdt;
                        $b = false;
                        break;
                    }
                }
            }
        }
        if($b == true){NhatKythemkhachhangcu($mysqli,$sodongduocthem);echo '<script language="javascript">alert("Thêm dữ liệu thành công!");</script>';}  
        else if($b == false) {echo '<script language="javascript">alert("Bị lỗi dữ liệu tại số điện thoại: '.$a.'!");history.go(-1);</script>';} 
    }
    function themkhachhang($mysqli,$file){
        $objReader = PHPExcel_IOFactory::createReaderForFile($file);
        $objReader ->setloadSheetsOnly('dulieukhachhang');

        $objExcel = $objReader ->load($file);
        $sheetData = $objExcel ->getActiveSheet()->toArray('null', true, true, true);

        $highestRow = $objExcel->setActiveSheetIndex()->getHighestRow();
        $a = 3;
        $b = true;
        $sodongduocthem=0;
        // $a[0][0] =1;
        // $i = 0;
        for($row = 3; $row<=$highestRow; $row++){

            $sdt = $sheetData[$row]['E'];
            $HOTEN = $sheetData[$row]['B'];
            $TENTRUONG = $sheetData[$row]['D'];
            $tentinh = $sheetData[$row]['C'];
            $nghenghiep = $sheetData[$row]['K'];
            $TENHINHTHUC = $sheetData[$row]['L'];
            $EMAIL = $sheetData[$row]['J'];

            //Dữ liệu khách hàng
            $sdtba = $sheetData[$row]['F'];
            $sdtme = $sheetData[$row]['G'];
            $zalo = $sheetData[$row]['H'];
            $facebook = $sheetData[$row]['I'];

            //Chức vụ của khách hàng
            $lop = $sheetData[$row]['M'];
            $chucvu = $sheetData[$row]['N'];

            //Ngành yêu thích
            $APTECH = $sheetData[$row]['O'];
            $APTECH_CD = $sheetData[$row]['P'];
            $APTECH_DHCT = $sheetData[$row]['Q'];
            $ACNPro = $sheetData[$row]['R'];
            $ARENA = $sheetData[$row]['S'];
            $ARENA_CD = $sheetData[$row]['T'];
            $ARENA_LT = $sheetData[$row]['U'];
            $KHAC = $sheetData[$row]['V'];

            //Thêm phiếu đk
            $kenhthongbao = $sheetData[$row]['W'];
            $khoahocquantam = $sheetData[$row]['X'];
            //$hoso = $sheetData[$row]['Z'];
            $kq = $sheetData[$row]['Y'];
            
            if($sdt!="null" && $HOTEN!="null" && $TENHINHTHUC !="null" && $nghenghiep !="null" && $tentinh !="null"){
                $MAHINHTHUC = layMaHT($mysqli,$TENHINHTHUC);
                $MANGHENGHIEP = layMaNN($mysqli,$nghenghiep);
                $MATRUONG = layMatruong($mysqli,$TENTRUONG,$tentinh);
                $MATINH=laymatinh($mysqli,$tentinh);
                if(mysqli_num_rows(mysqli_query($mysqli,"select SDT  FROM khachhang WHERE SDT='$sdt'")) == 0){
                    //if($EMAIL=="null"){}
                    //$a[$i][0] = $sdt;
                    //$i++;
                    $sql = "INSERT INTO `khachhang`(`SDT`, `MANGHENGHIEP`, `MATRUONG`, `MATINH`, `MAHINHTHUC`, `HOTEN`)
                            VALUES ('".$sdt."','".$MANGHENGHIEP."','".$MATRUONG."','".$MATINH."','".$MAHINHTHUC."','".$HOTEN."')";
                    if (mysqli_query($mysqli, $sql)){					
                        BosungttKH($mysqli,$sdt,$EMAIL);

                        //Thêm dữ liệu khách hàng
                        $makh = taomaKH($mysqli);
                        themdulieu($mysqli,$makh,$sdt,$sdtba,$sdtme,$zalo,$facebook);

                        //Thêm chức vụ
                        $stt = laysttlop($mysqli,$lop);
                        chucvuKH($mysqli,$sdt,$stt,$chucvu);

                        //Thêm ngành yêu thích 
                        nganhyeuthich($mysqli,$sdt,$APTECH,$APTECH_CD,$APTECH_DHCT,$ACNPro,$ARENA,$ARENA_CD,$ARENA_LT,$KHAC);
                        
                        //Thêm phiếu đăng ký
                        themphieudk($mysqli,$sdt,$kenhthongbao,$khoahocquantam,$kq);

                        $b = true;    
                        $sodongduocthem++;    
                    }
                    else {
                        $a=$row;
                        $b = false;
                        break;
                    }
                }
                else{}
            }else{$b = false;}
        }
        if($b == true){/*themdulieu($mysqli,$file);*/NhatKythemdulieu($mysqli,$sodongduocthem);echo '<script language="javascript">alert("Đã thêm thành công '.$sodongduocthem.' dòng dữ liệu!");</script>';}  
        else if($b == false ) {echo '<script language="javascript">alert("Bị lỗi khách hàng tại dòng số '.$a.' !");history.go(-1);</script>';}        
    } 
    function laytenKH($mysqli,$sdt){
        $sql = "Select HOTEN from khachhang where SDT='$sdt'";
        $result = mysqli_query($mysqli,$sql);
        $tenkh = 0;
        while($row = mysqli_fetch_assoc($result)){
            $tenkh = $row['HOTEN'];
        }
        return $tenkh;
    } 
    // function themkhachhangcu($mysqli,$sdt){
    //     $tenkh = laytenKH($mysqli,$sdt);
    //     $sql ="INSERT INTO `khachhangcu`(`SDT`, `HOTEN`) VALUES ('$sdt','$tenkh')";
    //     mysqli_query($mysqli, $sql);
    // }
    function BosungttKH($mysqli,$sdt,$EMAIL){
        // echo $sdt;
        // echo " ";
        // echo $TENTRUONG;
        // echo "||";
        if($EMAIL=="null"){}
        else{
            $sqlud1 = "UPDATE `khachhang` SET `EMAIL`='$EMAIL' WHERE SDT = '$sdt'";
            mysqli_query($mysqli, $sqlud1);
        }
        
    }  
    function taomaKH($mysqli){
        $makh = 0 ;
        $sql = "SELECT COUNT(MAKHACHHANG)+1 as tong FROM `dulieukhachhang` ";
        $result= mysqli_query($mysqli, $sql); 
        while($row = mysqli_fetch_assoc($result)){
            $makh = 'KH'.$row['tong'];
        }
        return $makh;
    }
    function themdulieu($mysqli,$makh,$sdt,$sdtba,$sdtme,$zalo,$facebook){
        $sql = "INSERT INTO `dulieukhachhang`(`MAKHACHHANG`, `SDT`) VALUES ('".$makh."','".$sdt."')";
        if (mysqli_query($mysqli, $sql)){	
            $c=Bosungduieu($mysqli,$makh,$sdtba,$sdtme,$zalo,$facebook);				         
        }else {}
    }
    // function themdulieu($mysqli,$file){
    //     $objReader = PHPExcel_IOFactory::createReaderForFile($file);
    //     $objReader ->setloadSheetsOnly('dulieukhachhang');

    //     $objExcel = $objReader ->load($file);
    //     $sheetData = $objExcel ->getActiveSheet()->toArray('null', true, true, true);

    //     $highestRow = $objExcel->setActiveSheetIndex()->getHighestRow();
    //     $a = 1;
    //     $b = true;
    //     $sodongduocthem=0;
    //     // $a[0][0] =1;
    //     // $i = 0;
    //     for($row = 3; $row<=$highestRow; $row++){
    //         $sdt = $sheetData[$row]['E'];
    //         $sdtba = $sheetData[$row]['F'];
    //         $sdtme = $sheetData[$row]['G'];
    //         $zalo = $sheetData[$row]['H'];
    //         $facebook = $sheetData[$row]['I'];
    //         $makh = taomaKH($mysqli);

    //         // if($sdtba=="null"){$sdtba=NULL;}
    //         // if($sdtme=="null"){$sdtme=NULL;}
    //         // if($zalo=="null"){$zalo=NULL;}
    //         if($sdt !="null"){
    //             if(mysqli_num_rows(mysqli_query($mysqli,"select MAKHACHHANG  FROM dulieukhachhang WHERE SDT='".$sdt."'")) == 0){
    //                 $sql = "INSERT INTO `dulieukhachhang`(`MAKHACHHANG`, `SDT`) VALUES ('".$makh."','".$sdt."')";
    //                 if (mysqli_query($mysqli, $sql)){	
    //                     $c=Bosungduieu($mysqli,$makh,$sdtba,$sdtme,$zalo,$facebook);				
    //                     $b = true;       
    //                     $sodongduocthem++;
    //                 }
    //                 else {
    //                     $a=$sdt;
    //                     $b = false;
    //                     break;
    //                 }
    //             }else{}
    //             // else{
    //             //     $b = laytrung($mysqli,$file,$sdt);
    //             //     if($b == 1){
    //             //         $madulieukh=laymadulieuKH($mysqli,$sdt);
    //             //         $ud=Bosungduieu($mysqli,$madulieukh,$sdtba,$sdtme,$zalo,$facebook);
    //             //         if($ud == true){
    //             //             $b=true;
    //             //             $sodongduocthem++;
    //             //         }
    //             //         else {
    //             //             $a=$sdt;
    //             //             $b = false;
    //             //             break;
    //             //         }
    //             //     }else if($b>1){
    //             //         $dongchungdt = dongtrungDT($mysqli,$file,$sdt);
    //             //         if($row == $dongchungdt){
    //             //             $madulieukh=laymadulieuKH($mysqli,$sdt);
    //             //             $ud = Bosungduieu($mysqli,$madulieukh,$sdtba,$sdtme,$zalo,$facebook);
    //             //             if($ud == true){
    //             //                 $b=true;
    //             //                 $sodongduocthem++;
    //             //             }
    //             //             else {
    //             //                 $a=$sdt;
    //             //                 $b = false;
    //             //                 break;
    //             //             }    
    //             //         }
    //             //     }
    //             // }
    //         }
    //     }
    //     if($b == true){chucvuKH($mysqli,$file);nganhyeuthich($mysqli,$file);themphieudk($mysqli,$file);NhatKythemdulieu($mysqli,$sodongduocthem);echo '<script language="javascript">alert("Đã thêm thành công '.$sodongduocthem.' dòng dữ liệu!");</script>';}  
    //     else if($b == false) {echo '<script language="javascript">alert("Bị lỗi dữ liệu tại số điện thoại: '.$a.'!");history.go(-1);</script>';}
    // }
    function laymadulieuKH($mysqli,$sdt){
        $sql = "select MAKHACHHANG  FROM dulieukhachhang WHERE SDT='$sdt'";
        $madulieukh = 0;
        $result= mysqli_query($mysqli,$sql); 
        while($row = mysqli_fetch_assoc($result)){
            $madulieukh = $row['MAKHACHHANG'];
        }
        return $madulieukh;  

    }
    function Bosungduieu($mysqli,$makh,$sdtba,$sdtme,$zalo,$facebook){
        $b = true;
        if($sdtba=="null"){}
        else{
            $sqlud1 = "UPDATE `dulieukhachhang` SET `SDTBA`='$sdtba' WHERE MAKHACHHANG = '$makh'";
            if (mysqli_query($mysqli, $sqlud1)){					
                $b = true;       
            }
            else {
                $b = false;
            }
        }
        if($sdtme=="null"){}
        else{
            $sqlud2 = "UPDATE `dulieukhachhang` SET `SDTME``='$sdtba' WHERE MAKHACHHANG = '$makh'";
            if (mysqli_query($mysqli, $sqlud2)){					
                $b = true;       
            }
            else {
                $b = false;
            }
        }
        if($zalo=="null"){}
        else{
            $sqlud3 = "UPDATE `dulieukhachhang` SET `SDTZALO``='$sdtba' WHERE MAKHACHHANG = '$makh'";
            if (mysqli_query($mysqli, $sqlud3)){					
                $b = true;       
            }
            else {
                $b = false;
            }
        }
        if($facebook=="null"){}
        else{
            $sqlud3 = "UPDATE `dulieukhachhang` SET `FACEBOOK``='$facebook' WHERE MAKHACHHANG = '$makh'";
            if (mysqli_query($mysqli, $sqlud3)){					
                $b = true;       
            }
            else {
                $b = false;
            }
        }
        return $b;
    }
    function kiemtraSDTKH($mysqli,$sdt){
        $b=false;
        $sql = "SELECT COUNT(SDT) FROM `khachhang` WHERE SDT='$sdt'";
        $result= mysqli_query($mysqli, $sql); 
        while($row = mysqli_fetch_assoc($result)){
            
            if($row['COUNT(SDT)']>0){$b=true;}
            else{
            }
        }
        return $b;
    }
    function Manganh($mysqli,$Nganh){
        $b=0;
        $sql = "SELECT MANGANH,COUNT(MANGANH) FROM `nganh` WHERE TENNGANH='$Nganh'";
        $result= mysqli_query($mysqli, $sql); 
        while($row = mysqli_fetch_assoc($result)){
            if($row['COUNT(MANGANH)']>0){$b=$row['MANGANH'];}
            else{	
                $b="NG08";
            }
        }
        return $b;
    }

    function nganhyeuthich($mysqli,$sdt,$APTECH,$APTECH_CD,$APTECH_DHCT,$ACNPro,$ARENA,$ARENA_CD,$ARENA_LT,$KHAC){
        if($APTECH != "null"){
            $sql1 = "INSERT INTO `nganhyeuthich`(`SDT`, `MANGANH`) VALUES ('".$sdt."','NG01');";
            mysqli_query($mysqli, $sql1);
        }
        if($APTECH_CD != "null"){
            $sql2 = "INSERT INTO `nganhyeuthich`(`SDT`, `MANGANH`) VALUES ('".$sdt."','NG02');";
            mysqli_query($mysqli, $sql2);
        }
        if($APTECH_DHCT != "null"){
            $sql3 = "INSERT INTO `nganhyeuthich`(`SDT`, `MANGANH`) VALUES ('".$sdt."','NG03');";
            mysqli_query($mysqli, $sql3);
        }
        if($ACNPro != "null"){
            $sql4 = "INSERT INTO `nganhyeuthich`(`SDT`, `MANGANH`) VALUES ('".$sdt."','NG04');";
                            mysqli_query($mysqli, $sql4);
        }
        if($ARENA != "null"){
            $sql5 = "INSERT INTO `nganhyeuthich`(`SDT`, `MANGANH`) VALUES ('".$sdt."','NG05');";
            mysqli_query($mysqli, $sql5);
        }
        if($ARENA_CD != "null"){
            $sql6 = "INSERT INTO `nganhyeuthich`(`SDT`, `MANGANH`) VALUES ('".$sdt."','NG06');";
            mysqli_query($mysqli, $sql6);
        }
        if($ARENA_LT != "null"){
            $sql7 = "INSERT INTO `nganhyeuthich`(`SDT`, `MANGANH`) VALUES ('".$sdt."','NG07');";
            mysqli_query($mysqli, $sql7);
        }
        if($KHAC != "null"){
            $sql8 = "INSERT INTO `nganhyeuthich`(`SDT`, `MANGANH`,`CHITIET`) VALUES ('".$sdt."','NG08','$KHAC');";
            mysqli_query($mysqli, $sql8);
        }
    }
    // function nganhyeuthich($mysqli,$file){
    //     $objReader = PHPExcel_IOFactory::createReaderForFile($file);
    //     $objReader ->setloadSheetsOnly('dulieukhachhang');

    //     $objExcel = $objReader ->load($file);
    //     $sheetData = $objExcel ->getActiveSheet()->toArray('null', true, true, true);

    //     $highestRow = $objExcel->setActiveSheetIndex()->getHighestRow();
    //     // $a[0][0] =1;
    //     // $i = 0;
    //     for($row = 3; $row<=$highestRow; $row++){

    //         $sdt = $sheetData[$row]['E'];
    //         $APTECH = $sheetData[$row]['P'];
    //         $APTECH_CD = $sheetData[$row]['Q'];
    //         $APTECH_DHCT = $sheetData[$row]['R'];
    //         $ACNPro = $sheetData[$row]['S'];
    //         $ARENA = $sheetData[$row]['T'];
    //         $ARENA_CD = $sheetData[$row]['U'];
    //         $ARENA_LT = $sheetData[$row]['V'];
    //         $KHAC = $sheetData[$row]['W'];

    //         $kt= kiemtraSDTKH($mysqli,$sdt);
    //         if($kt == true){
    //             if($APTECH != "null"){
    //                $sql1 = "INSERT INTO `nganhyeuthich`(`SDT`, `MANGANH`) VALUES ('".$sdt."','NG01');";
    //                mysqli_query($mysqli, $sql1);
    //             }
    //             if($APTECH_CD != "null"){
    //                 $sql2 = "INSERT INTO `nganhyeuthich`(`SDT`, `MANGANH`) VALUES ('".$sdt."','NG02');";
    //                 mysqli_query($mysqli, $sql2);
    //              }
    //              if($APTECH_DHCT != "null"){
    //                 $sql3 = "INSERT INTO `nganhyeuthich`(`SDT`, `MANGANH`) VALUES ('".$sdt."','NG03');";
    //                 mysqli_query($mysqli, $sql3);
    //              }
    //              if($ACNPro != "null"){
    //                 $sql4 = "INSERT INTO `nganhyeuthich`(`SDT`, `MANGANH`) VALUES ('".$sdt."','NG04');";
    //                 mysqli_query($mysqli, $sql4);
    //              }
    //              if($ARENA != "null"){
    //                 $sql5 = "INSERT INTO `nganhyeuthich`(`SDT`, `MANGANH`) VALUES ('".$sdt."','NG05');";
    //                 mysqli_query($mysqli, $sql5);
    //              }
    //              if($ARENA_CD != "null"){
    //                 $sql6 = "INSERT INTO `nganhyeuthich`(`SDT`, `MANGANH`) VALUES ('".$sdt."','NG06');";
    //                 mysqli_query($mysqli, $sql6);
    //              }
    //              if($ARENA_LT != "null"){
    //                 $sql7 = "INSERT INTO `nganhyeuthich`(`SDT`, `MANGANH`) VALUES ('".$sdt."','NG07');";
    //                 mysqli_query($mysqli, $sql7);
    //              }
    //              if($KHAC != "null"){
    //                 $sql8 = "INSERT INTO `nganhyeuthich`(`SDT`, `MANGANH`,`CHITIET`) VALUES ('".$sdt."','NG08','$KHAC');";
    //                 mysqli_query($mysqli, $sql8);
    //              }
    //         }
    //     }
    // }

    function chucvuKH($mysqli,$sdt,$stt,$chucvu){
        if($chucvu != "null"){
             $sql = "INSERT INTO `chucvu`(`SDT`, `STT`, `tenchucvu`) VALUES ('".$sdt."','".$stt."','".$chucvu."')";
            mysqli_query($mysqli, $sql);
        }
    }

    // function chucvuKH($mysqli,$file){
    //     $objReader = PHPExcel_IOFactory::createReaderForFile($file);
    //     $objReader ->setloadSheetsOnly('dulieukhachhang');

    //     $objExcel = $objReader ->load($file);
    //     $sheetData = $objExcel ->getActiveSheet()->toArray('null', true, true, true);

    //     $highestRow = $objExcel->setActiveSheetIndex()->getHighestRow();
    //     $stt = 0;
    //     // $a[0][0] =1;
    //     // $i = 0;
    //     for($row = 3; $row<=$highestRow; $row++){
    //         $sdt = $sheetData[$row]['E'];
    //         $lop = $sheetData[$row]['N'];
    //         $chucvu = $sheetData[$row]['O'];
    //         $stt = laysttlop($mysqli,$lop);

    //         if($chucvu != "null"){
    //             $sql = "INSERT INTO `chucvu`(`SDT`, `STT`, `tenchucvu`) VALUES ('".$sdt."','".$stt."','".$chucvu."')";
    //             mysqli_query($mysqli, $sql);
    //         }
    //         // else {
    //         //     $sql = "INSERT INTO `chucvu`(`SDT`, `STT`) VALUES ('".$sdt."','".$stt."')";
    //         //     mysqli_query($mysqli, $sql);
    //         // }
    //     }
    // }
    function laysttlop($mysqli,$lop){
        $stt = 0;
        if($lop == "null"){ $stt = 1;} 
        else{
            $sql = "select count(STT),STT from lop where LOP = '".$lop."'";
            $result= mysqli_query($mysqli, $sql); 
            while($row = mysqli_fetch_assoc($result)){
                if($row['count(STT)']>0){$stt = $row['STT'];}
                else{
                    themlop($mysqli,$lop);
                    $stt = laysttlop($mysqli,$lop);
                }
            }
        }
        return $stt;
    }
    function themlop($mysqli,$lop){
        $sqlinsert = "INSERT INTO `lop`(LOP) VALUES ('".$lop."')";
            if (mysqli_query($mysqli, $sqlinsert)){}
            else {}
    }
    function themphieudk($mysqli,$sdt,$kenhthongbao,$khoahocquantam,$kq){
        if($kenhthongbao != "null" && $khoahocquantam != "null"){
                if(mysqli_num_rows(mysqli_query($mysqli,"select MAPHIEUDK  FROM phieudkxettuyen WHERE SDT='".$sdt."'")) == 0){
                    $maphieu = taomaphieudk($mysqli);
                    $makq = ketqua($mysqli,$kq);
                    $makh = makhoahoc($mysqli,$khoahocquantam);
                    $makenh = makenhtb($mysqli,$kenhthongbao);
                    $sql = "INSERT INTO `phieudkxettuyen`(`MAPHIEUDK`, `MALOAIKHOAHOC`, `MAKENH`, `SDT`, `MAKETQUA`)
                            VALUES ('".$maphieu."','".$makh."','".$makenh."','".$sdt."','".$makq."')";
                    if (mysqli_query($mysqli, $sql)){
                                //bosungttphieudk($mysqli,$maphieu,$hoso);
                    }else {}
                }else{}
            }
    }
    // function themphieudk($mysqli,$file){
    //     $objReader = PHPExcel_IOFactory::createReaderForFile($file);
    //     $objReader ->setloadSheetsOnly('dulieukhachhang');

    //     $objExcel = $objReader ->load($file);
    //     $sheetData = $objExcel ->getActiveSheet()->toArray('null', true, true, true);

    //     $highestRow = $objExcel->setActiveSheetIndex()->getHighestRow();
    //     // $a[0][0] =1;
    //     // $i = 0;
    //     for($row = 3; $row<=$highestRow; $row++){
    //         //phiếu đăng ký
    //         $sdt = $sheetData[$row]['E'];
    //         $kenhthongbao = $sheetData[$row]['X'];
    //         $khoahocquantam = $sheetData[$row]['Y'];
    //         //$hoso = $sheetData[$row]['Z'];
    //         $kq = $sheetData[$row]['Z'];

    //         //Liên hệ
    //         //lần 1
    //         // $date1 = date_format(date_create($sheetData[$row]['AB']),"Y-m-d");
    //         // $trangthai1 = $sheetData[$row]['AC'];
    //         // $cttt1 = $sheetData[$row]['AD'];
    //         // $kqlh1 = $sheetData[$row]['AE'];

    //         // //lần 2
    //         // $date2 = date_format(date_create($sheetData[$row]['AF']),"Y-m-d");
    //         // $trangthai2 = $sheetData[$row]['AG'];
    //         // $cttt2 = $sheetData[$row]['AH'];
    //         // $kqlh2 = $sheetData[$row]['AI'];

    //         // //lần 3
    //         // $date3 = date_format(date_create($sheetData[$row]['AJ']),"Y-m-d");
    //         // $trangthai3 = $sheetData[$row]['AK'];
    //         // $cttt3 = $sheetData[$row]['AL'];
    //         // $kqlh3 = $sheetData[$row]['AM'];

    //         if($kenhthongbao != "null" && $khoahocquantam != "null"){
    //             if(mysqli_num_rows(mysqli_query($mysqli,"select MAPHIEUDK  FROM phieudkxettuyen WHERE SDT='".$sdt."'")) == 0){
    //                 $maphieu = taomaphieudk($mysqli);
    //                 $makq = ketqua($mysqli,$kq);
    //                 $makh = makhoahoc($mysqli,$khoahocquantam);
    //                 $makenh = makenhtb($mysqli,$kenhthongbao);
    //                 $sql = "INSERT INTO `phieudkxettuyen`(`MAPHIEUDK`, `MALOAIKHOAHOC`, `MAKENH`, `SDT`, `MAKETQUA`)
    //                         VALUES ('".$maphieu."','".$makh."','".$makenh."','".$sdt."','".$makq."')";
    //                 if (mysqli_query($mysqli, $sql)){
    //                     //bosungttphieudk($mysqli,$maphieu,$hoso);
    //                 }
    //                 else {}
    //             }
    //             else{}
    //         }
    //     }

    // }
    // function themlienhe($mysqli,$sdt,$maphieu,$date1,$trangthai1,$cttt1,$kqlh1,$date2,$trangthai2,$cttt2,$kqlh2,$date3,$trangthai3,$cttt3,$kqlh3){
    //     if($date1 != "null" && $trangthai1 !="null"){
    //         $sdtus;
    //         $sqllh1 = "INSERT INTO `lienhe`(`MAPHIEUDK`, `SDT`, `MATRANGTHAI`, `CHITIETTRANGTHAI`, `LAN`, `THOIGIAN`, `KETQUA`) 
    //                    VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]')";
    //     }
    // }
    function makenhtb($mysqli,$kenhthongbao){
        $makenh = 0;
        $sql = "select MAKENH from kenhnhanthongbao where TENKENH = '$kenhthongbao'";
        $result= mysqli_query($mysqli, $sql); 
        while($row = mysqli_fetch_assoc($result)){
            // if($row[$kq] != NULL)
            $makenh = $row['MAKENH'];
        }
        return $makenh;
    }
    function makhoahoc($mysqli,$khoahocquantam){
        $makh = 0;
        $sql = "select MALOAIKHOAHOC from khoahocquantam where TENLOAIKHOAHOC = '$khoahocquantam'";
        $result= mysqli_query($mysqli, $sql); 
        while($row = mysqli_fetch_assoc($result)){
            // if($row[$kq] != NULL)
            $makh = $row['MALOAIKHOAHOC'];
        }
        return $makh;
    }
    function ketqua($mysqli,$kq){
        $makq = 3;
        if($kq != "null"){
            $sql = "select MAKETQUA from ketquatotnghiep where 	KETQUA = '$kq'";
            $result= mysqli_query($mysqli, $sql); 
            while($row = mysqli_fetch_assoc($result)){
                // if($row[$kq] != NULL)
                $makq = $row['MAKETQUA'];
            }
        }
        return $makq;
    }
    // function bosungttphieudk($mysqli,$maphieu,$hoso){
    //     if($hoso=="null"){}
    //     else{
    //         $sqlud1 = "UPDATE `phieudkxettuyen` SET `HOSO`='$hoso' WHERE MAPHIEUDK = '$maphieu'";
    //         mysqli_query($mysqli, $sqlud1);
    //     }
    // }
    function taomaphieudk($mysqli){
        $tong = 0;
        $maphieu = "DK1";
        $sql = "select count(MAPHIEUDK) + 1 as tong from phieudkxettuyen";
        $result= mysqli_query($mysqli, $sql); 
        while($row = mysqli_fetch_assoc($result)){
            $tong = $row['tong'];  
            
        }
        for($i = 1 ; $i <=$tong ; $i++){
            $maphieu = "DK".$i;
            if(mysqli_num_rows(mysqli_query($mysqli,"select MAPHIEUDK  FROM phieudkxettuyen WHERE MAPHIEUDK='".$maphieu."'")) == 0){break;}
        }
        //$maphieu = "DK".$tong;
        return $maphieu;
    }

    //Nhật ký thay đổi
    function tenadmin($mysqli,$user){
        $sql = "select HOTEN from admin where MAADMIN = '$user'";
        $tenAD = 0;
        $result= mysqli_query($mysqli,$sql); 
        while($row = mysqli_fetch_assoc($result)){
            $tenAD = $row['HOTEN'];
        }
        return $tenAD;

    }
    function tenusermanager($mysqli,$user){
        $sql = "select HOTEN from usermanager where SDT = '$user'";
        $tenUM = 0;
        $result= mysqli_query($mysqli, $sql); 
        while($row = mysqli_fetch_assoc($result)){
            $tenUM = $row['HOTEN'];
        }
        return $tenUM;

    }
    function tongnhatky($mysqli,$ngaybd,$ngaykt){
        $sql = "SELECT COUNT(thoigian) FROM `nhatkythaydoi` where thoigian  BETWEEN '$ngaybd' AND '$ngaykt'";
        $result= mysqli_query($mysqli,$sql);
        $a = 0;
        while($row = mysqli_fetch_assoc($result)){
           $a = $row['COUNT(thoigian)'];
        }
        return $a;
    }
    function nhatkythaydoi($mysqli,$ngaybd,$ngaykt,$limit,$offset){
        $begin = $ngaybd." 00:00:00";
        $end = $ngaykt." 23:59:59";
        $sql = "SELECT * FROM `nhatkythaydoi` where thoigian  BETWEEN '$begin' AND '$end' limit ".$limit." OFFSET ".$offset."";
        $result= mysqli_query($mysqli,$sql); 
        $a[0][0]=0;
        $i = 0;
        while($row = mysqli_fetch_assoc($result)){
            $a[$i][0]= $row['thoigian'];
            $a[$i][1] = $row['maadmin'];
            $a[$i][2] = $row['sdt'];
            $a[$i][3] = $row['hanhdong'];
            $i++;
        }
        return $a;
    }
    function layTenNguoiDung($mysqli,$maadmin,$sdt){
        $ten = 0;
        if($maadmin==NULL){
            $sql = "Select HOTEN from usermanager where SDT = '$sdt'";
            $result= mysqli_query($mysqli, $sql); 
            while($row = mysqli_fetch_assoc($result)){
            $ten = $row['HOTEN'];
            }
        }
        else if($sdt == NULL){
            $sql = "Select HOTEN from admin where MAADMIN= '$maadmin'";
            $result= mysqli_query($mysqli, $sql); 
            while($row = mysqli_fetch_assoc($result)){
            $ten = $row['HOTEN'];
            } 
        }
        return $ten;
    }
    function layloainguoidung($maadmin,$sdt){
        $loai = "";
        if($maadmin==NULL){$loai = "User Manager"; }
        else if($sdt ==NULL){$loai = "Admin";}
        return $loai;
    }
    function NhatKythemdulieu($mysqli,$sodong){
        $user = $_SESSION['login'];

        // if (mysqli_num_rows(mysqli_query($mysqli,"select SDT FROM usermanager WHERE SDT='".$user."'")) == 0){
            $tenAD = tenadmin($mysqli,$user);
            $hanhdong = "Admin ".$tenAD." đã thêm ".$sodong." dữ liệu vào hệ thống";
            $sql = "INSERT INTO `nhatkythaydoi`( `maadmin`,`hanhdong`) VALUES ('$user','$hanhdong')";
            mysqli_query($mysqli,$sql);
        // }
        // else{
        //     $tenUM = tenadmin($mysqli,$user);
        //     $hanhdong = "User Manager ".$tenUM." đã thêm ".$sodong." dữ liệu vào hệ thống";
        //     $sql = "INSERT INTO `nhatkythaydoi`( `SDT`,`hanhdong`) VALUES ('$user','$hanhdong')";
        //     mysqli_query($mysqli,$sql);
        // }     
    }
    function NhatKythemkhachhangcu($mysqli,$sodong){
        $user = $_SESSION['login'];

        // if (mysqli_num_rows(mysqli_query($mysqli,"select SDT FROM usermanager WHERE SDT='".$user."'")) == 0){
            $tenAD = tenadmin($mysqli,$user);
            $hanhdong = "Admin ".$tenAD." đã thêm ".$sodong." dữ liệu vào bảng khách hàng cũ trong cơ sở dữ liệu";
            $sql = "INSERT INTO `nhatkythaydoi`( `maadmin`,`hanhdong`) VALUES ('$user','$hanhdong')";
            mysqli_query($mysqli,$sql);
        // }
        // else{
        //     $tenUM = tenadmin($mysqli,$user);
        //     $hanhdong = "User Manager ".$tenUM." đã thêm ".$sodong." dữ liệu vào hệ thống";
        //     $sql = "INSERT INTO `nhatkythaydoi`( `SDT`,`hanhdong`) VALUES ('$user','$hanhdong')";
        //     mysqli_query($mysqli,$sql);
        // }     
    }
    function NhatKysuadulieu($mysqli,$sdt){
        $user = $_SESSION['login'];

        if (mysqli_num_rows(mysqli_query($mysqli,"select SDT FROM usermanager WHERE SDT='".$user."'")) == 0){
            $tenAD = tenadmin($mysqli,$user);
            $hanhdong = "Admin ".$tenAD." đã cập nhật thông tin khách hàng có số điện thoại ".$sdt." vào hệ thống";
            $sql = "INSERT INTO `nhatkythaydoi`( `maadmin`,`hanhdong`) VALUES ('$user','$hanhdong')";
            mysqli_query($mysqli,$sql);
        }
        else{
            $tenUM = tenusermanager($mysqli,$user);
            $hanhdong = "User Manager ".$tenUM." đã cập nhật thông tin khách hàng có số điện thoại ".$sdt." vào hệ thống";
            $sql = "INSERT INTO `nhatkythaydoi`( `SDT`,`hanhdong`) VALUES ('$user','$hanhdong')";
            mysqli_query($mysqli,$sql);
        }     
    }

    function NhatKyxoadulieu($mysqli,$sdt){
        $user = $_SESSION['login'];
        $tenAD = tenadmin($mysqli,$user);
        $hanhdong = "Admin ".$tenAD." đã xoá khách hàng có số điện thoại ".$sdt." khỏi hệ thống";
        $sql = "INSERT INTO `nhatkythaydoi`( `maadmin`,`hanhdong`) VALUES ('$user','$hanhdong')";
        mysqli_query($mysqli,$sql);
          
    }

    function NhatKythemnguoidung($mysqli,$loainguoidung,$sdt,$tenuser){
        $user = $_SESSION['login'];
        $tenAD = tenadmin($mysqli,$user);
        $hanhdong = "Admin ".$tenAD." đã thêm ".$loainguoidung." ".$tenuser." có số điện thoại ".$sdt." vào hệ thống";
        $sql = "INSERT INTO `nhatkythaydoi`( `maadmin`,`hanhdong`) VALUES ('$user','$hanhdong')";
        mysqli_query($mysqli,$sql);
    }
    function NhatKysuanguoidung($mysqli,$sdt){
        $user = $_SESSION['login'];
        $tenAD = tenadmin($mysqli,$user);
        $hanhdong = "Admin ".$tenAD." đã chỉnh sửa thông tin của User Manager có số điện thoại ".$sdt."";
        $sql = "INSERT INTO `nhatkythaydoi`( `maadmin`,`hanhdong`) VALUES ('$user','$hanhdong')";
        mysqli_query($mysqli,$sql);
    }
    function Nhatkyxoanguoidung($mysqli,$sdt){
        $user = $_SESSION['login'];
        $tenAD = tenadmin($mysqli,$user);
        $hanhdong = "Admin ".$tenAD." đã xoá User Manager có số điện thoại ".$sdt."";
        $sql = "INSERT INTO `nhatkythaydoi`( `maadmin`,`hanhdong`) VALUES ('$user','$hanhdong')";
        mysqli_query($mysqli,$sql);
    }

    //Phân đoạn và phân chia dữ liệu
    function sinhmapq($mysqli){
        $Mapq = 0;
        $a = 1;
        $sql = "select Count(MaPQ)+1 as tong from phanquyen";
        $result= mysqli_query($mysqli, $sql); 
        while($row = mysqli_fetch_assoc($result)){
            $a = $row['tong'];
        }
        for($i = 1; $i <= $a;$i++){
            $kt = 'PQ'.$i;
            if(mysqli_num_rows(mysqli_query($mysqli,"select MaPQ  FROM phanquyen WHERE MaPq ='$kt'")) == 0){$Mapq = $kt;break;}
        }
        return $Mapq;
    }
    function sokhachhangtheotruong($mysqli,$MaTruong){
        $a = 0;
        $sql = "SELECT COUNT(SDT) as tong FROM khachhang,truong 
                WHERE khachhang.MATRUONG=truong.MATRUONG 
                and truong.MATRUONG='".$MaTruong."' and khachhang.SDT not in (SELECT SDT from chitietpq) 
                and khachhang.SDT not in (SELECT SDT FROM khachhangcu)
                and khachhang.SDT not in (SELECT k.SDT from lienhe l,phieudkxettuyen p, khachhang k, (SELECT lienhe.MALIENHE as lh,COUNT(MALIENHE) as tong from lienhe
                                          GROUP by lienhe.MAPHIEUDK) b WHERE b.lh = l.MALIENHE and l.MAPHIEUDK = p.MAPHIEUDK
                                          and p.SDT=k.SDT and b.tong=3) GROUP BY truong.MATRUONG";
        $result= mysqli_query($mysqli, $sql); 
        while($row = mysqli_fetch_assoc($result)){
            $a = $row['tong'];
        }
        return $a;
    }
    function TaoPQ($mysqli,$MaTruong,$sodong){
        $b = true;
        // $sophieu = sophieulienhetheotruong($mysqli,$MaTruong);
        // $doan = 0;
        // if($sophieu<=$sodong) $doan = 1;
        // else{
        //     $doan = (int)($sophieu/$sodong);
        //     if($sophieu - $sodong <=(($sodong*20)/100)){$doan = $doan + 1;}
        // }
        // // echo $sophieu;
        // // echo $sodong;
        // // echo $doan;
        // for($i = 0; $i < $doan; $i++){
            // $Mapq = sinhmapq($mysqli);
            // $sql = "INSERT INTO `phanquyen`(`MaPQ`, `MATRUONG`,`Sodong`) VALUES ('$Mapq','$MaTruong','$sodong')";
            // if (mysqli_query($mysqli, $sql)){					
            //     $a = chitietPQ($mysqli,$Mapq,$sodong,$MaTruong);     
            //     if($a == true) $b = true;
            //     else $b = false ; 
            // }
        //     else {$b = false; break;}
        // }
        $sokh = sokhachhangtheotruong($mysqli,$MaTruong);
        while($sokh !=0){
            $Mapq = sinhmapq($mysqli);
            $sql = "INSERT INTO `phanquyen`(`MaPQ`, `MATRUONG`,`Sodong`) VALUES ('$Mapq','$MaTruong','$sodong')";
            if (mysqli_query($mysqli, $sql)){					
                $a = chitietPQ($mysqli,$Mapq,$sodong,$MaTruong);     
                if($a == true) {
                    $b = true;
                    $sokh = sokhachhangtheotruong($mysqli,$MaTruong);
                }
                else {
                    $b = false ; 
                }
            }
        }
        if($b == true) {echo '<script language="javascript">alert("Phân đoạn thành công!");</script>';}
        else if($b == false) {echo '<script language="javascript">alert("Phân đoạn thất bại!'.$doan.'");</script>';}
    }
    // function sophieuconlai($mysqli,$MaTruong){
    //     $a = 0;
    //     $sql = "SELECT MAPHIEUDK FROM phieudkxettuyen,khachhang,truong 
    //             WHERE phieudkxettuyen.SDT=khachhang.SDT and khachhang.MATRUONG=truong.MATRUONG 
    //             and truong.MATRUONG='".$MaTruong."' and phieudkxettuyen.SDT not in (SELECT SDT from chitietpq)
    //             and phieudkxettuyen.SDT not in (SELECT SDT FROM khachhangcu)
    //             and phieudkxettuyen.MAPHIEUDK not in 
	// 			(SELECT l.MAPHIEUDK from lienhe l, (SELECT lienhe.MALIENHE as lh,COUNT(MALIENHE) as tong from lienhe GROUP by lienhe.MAPHIEUDK) b WHERE b.lh = l.MALIENHE and b.tong=3)";
    //     $result= mysqli_query($mysqli, $sql); 
    //     while($row = mysqli_fetch_assoc($result)){
    //         $a++;
    //     }
    //     return $a;
    // }
    function chitietPQ($mysqli,$Mapq,$sodong,$MaTruong){
        $kt = false;
        $limit = 0;
        $dem = sokhachhangtheotruong($mysqli,$MaTruong); 
        if($dem > $sodong){
        if($dem - $sodong <=(($sodong*20)/100)){$limit = $dem;} 
        else {$limit = $sodong;}}
        else {$limit = $dem;}
        $sql = "SELECT khachhang.SDT as sdtkh FROM khachhang,truong 
                WHERE khachhang.MATRUONG=truong.MATRUONG 
                and truong.MATRUONG='".$MaTruong."' and khachhang.SDT not in (SELECT SDT from chitietpq)
                and khachhang.SDT not in (SELECT SDT FROM khachhangcu)
                and khachhang.SDT not in 
                (SELECT k.SDT from lienhe l,phieudkxettuyen p, khachhang k, (SELECT lienhe.MALIENHE as lh,COUNT(MALIENHE) as tong from lienhe
                GROUP by lienhe.MAPHIEUDK) b WHERE b.lh = l.MALIENHE and l.MAPHIEUDK = p.MAPHIEUDK and p.SDT=k.SDT and b.tong=3) limit ".$limit."";
        $result= mysqli_query($mysqli, $sql); 
        while($row = mysqli_fetch_assoc($result)){
            $sdtkh = $row['sdtkh'];
            $sqlthem = "INSERT INTO `chitietpq`(`MaPQ`, `SDT`) VALUES ('$Mapq','$sdtkh')";
            if (mysqli_query($mysqli, $sqlthem)){					
                $kt = true;       
            }
            else{$kt = false;break;}
        }
        return $kt;
    }
    function Matruong($mysqli){
        $sql = "SELECT DISTINCT truong.MATRUONG,truong.TENTRUONG FROM khachhang,truong 
                WHERE khachhang.MATRUONG=truong.MATRUONG 
                and khachhang.SDT not in (SELECT SDT FROM khachhangcu)
                and khachhang.SDT not in (SELECT SDT from chitietpq)
                and khachhang.SDT not in 
                (SELECT k.SDT from lienhe l,phieudkxettuyen p, khachhang k, (SELECT lienhe.MALIENHE as lh,COUNT(MALIENHE) as tong from lienhe
                GROUP by lienhe.MAPHIEUDK) b WHERE b.lh = l.MALIENHE and l.MAPHIEUDK = p.MAPHIEUDK and p.SDT=k.SDT and b.tong=3);";
        $result = mysqli_query($mysqli,$sql);
        $a[0][0]=0;
        $i=0;
        while($row = mysqli_fetch_assoc($result)){
            $a[$i][0] = $row['MATRUONG'];
            $a[$i][1] = $row['TENTRUONG'];
            $i++;
        }
        return $a;
    }
    function Matruongdaphandoan($mysqli){
        $sql = "SELECT DISTINCT truong.MATRUONG,truong.TENTRUONG FROM truong,phanquyen where truong.MATRUONG=phanquyen.MATRUONG and phanquyen.SDT IS NULL";
        $result = mysqli_query($mysqli,$sql);
        $a[0][0]=0;
        $i=0;
        while($row = mysqli_fetch_assoc($result)){
            $a[$i][0] = $row['MATRUONG'];
            $a[$i][1] = $row['TENTRUONG'];
            $i++;
        }
        return $a;
    }
    function dsphanquyen($mysqli,$thongtintimkiem,$sogioihan,$batdau){
        $sql = "SELECT phanquyen.MaPQ as mapq,truong.TENTRUONG as tentruong,COUNT(chitietpq.SDT) as sodong 
        FROM phanquyen,truong,chitietpq where phanquyen.MATRUONG=truong.MATRUONG and chitietpq.MaPQ=phanquyen.MaPQ 
        and (truong.TENTRUONG like '%".$thongtintimkiem."%' or phanquyen.MaPQ like '%".$thongtintimkiem."%')
        GROUP BY phanquyen.MaPQ limit ".$sogioihan." offset ".$batdau."";
        $result = mysqli_query($mysqli,$sql);
        $a[0][0]=0;
        $i=0;
        while($row = mysqli_fetch_assoc($result)){
            $a[$i][0] = $row['mapq'];
            $a[$i][1] = $row['tentruong'];
            $a[$i][2] = $row['sodong'];
            $i++;
        }
        return $a;
    }
    function demso($mysqli,$thongtintimkiem){
        $sql = "SELECT Count(phanquyen.MaPQ) as dem  
        FROM phanquyen,truong where phanquyen.MATRUONG=truong.MATRUONG and (truong.TENTRUONG like '%".$thongtintimkiem."%' or phanquyen.MaPQ like '%".$thongtintimkiem."%')";
        $result = mysqli_query($mysqli,$sql);
        $a=0;
        while($row = mysqli_fetch_assoc($result)){
            $a = $row['dem'];
        }
        return $a;
    }
    function xoaCTdoan($mysqli,$mapq){
        $kt = false;
        $sql = "DELETE FROM `chitietpq` WHERE MaPQ = '$mapq'";
        if (mysqli_query($mysqli, $sql)){					
            $kt = true;       
        }
        return $kt;
    }
    function xoadoan($mysqli,$mapq){
        $b = false;
        $kt = xoaCTdoan($mysqli,$mapq);
        if($kt == true){
            $sql = "DELETE FROM `phanquyen` WHERE MaPQ = '$mapq'";
            if (mysqli_query($mysqli, $sql)){					
                $b = true;       
            }
        }
        if($b == true){echo '<script language="javascript">alert("Xoá đoạn thành công!");</script>';}  
        else if($b == false) {echo '<script language="javascript">alert("Xoá đoạn thất bại!");</script>';}
    }

    function thuhoidulieu($mysqli,$mapq){
        $b = false;
        $sql = "UPDATE `phanquyen` SET SDT = NULL, THOIGIANPQ = NULL WHERE MaPQ = '$mapq'";
            if (mysqli_query($mysqli, $sql)){					
             $b = true;       
        }
        if($b == true){echo '<script language="javascript">alert("Thu hồi dữ liệu thành công!");</script>';}  
        else if($b == false) {echo '<script language="javascript">alert("Thu hồi dữ liệu thất bại!");</script>';}
    }

    function dkxoa($dk,$mapq){
        if($dk == "KT"){
        echo"<script>
        if(confirm('Bạn có muốn xóa đoạn dữ liệu')){
            location.href='admin.php?route=phandoandulieu&&xoa=yes&&mapq=".$mapq."';
        }
        else{
            location.href='admin.php?route=phandoandulieu&&xoa=no&&mapq=".$mapq."';
        }
        </script>"; 
        }
    }
    function dkthuhoi($dk,$mapq){
        if($dk == "KT"){
        echo"<script>
        if(confirm('Bạn có muốn thu hồi dữ liệu')){
            location.href='admin.php?route=phanchiadulieu&&xoa=yes&&mapq=".$mapq."';
        }
        else{
            location.href='admin.php?route=phanchiadulieu&&xoa=no&&mapq=".$mapq."';
        }
        </script>"; 
        }
    }
    function laydoanpq($mysqli,$MaTruong){
        $doan = 1;
        $sql = "SELECT MaPQ FROM phanquyen where SDT is NULL and MATRUONG='".$MaTruong."'";
        $result = mysqli_query($mysqli,$sql);
        $a[0][0]=0;
        $i=0;
        while($row = mysqli_fetch_assoc($result)){
            $a[$i][0] = $row['MaPQ'];
            $a[$i][1] = "Đoạn ".$doan;
            $doan++;
            $i++;
        }
        return $a;
    }

    function soUMdaphanquyen($mysqli){
        $sql = "SELECT COUNT(SDT) from phanquyen";
        $result = mysqli_query($mysqli,$sql);
        $a=0;
        while($row = mysqli_fetch_assoc($result)){
            $a = $row['COUNT(SDT)'];
        }
        return $a;
    }
    function usermanagerchuaphanquyen($mysqli){
        $a[0][0]=0;
        $i=0;
        
            $sql = "SELECT SDT,HOTEN FROM usermanager";
            $result = mysqli_query($mysqli,$sql);
            while($row = mysqli_fetch_assoc($result)){
                $a[$i][0] = $row['SDT'];
                $a[$i][1] = $row['HOTEN'];
                $i++;
            }
        
        return $a;
    }

    function phandulieuchoUM($mysqli,$Mapq,$sdt){
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $timestamp = time();
        $date = date("Y-m-d H:i:s", $timestamp); 
        $kt = false;
        $sql = "UPDATE phanquyen SET SDT='$sdt',THOIGIANPQ='$date' WHERE MaPQ='".$Mapq."'";
        if (mysqli_query($mysqli, $sql)){					
            $kt = true;       
        }
        if($kt == true){echo '<script language="javascript">alert("Phân dữ liệu thành công!");</script>';}  
        else if($kt == false) {echo '<script language="javascript">alert("Phân dữ liệu thất bại!");</script>';}
    }
    function danhsachphandulieu($mysqli,$timkiem,$sogioihan,$batdau){
        $a[0][0]=0;
        $i=0;
        $sql = "SELECT usermanager.HOTEN as hoten,phanquyen.THOIGIANPQ as thoigian,
                truong.TENTRUONG as truong,phanquyen.MaPQ as madoan,COUNT(chitietpq.SDT) as tong
                FROM phanquyen,truong,chitietpq,usermanager 
                where phanquyen.MATRUONG=truong.MATRUONG 
                and phanquyen.SDT=usermanager.SDT 
                and phanquyen.MaPQ=chitietpq.MaPQ 
                and(usermanager.HOTEN like '%".$timkiem."%' 
                or truong.TENTRUONG like '%".$timkiem."%' 
                or phanquyen.MaPQ like '%".$timkiem."%')
                GROUP BY phanquyen.MaPQ limit ".$sogioihan." offset ".$batdau."";
        $result = mysqli_query($mysqli,$sql);
        while($row = mysqli_fetch_assoc($result)){
            $a[$i][0] = $row['hoten'];
            $a[$i][1] = $row['thoigian'];
            $a[$i][2] = $row['truong'];
            $a[$i][3] = $row['madoan'];
            $a[$i][4] = $row['tong'];
            $i++;
        }
        return $a;
    }
    function sodoandaduocphan($mysqli,$timkiem){
        $a=0;

        $sql = "SELECT COUNT(phanquyen.MaPQ) as tong
        FROM phanquyen,truong,usermanager 
        where phanquyen.MATRUONG=truong.MATRUONG 
        and phanquyen.SDT=usermanager.SDT 
        and(usermanager.HOTEN like '%".$timkiem."%' 
        or truong.TENTRUONG like '%".$timkiem."%' 
        or phanquyen.MaPQ like '%".$timkiem."%') ";
        $result = mysqli_query($mysqli,$sql);
        while($row = mysqli_fetch_assoc($result)){
            $a = $row['tong'];
        }
        return $a;
    }
    function tongdulieutrongchitietdoan($mysqli,$mapq,$timkiem){
        $a = 0;
        
        $sql = "SELECT COUNT(khachhang.SDT) as tong
                FROM khachhang,dulieukhachhang,truong
                WHERE khachhang.SDT=dulieukhachhang.SDT and khachhang.MATRUONG=truong.MATRUONG
                and (khachhang.SDT like '%".$timkiem."%' or khachhang.HOTEN like '%".$timkiem."%' 
                or khachhang.EMAIL like '%".$timkiem."%' or dulieukhachhang.SDTBA like '%".$timkiem."%' 
                or dulieukhachhang.SDTME like '%".$timkiem."%' or dulieukhachhang.SDTZALO like '%".$timkiem."%' or truong.TENTRUONG like '%".$timkiem."%')
                and khachhang.SDT in (SELECT SDT from chitietpq where MaPQ='$mapq');";
        $result = mysqli_query($mysqli,$sql);
        while($row = mysqli_fetch_assoc($result)){
           $a = $row['tong'];
        }
        return $a;
    }
    function chitietdoan($mysqli,$mapq,$timkiem,$sogioihan,$batdau){
        $a[0][0]=0;
        $i = 0;
        $sql = "SELECT khachhang.SDT as sdt,khachhang.HOTEN as ten,khachhang.EMAIL as email,dulieukhachhang.SDTBA as sdtba,
                dulieukhachhang.SDTME as sdtme,dulieukhachhang.SDTZALO as zalo,truong.TENTRUONG as truong
                FROM khachhang,dulieukhachhang,truong
                WHERE khachhang.SDT=dulieukhachhang.SDT and khachhang.MATRUONG=truong.MATRUONG
                and (khachhang.SDT like '%".$timkiem."%' or khachhang.HOTEN like '%".$timkiem."%' 
                or khachhang.EMAIL like '%".$timkiem."%' or dulieukhachhang.SDTBA like '%".$timkiem."%' 
                or dulieukhachhang.SDTME like '%".$timkiem."%' or dulieukhachhang.SDTZALO like '%".$timkiem."%' or truong.TENTRUONG like '%".$timkiem."%')
                and khachhang.SDT in (SELECT SDT from chitietpq where MaPQ='".$mapq."') limit ".$sogioihan." offset ".$batdau."";
        $result = mysqli_query($mysqli,$sql);
        while($row = mysqli_fetch_assoc($result)){
            $a[$i][0] = $row['sdt'];
            $a[$i][1] = $row['ten'];
            if($row['email'] == NULL){$a[$i][2] = "không có dữ liệu";}
            else{$a[$i][2] = $row['email'];}
            if($row['sdtba'] == NULL){$a[$i][3] = "không có dữ liệu";}
            else{$a[$i][3] = $row['sdtba'];}
            if($row['sdtme'] == NULL){$a[$i][4] = "không có dữ liệu";}
            else{$a[$i][4] = $row['sdtme'];}
            if($row['zalo'] == NULL){$a[$i][5] = "không có dữ liệu";}
            else{$a[$i][5] = $row['zalo'];}
            $a[$i][6] = $row['truong'];
            $i++;
        }
        return $a;
    }
    // danh sách khách hàng theo trạng thái
    function tentrangthai($mysqli,$matt){
        $a = 0;
        $sql = "Select TENTRANGTHAI from trangthai where MATRANGTHAI = '$matt'";
        $result = mysqli_query($mysqli,$sql);
        while($row = mysqli_fetch_assoc($result)){
            $a = $row['TENTRANGTHAI'];
        }
        return $a;
    }
    function tongdstheott($mysqli,$sdt,$matt,$lan,$timkiem){
        $a = 0;
        if($lan != 0){
            $sql = "SELECT count(khachhang.SDT) as tong
                    FROM khachhang, dulieukhachhang,phieudkxettuyen,lienhe,usermanager
                    WHERE dulieukhachhang.SDT = khachhang.SDT
                    and khachhang.SDT=phieudkxettuyen.SDT and phieudkxettuyen.MAPHIEUDK=lienhe.MAPHIEUDK and lienhe.MATRANGTHAI like '%".$matt."%' and lienhe.LAN=".$lan."
                    and usermanager.SDT = lienhe.SDT and usermanager.SDT like '%".$sdt."%'
                    and khachhang.SDT not IN  (SELECT SDT FROM khachhangcu)
                    and (khachhang.SDT like '%".$timkiem."%' or khachhang.HOTEN like '%".$timkiem."%' or khachhang.EMAIL like '%".$timkiem."%' or dulieukhachhang.SDTBA like '%".$timkiem."%'
                        or dulieukhachhang.SDTME like '%".$timkiem."%' or dulieukhachhang.SDTZALO like '%".$timkiem."%'); ";
            $result = mysqli_query($mysqli,$sql);
            while($row = mysqli_fetch_assoc($result)){
                $a = $row['tong'];
            }
        }
        else{
            $sql = "SELECT count(khachhang.SDT) as tong
                    FROM khachhang, dulieukhachhang,phieudkxettuyen,lienhe,usermanager
                    WHERE dulieukhachhang.SDT = khachhang.SDT
                    and khachhang.SDT=phieudkxettuyen.SDT and phieudkxettuyen.MAPHIEUDK=lienhe.MAPHIEUDK and lienhe.MATRANGTHAI like'%".$matt."%'
                    and usermanager.SDT = lienhe.SDT and usermanager.SDT like '%".$sdt."%'
                    and khachhang.SDT not IN  (SELECT SDT FROM khachhangcu)
                    and (khachhang.SDT like '%".$timkiem."%' or khachhang.HOTEN like '%".$timkiem."%' or khachhang.EMAIL like '%".$timkiem."%' or dulieukhachhang.SDTBA like '%".$timkiem."%'
                        or dulieukhachhang.SDTME like '%".$timkiem."%' or dulieukhachhang.SDTZALO like '%".$timkiem."%');";
            $result = mysqli_query($mysqli,$sql);
            while($row = mysqli_fetch_assoc($result)){
                $a = $row['tong'];
            }
        }
        return $a;
    }
    function danhsachtheott($mysqli,$sdt,$matt,$lan,$timkiem,$limit,$offset){
        $a[0][0]=0;
        $i = 0;
        if($lan != 0){
            $sql = "SELECT DISTINCT khachhang.SDT as sdt, khachhang.HOTEN as ten, khachhang.EMAIL as mail, dulieukhachhang.SDTBA as sdtba, 
                    dulieukhachhang.SDTME as sdtme, dulieukhachhang.SDTZALO as zalo
                    FROM khachhang, dulieukhachhang,phieudkxettuyen,lienhe,usermanager
                    WHERE dulieukhachhang.SDT = khachhang.SDT
                    and khachhang.SDT=phieudkxettuyen.SDT and phieudkxettuyen.MAPHIEUDK=lienhe.MAPHIEUDK and lienhe.MATRANGTHAI like '%".$matt."%' and lienhe.LAN=".$lan."
                    and usermanager.SDT = lienhe.SDT and usermanager.SDT like '%%'
                    and khachhang.SDT not IN  (SELECT SDT FROM khachhangcu)
                    and (khachhang.SDT like '%".$timkiem."%' or khachhang.HOTEN like '%".$timkiem."%' or khachhang.EMAIL like '%".$timkiem."%' or dulieukhachhang.SDTBA like '%".$timkiem."%'
                        or dulieukhachhang.SDTME like '%".$timkiem."%' or dulieukhachhang.SDTZALO like '%".$timkiem."%') LIMIT ".$limit." OFFSET ".$offset.";";
            $result = mysqli_query($mysqli,$sql);
            while($row = mysqli_fetch_assoc($result)){
                $a[$i][0] = $row['sdt'];
                $a[$i][1] = $row['ten'];
                $a[$i][2] = $row['mail'];
                $a[$i][3] = $row['sdtba'];
                $a[$i][4] = $row['sdtme'];
                $a[$i][5] = $row['zalo'];
                $i++;
            }
        }
        else{
            $sql = "SELECT DISTINCT khachhang.SDT as sdt, khachhang.HOTEN as ten, khachhang.EMAIL as mail, dulieukhachhang.SDTBA as sdtba, 
                    dulieukhachhang.SDTME as sdtme, dulieukhachhang.SDTZALO as zalo
                    FROM khachhang, dulieukhachhang,phieudkxettuyen,lienhe,usermanager
                    WHERE dulieukhachhang.SDT = khachhang.SDT
                    and khachhang.SDT=phieudkxettuyen.SDT and phieudkxettuyen.MAPHIEUDK=lienhe.MAPHIEUDK and lienhe.MATRANGTHAI like'%".$matt."%'
                    and usermanager.SDT = lienhe.SDT and usermanager.SDT like '%".$sdt."%'
                    and khachhang.SDT not IN  (SELECT SDT FROM khachhangcu)
                    and (khachhang.SDT like '%".$timkiem."%' or khachhang.HOTEN like '%".$timkiem."%' or khachhang.EMAIL like '%".$timkiem."%' or dulieukhachhang.SDTBA like '%".$timkiem."%'
                        or dulieukhachhang.SDTME like '%".$timkiem."%' or dulieukhachhang.SDTZALO like '%".$timkiem."%') LIMIT ".$limit." OFFSET ".$offset.";";
            $result = mysqli_query($mysqli,$sql);
            while($row = mysqli_fetch_assoc($result)){
                $a[$i][0] = $row['sdt'];
                $a[$i][1] = $row['ten'];
                $a[$i][2] = $row['mail'];
                $a[$i][3] = $row['sdtba'];
                $a[$i][4] = $row['sdtme'];
                $a[$i][5] = $row['zalo'];

                $i++;
            }
        }
        return $a;
    }
    //Chuyen de
    function sosanhngaytaochuyende($ngay){
        $kt = false;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $today = date("Y-m-d");
        if(strtotime($today) < strtotime($ngay)) $kt = true;
        return $kt;
    }

    function taochuyende($mysqli,$ten,$nd,$ngaytc){
        if(sosanhngaytaochuyende($ngaytc)){
            $sql = "INSERT INTO `chuyende`( `TENCHUYENDE`, `THOIGIANTOCHUCCHUYENDE`, `NOIDUNG`) VALUES ('$ten','$ngaytc','$nd')";
            if (mysqli_query($mysqli, $sql)){					
                echo '<script language="javascript">alert("Đã tạo chuyên đề thành công!");location.href="admin.php?route=quanlychuyende";</script>';      
            }
            else {
                echo '<script language="javascript">alert("Tạo chuyên đề thất bại!");history.go(-1);</script>'; exit();;
            }
        }
        else{echo '<script language="javascript">alert("Ngày tổ chức chuyên đề bị sai!");history.go(-1);</script>'; exit();}
    }

    function suachuyende($mysqli,$macd,$ten,$nd,$ngaytc){
        if(sosanhngaytaochuyende($ngaytc)){
            $sql = "UPDATE `chuyende` SET `TENCHUYENDE`='$ten',`THOIGIANTOCHUCCHUYENDE`='$ngaytc',`NOIDUNG`='$nd' WHERE MACHUYENDE = '$macd'";
            if (mysqli_query($mysqli, $sql)){					
                echo '<script language="javascript">alert("Cập nhật chuyên đề thành công!");location.href="admin.php?route=quanlychuyende";</script>';       
            }
            else {
                echo '<script language="javascript">alert("Cập nhật chuyên đề thất bại!");history.go(-1);</script>';exit();
            }
        }
        else{echo '<script language="javascript">alert("Ngày tổ chức chuyên đề bị sai!");history.go(-1);</script>'; exit();}
    }

    function dkxoacd($dk,$macd){
        if($dk == "KT"){
        echo"<script>
        if(confirm('Bạn có muốn xóa đoạn dữ liệu')){
            location.href='admin.php?route=quanlychuyende&&xoa=yes&&macd=".$macd."';
        }
        else{
            location.href='admin.php?route=quanlychuyende&&xoa=no&&macd=".$macd."';
        }
        </script>"; 
        }
    }

    function sochuyende($mysqli,$timkiem){
        $a;
        $sql = "Select COUNT(MACHUYENDE) from chuyende where TENCHUYENDE like '%".$timkiem."%' 
                or THOIGIANTHONGBAO like '%".$timkiem."%' or THOIGIANTOCHUCCHUYENDE like '%".$timkiem."%' or NOIDUNG like '%".$timkiem."%'";
        $result = mysqli_query($mysqli,$sql);
        while($row = mysqli_fetch_assoc($result)){
            $a = $row['COUNT(MACHUYENDE)'];
        }
        return $a;
    }

    function danhsachchuyende($mysqli,$timkiem,$limit,$offset){
        $a[0][0] = 0;
        $i=0;
        $sql = "Select * from chuyende where TENCHUYENDE like '%".$timkiem."%' 
                or THOIGIANTHONGBAO like '%".$timkiem."%' or THOIGIANTOCHUCCHUYENDE like '%".$timkiem."%' 
                or NOIDUNG like '%".$timkiem."%' LIMIT ".$limit." OFFSET ".$offset."";
        $result = mysqli_query($mysqli,$sql);
        while($row = mysqli_fetch_assoc($result)){
            $a[$i][0] = $row['MACHUYENDE'];
            $a[$i][1] = $row['TENCHUYENDE'];
            $a[$i][2] = $row['THOIGIANTHONGBAO'];
            $a[$i][3] = $row['THOIGIANTOCHUCCHUYENDE'];
            $a[$i][4] = $row['NOIDUNG'];

            $i++;
        }
        return $a;
    }
    function laychuyende($mysqli,$macd){
        $a[0][0] = 0;
        $sql = "Select * from chuyende where MACHUYENDE = '$macd'";
        $result = mysqli_query($mysqli,$sql);
        while($row = mysqli_fetch_assoc($result)){
            $a[0][0] = $row['TENCHUYENDE'];
            $a[0][1] = $row['THOIGIANTHONGBAO'];
            $a[0][2] = $row['THOIGIANTOCHUCCHUYENDE'];
            $a[0][3] = $row['NOIDUNG'];
        }
        return $a;
    }
    function xoacd($mysqli,$macd){
        $b = false;
        
        $sql = "DELETE FROM `chuyende` WHERE MACHUYENDE = '$macd'";
        if (mysqli_query($mysqli, $sql)){					
            $b = true;       
        }
        
        if($b == true){echo '<script language="javascript">alert("Xoá chuyên đề thành công!");</script>';}  
        else if($b == false) {echo '<script language="javascript">alert("Xoá chuyên đề thất bại!");</script>';}
    }

    //Hồ sơ
    function sohoso($mysqli,$timkiem){
        $user = $_SESSION['login'];
        $a;
        if(mysqli_num_rows(mysqli_query($mysqli,"select SDT FROM usermanager WHERE SDT='".$user."'")) == 0){
            $sql = "SELECT COUNT(HOSO) FROM phieudkxettuyen,khachhang WHERE phieudkxettuyen.SDT=khachhang.SDT AND  HOSO != '' and (khachhang.HOTEN like '%".$timkiem."%' or khachhang.SDT like '%".$timkiem."%')";
            $result = mysqli_query($mysqli,$sql);
            while($row = mysqli_fetch_assoc($result)){
                $a = $row['COUNT(HOSO)'];
            }
        }
        else{
            $sql = "SELECT COUNT(HOSO) FROM phieudkxettuyen,khachhang,usermanager,chitietpq,phanquyen 
            WHERE usermanager.SDT = phanquyen.SDT and phanquyen.MaPQ = chitietpq.MaPQ and phieudkxettuyen.SDT = chitietpq.SDT and
            phieudkxettuyen.SDT=khachhang.SDT AND  HOSO != '' and usermanager.SDT ='".$user."' 
            and (khachhang.HOTEN like '%".$timkiem."%' or khachhang.SDT like '%".$timkiem."%');";
            $result = mysqli_query($mysqli,$sql);
            while($row = mysqli_fetch_assoc($result)){
                $a = $row['COUNT(HOSO)'];
            }
        }
        return $a;
    }
    function danhsachhoso($mysqli,$timkiem,$limit,$offset){
        $user = $_SESSION['login'];
        $a[0][0] = 0;
        $i=0;
        if(mysqli_num_rows(mysqli_query($mysqli,"select SDT FROM usermanager WHERE SDT='".$user."'")) == 0){
            $sql = "SELECT khachhang.SDT as sdt,khachhang.HOTEN as ten,phieudkxettuyen.HOSO as hoso  FROM phieudkxettuyen,khachhang WHERE phieudkxettuyen.SDT=khachhang.SDT AND HOSO != ''
                    and (khachhang.HOTEN like '%".$timkiem."%' or khachhang.SDT like '%".$timkiem."%') LIMIT ".$limit." OFFSET ".$offset."";
            $result = mysqli_query($mysqli,$sql);
            while($row = mysqli_fetch_assoc($result)){
                $a[$i][0] = $row['sdt'];
                $a[$i][1] = $row['ten'];
                $a[$i][2] = $row['hoso'];
                $i++;
            }
        }
        else{
            $sql = "SELECT khachhang.SDT as sdt,khachhang.HOTEN as ten,phieudkxettuyen.HOSO as hoso  FROM phieudkxettuyen,khachhang,usermanager,chitietpq,phanquyen 
                    WHERE usermanager.SDT = phanquyen.SDT and phanquyen.MaPQ = chitietpq.MaPQ and phieudkxettuyen.SDT = chitietpq.SDT and
                    phieudkxettuyen.SDT=khachhang.SDT AND  HOSO != '' and usermanager.SDT ='".$user."' 
                    and (khachhang.HOTEN like '%".$timkiem."%' or khachhang.SDT like '%".$timkiem."%') LIMIT ".$limit." OFFSET ".$offset."";
            $result = mysqli_query($mysqli,$sql);
            while($row = mysqli_fetch_assoc($result)){
                $a[$i][0] = $row['sdt'];
                $a[$i][1] = $row['ten'];
                $a[$i][2] = $row['hoso'];
                $i++;
            }
        }
        return $a;
    }
?>
    