<?php

require_once 'includes/utils.php';
require_once 'includes/db.php';
require_once 'includes/auth.php';

$errors = [];

if (post('action') == 'register') {

    /* Validation */
    if (empty(htmlspecialchars($_POST['name']))) {
        $errors['name'] = 'Please insert your name.';
    }else if(empty(htmlspecialchars($_POST['email']))) {
        $errors['email'] = 'Email is required for registering';
    } else if(empty(htmlspecialchars($_POST['password']))) {
        $errors['password'] = 'You need to provide password';
    }else if(htmlspecialchars($_POST['password']) !== htmlspecialchars($_POST['password1'])) {
        $errors['password'] = 'Passwords do not match';
    } else {

        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);

        $users = get_users();
        $check = true;
        foreach ($users as $user) {
            if ($user->email == $email) {
                $check = false;
                $errors['password'] = 'This email is already registered';
                break;
            }
        }

        if ($check) {
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
}


?>

<?php include 'components/header.php'; ?>
<!-- CONTENT -->
<div class="main_div_register">
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

    <div class="<?php if(isset($errors['name'])) echo ' error' ?>">
        <label>Name:
            <input style="margin-left: 82px" type="text" name="name" value="<?php echo post('name'); ?>">
        </label>
    </div>
    <br>
    <div class="<?php if(isset($errors['email'])) echo ' error' ?>">
        <label>Email:
            <input style="margin-left: 85px" type="text" name="email" value="<?php echo post('email'); ?>">
        </label>
    </div>
    <br>
    <div class="<?php if(isset($errors['password'])) echo ' error' ?>">
        <label>Password:
            <input style="margin-left: 54px" type="password" name="password" value="<?php echo post('password'); ?>">
        </label>
    </div>
    <br>
    <div class="<?php if(isset($errors['password'])) echo ' error' ?>">
        <label>Repeat password:
            <input type="password" name="password1" >
        </label>
    </div>
    <input type="submit" class="button" value="Register">

</form>
</div>

<!-- /CONTENT -->
<?php include 'components/footer.php'; ?>
