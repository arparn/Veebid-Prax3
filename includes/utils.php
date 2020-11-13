<?php
/*
 * A collection of helper functions and utilities
 */


/**
 * Shorthand to redirect user
 *
 * @param $url page or location to be redirected to
 */

function redirect($url) {
    return header('Location: ' . $url);
}


/**
 * Read and return the variable from POST.
 * If variable is not found, then optionally return default value,
 * otherwise return false.
 *
 * @param $name
 * @param false $default
 * @return false|mixed
 */

function post($name, $default = false) {
    return $_POST[$name] ?? $default;
}

/**
 * Read and return the variable from url parameters.
 * If variable is not found, then optionally return default value,
 * otherwise return false.
 *
 * @param $name
 * @param false $default
 * @return false|mixed
 */

function get($name, $default = false) {
    return $_GET[$name] ?? $default;
}

/**
 * Read and return the session variable.
 * If variable is not found, then optionally return default value,
 * otherwise return false.
 *
 * @param $name
 * @param false $default
 * @return false|mixed
 */
function session($name, $default = false) {
    return $_SESSION[$name] ?? $default;
}


/**
 * Escape the string for database insertion
 *
 * @param $str
 * @return string
 */
function escape($str) {
    return trim(mysqli_real_escape_string($str));
}


/**
 * Dump the contents of variable to screen in printable format
 * regardless of variable type.
 *
 * @param $val
 */

function dump($val) {
    echo '<pre>';
    print_r($val);
    echo '</pre>';
}

/**
 * Dump the contents of variable to screen in printable format
 * regardless of variable type and exit the program.
 *
 * @param $val
 */

function dd($val) {
    dump($val);
    exit;
}



