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
if (isset($_POST['submit'])) {
    // Get all The data from the Update
    $id = $_POST['id'];
    $current_password = md5($_POST['current_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);
    
    // Create SQL Query to Update Admin
    $sql = "SELECT * FROM tbl_admin WHERE ID=$id AND Password='$current_password'"

    // Execute the Query
    $result = mysqli_query($conn, $sql);

    // Check if the Query is Executed Successfully
    if ($result == true) {
        //Check data is Available or not
        $count = mysqli_num_rows($result);

        if($count==1){
            echo"User found";
        }
        else{
            $_SESSION['user-not-found'] = "<div class='error'> User Not Found. </div>";
        }
    }

}
?>

<?php include('Partials/Footer.php') ?>