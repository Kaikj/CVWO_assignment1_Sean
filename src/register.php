<?php
include_once '/includes/db_connect.php';
include_once '/includes/functions.php';
include_once '/includes/register.inc.php';

sec_session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Secure Login: Registration Form</title>

        <!-- Bootstrap core CSS -->
        <link href="styles/css/bootstrap.css" rel="stylesheet">
        <!-- Custom styles for login/registration page -->
        <link href="styles/css/signin.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="styles/css/navbar-fixed-top.css" rel="stylesheet">

        <script type="text/JavaScript" src="js/sha512.js"></script>
        <script type="text/JavaScript" src="js/forms.js"></script>
    </head>
    <body>
        <?php include 'menu.php';?>

        <div class="container">
            <!-- Registration form to be output if the POST variables are not
            set or if the registration script caused an error. -->
            <?php
                if (!empty($error_msg)) :
                    echo '<div class="alert alert-danger">';
                        echo $error_msg;
                    echo '</div>';
                endif;

                if (login_check($mysqli) == true) :
                        header('Location: index.php');
                    else :
            ?>
            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"
                    method="post"
                    name="registration_form"
                    class="form-signin">

                <h1 class="form-signin-heading">Register</h1>
                <ul>
                    <li>Emails must have a valid email format</li>
                    <li>Passwords must be at least 6 characters long</li>
                    <li>Passwords must contain
                        <ul>
                            <li>At least one upper case letter (A..Z)</li>
                            <li>At least one lower case letter (a..z)</li>
                            <li>At least one number (0..9)</li>
                        </ul>
                    </li>
                    <li>Your password and confirmation must match exactly</li>
                </ul>

                <input class="form-control"
                       type="text"
                       name="email"
                       id="email"
                       placeholder="Email Address"
                       required
                       autofocus>
                <input class="form-control"
                       type="password"
                       name="password"
                       id="password"
                       placeholder="Password"
                       required>
                <input class="form-control"
                       type="password"
                       name="confirmpwd"
                       id="confirmpwd"
                       placeholder="Confirm Password"
                       required>
                <input type="button"
                       class="btn btn-lg btn-primary btn-block"
                       value="Register"
                       onclick="return regformhash(this.form,
                                       this.form.email,
                                       this.form.password,
                                       this.form.confirmpwd);">
                <p>Already registered? <a href="login.php">Login</a>.</p>
            </form>
            <?php endif; ?>
        </div>
    </body>
</html>
