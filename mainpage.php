<?php
    require "connectdb.php";
    session_start();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mainpage</title>
    <!-- FRAMEWORK BOOTSTRAP -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-lg mb-5">
        <a class="navbar-brand" href="#">Catery</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">ORDER <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php
                            if(!isset($_SESSION["IDLOGIN"])){
                            ?>
                        <a class="dropdown-item" href="login_view.php">Login</a>
                        <a class="dropdown-item" href="sign_view.php">Sign In</a>
                        <?php }else {?>
                        <a class="dropdown-item" href="settingacount_view.php">Setting</a>
                        <a class="dropdown-item" href="logout.php">Logout</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="redirectcatering.php">Login as Catering</a>
                    </div>
                </li>
                <li class="nav-item">
                    <?php
                            $IDLOGIN = $_SESSION["IDLOGIN"];

                            $welcome = "SELECT user_Name FROM user where kd_User = '$IDLOGIN'";
                            $result = mysqli_query($connnectdb, $welcome);
                            $row = mysqli_fetch_array($result);
                        ?>
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Welcome
                        <?= $row['user_Name'];?></a>
                </li>
                <?php }?>
            </ul>
            <form class="form-inline my-2 my-lg-0" method="GET" action="mainpage.php">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" name="search">
                <input type="submit" class="btn btn-outline-success my-2 my-sm-0" value="Search">
            </form>
        </div>
    </nav>
    <?php 
    if(!isset($_GET['search'])){

        $sqlfood = mysqli_query($connnectdb,"SELECT food.kd_Food, food.food_Name, food.food_Description, food.food_Image, food.food_Price, catering.catering_Name from food INNER JOIN catering ON catering.kd_Catering = food.kd_Catering");
    }else{
        $search = $_GET['search'];
        $sqlfood = mysqli_query($connnectdb,"SELECT food.kd_Food, food.food_Name, food.food_Description, food.food_Image, food.food_Price, catering.catering_Name from food INNER JOIN catering ON catering.kd_Catering = food.kd_Catering WHERE food.food_Name LIKE '%".$search."%'");
    }
    while($rowfood = mysqli_fetch_array($sqlfood)){
        ?>
    <div class="container">
        <div class="card" style="width: 18rem;">
            <img src="<?= $rowfood['food_Image']?>" class="card-img-top" alt="...">
            <div class="card-body">
                <form action="checkout_view.php?id=<?= $rowfood['kd_Food']?>" method="get">
                    <h5 class="card-title"><?=$rowfood['food_Name']?></h5>
                    <p class="card-text"><?=$rowfood['catering_Name']?> </p>
                    <p class="card-text"><?=$rowfood['food_Description']?> </p>
                    <p class="card-text">Rp.<?=$rowfood['food_Price']?> </p>
                    <input type="submit" class="btn btn-primary btn-block" value="Edit">
                </form>
            </div>
        </div>
    </div>
    <?php
    }
?>

</body>

</html>