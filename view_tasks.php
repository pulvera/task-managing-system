<?php 
    include('config.php');
    session_start();

    if(isset($_GET['id']))
    {
        $task_id = $_GET['id'];

        // Connect to the database
        $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_connect_error());

        // Select database
        $db_select = mysqli_select_db($conn, DB_NAME) or die($mysqli_connect_error());

        // Create SQL query to get data for the specific task
        $sql = "SELECT * FROM tasks WHERE id = $task_id";

        // Execute query
        $res = mysqli_query($conn, $sql);

        // Check whether the query executed or not 
        if($res==true)
        {
            // Fetch the task data
            $row = mysqli_fetch_assoc($res);
            $id = $row['id'];
            $title = $row['title'];
            $description = $row['description'];
            $priority = $row['priority'];
            $due_date = $row['due_date'];
        }
        else
        {
            // Task not found
            $_SESSION['view_task_fail'] = "Task not found.";
            header('location:'.SITEURL);
            exit();
        }
    }
    else
    {
        // Redirect to home if task id is not provided
        header('location:'.SITEURL);
        exit();
    }
?>

<html>
    <head>
        <title>View Task</title>
    </head>
    <body>
        <h1>View Task</h1>

        <p>
            <?php
                if(isset($_SESSION['view_task_fail']))
                {
                    echo $_SESSION['view_task_fail'];
                    unset($_SESSION['view_task_fail']);
                }
            ?>
        </p>

        <div>
            <h2><?php echo $title; ?></h2>
            <p>ID: <?php echo $id; ?></p>
            <p>Description: <?php echo $description; ?></p>
            <p>Priority: <?php echo $priority; ?></p>
            <p>Due Date: <?php echo $due_date; ?></p>
        </div>

        <a href="<?php echo SITEURL; ?>index.php">Back to Tasks</a>
    </body>
</html>