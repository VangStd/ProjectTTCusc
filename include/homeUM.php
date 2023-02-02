<?php
    include("../connect/config.php");
    include("../function/functionThongKe.php");
    
    if (isset($_POST['themghichu'])) {
        $noidung= $_POST['ghichu'];
        
        themGhiChuUM($conn, $user, $noidung);
    }

    if (isset($_POST['capnhatghichu'])) {
        
    }
?>

<div class="col-md-9 mainWeb">
    <h4>Xin chào <?php echo $hoten?>! </h4>
    <div class="row">
        <!-- Thống kê số lượng liên hệ -->
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12 lienhelan3">
                        <div class="row">
                            <div class="col-md-1">
                                <i class="fa-solid fa-headset labellienhe"></i>
                            </div>
                            <div class="col-md-11"><br>
                                <h5 style="text-align: center; color: red;">MISSCALL</h5>
                                <p class="ndthongkeum">
                                    <?php
                                        echo tongSoDongmisscall($conn, $SDT)
                                    ?>
                                    /

                                    <?php
                                        echo tongSoDong($conn, $SDT)
                                    ?>
                                </p>
                                <a class="chitietdsthongke" href="usermanager.php?route=misscall">Chi tiết
                                    danh
                                    sách</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12 chualienhe">
                        <div class="row">
                            <div class="col-md-1">
                                <i class="fa-solid fa-headset labellienhe"></i>
                            </div>
                            <div class="col-md-11"><br>
                                <h5 style="text-align: center; color: red;">CHƯA LIÊN HỆ</h5>
                                <p class="ndthongkeum">
                                    <?php
                                        echo tongDongChuaLienHe($conn, $SDT)
                                    ?>
                                    /
                                    <?php
                                        echo tongSoDong($conn, $SDT)
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="col-md-12 lienhelan1">
                        <div class="row">
                            <div class="col-md-1">
                                <i class="fa-solid fa-headset labellienhe"></i>
                            </div>
                            <div class="col-md-11"><br>
                                <h5 style="text-align: center; color: red;">LIÊN HỆ LẦN 1</h5>
                                <p class="ndthongkeum">
                                    <?php
                                        $lan=1;
                                        echo tongDongLienHeLan($conn, $SDT, $lan );
                                    ?>
                                    /
                                    <?php
                                        echo tongSoDong($conn, $SDT)
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12 lienhelan2">
                        <div class="row">
                            <div class="col-md-1">
                                <i class="fa-solid fa-headset labellienhe"></i>
                            </div>
                            <div class="col-md-11"><br>
                                <h5 style="text-align: center; color: red;">LIÊN HỆ LẦN 2</h5>
                                <p class="ndthongkeum">
                                    <?php
                                        $lan=2;
                                        echo tongDongLienHeLan($conn, $SDT, $lan );
                                    ?>
                                    /
                                    <?php
                                        echo tongSoDong($conn, $SDT)
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="col-md-12 lienhelan3">
                        <div class="row">
                            <div class="col-md-1">
                                <i class="fa-solid fa-headset labellienhe"></i>
                            </div>
                            <div class="col-md-11"><br>
                                <h5 style="text-align: center; color: red;">LIÊN HỆ LẦN 3</h5>
                                <p class="ndthongkeum">
                                    <?php
                                        $lan=3;
                                        echo tongDongLienHeLan($conn, $SDT, $lan );
                                    ?>
                                    /
                                    <?php
                                        echo tongSoDong($conn, $SDT)
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ghi chú cho User manager -->
        <div class="col-md-4">
            <h5 style="text-align: center; color: red;">GHI CHÚ</h5>
            <!-- Form ghi chú -->
            <form action="#" method="post">
                <!-- Thêm ghi chú -->
                <div class="row">
                    <form action="../function/functionThongKe.php" method="post">
                        <div class="col-md-9">
                            <input type="text" name="ghichu" placeholder="Thêm ghi chú" style="width: 99%;">
                        </div>
                        <div class="col-md-3">
                            <button class="btn-success shadow-none" name="themghichu" style="width: 99%;">
                                <i class="fa-solid fa-plus"></i>&nbsp;Mới</button>
                        </div>
                    </form>
                </div>
                <hr>
                <div class="formghichu">
                    <?php
                        $sql="SELECT * FROM ghichu WHERE SDT= '".$user."'";
                        $qr= mysqli_query($conn, $sql);
                        $mangghichu= mysqli_fetch_array($qr);

                        if(!empty($mangghichu)){
                            $i=0;
                            while ($rows= mysqli_fetch_array($qr)) {
                            $i++;
                    ?>
                    <input type="checkbox" name="ghichu" <?php if($rows['TRANGTHAI'] == 1) echo "checked"?>>
                    <label><?php echo $rows['NOIDUNG']?></label>
                    <a href="usermanager.php?route=xoaghichu&ID= <?php echo $rows['STT']?>">Xóa</a><br>
                    <?php
                            }
                        }else {
                            echo "Chưa có ghi chú nào!";
                        }
                    ?>
                </div><br>
            </form>
            <hr>

            <!-- Lịch loại 2 -->
            <div class="lichthang">
                <script type="text/javascript" language="JavaScript"
                    src="http://www.informatik.uni-leipzig.de/~duc/amlich/JavaScript/amlich-hnd.js">
                </script>
                <script language="JavaScript">
                setOutputSize("small");
                document.writeln(printSelectedMonth());
                </script>
            </div>
        </div>
    </div>
</div>