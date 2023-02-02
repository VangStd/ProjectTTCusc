<div class="col-md-9 mainWeb">
    <?php
             $sdt=$_GET['sdt'];
        if(!isset($_GET['xoa'])){
            echo"<script>
            var test;
            function test(){
            if(confirm('Xóa SDT khách hàng này?')){
                location.href='usermanager.php?route=xoamisscall&&xoa=ok&&sdt=".$sdt."';
            }
            else{
                location.href='usermanager.php?route=xoamisscall&&xoa=no&&sdt=".$sdt."';
            }
        }
            test();
              </script>";}
            else if(isset($_GET['xoa'])&&$_GET['xoa']=='ok'){
                $sql="DELETE FROM misscall WHERE SDT='".$sdt."'";
                require_once "../connect/config.php";
                if($conn->query($sql)){
                    
                    echo"<script>alert('Xóa Thành Công')</script>";
                }
                echo"<script>location.href='usermanager.php?route=misscall'</script>";
                
             }  
             else{
                echo"<script>alert('Xóa không thành công')</script>";
                echo"<script>location.href='usermanager.php?route=misscall'</script>";
             }    
    ?>
</div>