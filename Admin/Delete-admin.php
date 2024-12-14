<?php

include('../config/Constant.php');

//get the id of the admin to be deleted
$id = $_GET['ID'];

//Create SQL Query to Delete Admin
$sql = "DELETE FROM tbl_admin WHERE ID = $id";

//Execute the Query
$result = mysqli_query($conn, $sql);

//Check whether the query executed successfully or not

if($result == TRUE){

    //Query Executed Successfully and Admin Deleted
    
    //Create Session Variable to Display Message
    $_SESSION['delete'] = "<div style=\"color: green\"><strong>Admin Deleted Successfully</strong></div>";
    //Redirect to Manage Admin Page
    header('location:'.HOMEURL.'Admin/manage-admin.php');
}
else{
    //Failed to Delete Admin
    $_SESSION['delete'] = "<div style=\"color: red\">Faild to Delete Admin</div>";
    header('location:'.HOMEURL.'Admin/manage-admin.php');
}


?>