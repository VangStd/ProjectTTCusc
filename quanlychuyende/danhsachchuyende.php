<?php 
//index.php
	include '../connect/config.php';
    require_once "../function/functionH.php";
    $b=0;
    if(isset($_POST['taochuyende'])){
		$date = date_create($_POST['thoigiantochuc']);
        $ngaytochuc = date_format($date,"Y-m-d");

        $tencd = $_POST['tenchuyende'];
        $ndcd = $_POST['noidungchuyende'];
        taochuyende($conn,$tencd,$ndcd,$ngaytochuc);

        echo "<script>location.href='admin.php?route=quanlychuyende';</script>";
    }
    if (isset($_GET['xoa'])) {
        $macd = $_GET['macd'];
        $dk = $_GET['xoa'];
        dkxoacd($dk, $macd);
        if ($dk == "yes") {
            xoacd($conn, $macd);
            echo "<script>location.href='admin.php?route=quanlychuyende';</script>";
        } else if ($dk == "no") {
            echo "<script>location.href='admin.php?route=quanlychuyende';</script>";
        }
    }
?>

<div class="col-md-9 mainWeb">
    <!-- Breakdrumb -->
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="admin.php?route=home">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Danh sách chuyên đề</li>
            </ol>
        </nav>
    </div>
    <!-- End breakdrumb -->

    <h3 style="text-align:center; color: red;">Quản lý chuyên đề</h3>
    <div class="row">
        <div class="col-md-6" style="margin: auto;">
            <div class="row">
                <form action="" method="POST">
                    <label>Tên chuyên đề:</label>
                    <input type="text" class="form-control shadow-none" name="tenchuyende">
                    <label>Nội dung chuyên đề:</label>
                    <textarea class="form-control shadow-none" rows="3" name="noidungchuyende"></textarea>
                    <!-- <label>Thời gian thông báo:</label>
                    <input type="date" class="form-control shadow-none" name="thoigianthongbao"> -->
                    <label>Thời gian tổ chức:</label>
                    <input type="date" class="form-control shadow-none" name="thoigiantochuc">

                    <button class="btn btn-success nutthemchuyende" name="taochuyende" type="submit"
                        style="width: 18%; margin-top: 15px;"><i class="fa-solid fa-plus">&nbsp;</i>Thêm
                    </button>
                </form>
            </div>
        </div>
    </div>
    <hr>

    <!-- Danh sách chuyên đề -->
    <div class="row">
        <h3 style="text-align:center;">Danh sách chuyên đề</h3>
        <div class="row">
            <div class="col-md-12">
                <!-- Ô tìm kiếm chuyên đề -->
                <form class="d-flex" style="float: right; margin-bottom: 10px;" method="get">
                    <input class="form-control me-2 shadow-none" type="text" placeholder="Tìm kiếm chuyên đề?"
                        name="timkiemttchuyende">
                    <button class="btn btn-success" type="submit" name="timkiemchuyende">
                        Tìm
                    </button>
                </form>
            </div>
        </div>

        <div class="row">
            <!-- Bảng dánh sách dữ liệu -->
            <table class="table table-success table-striped">
                <tr>
                    <th>STT</th>
                    <th>Tên chuyên đề</th>
                    <th>Ngày thông báo</th>
                    <th>Ngày tổ chức</th>
                    <th>Nội dung</th>
                    <th>Tùy chọn</th>
                </tr>
                <?php

                    $item_per_page = !empty($_GET['per_page'])?$_GET['per_page']:20;
                    $current_page = !empty($_GET['page'])?$_GET['page']:1; ; //Trang hiện tại
                    $offset = ($current_page - 1) * $item_per_page; 
                    if(isset($_GET['timkiemchuyende'])){
                        $timkiem = $_GET['timkiemttchuyende'];
                        $tong = sochuyende($conn,$timkiem);
                        $totalPages = ceil($tong / $item_per_page);
                        $danhsach = danhsachchuyende($conn,$timkiem,$item_per_page,$offset);
                    }
                    else{
                        $tong = sochuyende($conn,'');
                        $totalPages = ceil($tong / $item_per_page);
                        $danhsach = danhsachchuyende($conn,'',$item_per_page,$offset);
                    }
                    $i = 1;
                    if($tong > 0){
                        foreach($danhsach as $value){
                            $macd = "$value[0]";
                            $ten = "$value[1]";
                            $ngaytao = "$value[2]";
                            $ngaytc = "$value[3]";
                            $nd = "$value[4]";
                ?>
                <tr>
                    <td><?php  echo $i ?></td>
                    <td><?php  echo $ten ?></td>
                    <td><?php  echo date_format(date_create($ngaytao),"d-m-Y") ?></td>
                    <td><?php  echo date_format(date_create($ngaytc),"d-m-Y") ?></td>
                    <td><?php  echo $nd ?></td>
                    <td>
                        <a href="admin.php?route=suachuyende&macd=<?php echo $macd ?>">Sửa</a><br>
                        <a href="admin.php?route=quanlychuyende&xoa=KT&macd=<?php echo $macd; ?>">Xóa</a>
                    </td>
                </tr>
                <?php 
                        $i++;
                        }
                    }
                    else{
                ?>
                <tr>
                    <th>0</th>
                    <th>Chưa có chuyên đề</th>
                    <th>00/00/0000</th>
                    <th>00/00/0000</th>
                    <th>Chưa có chuyên đề</th>
                    <th></th>
                </tr>
                <?php
                    }
                ?>
            </table>

            <!-- Phân trang -->
            <nav aria-label="Page navigation example" style="float: right;">
                <ul class="pagination">
                    <li class="page-item"><?php require_once "../function/phantrang/paginationcd.php";?></li>
                </ul>

            </nav>
        </div>
    </div>
</div>