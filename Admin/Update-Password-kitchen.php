<?php include('Partials/Navigation.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change-Password</h1>
        <br><br>

        <?php
        if(isset($_GET['ID'])){
            $id = $_GET['ID'];
        }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Current Password:</td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current Password">
                    </td>
                </tr>

                <tr>
                    <td>New Password:</td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>

                <tr>
                    <td>Confirm Password:</td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
// Check if the submit button is clicked or not
if (isset($_POST['submit'])) {
    // Get all The data from the Form
    $id = $_POST['id'];
    $current_password = md5($_POST['current_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);
    
    // Create SQL Query to Update Admin
    $sql = "SELECT * FROM kitchen WHERE ID=$id AND Password='$current_password'";

    // Execute the Query
    $result = mysqli_query($conn, $sql);

    // Check if the Query is Executed Successfully
    if ($result == true) {
        //Check data is Available or not
        $count = mysqli_num_rows($result);

        if($count==1){
            // User Exists and Password Can be Changed
            // Check if the New Password and Confirm Password Match
            if($new_password==$confirm_password){
                // Update Password
                $sql2 = "UPDATE kitchen SET
                    Password = '$new_password'
                    WHERE ID = $id
                ";

                // Execute the Query
                $result2 = mysqli_query($conn, $sql2);

                // Check if the Query is Executed Successfully
                if ($result2 == true) {
                    // Display Success Message
                    $_SESSION['change-password'] = "<div style='color: green;'><h3><strong>Password Changed Successfully!</strong></h3></div>";
                    header('location:'.HOMEURL.'admin/manage-kitchen.php');
                }
                else{
                     // Redirect to Manage Admin Page with error message
                    $_SESSION['change-password'] = "<div style='color: red;'><h3><strong>Failed to Change Password!</strong></h3></div>";
                    header('location:'.HOMEURL.'admin/manage-kitchen.php');
                }
            }
            else{
                // Redirect to Manage Admin Page with error message
                $_SESSION['password-not-matched'] = "<div style='color: red;'><h3><strong>Password Did Not Match!</strong></h3></div>";
                header('location:'.HOMEURL.'admin/manage-kitchen.php');
            }
        }
        else{
            // Redirect to Manage Admin Page with error message
            $_SESSION['user-not-found'] = "<div style='color: red;'><h3><strong>User Not Found!</strong></h3></div>";
            header('location:'.HOMEURL.'admin/manage-kitchen.php');
        }
    }

}
?>

<?php include('Partials/Footer.php') ?>
