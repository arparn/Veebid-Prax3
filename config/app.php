<?php

//We check whether we are running the code locally or on live server

if ('127.0.0.1' == $_SERVER['REMOTE_ADDR']) {
    //Local server configuration. These are for local test database only so right now I do not care putting it up to Git,
    //Otherwise passwords should not be shared on Git
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', 'parool');
    define('DB_BASE', 'prax3');
} else {
    //Live server configuration
    define('DB_HOST', 'localhost');
    define('DB_USER', 's_arparn');
    define('DB_PASS', 'aVAJRlh2');
    define('DB_BASE', 'arparn');
}


