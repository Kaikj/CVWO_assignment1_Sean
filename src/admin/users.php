<?php
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

sec_session_start();

// If user is not logged in, redirect to login page
if (!login_check($mysqli)) {
    header('Location: ../login.php');
}

//show message from add / edit page
if(isset($_GET['deluser'])){

    //if user id is 1 ignore
    if($_GET['deluser'] !='1'){
        $prep_stmt = 'DELETE FROM members WHERE id = ?';

        if ($stmt = $mysqli->prepare($prep_stmt)) {
            $stmt->bind_param('i', $_GET['deluser']);
            $stmt->execute();
            header('Location: users.php?action=deleted');
            exit;
        } else {
            header('Location: users.php?error=deleted');
            exit;
        }

    }
}

?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin - Users</title>

        <!-- Bootstrap core CSS -->
        <link href="../styles/css/bootstrap.css" rel="stylesheet">
        <!-- Bootstrap theme -->
        <link href="../styles/css/bootstrap-theme.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="../styles/css/navbar-fixed-top.css" rel="stylesheet">

        <script language="JavaScript" type="text/javascript">
            function deluser(id, title) {
                if (confirm("Are you sure you want to delete '" + title + "'")) {
                    window.location.href = 'users.php?deluser=' + id;
                }
            }
        </script>
    </head>
    <body>

        <?php include 'admin_menu.php';?>

        <div class="container">

            <?php
                //show message from add / edit page
                if(isset($_GET['action'])){
                    echo '<div class="alert alert-success alert-dismissable">';
                        echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                        echo 'User '.$_GET['action'].'.';
                    echo '</div>';
                }
                if(isset($_GET['error'])){
                    echo '<div class="alert alert-danger alert-dismissable">';
                        echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                        echo 'Error: User not '.$_GET['error'].'.';
                    echo '</div>';
                }
            ?>

            <div class="panel panel-default">
                <div class="panel-heading">Manage Users</div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $query = 'SELECT id, email FROM members ORDER BY id';
                            if ($result = $mysqli->query($query)) {
                                // fetch associative array
                                while($row = $result->fetch_assoc()) {
                                    echo '<tr>';
                                        echo '<td>'.$row['email'].'</td>';
                                        ?>

                                        <td>
                                            <a href="edit-user.php?id=<?php echo $row['id'];?>">Edit</a>
                                            <?php if($row['id'] != 1) { ?>
                                                <a href="javascript:deluser('<?php echo $row['id'];?>','<?php echo $row['email'];?>')">Delete</a>
                                            <?php } ?>
                                        </td>

                                    <?php
                                    echo '</tr>';
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="../styles/js/bootstrap.min.js"></script>

    </body>
</html>
