<?php
require_once 'includes/utils.php';
require_once 'includes/auth.php';
require_once 'includes/db.php';

if (!is_logged_in()) {
    redirect('index.php');
}

$city = getCity();
$description = getDescription();
$name = $_SESSION['username'];

?>

<?php include 'components/header.php'; ?>
<!-- CONTENT -->
<h1>Hello, <?php echo $name?>, have a nice day!</h1>

<div>
    <h3>City:</h3>
    <?php if ($city == "") {?>
        <p>Not set</p>
    <?php } else { ?>
        <p><?php echo $city?></p>
    <?php } ?>

    <h3>Info about <?php echo $name?>:</h3>
    <?php if ($description == "") {?>
        <p>Not set</p>
    <?php } else { ?>
        <p><?php echo $description?></p>
    <?php } ?>


    <a href="modifyData.php">Change my info</a>
</div>

<div>

    <?php include 'posts.php'; ?>

</div>

<!-- /CONTENT -->
<?php include 'components/footer.php'; ?>

