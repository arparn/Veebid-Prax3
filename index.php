<?php

require_once 'includes/utils.php';
require_once 'includes/auth.php';
require_once 'includes/db.php';

if (post('action') == 'do_login') {

    $email = post('email');
    $password = post('password');

    if (auth_login($email, $password)) {
        redirect('/prax3/myPage.php');
    }

}

?>

<?php include 'components/header.php'; ?>
<!-- CONTENT -->
<div>

    <h1>Login</h1>

    <p>Do not have an account? <a href="registration.php">Please register</a></p>

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
        <div>
            <label>Email:
                <input type="text" name="email">
            </label>
        </div>

        <div>
            <label>Password:
                <input type="password" name="password">
            </label>
        </div>

        <div>
            <input type="submit" value="Login">
        </div>

    </form>

</div>
<!-- /CONTENT -->
<?php include 'components/footer.php'; ?>
