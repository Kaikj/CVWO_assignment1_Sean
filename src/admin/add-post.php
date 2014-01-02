<?php
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

sec_session_start();

// If user is not logged in, redirect to login page
if (!login_check($mysqli)) {
    header('Location: ../login.php');
}
?>
<!DOCTYPE html>
<head>
    <title>Admin - Add Post</title>

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

    <?php include 'admin_menu.php';?>

    <div class = "container">
        <div id="wrapper">

            <h2>Add Post</h2>

            <form action='process-add-post.php' method='post'>

                <p><label>Title</label><br />
                <input type='text' name='postTitle' value='<?php if(isset($error)){ echo $_POST['postTitle'];}?>'></p>

                <p><label>Description</label><br />
                <textarea name='postDesc' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['postDesc'];}?></textarea></p>

                <p><label>Content</label><br />
                <textarea name='postCont' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['postCont'];}?></textarea></p>

                <p><input type='submit' name='submit' value='Submit'></p>

            </form>

        </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="../styles/js/bootstrap.min.js"></script>
</body>
</html>
