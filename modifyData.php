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


    if (post('city')) {
        $city = htmlspecialchars(post('city'));;
    }
    if (post('description')) {
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

<form method="post">

    <input type="hidden" name="action" value="change_info">

    <div>
        <label>City:
            <input type="text" name="city" value="<?php echo $city?>">
        </label>
    </div>

    <div>
        <label>A few words about yourself:
            <textarea name="description" rows="6" cols="50"><?php echo $description?></textarea>
        </label>
    </div>

    <div>
        <input type="submit" value="Save Changes">
    </div>

</form>

<a href="myPage.php">Back to my page</a>

<!-- /CONTENT -->
<?php include 'components/footer.php'; ?>
