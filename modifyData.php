<?php
require_once 'includes/utils.php';
require_once 'includes/auth.php';
require_once 'includes/db.php';

if (!is_logged_in()) {
    redirect('index.php');
}

$id = $_SESSION['id'];
$city = getCity();
$description = getDescription();

if (post('action') == 'change_info') {


    if (htmlspecialchars(post('city'))) {
        $city = htmlspecialchars(post('city'));;
    }
    if (htmlspecialchars(post('description'))) {
        $description = htmlspecialchars(post('description'));;
    }

    $conn = db();
    $query = 'UPDATE users SET city="%s", description="%s" WHERE id="%d"';
    $query = sprintf($query, $city, $description, $id);
    mysqli_query($conn, $query) or die('Error');

    $_SESSION['message'] = "Information about you was updated!";
    $_SESSION['type'] = 'alert-success';

}

?>

<?php include 'components/header.php'; ?>
<!-- CONTENT -->

<div class="main_div_login">
<form method="post">
<div class="post_area">
    <input type="hidden" name="action" value="change_info">
    <label>City:
        <input type="text" name="city" value="<?php echo $city?>">
    </label>
    <br>
    <label>A few words about yourself:</label>
    <label>
        <textarea name="description" rows="6" cols="50"><?php echo $description?></textarea>
    </label>
</div>
    <input class="button" type="submit" value="Save Changes">
</form>
<br>
<a class="linkBtn" style="padding-bottom: 12px; margin-left: 0" href="myPage.php">Back to my page</a>
</div>

<!-- /CONTENT -->
<?php include 'components/footer.php'; ?>
