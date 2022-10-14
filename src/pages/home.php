<?php
session_start();
require('../includes/pdo.php');


$submit = filter_input(INPUT_POST, 'submit');
$post = filter_input(INPUT_POST, 'post');
$user_id = $_SESSION['id'];


if (isset($submit)) {
    if (!empty($post)) {
        $insertPostData = $pdo->prepare("INSERT INTO posts (content, user_id) VALUES (:post, :user_id)");
        $insertPostData->execute([
            ":post" => $post,
            ":user_id" => $_SESSION['id'],
        ]);
    }
}

$postsData = $pdo->query("SELECT * FROM posts");
$allPosts = $postsData->fetchAll(PDO::FETCH_ASSOC)
?>

<?php
require('../partials/header.php');
?>


<a href="../includes/logout.inc.php">Log out</a>

<div class="homeWrapper">
    <h1 class="homeTitle">Welcome on your profile <?= $_SESSION['username'] ?></h1>
    <form class="formPost" method="POST">
        <input class="postInput" type="text" name="post" placeholder="Write your post...">
        <input type="submit" value="Publish" name="submit">
    </form>
</div>




<?php
require('../partials/footer.php');
?>