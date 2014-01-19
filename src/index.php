<?php
include_once '/includes/db_connect.php';
include_once '/includes/functions.php';

sec_session_start();

$blog_postnumber = 5;

if(!isset($_GET['page'])) {
    $page = 1;
}
else {
    $page = (int)$_GET['page'];
}


$from_postnumber = (($page * $blog_postnumber) - $blog_postnumber);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>My Blog</title>

        <!-- Bootstrap core CSS -->
        <link href="styles/css/bootstrap.css" rel="stylesheet">
        <!-- Bootstrap theme -->
        <link href="styles/css/bootstrap-theme.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="styles/css/navbar-fixed-top.css" rel="stylesheet">

    </head>
    <body>
        <?php include 'menu.php';?>

        <div class="container">
            <?php
                if (isset($_GET['message'])) :
                    echo '<div class="alert alert-success alert-dismissable">';
                        echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                        switch ($_GET['message']) {
                            case "register":
                                echo 'Registeration Successful!';
                                break;
                            case "logout":
                                echo 'Logout Successful!';
                                break;
                            case "login":
                                echo 'Login Successful!';
                                break;
                            case "added":
                                echo 'Post Added!';
                                break;
                            default:
                                echo $_GET['message'];
                        }
                    echo '</div>';
                endif;
            ?>
            <div class="row">
            <?php
                $prep_stmt = 'SELECT postID, postTitle, postDesc, postDate FROM posts ORDER BY postID DESC LIMIT ?, ?';
                if ($stmt = $mysqli->prepare($prep_stmt)) {
                    $stmt->bind_param('ii', $from_postnumber, $blog_postnumber);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    // fetch associative array
                    while($row = $result->fetch_assoc()) {
                        echo '<article class="post-wrapper">';
                            echo '<h1 class="post-title"><a href="viewpost.php?id='.$row['postID'].'">'.$row['postTitle'].'</a></h1>';
                            echo '<div class="post-info">';
                                echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row['postDate'])).'</p>';
                            echo '</div>';
                            echo '<div class="post-content">';
                                echo '<p>'.$row['postDesc'].'</p>';
                            echo '</div>';
                            echo '<p><a href="viewpost.php?id='.$row['postID'].'">Read More >></a></p>';
                        echo '</article>';
                    }
                }
            ?>
            </div>

            <div class="row">
                <?php
                    $query_num = 'SELECT * FROM posts';
                    if ($num_result = $mysqli->query($query_num)) {
                        $total_results = $num_result->num_rows;
                        $total_pages = ceil($total_results / $blog_postnumber);
                    }

                    echo "<div class='col-lg-6'>";
                        if ($page > 1) {
                            $prev = ($page - 1);
                            echo "<a href='index.php?page=$prev' class='btn btn-xs btn-default' role='button'>&lt;&lt;  Newer</a>";
                    }
                    echo "</div>";

                    echo "<div class='col-lg-6'>";
                        for($i = 1; $i <= $total_pages; $i++) {
                            if ($page == $i) {

                                echo "<div class='btn btn-xs btn-default active disabled'>";
                                    echo "$i ";
                                echo "</div>";
                                }
                                else {
                                   echo "<a href='index.php?page=$i' class='btn btn-xs btn-default' role='button'>$i</a>";
                                }
                        }
                    echo "</div>";

                    echo "<div class='col-lg-offset-12'>";
                        if ($page < $total_pages) {
                           $next = ($page + 1);
                           echo "<a href='index.php?page=$next' class='btn btn-xs btn-default' role='button'>Older &gt;&gt;</a>";
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
