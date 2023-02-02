<div class="col-md-9 mainWeb">
    <h2>Xóa dữ liệu</h2>
    <?php
    $id = $_GET['id'];
    echo $id;

    $sql = "UPDATE khachhang SET khachhang.TRANGTHAIKHACHHANG = 0 WHERE SDT = '$id'";

    if (mysqli_query($conn, $sql)) {
        require_once "../function/functionH.php";
        NhatKyxoadulieu($conn,$id);
        echo "<script>
        alert('Đã xóa thành công')
        location.replace('admin.php?route=danhsachdulieu');
        </script>";
    } else {
        echo "Lỗi:" . mysqli_errno($conn);
    }
    
    ?>
</div>