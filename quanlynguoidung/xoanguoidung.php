<div class="col-md-9 mainWeb">
    <?php
    require_once "../function/functionH.php";
    // if($_GET['route']==="xoanguoidung"){
    $sdt = $_GET['sdt'];
    //
    if (!isset($_GET['xoa'])) {
        echo"<script>
            var test;
            function test(){
            if(confirm('Bạn có muốn xóa người dùng')){
                location.href='admin.php?route=xoanguoidung&&xoa=ok&&sdt=" . $sdt . "';
            }
            else{
                location.href='admin.php?route=xoanguoidung&&xoa=no&&sdt=" . $sdt . "';
            }
        }
            test();
              </script>";
    } else if (isset($_GET['xoa']) && $_GET['xoa'] == 'ok') {
        try {
            $sql = "UPDATE `usermanager` SET `TRANGTHAIUM`=0 WHERE SDT='" . $sdt . "'";
            $sql1 = "DELETE FROM `usermanager` WHERE usermanager.SDT='$sdt'";
            require_once "../connect/config.php";
            if ($conn->query($sql) && $conn->query($sql1)) {
                Nhatkyxoanguoidung($conn, $sdt);
                echo"<script>alert('Xóa Thành Công')</script>";
            }
        } catch (Exception $ex) {
            echo"<script>alert('Người Dùng Đang Có Vai Trò')</script>";
        }

        echo"<script>location.href='admin.php?route=hienthinguoidung'</script>";
        //echo"<script>alert('Xóa Thất Bại".$sdt."')</script>";
    } else {
        echo"<script>alert('Xóa ko thành công')</script>";
        echo"<script>location.href='admin.php?route=hienthinguoidung'</script>";
    }
    ?>
</div>