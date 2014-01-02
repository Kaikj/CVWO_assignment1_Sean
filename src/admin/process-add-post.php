<?php

include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

sec_session_start();

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
            $prep_stmt = 'INSERT INTO posts (postTitle,postDesc,postCont,postDate) VALUES (?, ?, ?, ?)';

            if ($insert_stmt = $mysqli->prepare($prep_stmt)) {
                $insert_stmt->bind_param('ssss', $postTitle, $postDesc, $postCont, $postDate);
            }

            // Execute the prepared query.
            if (! $insert_stmt->execute()) {
                header('Location: ../error.php?err=Add post failure: INSERT');
            } else {
                //redirect to index page
                header('Location: index.php?action=added');
                exit;
            }

        }

    }

    //check for any errors
    if(isset($error)){
        foreach($error as $error){
            echo '<p class="error">'.$error.'</p>';
        }
    }
?>
