<nav>
    <ul>
        <li><a href="#">Feed</a></li>
        <li><a href="#">Profile</a></li>
    </ul>

    <ul>
        <?php if (isset($auth_user) && $auth_user == null) { ?>
            <li><a href="login.php">Login</a></li>
        <?php } else { ?>
            <li><a href="logout.php">Login</a></li>
        <?php } ?>
    </ul>
</nav>
