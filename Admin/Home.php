<?php
include("Partials/Navigation.php");
?>
    <div class="main-content">
        <div class="wrapper">
            <h1>Admin-Dashboard</h1>
            <br><br>
            <?php
            if(isset($_SESSION['login'])) {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
        ?>
        <br><br>
        </div>
        <div class="col-4 text-center">
            <h1>5</h1>
            <br>
            Categories
        </div>
        <div class="col-4 text-center">
            <h1>5</h1>
            <br>
            Categories
        </div>
        <div class="col-4 text-center">
            <h1>5</h1>
            <br>
            Categories
        </div>
        <div class="col-4 text-center">
            <h1>5</h1>
            <br>
            Categories
        </div>
        <div class="clearfix"></div>
    </div>
<?php
include("Partials/Footer.php");
?>