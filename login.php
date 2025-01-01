<?php include("Config/Constant.php");?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login-Page</title>
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
        E-mail: <br>
        <input type="text" name="email" placeholder="Enter E-mail">
        <br><br>
        Password:<br>
        <input type="password" name="password" placeholder="Enter Password">
        <br><br>
        <input type="submit" name="submit" value="Login">
        </form>
        <br><br>
        <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
    </div>
</body>
</html>

<?php

// Check if the submit button is clicked
if (isset($_POST['submit'])) {
    
    // Get the data from the form
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    // SQL Query to check if the user email and password exists or not
    $sql = "SELECT * FROM customer WHERE Email = '$email' AND Password = '$password'";

    // Execute the Query
    $result = mysqli_query($conn, $sql);

    // Count rows to check if the user exists or not
    $count = mysqli_num_rows($result);

    if ($count == 1) {
        // Fetch the user data
        $row = mysqli_fetch_assoc($result);
        
        $_SESSION['login'] = "<div style='color: green;'><h2><strong>Welcome Back!</h2></strong></div>";
        $_SESSION['UID'] = $row['ID']; // Save the user ID in session
        $_SESSION['email'] = $email; // Save the email in session
        $_SESSION['role'] = "customer"; // Set the user role

        header("location:".HOMEURL.'index.php');
    } else {
        $_SESSION['login'] = "<div style='color: red;'><h3><strong>E-mail or Password is incorrect!</strong></h3></div>";
        header("location:".HOMEURL.'login.php');
    }
}

?>