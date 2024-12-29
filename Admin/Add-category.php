<?php
include("Partials/Navigation.php");
?>

<div class="main-content">
        <div class="wrapper">
            <h1>Add-Category</h1>
            <br><br>

            <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">

                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Enter Category Title: ">
                    </td>
                </tr>

                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                    <input type="radio" name="active" value="Yes"> Yes
                    <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category">
                    </td>
                </tr>

            </table>

            </form>


<?php
include("Partials/Footer.php");

// Check if submit button is clicked or not
if(isset($_POST['submit']))
{
    // if Button Clicked
    // Get the data from the form
    $title = $_POST['title'];

    // For Radio input, we need to check if the button is selected or not
    if(isset($_POST['featured']))
    {
        // Get the value from form
        $featured = $_POST['featured'];
    }
    else
    {
        // Default Value
        $featured = "No";
    }

    if(isset($_POST['active']))
    {
        // Get the value from form
        $active = $_POST['active'];
    }
    else
    {
        // Default Value
        $active = "No";
    }

    // Check if image is selected or not

    if(isset($_FILES['image']['name']))
    {
        // Upload the Image
        // To upload image we need image name, source path and destination path
        $image_name = $_FILES['image']['name'];

        // Upload the Image only if image is selected
        if($image_name != "")
        {
            // Auto Rename Image
            // Get the extension of the image
            $temp = explode('.', $image_name);
            $ext = end($temp);

            // Rename the Image
            $image_name = "Food_Category_".rand(000, 999).'.'.$ext;
            $source_path = $_FILES['image']['tmp_name'];
            $destination_path = "../Images/Category/".$image_name;

            // Upload the Image
            $upload = move_uploaded_file($source_path, $destination_path);

            // Check if the image is uploaded or not
            if($upload == FALSE)
            {
                // Set Message
                $_SESSION['upload'] = "<div style=\"color: red\"><strong>Failed to Upload Image!</strong></div>";

                // Redirect to Add Category Page
                header("location:".HOMEURL.'admin/Add-category.php');

                // Stop the Process
                die();
            }
        }
    }
    else
    {
        // Don't Upload Image and set the image_name value to blank
        $image_name = "";
    }


    // SQL Query to Save the data into database
    $sql = "INSERT INTO category SET
        Title = '$title',
        Image = '$image_name',
        Featured = '$featured',
        Active = '$active'
    ";

    // Execute the Query and Insert into Database
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));


    // Check whether the data is inserted or not

    if($result == TRUE)
    {
        // Data Inserted
        // Create a Session Variable to Display Message
        $_SESSION['add'] = "<div style=\"color: green\"><strong>Category Added Successfully</strong></div>";

        // Redirect to Manage Category Page
        header("location:".HOMEURL.'admin/Manage-category.php');

    }
    else
    {
        // Failed to Insert Data
        // Create a Session Variable to Display Message
        $_SESSION['add'] = "Failed To Add Category!";

        // Redirect to Manage Category Page
        header("location:".HOMEURL.'admin/Add-category.php');
    }
}



?>