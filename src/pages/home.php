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
?>

<?php
require('../partials/header.php');
?>


<a href="../includes/logout.inc.php">Log out</a>

<div class="wrapper">
    <div class="homeWrapper">
        <h1 class="homeTitle">Welcome on your profile <?= $_SESSION['username'] ?></h1>
        <form class="formPost" method="POST">
            <input class="postInput" type="text" name="post" placeholder="Write your post...">
            <input type="submit" value="Publish" name="submit">
        </form>
        <div class="postsWrapper">
            <?php
            $allPosts = $pdo->query("SELECT id, content, user_id FROM posts");

            while ($post = $allPosts->fetch()) {
                $getPostUsername = $pdo->query("SELECT username FROM users WHERE id = $post[user_id]");
                $getPostUserName = $getPostUsername->fetch()['username'];

            ?>
                <div class="publishedPost">
                    <p class="username">
                        <?= $getPostUserName ?>
                    </p>
                    <p>
                        <?= $post["content"] ?>
                    </p>
                </div>
            <?php } ?>
        </div>
    </div>
</div>


<?php
require('../partials/footer.php');
?>