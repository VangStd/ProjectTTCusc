<div class="container-fluid footerWeb">
    <div class="row">
        <div class="col-md-2">
            <div class="row luottruycap">
                <h5 style="margin-top: 10px;">SỐ LƯỢT TRUY CẬP</h5>
                <h3><?php   $sl4="select count(*) as tongso from thoigiandangnhap";
                            $kq4=mysqli_query($conn,$sl4);
                            $d4=mysqli_fetch_array($kq4);
                            echo $d4['tongso'];  ?></h3>
                <p>Hôm nay: <?php   $sl4="select count(*) as tongso from thoigiandangnhap where day(dangnhap)=day(now())";
                            $kq4=mysqli_query($conn,$sl4);
                            $d4=mysqli_fetch_array($kq4);
                            echo $d4['tongso'];  ?></p>
                <p>Tuần này: <?php   $sl4="select count(*) as tongso from thoigiandangnhap where week(dangnhap)=week(now())";
                            $kq4=mysqli_query($conn,$sl4);
                            $d4=mysqli_fetch_array($kq4);
                            echo $d4['tongso'];  ?></p>
                <p>Tháng này: <?php   $sl4="select count(*) as tongso from thoigiandangnhap where month(dangnhap)=month(now())";
                            $kq4=mysqli_query($conn,$sl4);
                            $d4=mysqli_fetch_array($kq4);
                            echo $d4['tongso'];  ?></p>
            </div>
        </div>
        <div class="col-md-7 thongtinfooter">
            <h3>TRUNG TÂM CÔNG NGHỆ PHẦN MỀM ĐẠI HỌC CẦN THƠ</h3>
            <p><i class="fa-solid fa-location-dot"></i>&nbsp; Khu III, Đại Học Cần Thơ, 01 Lý Tự Trọng, Q. Ninh Kiều,
                TP. Cần Thơ</p>
            <p><i class="fa-solid fa-phone"></i>&nbsp;Điện thoại: 0292 383 5581</p>
            <p>Zalo: 0868 952 535</p>
            <p><i class="fa-solid fa-envelope"></i>&nbsp;Mail: tuyensinh@cusc.ctu.edu.vn</p>

        </div>

        <div class="col-md-3 thongtinfooter">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3928.7933383849145!2d105.77767954957537!3d10.033905575169303!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a0881f9a732075%3A0xfa43fbeb2b00ca73!2sCUSC%20-%20Cantho%20University%20Software%20Center!5e0!3m2!1svi!2s!4v1654614294824!5m2!1svi!2s"
                width="100%" height="180" style="border:0; margin-top: 10px; " allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 coppyright" style="text-align: center;">
            <h4>CUSC APTECH © 2022</h4>
        </div>
    </div>
</div>