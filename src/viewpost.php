<?php
include_once 'includes/db_connect.php';

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
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="style/main.css">
</head>
<body>

    <div class = "container">

        <?php
            echo '<div>';
                echo '<h1>'.$row['postTitle'].'</h1>';
                echo '<p>Posted on '.date('jS M Y', strtotime($row['postDate'])).'</p>';
                echo '<p>'.$row['postCont'].'</p>';
            echo '</div>';
        ?>

    </div>


</body>
</html>
