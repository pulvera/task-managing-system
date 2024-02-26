<?php 
    include('config.php');
    session_start();
?>

<html>
    <head>
        <title>Task Management System</title>
    </head>
    <body>
        <h1>Task Manager</h1>
        <p>
            <?php
                if(isset($_SESSION['add']))
                {
                    echo($_SESSION['add']);
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
                if(isset($_SESSION['delete_fail']))
                {
                    echo $_SESSION['delete_fail'];
                    unset($_SESSION['delete_fail']);
                }
            ?>
        </p>

        <div class="all-tasks">
            <a href="<?php SITEURL: ?>create_task.php">Create Task</a>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Priority</th>
                    <th>Deadline</th>
                    <th>Actions</th>
                </tr>

                <?php
                    //Connect database
                    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_connect_error());

                    //Select database
                    $db_select = mysqli_select_db($conn, DB_NAME) or die($mysqli_connect_error());
                
                    //Create SQL query to get data from database
                    $sql = "SELECT * FROM tasks";

                    //Execute query
                    $res = mysqli_query($conn, $sql);

                    //Check whether the query executed or not 
                    if($res==true)
                    {
                        //Display the tasks from database
                        //Count the tasks on database first 
                        $count_rows = mysqli_num_rows($res);

                        //Check whether there is task in database or not
                        if($count_rows>0)
                        {
                            //Data is in database
                            while($row=mysqli_fetch_assoc($res))
                            {
                                $id = $row['id'];
                                $title = $row['title'];
                                $description = $row['description'];
                                $priority = $row['priority'];
                                $due_date = $row['due_date'];
                                ?>

                                <tr>
                                    <td><?php echo$id; ?></td>
                                    <td><?php echo $title; ?></td>
                                    <td><?php echo $description;?></td>
                                    <td><?php echo $priority; ?></td>
                                    <td><?php echo $due_date; ?></td>
                                    <td>
                                    <a href="<?php echo SITEURL; ?>view_tasks.php?id=<?php echo $id; ?>">View</a>
                                        <a href="<?php echo SITEURL; ?>edit_task.php?id=<?php echo $id; ?>">Update</a>
                                        <a href="<?php echo SITEURL; ?>delete_task.php?id=<?php echo $id; ?>">Delete</a>
                                    </td>
                                </tr>

                                <?php
                            }
                                
                        }
                        else
                        {
                            //No data in database
                            ?>

                            <tr>
                                <td colspan="5">No task added yet.</td>
                            </tr>

                            <?php
                        }
                    }
                ?>
            </table>
        </div>
    </body>
</html>