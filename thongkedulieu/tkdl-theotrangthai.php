<?php 
//index.php
    include '../connect/config.php';
    require_once "../function/functionH.php";

    $chart_data = '';
    $UM =0;
    if(isset($_POST['xacnhan'])){
        $UM = $_POST['usermanager'];
        $a = thongketheoTT($conn,$UM);
    }
    if(!isset($_POST['xacnhan'])) $a = thongketheoTT($conn,'');
    foreach($a as $value){
        // echo ".$value[0].";
        // echo ".$value[1].";
        $chart_data .= "{ TrangThai:'".$value[0]."', NumberofCalls :".$value[1]."}, ";
    }
        
    
	$chart_data = substr($chart_data, 0, -2);
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
                <li class="breadcrumb-item active" aria-current="page">Thống kê dữ liệu theo trạng thái</li>
            </ol>
        </nav>
    </div>
    <!-- End breakdrumb -->
    <h3 style="text-align: center; color: red;">THỐNG KÊ DỮ LIỆU THEO TRẠNG THÁI</h3><br>
    <!-- Chọn tên UM -->
    <div class="row">
        <form method="POST" enctype="multipart/form-data" class="d-flex">
            <div class="col-md-5" style="margin: auto;">
                <div class="row">
                    <div class="col-md-9">
                        <label>Chọn User manager:</label>
                        <select class="form-select shadow-none" aria-label="Default select example" name="usermanager">
                            <option value="">Tất cả</option>
                            <?php
                    $um = MaUM($conn);
                    foreach($um as $value){
                        $SDT = "$value[0]";
                        $TEN = "$value[1]";
                    ?>
                            <option <?php if ($SDT == $UM) echo 'selected' ; ?> value="<?php echo  $SDT; ?>">
                                <?php echo $TEN; ?>
                                <?php } ?>
                            </option>
                        </select>
                    </div>

                    <div class="col-md-3"><br>
                        <button class="btn btn-success shadow-none" name="xacnhan" type="submit">Xác nhận</button>
                    </div>
                </div>
            </div>

        </form>
    </div>

    <!-- Biểu đồ dữ liệu -->
    <div class="row">
        <div class="col-md-10" style="width:1000px; margin: auto;">
            <br /><br />
            <div id="chart"></div>
        </div>
    </div>
</div>
<script>
Morris.Bar({
    element: 'chart',
    data: [<?php echo $chart_data; ?>],
    xkey: 'TrangThai',
    ykeys: ['NumberofCalls'],
    labels: ['NumberofCalls'],
    hideHover: 'auto',
    stacked: true
});
</script>