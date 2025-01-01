<?php include("Config/Constant.php");?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up Page</title>
    <link rel="stylesheet" href="CSS/Login.css">
</head>
<body>

    <div class="login" align="center">
        <h1 align="center">Login</h1>
        <br>

        <?php
            if(isset($_SESSION['login'])) {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }

            if(isset($_SESSION['not-logged-in'])) {
                echo $_SESSION['not-logged-in'];
                unset ($_SESSION['not-logged-in']);
            }
        ?>
        <br>

        <form action="" method="POST">
        First name:
        <input type="text" name="first_name" placeholder="Enter first name"><br><br>
        Last name:
        <input type="text" name="last_name" placeholder="Enter last name"><br><br>
        E-mail:
        <input type="text" name="email" placeholder="Enter E-mail"><br><br>
        Phone number 
        <input type="number" name="phone" placeholder="Enter number">
        <br><br>
        Password:
        <input type="password" name="password" placeholder="Enter Password">
        <br><br>
        <input type="submit" name="submit" value="Login">
        </form>
    </div>
</body>
</html>

<?php

// Check if the submit button is clicked
if (isset($_POST['submit'])) {
    
    // Get the data from the form
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = md5($_POST['password']); // Password Encryption with MD5

    // SQL Query to check if the user email and password exists or not
    $sql = "INSERT INTO customer SET
        First_Name = '$first_name',
        Last_Name = '$last_name',
        Phone = '$phone',
        Email = '$email',
        Password = '$password'

    ";
    // Execute the Query
    $result = mysqli_query($conn, $sql);

    if($result == TRUE)
    {
        // Data Inserted
        // Create a Session Variable to Display Message
        $_SESSION['add'] = "<div style=\"color: green\"><strong>Welcome!</strong></div>";

        // Redirect to Manage Admin Page
        header("location:".HOMEURL.'login.php');

    }
    else
    {
        // Failed to Insert Data
        // Create a Session Variable to Display Message
        $_SESSION['add'] = "Failed To sign up!";

        // Redirect to Manage Admin Page
        header("location:".HOMEURL.'signUp.php');
    }
}

?>