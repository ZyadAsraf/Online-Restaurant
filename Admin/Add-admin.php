<?php
include("Partials/Navigation.php");
?>

<div class="main-content">
        <div class="wrapper">
            <h1>Add-Admin</h1>
            <br><br>

            <form action="" method="POST">

            <table class="tbl-30">

                <tr>
                    <td>First Name:</td>
                    <td>
                        <input type="text" name="first_name" placeholder="Enter First Name: ">
                    </td>
                </tr>

                <tr>
                    <td>Last Name:</td>
                    <td>
                        <input type="text" name="last_name" placeholder="Enter Last Name: ">
                    </td>
                </tr>

                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" name="username" placeholder="Enter Username: ">
                    </td>
                </tr>

                <tr>
                    <td>E-Mail:</td>
                    <td>
                        <input type="text" name="email" placeholder="Enter E-Mail: ">
                    </td>
                </tr>

                <tr>
                    <td>Password:</td>
                    <td>
                        <input type="password" name="password" placeholder="Enter Password: ">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Save" class=".btn-secondary">
                    </td>
                </tr>

            </table>

            </form>





<?php
include("Partials/Footer.php");


if(isset($_POST['submit']))
{
    // if Button Clicked
    // Get the data from the form
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Password Encryption with MD5


    // SQL Query to Save the data into database
    $sql = "INSERT INTO tbl_admin SET
        First_Name = '$first_name',
        Last_Name = '$last_name',
        User_Name = '$username',
        Email = '$email',
        Password = '$password'

    ";

    
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));


    // Check whether the data is inserted or not

    if($result == TRUE)
    {
        // Data Inserted
        // Create a Session Variable to Display Message
        $_SESSION['add'] = "<strong> Admin Added Successfully </strong>";

        // Redirect to Manage Admin Page
        header("location:".HOMEURL.'admin/Manage-admin.php');

    }
    else
    {
        // Failed to Insert Data
        // Create a Session Variable to Display Message
        $_SESSION['add'] = "Failed To Add Admin!";

        // Redirect to Manage Admin Page
        header("location:".HOMEURL.'admin/Add-admin.php');
    }


}



?>