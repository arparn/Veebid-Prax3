<?php

require_once 'includes/utils.php';
require_once 'includes/db.php';
require_once 'includes/auth.php';

$errors = [];

if (post('action') == 'register') {

    /* Validation */
    if (empty($_POST['name'])) {
        $errors['name'] = 'Please insert your name.';
    }else if(empty($_POST['email'])) {
        $errors['email'] = 'Email is required for registering';
    } else if(empty($_POST['password'])) {
        $errors['password'] = 'You need to provide password';
    }else if($_POST['password'] !== $_POST['password1']) {
        $errors['password'] = 'Passwords do not match';
    } else {

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        //We shall get DB connection pointer from a wrapper function
        $conn = db();

        //We shall provide a template for a query. The %s will be cast to string,
        //%d to integer etc. See: https://www.php.net/manual/en/function.sprintf.php
        $query = 'INSERT INTO users(name, email, password) VALUES("%s", "%s", "%s")';

        //We will construct a query here from actual variables
        $query = sprintf($query, $name, $email, $password);

        //Execute the query
        mysqli_query($conn, $query) or die('Error');

        $_SESSION['message'] = "You are registered!";
        $_SESSION['type'] = 'alert-success';

        redirect('index.php');
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

    <div class="field<?php if(isset($errors['name'])) echo ' error' ?>">
        <label>Name:
            <input type="text" name="name" value="<?php echo post('name'); ?>">
        </label>
    </div>

    <div class="field<?php if(isset($errors['email'])) echo ' error' ?>">
        <label>Email:
            <input type="text" name="email" value="<?php echo post('email'); ?>">
        </label>
    </div>

    <div class="field <?php if(isset($errors['password'])) echo ' error' ?>">
        <label>Password:
            <input type="password" name="password" value="<?php echo post('password'); ?>">
        </label>
    </div>


    <div class="field <?php if(isset($errors['password'])) echo ' error' ?>">
        <label>Repeat password:
            <input type="password" name="password1" >
        </label>
    </div>

    <div class="field">
        <input type="submit" class="button" value="Log In">
    </div>

</form>


<!-- /CONTENT -->
<?php include 'components/footer.php'; ?>
