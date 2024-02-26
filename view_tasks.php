<?php 
    include('config.php');
    session_start();

    if(isset($_GET['id']))
    {
        $task_id = $_GET['id'];

        // connect to the database
        $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_connect_error());

        // select database
        $db_select = mysqli_select_db($conn, DB_NAME) or die($mysqli_connect_error());

        // create sql query
        $sql = "SELECT * FROM tasks WHERE id = $task_id";

        // execute query
        $res = mysqli_query($conn, $sql);

        // check whether the query is executed or not 
        if($res==true)
        {
            // fetch the task data
            $row = mysqli_fetch_assoc($res);
            $id = $row['id'];
            $title = $row['title'];
            $description = $row['description'];
            $priority = $row['priority'];
            $due_date = $row['due_date'];
        }
        else
        {
            // task not found
            $_SESSION['view_task_fail'] = "Task not found.";
            header('location:'.SITEURL);
            exit();
        }
    }
    else
    {
        // redirect to homepage
        header('location:'.SITEURL);
        exit();
    }
?>

<html>
    <head>
        <title>View Task</title>
        <link rel="stylesheet" href="<?php echo SITEURL; ?>style.css" />
    </head>
    <body>
    <div class="wrapper">
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
    </div>
    </body>
</html>