<?php 
//index.php
	include '../connect/config.php';
    require_once "../function/functionH.php";
    $macd = $_GET['macd'];

    $chuyende = laychuyende($conn,$macd);
    foreach($chuyende as $value){
        $ten = "$value[0]";
        $ngaytao = "$value[1]";
        $ngaytc = "$value[2]";
        $nd = "$value[3]";
    }
    if(isset($_POST['suachuyende'])){
		$date = date_create($_POST['thoigiantochuc']);
        $ngaytochuc = date_format($date,"Y-m-d");;

        $tencd = $_POST['tenchuyende'];
        $ndcd = $_POST['noidungchuyende'];
        suachuyende($conn,$macd,$tencd,$ndcd,$ngaytochuc);

        
    }
?>

<div class="col-md-9 mainWeb">
    <!-- Breakdrumb -->
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="admin.php?route=home">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="admin.php?route=quanlychuyende">Danh sách chuyên đề</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sửa chuyên đề</li>
            </ol>
        </nav>
    </div>
    <!-- End breakdrumb -->
    <h3 style="text-align:center; color: red;">Sửa chuyên đề</h3>
    <div class="row">
        <div class="col-md-6" style="margin: auto;">
            <div class="row">
                <form action="" method="POST">
                    <label>Tên chuyên đề:</label>
                    <input type="text" class="form-control shadow-none" value="<?php echo $ten  ?>" name="tenchuyende">
                    <label>Nội dung chuyên đề:</label>
                    <textarea class="form-control shadow-none" rows="3"  name="noidungchuyende"><?php echo $nd  ?></textarea>
                    <label>Ngày thông báo:</label>
                    <input type="date" class="form-control shadow-none" value="<?php echo $ngaytao  ?>" name="thoigianthongbao" disabled>
                    <label>Ngày tổ chức:</label>
                    <input type="date" class="form-control shadow-none" value="<?php echo $ngaytc  ?>" name="thoigiantochuc">

                    <button class="btn btn-success nutthemchuyende" type="submit" name = "suachuyende"
                        style="width: 18%; margin-top: 15px; margin-bottom: 15px;"><i
                            class="fa-solid fa-pen-to-square"></i>&nbsp;</i>Sửa
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
</div>
</div>