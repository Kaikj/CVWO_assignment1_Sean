<div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Blog</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <?php if (!login_check($mysqli)): ?>
                    <li><p class="navbar-text">Welcome Guest!</p></li>
                    <li><a href="login.php">Login</a></li>

                <?php else: ?>
                    <li><p class="navbar-text">Welcome <?php echo $_SESSION['email']; ?>!</p></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">Posts</li>
                            <li><a href="./admin/manage-posts.php">Manage Posts</a></li>
                            <li><a href="./admin/add-post.php">Add Posts</a></li>
                            <li class="divider"></li>
                            <li class="dropdown-header">Users</li>
                            <li><a href="./admin/users.php">Manage Users</a></li>
                        </ul>
                    </li>
                    <li><a href="includes/logout.php">Logout</a></li>
                <?php endif; ?>
          </ul>
        </div><!-- /.nav-collapse -->
    </div><!-- /.container -->
</div><!-- /.navbar -->
