<?php
require_once 'includes/utils.php';
require_once 'includes/auth.php';
require_once 'includes/db.php';

$friends_id = [];
$news = [];

$friends = get_friends($_SESSION['id']);

foreach ($friends as $friend) {
    $friends_id[] = $friend['id'];
}


foreach (db_get_list('SELECT * FROM posts ORDER BY created_at DESC') as $post) {
    foreach ($friends_id as $id) {
        if ($post->user_id == $id) {
            $news[] = $post;
        }
    }
}
?>

<?php include 'components/header.php'; ?>
<!-- CONTENT -->
<div>

    <?php if (count($news) === 0) { ?>
        <h3>You friends have no posts yet.</h3>
    <?php } else { ?>
        <ul>
            <?php foreach ($news as $post) { ?>
                <li>
                    <div>
                        <p><?php echo $post->username; ?></p>
                        <p><?php echo $post->content; ?></p>
                        <p><?php echo $post->created_at; ?></p>
                    </div>
                    <a href="comments.php?post_id=<?php echo $post->id?>&location=news.php">View Comments</a>
                </li>
            <?php } ?>
        </ul>
    <?php } ?>

</div>
<!-- /CONTENT -->
<?php include 'components/footer.php'; ?>
