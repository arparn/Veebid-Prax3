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

if (htmlspecialchars(post('comment'))) {
    $comment = htmlspecialchars(post('comment'));
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

if (post('action') == 'like') {
    $post_id_like = post('post_id_like');
    like_post($post_id_like, $user_id);
}

$comments = get_comments($post_id);

?>

<?php include 'components/header.php'; ?>
    <!-- CONTENT -->
<div class="main_div_login">
    <div class="post">
    <div class="post_content_comments">
        <p><?php echo $post['username']?>:</p>
        <p style="align-self: center"><?php echo $post['content']?></p>
        <p style="align-self: flex-end"><?php echo $post['created_at']?></p>
    </div>
    <form method="post">
        <input type="hidden" name="action" value="like">
        <input type="hidden" name="post_id_like" value="<?php echo $post_id?>">
        <?php $likes = get_likes($post_id)?>
        <input class="button" type="submit" value="Like <?php echo count($likes)?>">
    </form>
    </div>
    <br>
    <a class="linkBtn" style="padding-bottom: 12px; margin-left: 0" href="<?php echo $location?>">Go Back</a>

    <h3>Add Comment:</h3>

    <form method="post">

        <input type="hidden" name="action" value="add_comment">

        <div class="post_area">
            <label>Comment:</label>
            <label>
                <textarea name="comment" rows="6" cols="50"></textarea>
            </label>
        </div>

        <div>
            <input class="button" type="submit" value="Add Comment">
        </div>

    </form>

    <?php if (count($comments) === 0) { ?>
        <h3>This post have no comments yet.</h3>
    <?php } else { ?>
        <h3>All Comments:</h3>
        <ul class="posts">
            <?php foreach ($comments as $previous_comment) { ?>
                <li class="post_comment">
                    <form method="post">
                        <div class="comment">
                        <?php if ($previous_comment->user_id == $_SESSION['id']) { ?>
                            <input type="hidden" name="action" value="delete_comment">
                            <input type="hidden" name="comment_id" value="<?php echo $previous_comment->id; ?>">
                            <p><?php echo $previous_comment->username;?></p>
                            <p style="align-self: center"><?php echo $previous_comment->content; ?></p>
                            <p style="align-self: flex-end"><?php echo $previous_comment->created_at; ?></p>
                            <input class="button" style="align-self: flex-end" type="submit" value="Delete this comment">
                        <?php } else { ?>
                            <p><?php echo $previous_comment->username;?></p>
                            <p style="align-self: center"><?php echo $previous_comment->content; ?></p>
                            <p style="align-self: flex-end"><?php echo $previous_comment->created_at; ?></p>
                        <?php } ?>
                        </div>
                    </form>
                </li>
                <br>
            <?php } ?>
        </ul>
    <?php } ?>
</div>
<!-- /CONTENT -->
<?php include 'components/footer.php'; ?>