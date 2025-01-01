<?php
include("Partials/Navigation.php");
?>

<div class="main-content">
        <div class="wrapper">
            <h1>Add-staff</h1>
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
                    <td>Phone:</td>
                    <td>
                        <input type="number" name="phone" placeholder="Enter Phone: ">
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
                        <input type="submit" name="submit" value="Save">
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
    $phone = $_POST['phone'];
    $password = md5($_POST['password']); // Password Encryption with MD5


    // SQL Query to Save the data into database
    $sql = "INSERT INTO kitchen SET
        First_Name = '$first_name',
        Last_Name = '$last_name',
        Phone = '$phone',
        Email = '$email',
        Password = '$password'

    ";

    
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));


    // Check whether the data is inserted or not

    if($result == TRUE)
    {
        // Data Inserted
        // Create a Session Variable to Display Message
        $_SESSION['add'] = "<div style=\"color: green\"><strong>staff Added Successfully</strong></div>";

        // Redirect to Manage Admin Page
        header("location:".HOMEURL.'admin/Manage-kitchen.php');

    }
    else
    {
        // Failed to Insert Data
        // Create a Session Variable to Display Message
        $_SESSION['add'] = "Failed To Add staff!";

        // Redirect to Manage Admin Page
        header("location:".HOMEURL.'admin/Add-kitchen.php');
    }


}



?>