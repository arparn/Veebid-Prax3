<?php

$title = "My first php web page!";
$content = "Hello World!";

/*
 * $_GET
 * $_POST
 * $_FILES
 *
 * $_SESSION
 * $_SERVER
 */

/*
 * MySQL põhilised andmetüübid:
 *
 * integer - täisarv
 * tinyint - piisike täisarv (kuni 128)
 * float - komaga arv
 * varchar - lühem tekst
 * text - pikem text
 * boolean - true/false
 */

$num = 1 + strlen($title);
$num2 = $_GET["num"] ?? 0; # Берем переменную $num из поисковой строки. Try: localhost/prax3/?num=10
$num3 = isset($_GET["num"]) ? $_GET["num"] : 0 # $num2 = $num3

?>


<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Example</title>
        <meta charset="UTF-8">
    </head>

    <body>

        <h1><?php echo $title;?></h1>
        <p><?php echo $content;?></p>

        <h2><?php echo $num;?></h2>

    </body>

</html>