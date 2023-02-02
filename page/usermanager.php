<?php
    session_start();
    include "../connect/config.php";
    if (isset($_SESSION['login'])){
        $SDT = $_SESSION['login'];
    } else{
        header("Location: ../form/index.php");
    }
  
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="shortcut icon" type="image/png" href="../images/iconLogo.png">

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <link rel="stylesheet prefetch"
        href="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css">
    <title>Usermanager HTQL Tuyển sinh CUSC</title>
</head>

<body>
    <!-- Logo Website -->
    <div class="container logoWeb">
        <img src="../images/logo.png" alt="logoweb">
    </div>

    <!-- Menu Website -->
    <?php
        include('../include/menu.php');
    ?>

    <div class="container-fluid homeWeb">
        <div class="row">
            <!-- Sidebar Website -->
            <?php
                include('../include/sidebarUM.php');
            ?>

            <!-- Main website -->
            <?php
                include('../include/mainUM.php');
                
            ?>
        </div>
    </div>

    <!-- Footer Website -->
    <?php
        include('../include/footer.php');
    ?>


    <script src="../include/javascript.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="../include/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/js/bootstrap.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
</body>

</html>