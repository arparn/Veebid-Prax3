<?php
require_once 'includes/utils.php';
require_once 'includes/auth.php';
require_once 'includes/db.php';

if (!is_logged_in()) {
    redirect('index.php');
}

$post_id = $_GET['post_id'] ?? 0;
$location = $_GET['location'] ?? 0;
$post = get_post($post_id);

$user_id = $_SESSION['id'];
$username = $_SESSION['username'];
$comment = "";

if (post('comment')) {
    $comment = post('comment');
}

if (post("action") == "add_comment") {
    $conn = db();
    $query = 'INSERT INTO comments(post_id, user_id, username, content) VALUES("%d", "%d", "%s", "%s")';
    $query = sprintf($query, $post_id, $user_id, $username, $comment);
    mysqli_query($conn, $query) or die('Error');
    $_SESSION['message'] = "New post added!";
    $_SESSION['type'] = 'alert-success';
}

if (post('action') == "delete_comment") {
    $comment_to_del = post('comment_id');
    $conn = db();
    $query = 'DELETE FROM comments WHERE id="%d"';
    $query = sprintf($query, $comment_to_del);
    mysqli_query($conn, $query) or die('Error');
    $_SESSION['message'] = "Comment Deleted!";
    $_SESSION['type'] = 'alert-success';
}

$comments = get_comments($post_id);

?>

<?php include 'components/header.php'; ?>
    <!-- CONTENT -->
    <div>
        <p><?php echo $post['username']?>:</p>
        <p><?php echo $post['content']?></p>
        <p><?php echo $post['created_at']?></p>
    </div>

    <div>
        <?php if (count($comments) === 0) { ?>
            <h3>This post have no comments yet.</h3>
        <?php } else { ?>
            <h3>All Comments:</h3>
            <ul>
                <?php foreach ($comments as $previous_comment) { ?>
                    <li>
                        <form method="post">
                            <div>
                                <?php if ($previous_comment->user_id == $_SESSION['id']) { ?>
                                    <input type="hidden" name="action" value="delete_comment">
                                    <input type="hidden" name="comment_id" value="<?php echo $previous_comment->id; ?>">
                                    <p><?php echo $previous_comment->username;?>:</p>
                                    <p><?php echo $previous_comment->content; ?></p>
                                    <p><?php echo $previous_comment->created_at; ?></p>
                                    <input type="submit" value="Delete this comment">
                                <?php } else { ?>
                                    <p><?php echo $previous_comment->username;?>:</p>
                                    <p><?php echo $previous_comment->content; ?></p>
                                    <p><?php echo $previous_comment->created_at; ?></p>
                                <?php } ?>
                            </div>
                        </form>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>

        <h3>Add Comment:</h3>

        <form method="post">

            <input type="hidden" name="action" value="add_comment">

            <div>
                <label>Comment:
                    <textarea name="comment" rows="6" cols="50"></textarea>
                </label>
            </div>

            <div>
                <input type="submit" value="Add Comment">
            </div>

        </form>
    </div>
    <a href="<?php echo $location?>">Go Back</a>

<!-- /CONTENT -->
<?php include 'components/footer.php'; ?>