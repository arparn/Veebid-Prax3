<?php

require_once 'includes/auth.php';

?>

<nav class="menu_div">
    <ul class="menu">
        <li><a href="friends.php">Friends</a></li>
        <li><a href="news.php">News</a></li>
        <li><a href="myPage.php">Profile</a></li>
    </ul>

    <ul class="menu" style="justify-content: flex-end; padding-right: 50px">
        <?php if (!is_logged_in()) { ?>
            <li><a href="index.php">Login</a></li>
        <?php } else { ?>
            <li><a href="logout.php">Logout</a></li>
        <?php } ?>
    </ul>
</nav>
