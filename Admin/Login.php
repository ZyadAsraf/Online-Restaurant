<?php include("../Config/Constant.php");?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login-Page</title>
    <link rel="stylesheet" href="../CSS/Login.css">
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
    </div>
</body>
</html>

<?php

// Check if the submit button is clicked
if (isset($_POST['submit'])) {
    
    // Get the data from the form
    $email = trim($_POST['email']);
    $password_raw = $_POST['password'];

    // Check for empty fields
    if (empty($email) || empty($password_raw)) {
        $_SESSION['login'] = "<div style='color: red;'><h3><strong>Please Enter Your Email And Password!</strong></h3></div>";
        header("location:" . HOMEURL . 'admin/Login.php');
        exit();
    }

    // Hash the password after checking for empty
    $password = md5($password_raw);

    // Check if the email exists
    $email_check_sql = "SELECT * FROM tbl_admin WHERE Email = '$email'";
    $email_result = mysqli_query($conn, $email_check_sql);

    if (mysqli_num_rows($email_result) == 1) {
        // Email exists, now check the password
        $row = mysqli_fetch_assoc($email_result); // Fetch user data
        if ($row['Password'] == $password) {
            // Email and password match
            $_SESSION['login'] = "<div style='color: green;'><h2><strong>Welcome Back!</strong></h2></div>";
            $_SESSION['email'] = $email;
            $_SESSION['UID'] = $row['ID'];
            $_SESSION['role'] = "admin";
            header("location:" . HOMEURL . 'admin/');
            exit();
        } else {
            // Password incorrect
            $_SESSION['login'] = "<div style='color: red;'><h3><strong>Incorrect Password!</strong></h3></div>";
            header("location:" . HOMEURL . 'admin/Login.php');
            exit();
        }
    } else {
        // Email doesn't exist
        $_SESSION['login'] = "<div style='color: red;'><h3><strong>User Not Found!</strong></h3></div>";
        header("location:" . HOMEURL . 'admin/Login.php');
        exit();
    }
}
?>
