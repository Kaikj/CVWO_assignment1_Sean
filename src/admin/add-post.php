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
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin - Add Post</title>

        <!-- Bootstrap core CSS -->
        <link href="../styles/css/bootstrap.css" rel="stylesheet">
        <!-- Bootstrap theme -->
        <link href="../styles/css/bootstrap-theme.css" rel="stylesheet">
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

            <?php include '../includes/process-add-post.php'; ?>

            <h2>Add Post</h2>

            <form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' method='post'>

                    <p><label>Title</label><br>
                        <input type='text'
                               class="form-control"
                               name='postTitle'
                               value='<?php if(isset($error)){ echo $_POST['postTitle'];}?>'
                               required
                               autofocus>
                    </p>

                    <p><label>Description</label><br>
                    <textarea name='postDesc'
                              class="form-control"
                              cols='60'
                              rows='10'><?php if(isset($error)){ echo $_POST['postDesc'];}?></textarea>
                    </p>

                    <p><label>Content</label><br>
                    <textarea name='postCont'
                              class="form-control"
                              cols='60'
                              rows='10'><?php if(isset($error)){ echo $_POST['postCont'];}?></textarea>
                    </p>

                    <p><input type='submit'
                              class="btn btn-lg btn-default"
                              name='submit'
                              value='Submit'>
                    </p>

            </form>
        </div>

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="../styles/js/bootstrap.min.js"></script>
    </body>
</html>
