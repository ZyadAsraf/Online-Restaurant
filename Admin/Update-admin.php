<?php include('Partials/Navigation.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Edit-Admin</h1>
        <br><br>

        <?php
        // Get ID of the Admin
        if (isset($_GET['ID'])) {
            $id = $_GET['ID'];

            // Create SQL Query to Get Admin Details
            $sql = "SELECT * FROM tbl_admin WHERE ID = $id";

            // Execute the Query
            $result = mysqli_query($conn, $sql);

            // Check if the query is executed
            if ($result == true) {
                // Check if admin data is available
                $count = mysqli_num_rows($result);
                if ($count == 1) {
                    // Get Admin Details
                    $row = mysqli_fetch_assoc($result);

                    $first_name = $row['First_Name'];
                    $last_name = $row['Last_Name'];
                    $user_name = $row['User_Name'];
                    $email = $row['Email'];
                } else {
                    // Redirect to Manage Admin Page if no admin found
                    header("location:" . HOMEURL . 'admin/Manage-admin.php');
                    exit;
                }
            } else {
                echo "<div style='color: red;'>Failed to fetch admin details</div>";
            }
        } else {
            header("location:" . HOMEURL . 'admin/Manage-admin.php');
            exit;
        }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>First Name:</td>
                    <td>
                        <input type="text" name="first_name" value="<?php echo $first_name; ?>" required>
                    </td>
                </tr>

                <tr>
                    <td>Last Name:</td>
                    <td>
                        <input type="text" name="last_name" value="<?php echo $last_name; ?>" required>
                    </td>
                </tr>

                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" name="username" value="<?php echo $user_name; ?>" required>
                    </td>
                </tr>

                <tr>
                    <td>E-Mail:</td>
                    <td>
                        <input type="email" name="email" value="<?php echo $email; ?>" required>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {
    // Get all The data from the Update
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $user_name = $_POST['username'];
    $email = $_POST['email'];

    // Create SQL Query to Update Admin
    $sql = "UPDATE tbl_admin SET
            First_Name = '$first_name',
            Last_Name = '$last_name',
            User_Name = '$user_name',
            Email = '$email'
            WHERE ID = $id";

    // Execute the Query
    $result = mysqli_query($conn, $sql);

    // Check if the Query is Executed Successfully
    if ($result == true) {
        $_SESSION['update'] = "<div style='color: green;'><strong>Admin Updated Successfully</strong></div>";
        header("location:" . HOMEURL . 'admin/Manage-admin.php');
        exit;
    } else {
        $_SESSION['update'] = "<div style='color: red;'>Failed to Update Admin</div>";
        header("location:" . HOMEURL . 'admin/Manage-admin.php');
        exit;
    }
}
?>

<?php include('Partials/Footer.php') ?>
