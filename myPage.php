<?php
require_once 'includes/utils.php';
require_once 'includes/auth.php';
require_once 'includes/db.php';

?>

<?php include 'components/header.php'; ?>
<!-- CONTENT -->
<h1>Hello, <?php echo $_SESSION['username']?>, have a nice day!</h1>

<a href="logout.php">Logout</a>

<!-- /CONTENT -->
<?php include 'components/footer.php'; ?>

