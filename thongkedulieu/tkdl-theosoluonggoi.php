<?php 
//index.php
    include '../connect/config.php';
    require_once "../function/functionH.php";
    $chart_data = '';
    $a = thongketheoTT($conn,'');
       foreach($a as $value){
        $chart_data .= "{ TrangThai:'".$value[0]."', NumberofCalls :".$value[1]."}, ";
       }
        
    
	$chart_data = substr($chart_data, 0, -2);
?>
<div class="col-md-9 mainWeb">
    <h2>Thống kê dữ liệu theo trạng thái</h2>
    <div class="container-fluid">
        <div class="container" style="width:1000px;">
            <br /><br />
            <div id="chart"></div>
        </div>
    </div>
</div>
<script>
Morris.Bar({
 element : 'chart',
 data:[<?php echo $chart_data; ?>],
 xkey:'TrangThai',
 ykeys:['NumberofCalls'],
 labels:['NumberofCalls'],
 hideHover:'auto',
 stacked:true
});
</script>