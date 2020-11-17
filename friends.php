<?php
require_once 'includes/utils.php';
require_once 'includes/auth.php';
require_once 'includes/db.php';

if (!is_logged_in()) {
    redirect('index.php');
}

$all_users = all_other_users($_SESSION['id']);
$input = htmlspecialchars(post('name'));
$needed_people = [];



function check_if_friends($my_id, $user_id) {
    $conn = db();
    $query = "SELECT * FROM friends WHERE (first_user_id = ? AND second_user_id = ?) OR (first_user_id = ? AND second_user_id = ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iiii', $my_id, $user_id, $user_id, $my_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $answer = $res->fetch_all();
    if(count($answer) === 1){
        return true;
    }
    else{
        return false;
    }
}

function find_people($all_users, $input) {
    $needed_people = [];
    if ($input == "" || $input == " ") {
        return $needed_people;
    }
    foreach ($all_users as $user) {
        $check = strpos(strtoupper($user['1']), strtoupper($input));
        if ($check === false) {
            $check = strpos(strtoupper($user['5']), strtoupper($input));
        }
        if ($check !== false) {
            $needed_people[] = $user;
        }
    }
    return $needed_people;
}

if (post('action') == 'find_person') {
    $needed_people = find_people($all_users, $input);
}

if (post('action') == 'add_to_friends') {
    $conn = db();
    $query = 'INSERT INTO friends(first_user_id, second_user_id) VALUES("%d", "%d")';
    $query = sprintf($query, $_SESSION['id'], htmlspecialchars(post('person_id')));
    mysqli_query($conn, $query) or die('Error');
    $_SESSION['message'] = "Friend Added!";
    $_SESSION['type'] = 'alert-success';
}

if (post('action') == 'delete_friend') {
    $id = post('person_id_delete');
    $conn = db();
    $query = 'DELETE FROM friends WHERE (first_user_id = ? AND second_user_id = ?) OR (first_user_id = ? AND second_user_id = ?)';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iiii', $_SESSION['id'], $id, $id, $_SESSION['id']);
    $stmt->execute();
    $_SESSION['message'] = "Friend Added!";
    $_SESSION['type'] = 'alert-success';
}

$friends = get_friends($_SESSION['id']);
?>

<?php include 'components/header.php'; ?>
<!-- CONTENT -->

<div class="main_div_login">
<h3>Search by name or city:</h3>
<form method="post">

    <input type="hidden" name="action" value="find_person">

    <div>
        <label>Name/City:
            <input type="text" name="name">
        </label>
    </div>
    <input class="button" type="submit" value="Search">
</form>

<div>
    <?php if (count($needed_people) !== 0) { ?>
        <h3>For your request people found (<?php echo count($needed_people)?>):</h3>
        <ul class="posts">
            <?php foreach ($needed_people as $person) { ?>
                <li class="friend_search">
                    <form method="post">
                        <div>
                            <?php if (!check_if_friends($_SESSION['id'], $person['0'])) {?>
                            <input type="hidden" name="action" value="add_to_friends">
                            <input type="hidden" name="person_id" value="<?php echo $person['0']?>">
                            <p>Name: <?php echo $person['1']?></p>
                            <p>From: <?php echo $person['5']?></p>
                            <p>Description: <?php echo $person['4']?></p>
                            <input class="button" type="submit" value="Add to friends">
                            <?php } else { ?>
                                <p>Name: <?php echo $person['1']?></p>
                                <p>From: <?php echo $person['5']?></p>
                                <p>Description: <?php echo $person['4']?></p>
                                <p><?php echo $person['1']?> is already your friend.</p>
                            <?php } ?>
                        </div>
                    </form>
                </li>
                <br>
            <?php } ?>
        </ul>
    <?php } ?>
</div>

<?php if (count($friends) === 0) { ?>
    <h3>You have no friends yet.</h3>
<?php } else { ?>
    <h3>Your Friends:</h3>
    <div class="posts">
        <?php foreach ($friends as $friend) { ?>
                <div class="friends">
                    <form method="post">
                        <input type="hidden" name="action" value="delete_friend">
                        <input type="hidden" name="person_id_delete" value="<?php echo $friend['id']?>">
                        <p>Name: <?php echo $friend['name']?></p>
                        <p>From: <?php echo $friend['city']?></p>
                        <p>Description: <?php echo $friend['description']?></p>
                        <input class="button" type="submit" value="Delete from friends">
                    </form>
                </div>
                <br>
        <?php } ?>
    </div>
<?php } ?>
</div>

<!-- /CONTENT -->
<?php include 'components/footer.php'; ?>

