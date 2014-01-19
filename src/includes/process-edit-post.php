<?php
    include_once '../includes/db_connect.php';
    include_once '../includes/functions.php';

    // If user is not logged in, redirect to login page
    if (!login_check($mysqli)) {
        header('Location: ../login.php');
    }

    //if form has been submitted process it
    if(isset($_POST['submit'])){

        $_POST = array_map( 'stripslashes', $_POST );

        //collect form data
        extract($_POST);

        //very basic validation
        if($postTitle ==''){
            $error[] = 'Please enter the title.';
        }

        if($postDesc ==''){
            $error[] = 'Please enter the description.';
        }

        if($postCont ==''){
            $error[] = 'Please enter the content.';
        }

        if(!isset($error)){

            $postDate = date('Y-m-d H:i:s');
            $prep_stmt = 'UPDATE posts SET postTitle = ?, postDesc = ?, postCont = ? WHERE postID = ?';

            if ($update_stmt = $mysqli->prepare($prep_stmt)) {
                $update_stmt->bind_param('sssi', $postTitle, $postDesc, $postCont, $postID);
            }

            // Execute the prepared query.
            if (! $update_stmt->execute()) {
                header('Location: ../error.php?err=Update post failure: INSERT');
            } else {
                //redirect to manage posts page
                header('Location: manage-posts.php?action=updated');
                exit;
            }

        }

    }

    //check for any errors
    if (isset($error)) {
        foreach($error as $error){
            echo '<div class="alert alert-danger">';
                echo '<p class="error">'.$error.'</p>';
            echo '</div>';
        }
    }
?>
