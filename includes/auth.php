<?php

require_once 'includes/db.php';

session_start();

function auth_login($email, $password) {
    //1. Read email and password in plaintext from POST
    //2. Construct a SQL query
    //3. Execute sql query and read the results
    //4. If no results, show login failed error, if success write user to session
    $conn = db();
    $query = sprintf('SELECT * FROM users WHERE email=?');
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        if ($user && password_verify($password, $user['password'])) { // if password matches
            $stmt->close();
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['verified'] = $user['verified'];
            $_SESSION['message'] = "You are logged in!";
            $_SESSION['type'] = 'alert-success';
            return true;
        } else {
            $_SESSION['message'] = "Wrong username / password!";
            $_SESSION['type'] = "alert-danger";
            return false;
        }
    } else {
        $_SESSION['message'] = "Database error. Login failed!";
        $_SESSION['type'] = "alert-danger";
        return false;
    }

}

function do_logout() {
    //Delete user to session
    session_destroy();
    unset($_SESSION['id']);
    unset($_SESSION['username']);
    unset($_SESSION['email']);
    unset($_SESSION['verify']);
    redirect('/prax3/');
}

function is_logged_in() {
    if (auth_get_user() != null) {
        return true;
    } else {
        return false;
    }
}

function auth_get_user() {
    return $_SESSION['username'] ?? null;
}
