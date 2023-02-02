<?php 
//index.php
    include '../connect/config.php';
    require_once "../function/functionH.php";
    $lan = 0;
    $user = 0;
    $dc = 0;
    $khoa = false;

    if(laUserManager($conn) == false){
        $user = $_SESSION['login'];
        $khoa = true;
    }

    if(isset($_POST['chondieukien'])){
		$lan = $_POST['dieukienloc'];
        if($khoa == false){$user = $_POST['usermanager'];}
        $dc =1;
    }
?>
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
                <li class="breadcrumb-item active" aria-current="page">Thống kê dữ liệu theo kết quả khai thác</li>
            </ol>
        </nav>
    </div>
    <!-- End breakdrumb -->
    <h3 style="text-align: center; color: red;">THỐNG KÊ DỮ LIỆU THEO KẾT QUẢ KHAI THÁC</h3>

    <!-- Ô điều kiện lọc -->
    <div class="row">
        <form method="POST" enctype="multipart/form-data">
            <div class="col-md-8" style="margin: auto;">
                <div class="row">
                    <!-- Ô dropdown input chọn điều kiện -->
                    <div class="col-md-5">
                        <label>Chọn lần liên hệ:</label>
                        <select class="form-select shadow-none suanghenghiep" name="dieukienloc">
                            <option <?php if ($lan == 0 ) echo 'selected' ; ?> value="0">Tất cả</option>
                            <option <?php if ($lan == 1 ) echo 'selected' ; ?> value="1">Liên hệ lần 1</option>
                            <option <?php if ($lan == 2 ) echo 'selected' ; ?> value="2">Liên hệ lần 2</option>
                            <option <?php if ($lan == 3 ) echo 'selected' ; ?> value="3">Liên hệ lần 3</option>
                        </select>
                    </div>

                    <!-- <label>Chọn Usermanager:</label> -->
                    <div class="col-md-5">
                        <label>Chọn User manager:</label>
                        <select class="form-select shadow-none suanghenghiep" name="usermanager"
                            <?php if($khoa  == true){ ?> disabled <?php } ?>>
                            <option value="" selected>Tất cả</option>
                            <?php
                        $um = MaUM($conn);
                        foreach($um as $value){
                            $SDT = "$value[0]";
                            $TEN = "$value[1]";
                        ?>
                            <option <?php if ($SDT== $user) echo 'selected' ; ?> value="<?php echo  $SDT; ?>">
                                <?php echo $TEN; ?>
                                <?php } ?>
                            </option>
                        </select>
                    </div>

                    <!-- Btn xác nhận chọn -->
                    <div class="col-md-2"><br>
                        <button class="btn btn-success shadow-none" name="chondieukien" type="submit">Chọn</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <br>
    <!-- Kết quả thống kê -->
    <div class=" row">
        <?php 
        if($dc==1){
            $tong = SophieuDK($conn,$user,$lan);
            if($lan==0){
                //$tong = SophieuDK($conn,$user,$lan);
                $phieudkxt = sophieuDKtheoTT($conn,$user,$lan);
                foreach($phieudkxt as $value){
                    $matt = "$value[0]";
                    $tentt = "$value[1]";
                    $sophieu = "$value[2]";
                    $thongke = thongketheoKQkhaithac($conn,$user,$matt);
        ?>
        <div class="col-md-6">
            <div class="theketquathongke">
                <h3 class="box-title tentrangthaithongke"><?php echo $tentt ?></h3>
                <h5><?php echo $sophieu  ?>/<span><?php echo $tong ?></span> phiếu</h5>
                <p>- ĐÃ LIÊN HỆ: <?php echo $thongke ?>(Lần 1,2,3)</p>
                <a href="<?php if($ad== 1){echo "admin.php";}else{echo "usermanager.php";} ?>?route=danhsachdulieustatus&maus=<?php echo $user ?>&matt=<?php echo $matt ?>&lan=<?php echo $lan ?>"
                    style="float: right;">
                    Danh sách chi tiết
                </a>
            </div><br>
        </div>
        <?php
                }
            }
            else if($lan!=0){
                //$tong = SophieuDK($conn,$user,$lan);
                $phieudkxt = sophieuDKtheoTT($conn,$user,$lan);
                foreach($phieudkxt as $value){
                    $matt = "$value[0]";
                    $tentt = "$value[1]";
                    $sophieu = "$value[2]";
                    $thongke = thongketheoKQkhaithactheolan($conn,$user,$matt,$lan);
        ?>
        <br>
        <div class="col-md-6">
            <div class="theketquathongke">
                <h3 class="box-title tentrangthaithongke"><?php echo $tentt ?></h3>
                <p>- <?php echo $tentt ?>: <?php echo $sophieu ?>/<?php echo $tong ?> phiếu XT</p>
                <p>- ĐÃ LIÊN HỆ: <?php echo $thongke ?></p>
                <a href="<?php if($ad== 1){echo "admin.php";}else{echo "usermanager.php";} ?>?route=danhsachdulieustatus&maus=<?php echo $user ?>&matt=<?php echo $matt ?>&lan=<?php echo $lan ?>"
                    style="float: right;">
                    Danh sách chi tiết
                </a>
            </div><br>
        </div>
        <?php 
                }
            }
        }
        ?>
    </div>
</div>