<?php
    include('config.php');

    // check the task id in url
    if(isset($_GET['id']))
    {
        // get the values from database
        $id = $_GET['id'];

        // connect database
        $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_connect_error());

        //select database
        $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_connect_error());

        // sql query to get the detail of selected task
        $sql = "SELECT * FROM tasks WHERE id=$id";

        //execute query
        $res = mysqli_query($conn, $sql);

        //check if the query executed successfully or not
        if($res==true)
        {
            //query is executed successfully
            $row = mysqli_fetch_assoc($res);

            // get the individual value
            $title = $row['title'];
            $description = $row['description'];
            $priority = $row['priority'];
            $due_date = $row['due_date'];
        }
    }
    else
    {
        // redirect to homepage
        header('location:'.SITEURL);
    }
?>

<html>
    <head>
        <title>Task Manager</title>
    </head>
    
    <body>
        <p>
            <a href="<?php echo SITEURL; ?>">Home</a>
        </p>

        <h3>Update Task Page</h3>

        <p>
            <?php 
                if(isset($_SESSION['update_fail']))
                {
                    echo $_SESSION['update_fail'];
                    unset($_SESSION['update_fail']);
                }
            ?>
        </p>

        <form method="POST" action="">
            <table>
                <tr>
                    <td>Title: </td>
                    <td><input type="text" name="title" value="<?php echo $title; ?>" required="required" /></td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description"><?php echo $description; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Priority: </td>
                    <td>
                        <select name="priority">
                            <option <?php if($priority=="High"){echo "selected='selected'";}?> value="High">High</option>
                            <option <?php if($priority=="Medium"){echo "selected='selected'";}?> value="Medium">Medium</option>
                            <option <?php if($priority=="Low"){echo "selected='selected'";}?> value="Low">Low</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Due Date: </td>
                    <td><input type="date" name="due_date" value="<?php echo $due_date; ?>" /></td>
                </tr>

                <tr>
                    <td><input type="submit" name="submit" value="UPDATE" /></td>
                </tr>
            </table>
        </form>
    </body>
</html>

<?php 
    // check if the button is clicked
    if(isset($_POST['submit']))
    {
        //echo "Clicked";

        // gets the values from form
        $title = $_POST['title'];
        $description = $_POST['description'];
        $priority = $_POST['priority'];
        $due_date = $_POST['due_date'];

        //connect database
        $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_connect_error());

        // select database
        $db_select2 = mysqli_select_db($conn2, DB_NAME) or die(mysqli_connect_error());

        // create sql query to update task
        $sql2 = "UPDATE tasks SET
        title = '$title',
        description = '$description',
        priority = '$priority',
        due_date = '$due_date'
        WHERE
        id = $id
        ";

        //execute query
        $res2 = mysqli_query($conn2, $sql2);

        if($res2==true)
        {
            //query executed and task updated
            $_SESSION['update'] = "Task updated successfully.";
            
            // redirect to homepage
            header('location:'.SITEURL);
        }
        else
        {
            $_SESSION['update_fail'] = "Failed to update task";

            header('locaton:'.SITEURL.'edit_task.php?id='.$id);

        }
    }
?>
