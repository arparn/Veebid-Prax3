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

function get_users() {
    $query = 'SELECT * FROM users';
    return db_get_list($query);
}

function like_post($post_id, $user_id) {
    $liked_posts = get_liked_posts($user_id);
    $post_liked = false;
    foreach ($liked_posts as $liked_post_id) {
        if ($liked_post_id == $post_id) {
            $post_liked = true;
            break;
        }
    }
    if ($post_liked == false) {
        add_reaction($post_id, $user_id);
    } else {
        delete_like($post_id, $user_id);
    }
}

function get_liked_posts($user_id) {
    $query = 'SELECT * FROM reactions WHERE user_id="%d"';
    $query = sprintf($query, $user_id);
    $all_likes = [];
    $all_reactions = db_get_list($query);
    foreach ($all_reactions as $reaction) {
        $all_likes[] = $reaction->post_id;
    }
    return $all_likes;
}

function get_likes($post_id) {
    $query = 'SELECT * FROM reactions WHERE post_id="%d"';
    $query = sprintf($query, $post_id);
    return db_get_list($query);
}

function add_reaction($post_id, $user_id) {
    $conn = db();
    $query = 'INSERT INTO reactions(post_id, user_id) VALUES("%d", "%d")';
    $query = sprintf($query, $post_id, $user_id);
    mysqli_query($conn, $query) or die('Error');
    $_SESSION['message'] = "Reaction added!";
    $_SESSION['type'] = 'alert-success';
}

function get_posts($user_id) {
    $query = 'SELECT * FROM posts WHERE user_id="%d" ORDER BY created_at DESC';
    $query = sprintf($query, $user_id);
    return db_get_list($query);
}

function get_comments($post_id) {
    $query = 'SELECT * FROM comments WHERE post_id="%d" ORDER BY created_at DESC';
    $query = sprintf($query, $post_id);
    return db_get_list($query);
}

// FETCH ALL USERS WHERE ID IS NOT EQUAL TO MY ID
function all_other_users($my_id){
    $conn = db();
    $query = sprintf('SELECT * FROM users WHERE id!=?');
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $my_id);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        return $result->fetch_all();
    } else {
        $_SESSION['message'] = "Cant get post";
        $_SESSION['type'] = "alert-danger";
        return null;
    }
}

function get_friends($id) {
    $conn = db();
    $query = sprintf("SELECT * FROM friends WHERE first_user_id=? OR second_user_id=?");
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $id, $id);
    $stmt->execute();
    $return_data = [];
    $result = $stmt->get_result();
    $all_users = $result->fetch_all();
    foreach ($all_users as $row) {
        if ($row['1'] == $id) {
            $get_user_query = sprintf('SELECT * FROM users WHERE id=?');
            $get_user_stmt = $conn->prepare($get_user_query);
            $get_user_stmt->bind_param('i', $row['2']);
            $get_user_stmt->execute();
            $res = $get_user_stmt->get_result();
            $return_data[] = $res->fetch_assoc();
        } else {
            $get_user_query = sprintf('SELECT * FROM users WHERE id=?');
            $get_user_stmt = $conn->prepare($get_user_query);
            $get_user_stmt->bind_param('i', $row['1']);
            $get_user_stmt->execute();
            $res = $get_user_stmt->get_result();
            $return_data[] = $res->fetch_assoc();
        }
    }
    return $return_data;
}

function delete_post($post_id) {
    $conn = db();
    $query = 'DELETE FROM posts WHERE id="%d"';
    $query = sprintf($query, $post_id);
    mysqli_query($conn, $query) or die('Error');
    $_SESSION['message'] = "Post Deleted!";
    $_SESSION['type'] = 'alert-success';
}

function delete_like($post_id, $user_id) {
    $conn = db();
    $query = 'DELETE FROM reactions WHERE post_id="%d" AND user_id ="%d"';
    $query = sprintf($query, $post_id, $user_id);
    mysqli_query($conn, $query) or die('Error');
    $_SESSION['message'] = "Reaction removed!";
    $_SESSION['type'] = 'alert-success';
}

function get_post($post_id) {
    $conn = db();
    $query = sprintf('SELECT * FROM posts WHERE id=?');
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $post_id);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    } else {
        $_SESSION['message'] = "Cant get post";
        $_SESSION['type'] = "alert-danger";
        return null;
    }
}


function getCity() {
    $id = $_SESSION['id'];
    $conn = db();
    $query = sprintf('SELECT * FROM users WHERE id=? LIMIT 1');
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
