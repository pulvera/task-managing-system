<?php 
    include('config.php');
?>

<html>
    <head>
        <title>Task Management System</title>
    </head>
    <body>
        <h1>Task Manager</h1>
        <a href="<?php echo SITEURL ?>">Home</a>

        <h3>Create Task Page</h3>

        <p>
            <?php
                if(isset($_SESSION['add_fail']))
                {
                    echo $_SESSION['add_fail'];
                    unset($_SESSION['add_fail']);
                } 
            
            ?>
        </p>

        <form method="POST" action="">
            <table>

                <!-- Title -->

                <tr>
                    <td>Title: </td>
                    <td><input type="text" name="title" placeholder="Type your title" required="required"/></td>
                </tr>

                <!-- Description -->

                <tr>
                    <td>Description: </td>
                    <td><textarea name="description" placeholder="Type description"></textarea></td>
                </tr>

                <!-- Priority (Low, Medium, High) -->

                <tr>
                    <td>Priority: </td> 
                    <td>
                        <select name="priority">
                            <option value="High">High</option>
                            <option value="Medium">Medium</option>
                            <option value="Low">Low</option>
                        </select>
                    </td>
                </tr>

                <!-- Due Date -->

                <tr>
                    <td>Due Date: </td>
                    <td><input type="date" name="due_date" /></td>
                </tr>

                <tr> 
                    <td><input type="submit" name="submit" value="SAVE" /></td>
            </table>
        </form>
    </body>

</html>

<?php
    // Check whether the SAVE button is clicked or not 
    if(isset($_POST['submit']))
    {
        //echo "Button Clicked";
        //Get all the Values from Form
        $title = $_POST['title'];
        $description = $_POST['description'];
        $priority = $_POST['priority'];
        $due_date = $_POST['due_date'];

        //Connect Database
        $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_connect_error());

        //Select Database
        $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_connect_error());

        //Create SQL Query to INSERT DATA into Database
        $sql = "INSERT INTO tasks SET
            title = '$title',
            description = '$description',
            priority = '$priority',
            due_date = '$due_date'
        ";

        //Execute Quety
        $res = mysqli_query($conn, $sql);

        //Check whether the query executed successfully or not
        if($res==true)
        {
            //Query executed and task inserted successfully
            $_SESSION['add'] = "Task added successfully.";

            //Redirect to Homepage
            header('location:'.SITEURL);
        }
        else 
        {
            //Failed to add task
            $_SESSION['add_fail'] = "Failed to add task";
            //Redirect to Create Task Page
            header('location:'.SITEURL.'create_task.php');
        }
    }
?>