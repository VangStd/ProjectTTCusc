<div class="col-md-3 sidebarWeb">
    <button class="btn btn-warning shadow-none inconHome" type="button" style="height: 55px; width: 100%; margin-top: 10px; ">
        <a style="text-decoration: none; font-size: 24px;" href="usermanager.php?route=trangchu"><i class="fa-solid fa-house"></i>&nbsp;TRANG CHỦ</a>
    </button>

    <!-- Quản lý dữ liệu -->
    <div class="dropdown itemSidebarWeb" style="margin-top: 30px;">
        <button class="btn btn-warning dropdown-toggle shadow-none" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-database"></i>&nbsp; QUẢN LÝ DỮ LIỆU
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="usermanager.php?route=danhsachdulieu">Danh sách dữ liệu</a></li>
        </ul>
    </div>

    <!-- Thống kê dữ liệu -->
    <div class="dropdown itemSidebarWeb">
        <button class="btn btn-warning dropdown-toggle shadow-none" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-calculator"></i>&nbsp; THỐNG KÊ DỮ LIỆU
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="usermanager.php?route=tkdl-theongay">Thống kê dữ liệu theo ngày</a></li>
            <li><a class="dropdown-item" href="usermanager.php?route=tkdl-theokqkt">TK-DL theo kết quả khai thác</a>
            </li>
            <li><a class="dropdown-item" href="usermanager.php?route=tkdl-theotrangthai">TK-DL theo trạng thái</a></li>
        </ul>
    </div>

    <!-- Tính tổng thời gian đăng nhập -->
    <div class="dropdown itemSidebarWeb">
        <button class="btn btn-warning shadow-none" type="button">
            <a href="usermanager.php?route=tongthoigiandangnhap" style="text-decoration: none; color: white;">
                <i class="fa-solid fa-book"></i>&nbsp; TỔNG THỜI GIAN ĐĂNG NHẬP
            </a>
        </button>
    </div>


    <!-- Xem danh sách hồ sơ -->
    <div class="dropdown itemSidebarWeb">
        <button class="btn btn-warning shadow-none" type="button">
            <a href="usermanager.php?route=danhsachhoso" style="text-decoration: none; color: white;">
                <i class="fa-solid fa-book"></i>&nbsp; XEM DANH SÁCH HỒ SƠ
            </a>
        </button>
    </div>
</div>