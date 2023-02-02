<?php
session_start();
include "../connect/config.php";
if (isset($_POST['login'])) {
    $username = $_POST['tendangnhap'];
    $password = $_POST['matkhau'];
    if(isset($_POST['remember_me'])) {
        setcookie('user', $username, time()+3600, '/','', 0,0);
        setcookie('pass', $password, time()+3600, '/','', 0,0);
    }
    $password = md5($password);
    if (!$username || !$password) {
        echo "Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu. <a href='javascript: history.go(-1)'>Trở lại</a>";
        exit;
    }
    $sql = "SELECT * FROM taikhoan WHERE TENDANGNHAP = '$username' AND MATKHAU = '$password'";
    $query = $conn->query($sql);
    $numrow = mysqli_fetch_array($query);
    
    if ($numrow['SDT'] != '' && empty($numrow['MAADMIN'])) {
        $row = mysqli_fetch_array($query);
        $_SESSION['login'] = $numrow['SDT'];
        $user= $numrow['SDT'];
        $sql1="insert into thoigiandangnhap values('','','$user',now(),'','') ";
        mysqli_query($conn,$sql1);
        header("Location: ../page/usermanager.php");
    } else if ($numrow['MAADMIN'] != '' && empty($numrow['SDT'])) {
        $_SESSION['login'] = $numrow['MAADMIN'];
        $user= $numrow['MAADMIN']; 
        $sql2="insert into thoigiandangnhap values('','$user','',now(),'','')";
        mysqli_query($conn,$sql2);
        header("Location: ../page/admin.php");
    } else {
        header("Location:index.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Login Form</title>
    <link rel="stylesheet" href="css/style.css">
    <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>

<body>
    <section class="container">
        <div class="login">
            <h1>ĐĂNG NHẬP</h1>

            <!-- Logoweb -->
            <div>
                <img src="../images/iconLogo.png" alt="logowweb" style="width: 100%; height: 100px;">
            </div><br>

            <!-- Form đăng nhập -->
            <form method="post" action="index.php">
                <p><input type="text" name="tendangnhap"
                        value="<?php if(isset($_COOKIE['user'])) echo $_COOKIE['user']; ?>" placeholder="Tên đăng nhập">
                </p>
                <p><input type="password" name="matkhau"
                        value="<?php if(isset($_COOKIE['pass'])) echo $_COOKIE['pass']; ?>" placeholder="Mật khẩu"></p>
                <p class="remember_me">
                    <label>
                        <input type="checkbox" name="remember_me"
                            value="<?php if(isset($_COOKIE['user'])) echo "checked"; ?>" id="remember_me">
                        Ghi nhớ đăng nhập
                    </label>
                </p>
                <p class="submit"><input type="submit" name="login" value="Đăng nhập"></p>
            </form>
        </div>
    </section>
</body>

</html>