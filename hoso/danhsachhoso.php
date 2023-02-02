<div class="col-md-9 mainWeb">
    <!-- Breakdrumb -->
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a
                        href="<?php if($ad ==0){echo "usermanager.php?";}else{echo "admin.php?";}?>route=<?php if($ad ==0){echo "homeUM";}else{echo "home";}?>">
                        Trang chủ
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Danh sách hồ sơ</li>
            </ol>
        </nav>
    </div>
    <!-- End breakdrumb -->

    <!-- Danh sách hồ sơ-->
    <div class="row">
        <h3 style="text-align:center;">Danh sách hồ sơ</h3>
        <div class="row">
            <div class="col-md-12">
                <!-- Ô tìm kiếm hồ sơ -->
                <form class="d-flex" style="float: right; margin-bottom: 10px;" method="get">
                    <input class="form-control me-2 shadow-none" type="text" placeholder="Tìm kiếm hồ sơ?"
                        name="timkiemtthoso">
                    <button class="btn btn-success" type="submit" name="timkiemdshoso">
                        Tìm
                    </button>
                </form>
            </div>
        </div>

        <div class="row">
            <!-- Bảng dánh sách hồ sơ -->
            <table class="table table-success table-striped">
                <tr>
                    <th>STT</th>
                    <th>SDT</th>
                    <th>Họ tên</th>
                    <th>Hồ sơ</th>
                    <th>Tùy chọn</th>
                </tr>
                <?php
                include '../connect/config.php';
                require_once "../function/functionH.php";
                
                $item_per_page = !empty($_GET['per_page'])?$_GET['per_page']:20;
                $current_page = !empty($_GET['page'])?$_GET['page']:1; ; //Trang hiện tại
                $offset = ($current_page - 1) * $item_per_page; 

                if(isset($_GET['timkiemdshoso'])){
                    $timkiem = $_GET['timkiemtthoso'];
                    $tong = sohoso($conn,$timkiem);
                    $totalPages = ceil($tong / $item_per_page);
                    $ds = danhsachhoso($conn,$timkiem,$item_per_page,$offset);
                }
                else{
                    $tong = sohoso($conn,'');
                    $totalPages = ceil($tong / $item_per_page);
                    $ds = danhsachhoso($conn,'',$item_per_page,$offset);
                }
                $i=1;
                if($tong >0){
                    foreach($ds as $value){
                        $sdt = "$value[0]";
                        $ten = "$value[1]";
                        $hoso = "$value[2]";
                ?>
                <tr>
                    <td><?php  echo $i ?></td>
                    <td><?php  echo $sdt ?></td>
                    <td>
                        <?php 

                            echo $ten
                        ?>
                    </td>
                    <td><a href="<?php  echo '../'.$hoso ?>">Hồ sơ</a></td>
                    <td>
                        <a
                            href="<?php if($ad ==0){echo "usermanager.php?";}else{echo "admin.php?";}?>route=<?php if($ad ==0){echo "xoahoso";}else{echo "xoahoso";}?>&SDT=<?php echo $rows['SDT']?>">Xóa</a>
                    </td>
                </tr>
                <?php
                    $i++;
                    }
                }
                ?>
            </table>

            <!-- Phân trang -->
            <nav aria-label="Page navigation example" style="float: right;">
                <ul class="pagination">
                    <li class="page-item"><?php require_once "../function/phantrang/paginationhs.php";?></li>
                </ul>
            </nav>
        </div>
    </div>
</div>