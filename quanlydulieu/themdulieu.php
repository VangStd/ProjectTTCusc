<?php
//index.php
include '../connect/config.php';
include('../function/PHPExcel-1.8/Classes/PHPExcel.php');
require_once "../function/functionH.php";
if (isset($_POST['btnGui'])) {
    $file = $_FILES['file']['tmp_name'];
    $a = themkhachhang($conn, $file);
    //$b = nganhyeuthich($conn, $file);
    echo "<script>location.href='admin.php?route=danhsachdulieu';</script>";
}
if (isset($_POST['themKHcu'])) {
    $file = $_FILES['fileKHcu']['tmp_name'];
    $a = themkhachhangcu($conn, $file);
    //$b = nganhyeuthich($conn, $file);
    echo "<script>location.href='admin.php?route=danhsachdulieu';</script>";
}
?>
<div class="col-md-9 mainWeb">
    <!-- Breakdrumb -->
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="bread" href="admin.php?route=home">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Thêm dữ liệu</li>
            </ol>
        </nav>
    </div>
    <!-- End breakdrumb -->
    <!-- <h2>Thêm dữ liệu</h2> -->
    <div class="row">
        <!-- Thêm khách hàng mới -->
        <div class="col-md-6"><br>
            <h4 style="color: red;">THÊM KHÁCH HÀNG MỚI</h4>
            <form method="POST" enctype="multipart/form-data">
                <div class=" form-group">
                    <label>Vui lòng chọn file:</label><br>
                    <input type="file" class="form-control-file" id="exampleFormControlFile1" accept=".xlsx" name="file">
                    <br><br>
                    <button class="btn btn-success" type="submit" name="btnGui">Xác nhận</button>
                </div>
                <br><br><br>
                <i>Chỉ chấp nhận file .xlsx</i>
            </form>
        </div>

        <!-- Thêm khách hàng cũ -->
        <div class="col-md-6"><br>
            <h4 style="color: red;">THÊM KHÁCH HÀNG CŨ</h4>
            <form method="POST" enctype="multipart/form-data">
                <div class=" form-group">
                    <label>Vui lòng chọn file:</label><br>
                    <input type="file" class="form-control-file" accept=".xlsx" name="fileKHcu">
                    <br><br>
                    <button class="btn btn-success" type="submit" name="themKHcu">Xác nhận</button>
                </div>
                <br><br><br>
                <i>Chỉ chấp nhận file .xlsx</i>
            </form>
        </div>
    </div>
</div>