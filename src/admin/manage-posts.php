<?php
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

sec_session_start();

// If user is not logged in, redirect to login page
if (!login_check($mysqli)) {
    header('Location: ../login.php');
}

//show message from add / edit page
if(isset($_GET['delpost'])){

    $prep_stmt = 'DELETE FROM posts WHERE postID = ?';

    if ($stmt = $mysqli->prepare($prep_stmt)) {
        $stmt->bind_param('i', $_GET['delpost']);
        $stmt->execute();
    }

    header('Location: manage-posts.php?action=deleted');
    exit;
}

?>
<!doctype html>
<html lang="en">
<head>

    <title>Admin</title>
        <!-- Bootstrap core CSS -->
    <link href="../styles/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../styles/css/navbar-fixed-top.css" rel="stylesheet">

    <script language="JavaScript" type="text/javascript">
    function delpost(id, title) {
        if (confirm("Are you sure you want to delete '" + title + "'")) {
            window.location.href = 'manage-posts.php?delpost=' + id;
        }
    }
    </script>
</head>
<body>

    <?php include 'admin_menu.php';?>

    <div class = "container">

    <?php
    //show message from add / edit page
    if(isset($_GET['action'])){
        echo '<h3>Post '.$_GET['action'].'.</h3>';
    }
    ?>

    <table>
    <tr>
        <th>Title</th>
        <th>Date</th>
        <th>Action</th>
    </tr>
    <?php

        $query = 'SELECT postID, postTitle, postDate FROM posts ORDER BY postID DESC';
        if ($result = $mysqli->query($query)) {
            // fetch associative array
            while($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>'.$row['postTitle'].'</td>';
                echo '<td>'.date('jS M Y', strtotime($row['postDate'])).'</td>';
                ?>

                <td>
                    <a href="edit-post.php?id=<?php echo $row['postID'];?>">Edit</a> |
                    <a href="javascript:delpost('<?php echo $row['postID'];?>','<?php echo $row['postTitle'];?>')">Delete</a>
                </td>

                <?php
                echo '</tr>';
            }
        }
    ?>
    </table>

</div>

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="../styles/js/bootstrap.min.js"></script>


</body>
</html>
