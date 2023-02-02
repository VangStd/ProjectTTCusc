<?php 
//index.php
	include '../connect/config.php';
    require_once "../function/functionH.php";
    $chart_data = '';
    $ngaybd=0;
    $ngaykt=0;
    $b=0;
    if(isset($_POST['chonngaytinhtong'])){
		$ngaybd = $_POST['ngaybd'];
        $ngaykt = $_POST['ngaykt'];
        
        
        $b = songay($ngaybd, $ngaykt);    
        if($b !=-1){
            $a =  ngay($ngaybd,$b);
                
            for($i = 0 ; $i < $b ; $i++){
                foreach($a as $value){
                $ngay = "$value[$i]";
            }
                $c = thongke($conn,$ngay,'');
                $chart_data .= "{ date:'".$ngay."', NumberofCalls :".$c."}, ";
            }
            $chart_data = substr($chart_data, 0, -2);
        }else {}
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
                <li class="breadcrumb-item active" aria-current="page">Thống kê dữ liệu theo ngày</li>
            </ol>
        </nav>
    </div>
    <!-- End breakdrumb -->
    <h3 style="text-align: center; color: red;">THỐNG KÊ DỮ LIỆU THEO NGÀY</h3>
    <br>
    <form method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6" style="margin: auto;">
                <div class="row">
                    <div class="col-md-5">
                        <label>Chọn ngày BD: </label>
                        <div id="datepickerBD" class="input-group date" data-date-format="dd-mm-yyyy">
                            <input class="form-control shadow-none" type="text" name="ngaybd">
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <label>Chọn ngày KT: </label>
                        <div id="datepickerKT" class="input-group date" data-date-format="dd-mm-yyyy">
                            <input class="form-control shadow-none" readonly="" type="text" name="ngaykt">
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-2"><br>
                        <button class="btn btn-success shadow-none" type="submit" name="chonngaytinhtong">
                            Chọn
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Biểu đồ đường thống kê -->
    <div class="container-fluid">
        <div class="container" style="width:1000px;">
            <br /><br />
            <div id="chart"></div>
        </div>
    </div>
    <table class="table table-success table-striped">
        <?php 
        if($ngaybd > 0 ){
        ?>
        <tr>
            <th>STT</th>
            <th>Ngày liên hệ</th>
            <th>Người liên hệ liên hệ</th>
            <th>Số lượng liên hệ</th>
        </tr>
        <?php
            $d = ngay($ngaybd,$b);
            if($b !=-1){
                $stt = 1;
                $e =  ngay($ngaybd,$b);
                $kt = false;
                for($i = 0 ; $i < $b ; $i++){
                    foreach($e as $value){
                    $ngay = "$value[$i]";
                    }  
                    $f = soluonglienhetheonguoi($conn,$ngay);
                    foreach($f as $value){
                        if("$value[0]"!=1){
                            $tg = "$value[0]";
                            $tenum = "$value[1]";
                            $sl = "$value[2]";
        ?>
        <tr>
            <th><?php echo $stt ?></th>
            <th><?php echo date_format(date_create($tg),"d-m-Y") ?></th>
            <th><?php echo $tenum ?></th>
            <th><?php echo $sl ?></th>
        </tr>
        <?php 
                    $stt++;
                    $kt = true;
                        }
                    }
                }if($kt == false){
        ?>
        <tr>
            <th>0</th>
            <th>00-00-0000</th>
            <th>Không có dữ liệu</th>
            <th>0</th>
        </tr>
        <?php 
                 }
            }
        }
        ?>
    </table>
</div>
<script>
// Điều khiển biểu đồ
Morris.Line({
    element: 'chart',
    data: [<?php echo $chart_data; ?>],
    xkey: 'date',
    ykeys: ['NumberofCalls'],
    labels: ['NumberofCalls'],
    hideHover: 'auto',
    stacked: true
});
</script>

<?php
 if($ngaybd == 0 &&$ngaykt==0){
?>
<script>
// Hàm điều khiển lịch
// Thời gian bắt đầu
$(function() {
    $("#datepickerBD").datepicker({
        autoclose: true,
        todayHighlight: true
    }).datepicker('update', new Date());
});

// Thời gian kết thúc
$(function() {
    $("#datepickerKT").datepicker({
        autoclose: true,
        todayHighlight: true
    }).datepicker('update', new Date());
});
</script>
<?php }
else{ 
    $begin = date_create($ngaybd);
    $ngaybatdau=date_format($begin,"Y-m-d");
    $end= date_create($ngaykt);
    $ngayketthuc=sosanhngayHT(date_format($end,"Y-m-d"));
    
?>
<script>
// Hàm điều khiển lịch
// Thời gian bắt đầu
$(function() {
    $("#datepickerBD").datepicker({
        autoclose: true,
        todayHighlight: true
    }).datepicker('update', new Date('<?php echo $ngaybatdau ?>'));
});

// Thời gian kết thúc
$(function() {
    $("#datepickerKT").datepicker({
        autoclose: true,
        todayHighlight: true
    }).datepicker('update', new Date('<?php echo $ngayketthuc ?>'));
});
</script>
<?php }?>