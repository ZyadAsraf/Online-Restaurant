<?php
include("Partials/Navigation.php");
?>
    <!-- Main Content Section Starts -->

    <div class="main-content">
        <div class="wrapper">
            <h1>Manage Kichen Staff</h1>
            <br>

            <?php
            
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
                
            }

            if(isset($_SESSION['delete']))
            {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
                
            }

            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
                
            }
            
            if(isset($_SESSION['user-not-found']))
            {
                echo $_SESSION['user-not-found'];
                unset($_SESSION['user-not-found']);
                
            }

            if(isset($_SESSION['password-not-matched']))
            {
                echo $_SESSION['password-not-matched'];
                unset($_SESSION['password-not-matched']);
                
            }
  
            if(isset($_SESSION['change-password']))
            {
                echo $_SESSION['change-password'];
                unset($_SESSION['change-password']);
                
            }

            ?>



            <a href="Add-kitchen.php" class="btn-success">Add Staff</a>


            <table class="tbl-full">
                <tr>
                    <th>Admin-ID</th>
                    <th>Full-Name</th>
                    <th>Phone</th>
                    <th>E-mail</th>
                    <th>Actions</th>
                </tr>

                <?php
                
                // Query to get all Admin
                $sql = "SELECT * FROM kitchen";

                // Execute the Query
                $result = mysqli_query($conn, $sql);

                // Check whether the Query is Executed of Not
                if($result == TRUE){
                    // Count Rows to check if we have data in database
                    $count = mysqli_num_rows($result); // Function to get all the rows in database

                    //Check Number of Rows
                    $sn = 1;
                    if ($count>0){

                        // There is Data in Database
                        while($rows = mysqli_fetch_assoc($result)){

                        // Using While Loop to get all the Data from Database.
                    //Variabel Name     Column Name in Database
                            $id = $rows['ID'];
                            $first_name = $rows['First_Name'];
                            $last_name = $rows['Last_Name'];
                            $phone = $rows['Phone'];
                            $email = $rows['Email'];
                            
                            // Display the Values in our Table
                            ?>
                            <tr>
                                <td><?php echo($sn++) ?></td>
                                <td><?php echo($first_name." ".$last_name) ?></td>
                                <td><?php echo($phone) ?></td>
                                <td><?php echo($email) ?></td> 
                                <td>
                                <a href="<?php echo HOMEURL; ?>Admin/Update-Password-kitchen.php?ID=<?php echo $id;?>" class="btn-grey"><i class="fa-solid fa-key" style="color: #FFD43B;"></i></a>
                                <a href="<?php echo HOMEURL; ?>Admin/Update-kitchen.php?ID=<?php echo $id;?>" class="btn-secondary"><i class="fa-solid fa-pen"></i></a>
                                <a href="<?php echo HOMEURL; ?>Admin/Delete-kitchen.php?ID=<?php echo $id;?>" class="btn-danger"><i class="fa-regular fa-trash-can"></i></a>
                                </td>
                            </tr>
                            <?php   
                        }
                    }
                    else{
                        // There is No Data in Database
                    }
                } 
            ?>
        </table>

        </div>
    </div>
    <!-- Main Content Section Ends -->

<?php
include("Partials/Footer.php");
?>