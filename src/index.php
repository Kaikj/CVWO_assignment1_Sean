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

        <!-- Bootstrap core CSS -->
        <link href="styles/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="styles/css/navbar-fixed-top.css" rel="stylesheet">

    </head>
    <body>
        <?php include 'menu.php';?>


        <?php
        $prep_stmt = 'SELECT postID, postTitle, postDesc, postDate FROM posts ORDER BY postID DESC LIMIT ?, ?';
        if ($stmt = $mysqli->prepare($prep_stmt)) {
            $stmt->bind_param('ii', $from_postnumber, $blog_postnumber);
            $stmt->execute();
            $result = $stmt->get_result();
            // fetch associative array
            while($row = $result->fetch_assoc()) {
                echo '<div class="container">';
                    echo '<h1><a href="viewpost.php?id='.$row['postID'].'">'.$row['postTitle'].'</a></h1>';
                    echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row['postDate'])).'</p>';
                    echo '<p>'.$row['postDesc'].'</p>';
                    echo '<p><a href="viewpost.php?id='.$row['postID'].'">Read More</a></p>';
                echo '</div>';
            }
        }

        $query_num = 'SELECT * FROM posts';
        if ($num_result = $mysqli->query($query_num)) {
            $total_results = $num_result->num_rows;
            $total_pages = ceil($total_results / $blog_postnumber);
        }
        if ($page > 1) {
            $prev = ($page - 1);
            echo "<a href=\"index.php?page=$prev\">&lt;&lt;  Newer</a> ";
        }
        for($i = 1; $i <= $total_pages; $i++) {
            if ($page == $i) {
                echo "$i ";
                }
                else {
                   echo "<a href=\"index.php?page=$i\">$i</a> ";
                }
        }
        if ($page < $total_pages) {
           $next = ($page + 1);
           echo "<a href=\"index.php?page=$next\">Older &gt;&gt;</a>";
        }
        ?>

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="styles/js/bootstrap.min.js"></script>

    </body>
</html>
