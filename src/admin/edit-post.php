<?php
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

sec_session_start();

// If user is not logged in, redirect to login page
if (!login_check($mysqli)) {
    header('Location: ../login.php');
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin - Edit Post</title>

      <!-- Bootstrap core CSS -->
    <link href="../styles/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../styles/css/navbar-fixed-top.css" rel="stylesheet">

    <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: "textarea",
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        });
    </script>
</head>
<body>

    <?php include('admin_menu.php');?>

    <div class = "container">


    <h2>Edit Post</h2>



    <?php

        $prep_stmt = 'SELECT postID, postTitle, postDesc, postCont FROM posts WHERE postID = ?';

        if ($stmt = $mysqli->prepare($prep_stmt)) {
            $stmt->bind_param('i', $_GET['id']);
            $stmt->execute();
            $stmt->bind_result($postID, $postTitle, $postDesc, $postCont);
            $stmt->fetch();
        }

    ?>

    <form action='process-edit-post.php' method='post'>
        <input type='hidden' name='postID' value='<?php echo $postID;?>'>

        <p><label>Title</label><br />
        <input type='text' name='postTitle' value='<?php echo $postTitle;?>'></p>

        <p><label>Description</label><br />
        <textarea name='postDesc' cols='60' rows='10'><?php echo $postDesc;?></textarea></p>

        <p><label>Content</label><br />
        <textarea name='postCont' cols='60' rows='10'><?php echo $postCont;?></textarea></p>

        <p><input type='submit' name='submit' value='Update'></p>

    </form>

</div>

</body>
</html>
