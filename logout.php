<?php

require 'includes/utils.php';
require 'includes/auth.php';

//We called the function defined in auth.php
do_logout();

//Let's redirect to previous page
redirect('index.php');
