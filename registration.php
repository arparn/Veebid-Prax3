<?php

require_once 'includes/auth.php';
require_once 'includes/utils.php';
require_once 'includes/db.php';

$errors = [];

if (post('action') == 'register') {

    $email = $_POST['email'] ?? false;
    $password = $_POST['password'] ?? false;
    $repeat_password = $_POST['password1'] ?? false;

    /* Validation */
    if(false == $email) {
        $errors['email'] = 'Email is required for registering';
    } else if(!$password) {
        $errors['password'] = 'You need to provide password';
    }else if($password != $repeat_password) {
        $errors['password'] = 'Passwords do not match';
    } else {

        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        //We shall get DB connection pointer from a wrapper function
        $conn = db();

        //We shall provide a template for a query. The %s will be cast to string,
        //%d to integer etc. See: https://www.php.net/manual/en/function.sprintf.php
        $query = 'INSERT INTO users(email, password) VALUES("%s", "%s")';

        //We will construct a query here from actual variables
        $query = sprintf($query, $email, $password);

        //Execute the query
        mysqli_query($conn, $query) or die('Error: ' . msqli_error($conn));

        $_SESSION['message'] = "You are registered!";
        $_SESSION['type'] = 'alert-success';

        redirect('/prax3/index.php');
    }
}


?>

<?php include 'components/header.php'; ?>
<!-- CONTENT -->

<h1>Register</h1>

<?php if($errors) { ?>
    <div class="alert error">
        <ul>
            <?php foreach($errors as $error) { ?>
                <li><?php echo $error; ?></li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>

<form method="post">
    <input type="hidden" name="action" value="register">

    <div class="field<?php if(isset($errors['email'])) echo ' error' ?>">
        <label>Email:</label>
        <input type="text" name="email" value="<?php echo post('email'); ?>">
    </div>

    <div class="field <?php if(isset($errors['password'])) echo ' error' ?>">
        <label>Password:</label>
        <input type="password" name="password" value="<?php echo post('password'); ?>">
    </div>


    <div class="field <?php if(isset($errors['password'])) echo ' error' ?>">
        <label>Repeat password:</label>
        <input type="password" name="password1" >
    </div>

    <div class="field">
        <input type="submit" class="button" value="Log In">
    </div>

</form>


<!-- /CONTENT -->
<?php include 'components/footer.php'; ?>
