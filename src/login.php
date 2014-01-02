<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

sec_session_start();

if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Secure Login: Log In</title>

        <!-- Bootstrap core CSS -->
        <link href="styles/css/bootstrap.css" rel="stylesheet">

        <!-- Custom styles for login page -->
        <link href="styles/css/signin.css" rel="stylesheet">

        <script type="text/JavaScript" src="js/sha512.js"></script>
        <script type="text/JavaScript" src="js/forms.js"></script>
    </head>
    <body>
        <?php include('menu.php');?>
        <?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Error Logging In!</p>';
        }
        ?>
        <div class="container">
            <form class="form-signin" action="includes/process_login.php" method="post" name="login_form">
                <h2 class="form-signin-heading">Please sign in</h2>
                <input class="form-control"
                       type="text"
                       name="email"
                       placeholder="Email Address"
                       required
                       autofocus>
                <input class="form-control"
                       type="password"
                       name="password"
                       id="password"
                       placeholder="Password"
                       required>
                <input type="button"
                       class="btn btn-lg btn-primary btn-block"
                       value="Login"
                       onclick="return formhash(this.form, this.form.password);">
                <p>If you don't have a login, please <a href="register.php">register</a></p>
                <p>If you are done, please <a href="includes/logout.php">log out</a>.</p>
                <p>You are currently logged <?php echo $logged ?>.</p>
            </form>
        </div>
    </body>
</html>
