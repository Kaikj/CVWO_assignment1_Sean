<?php
include_once 'includes/db_connect.php';
include_once '/includes/functions.php';

sec_session_start();

$query = 'SELECT postID, postTitle, postCont, postDate FROM posts WHERE postID = ? LIMIT 1';

if ($stmt = $mysqli->prepare($query)) {
    $stmt->bind_param('i', $_GET['id']);  // Bind "$_GET['id]" to parameter.
    $stmt->execute();    // Execute the prepared query.
    $result = $stmt->get_result();   // Get the result of the query
    $row = $result->fetch_assoc();   // Fetch associative array
}

//if post does not exists redirect user.
if($row['postID'] == ''){
    header('Location: index.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Blog - <?php echo $row['postTitle'];?></title>

        <!-- Bootstrap core CSS -->
        <link href="styles/css/bootstrap.css" rel="stylesheet">
        <!-- Bootstrap theme -->
        <link href="styles/css/bootstrap-theme.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="styles/css/navbar-fixed-top.css" rel="stylesheet">
    </head>
    <body>
        <?php include 'menu.php';?>

        <div class = "container">

            <div class="row">
                <?php
                    echo '<article class="post-wrapper">';
                        echo '<h1 class="post-title">'.$row['postTitle'].'</h1>';
                        echo '<div class="post-info">';
                            echo '<p>Posted on '.date('jS M Y', strtotime($row['postDate'])).'</p>';
                        echo '</div>';
                        echo '<div class="post-content">';
                            echo '<p>'.$row['postCont'].'</p>';
                        echo '</div>';
                    echo '</article>';
                ?>
            </div>

            <div class="row">
                    <?php
                        $query_num = 'SELECT * FROM posts';
                        if ($num_result = $mysqli->query($query_num)) {
                            $total_results = $num_result->num_rows;
                        }
                        $id = $_GET['id'];

                        // Find newer posts
                        $query_new = "SELECT * FROM posts WHERE postID < ? ORDER BY postID DESC LIMIT 1";

                        if ($stmt = $mysqli->prepare($query_new)) {
                            $stmt->bind_param('i', $id);  // Bind "$id" to parameter.
                            $stmt->execute();    // Execute the prepared query.
                            $result = $stmt->get_result();   // Get the result of the query
                            $row = $result->fetch_assoc();   // Fetch associative array
                            $newer = $row['postID'];
                        }

                        // Find older posts
                        $query_old = "SELECT * FROM posts WHERE postID > ? ORDER BY postID LIMIT 1";

                        if ($stmt = $mysqli->prepare($query_old)) {
                            $stmt->bind_param('i', $id);  // Bind "$id" to parameter.
                            $stmt->execute();    // Execute the prepared query.
                            $result = $stmt->get_result();   // Get the result of the query
                            $row = $result->fetch_assoc();   // Fetch associative array
                            $older = $row['postID'];
                        }

                        echo "<div class='col-lg-11'>";
                            if (isset($newer)) {
                                    echo "<a href='viewpost.php?id=$newer' class='btn btn-xs btn-default' role='button'>&lt;&lt;  Newer</a>";
                            }
                        echo "</div>";

                        echo "<div class='col-lg-1'>";
                            if (isset($older)) {
                               echo "<a href='viewpost.php?id=$older' class='btn btn-xs btn-default' role='button'>Older &gt;&gt;</a>";
                            }
                        echo "</div>";
                    ?>
                </div>

        </div>
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="styles/js/bootstrap.min.js"></script>

    </body>
</html>
