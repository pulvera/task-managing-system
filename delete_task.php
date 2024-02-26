<?php 
    include('config.php');

    // check id in url
    if(isset($_GET['id']))
    {
        // delete the task from database
        // get the task id 
        $id = $_GET['id'];

        // conect databases
        $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_connect_error());

        // select database
        $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_connect_error());

        // sql query to delete task
        $sql = "DELETE FROM tasks WHERE id = $id";

        // execute query
        $res = mysqli_query($conn, $sql);

        // check if query executed successfully or not 
        if($res==true)
        {
            //query executed successfully and task deleted
            $_SESSION['delete'] = "Task deleted successfully.";

            // redirect to homepage
            header('location:'.SITEURL);
        }
        else
        {
            // failed to delete task
            $_SESSION['delete_fail'] = "Failed to delete task";

            // redirect to homepage
            header('location:'.SITEURL);
        }
    }
    else
    {
        //redirect to home
        header('location:'.SITEURL);
    }
?>