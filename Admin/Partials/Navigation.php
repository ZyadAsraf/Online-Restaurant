<?php
include("../Config/Constant.php");
include("Login-Check.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Dashboard</title>
    <link rel="stylesheet" href="../CSS/Admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="navigation">
        <div class="wrapper">
            <ul>
                <li><a href="Home.php">Home</a></li>
                <li><a href="Manage-admin.php">Admin</a></li>
                <li><a href="Manage-category.php">Category</a></li>
                <li><a href="Manage-food.php">Food</a></li>
                <li><a href="Manage-kitchen.php">Kitchen staff</a></li>
                <li><a href="Logout.php">Log-Out</a></li>
            </ul>
        </div>
    </div>