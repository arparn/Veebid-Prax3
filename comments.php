<?php

if (!session_id()) {
    session_start();
}

function post($name, $default = false) {
    return $_POST[$name] ?? $default;
}

function get($name) {
    return $_GET[$name] ?? false;
}

function session($name, $default = false) {
    return $_SESSION[$name] ?? $default;
}

if (post('action') == 'add_comment') {
    $_SESSION['comments'][] = post('comment');
}

$comments = session('comments', []);

?>

<?php include  'components/header.php'; ?>
<!-- CONTENT -->

<div>

    <?php if (count($comments) === 0) { ?>
        <h2>You have no comments yet.</h2>
    <?php } else { ?>
        <h2>Previous comments:</h2>

        <ul>
            <?php foreach ($comments as $comment) { ?>
                <li><?php echo $comment; ?></li>
            <?php } ?>
        </ul>

    <?php } ?>


    <h1>All Commentaries:</h1>

    <hr>

    <h2>Add Commentary</h2>

    <form method="post">

        <input type="hidden" name="action" value="add_comment">

        <div>
            <label>Commentary:
                <textarea name="comment" rows="6" cols="50"></textarea>
            </label>
        </div>

        <div>
            <input type="submit" value="Add Commentary">
        </div>

    </form>

</div>

<!-- /CONTENT -->
<?php include 'components/footer.php'; ?>