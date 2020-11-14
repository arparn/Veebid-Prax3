<?php

require_once 'includes/utils.php';
require_once 'includes/auth.php';


function db() {
    static $conn;
    if ($conn===NULL){
        $conn = mysqli_connect ('localhost', 'root', '', 'prax3');
        $conn->set_charset('utf8');
    }
    return $conn;
}



function db_get_list($query) {
    $conn = db();
    $data = [];
    $res =  mysqli_query($conn, $query) or die(mysqli_error($conn));
    while($row = mysqli_fetch_object($res)) {
        $data[] = $row;
    }
    return $data;
}

function getCity() {
    $id = $_SESSION['id'];
    $conn = db();
    $query = sprintf('SELECT * FROM users WHERE id=?');
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        if ($user['city']) {
            return $user['city'];
        } else {
            return '';
        }
    } else {
        $_SESSION['message'] = "Cant get user";
        $_SESSION['type'] = "alert-danger";
        return '';
    }
}

function getDescription() {
    $id = $_SESSION['id'];
    $conn = db();
    $query = sprintf('SELECT * FROM users WHERE id=?');
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        if ($user['description']) {
            return $user['description'];
        } else {
            return '';
        }
    } else {
        $_SESSION['message'] = "Cant get user";
        $_SESSION['type'] = "alert-danger";
        return '';
    }
}
