<?php
include("Partials/Navigation.php");
?>
    <!-- Main Content Section Starts -->

    <div class="main-content">
        <div class="wrapper">
            <h1>Manage-Categories</h1>
            <br><br>

            <?php
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['uplode']))
            {
                echo $_SESSION['uplode'];
                unset($_SESSION['uplode']);
            }

            ?>

            <a href="Add-category.php" class="btn-success">Add Categ</a>


            <table class="tbl-full">
                <tr>
                    <th>Admin-ID</th>
                    <th>Full-Name</th>
                    <th>UserName</th>
                    <th>Actions</th>
                </tr>

                <tr>
                    <td>1.</td>
                    <td>John Doe</td>
                    <td>john123</td>
                    
                    <td>
                    <a href="#" class="btn-secondary"><i class="fa-solid fa-pen"></i></a>
                    <a href="#" class="btn-danger"><i class="fa-regular fa-trash-can"></i></a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <!-- Main Content Section Ends -->

<?php
include("Partials/Footer.php");
?>