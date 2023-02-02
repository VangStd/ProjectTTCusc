<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="shortcut icon" type="image/png" href="./images/iconLogo.png">
    <title>HTQL Tuyển sinh CUSC</title>
</head>

<body>

    <!-- Menu Website -->
    <div class="body">
        <div class="row1">
            <div class="logoweb">
                <img src="./images/iconLogo.png" alt="logo">
            </div>

            <div class="flex-tracuu">
                <form action="./thongtinkhachhang/thongtinkhachhang.php" method="POST" style=" margin: 5px;">
                    <input class="form-control me-2 shadow-none" name="noidungtim" type="text" placeholder="Vui lòng nhập số điện thoại" style="float: left; width: 400px;   border: 2px solid black;" required>
                    <button class="btn btn-warning shadow-none" name="tracuu" type="submit" style="float: left;"><i class="fa-solid fa-magnifying-glass"></i>Tra cứu</a></button>
                </form>
            </div>

        </div>
        <div class="row" style="width: 1548px;">
            <div class="col-md-12 thongtinfooter">
                <h3>TRUNG TÂM CÔNG NGHỆ PHẦN MỀM ĐẠI HỌC CẦN THƠ</h3>
                <p><i class="fa-solid fa-location-dot"></i>&nbsp; Khu III, Đại Học Cần Thơ, 01 Lý Tự Trọng, Q. Ninh Kiều,
                    TP. Cần Thơ</p>
                <p><i class="fa-solid fa-phone"></i>&nbsp;Điện thoại: 0292 383 5581</p>
                <p>Zalo: 0868 952 535</p>
                <p><i class="fa-solid fa-envelope"></i>&nbsp;Mail: tuyensinh@cusc.ctu.edu.vn</p>
            </div>


            <!--  <div class="row"> -->
            <!-- <div class=" coppyright" style="text-align: center; width:1532px;">
                <h4>CUSC APTECH © 2022</h4>
            </div> -->
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="./include/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/js/bootstrap.min.js"></script>
</body>

</html>