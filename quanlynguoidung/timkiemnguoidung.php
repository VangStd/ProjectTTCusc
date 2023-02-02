<?php
    
?>
<div class="col-md-9 mainWeb">
    <h2>Danh sách người dùng</h2>
    <!-- Ô tìm kiếm người  dùng -->
    <form class="d-flex" style="width: 400px; float: right;" action="admin.php?route=timkiemnguoidung" method="GET">
        <input class="form-control me-2 shadow-none" name="timkiemnguoidung" type="search" placeholder="Tìm kiếm người dùng?"
            aria-label="Search">
        <button class="btn btn-success shadow-none" name="submit" type="submit">Tìm</button>
    </form><br><br>

    <!-- Bảng dánh sách người dùng -->
    <table class="table table-success table-striped">
        <tr>
            <th>STT</th>
            <th>Loại Người Dùng</th>
            <th>SDT</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>Giới tính</th>
            <th>Địa chỉ</th>
            <th>Tùy chọn</th>
        </tr>
       <?php
        require_once "../function/function.php";
        if(isset($_GET['page'])){
           $page=$_GET['page'];
           if($page<=0){
            $page=1;
           }
        }
        else{
            $page=1;
        }
        $dem=0;
        $so_dong_can_phan=10;
        $conn=connect();
        $tt=$_GET['timkiemnguoidung'];
        $list=timKiemNguoiDung($conn,$tt);
        if($list !=null){
            for($i=($page-1)* $so_dong_can_phan; $i<count($list); $i++){
                if($dem>=$so_dong_can_phan){
                    break;
                 }
                echo
            "<tr>
                <td>".($i+1)."</td>
                <td>".$list[$i]['loaitk']."</td>
                <td>".$list[$i]['SDT']."</td>
                <td>".$list[$i]['HOTEN']."</td>
                <td>".$list[$i]['EMAIL']."</td>
                <td>".$list[$i]['GIOITINH']."</td>
                <td>".$list[$i]['DIACHI']."</td>";
               if($list[$i]['loaitk']==='Admin'){
               echo"
                <td><a href='admin.php?route=chitietnguoidung&&sdt=".$list[$i]['SDT']."&&user=admin'>Chi tiết</a><br>
                </td>";
               }
               else{
               echo"
                <td>
                  <a href='admin.php?route=chitietnguoidung&&sdt=".$list[$i]['SDT']."&&user=usermanager'>Chi tiết</a><br>
                  <a href='admin.php?route=xoanguoidung&&sdt=".$list[$i]['SDT']."'>Xóa</a><br>
                  <a href='admin.php?route=suanguoidung&&sdt=".$list[$i]['SDT']."'>Sửa</a>
                </td>";

               }
            echo
            "</tr>";
           $dem++;
            }
            $_SESSION['sotrang']=ceil(count($list)/10);
        }
    //     foreach ($list as $value){
    //         if($i<10){
    //             $i="0".$i;
    //         }
    //         echo"<tr>
    //         <td>".$i."</td>
    //         <td>".$value['loaitk']."</td>
    //         <td>".$value['SDT']."</td>
    //         <td>".$value['HOTEN']."</td>
    //         <td>".$value['EMAIL']."</td>
    //         <td>".$value['GIOITINH']."</td>
    //         <td>".$value['DIACHI']."</td>
    //         <td>";
              
    //         if($value['loaitk']==='User Manager'){
    //           echo" <a href='admin.php?route=chitietnguoidung&&sdt=".$value['SDT']."&&user=usermanager'>Chi tiết<br>";
    //         //   echo"<a href='admin.php?route=suanguoidung&&sdt=".$value['SDT']."'>Sửa</a><br>";
    //           echo"  <a href='admin.php?route=xoanguoidung'>Xóa</a>
    //         </td>
    //    </tr>";}
    //             else{
    //                 echo" <a href='admin.php?route=chitietnguoidung&&sdt=".$value['SDT']."&&user=admin'>Chi tiết<br>";
    //             }
    //    $i=$i+1;
    //     }
       ?>
    </table>
    <!-- Phân trang -->
    <nav aria-label="Page navigation example" style="float: right;">
        <ul class="pagination">
        <?php
            $i=0;
            if(isset($_GET['page'])){
                $page=$_GET['page'];
            }
            if($page !=1){
           echo" 
           <li class='page-item'>
                <a class='page-link shadow-none' href='admin.php?route=timkiemnguoidung&&page=".($page-1)."&&timkiemnguoidung=".$_GET['timkiemnguoidung']."'".($i+1)." aria-label='Previous'>
                    <span aria-hidden='true'>&laquo;</span>
                    <span class='sr-only'>Previous</span>
                </a>
            </li>";
              }
            for($i=0; $i<$_SESSION['sotrang']; $i++){
            echo"<li class='page-item";if($page==($i+1)){ echo" active";}echo"'><a class='page-link shadow-none' href='admin.php?route=timkiemnguoidung&&page=".($i+1)."&&timkiemnguoidung=".$_GET['timkiemnguoidung']."'>".($i+1)."</a></li>";
            }
            if($page <$_SESSION['sotrang']){
            echo"
            <li class='page-item'>
                <a class='page-link shadow-none' href='admin.php?route=timkiemnguoidung&&page=".($page+1)."&&timkiemnguoidung=".$_GET['timkiemnguoidung']."'".($i+1)." aria-label='Next'>
                    <span aria-hidden='true'>&raquo;</span>
                    <span class='sr-only'>Next</span>
                </a>
           </li>";
            }
            ?>
        </ul>
    </nav>
</div>