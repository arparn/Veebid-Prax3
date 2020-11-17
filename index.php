<?php

require_once 'includes/utils.php';
require_once 'includes/auth.php';
require_once 'includes/db.php';

if (post('action') == 'do_login') {

    $email = htmlspecialchars(post('email'));
    $password = htmlspecialchars(post('password'));

    if (auth_login($email, $password)) {
        redirect('/prax3/myPage.php');
    }
}

?>

<?php include 'components/header.php'; ?>
<!-- CONTENT -->
<div class="main_div_login">
    <h1>Login</h1>

    <div class="login">
    <p>Do not have an account? <a href="registration.php"><strong>Please register</strong></a></p>

    <br>

    <form method="post">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert <?php echo $_SESSION['type'] ?>">
                <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                unset($_SESSION['type']);
                ?>
            </div>
        <?php endif;?>
        <input type="hidden" name="action" value="do_login">
        <label>Email:
            <input type="text" name="email" style="margin-left: 30px">
        </label>
        <br>
        <br>
        <label>Password:
            <input type="password" name="password">
        </label>
        <br>
        <input class="button" type="submit" value="Login">
    </form>
    </div>
</div>
<!-- /CONTENT -->
<?php include 'components/footer.php'; ?>
