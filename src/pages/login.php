<?php
session_start();
require('../includes/pdo.php');

$submit = filter_input(INPUT_POST, 'submit');
$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST, 'password');

if (isset($submit)) {
    if (!empty($username) && !empty($password)) {
        $getUsername = $pdo->query("SELECT username FROM users WHERE username = '$username'");

        if ($getUsername->rowCount() === 0) {
            $errorUsername = 'Your username or password is incorrect!';
        } else {
            $getHashedPassword = $pdo->prepare("SELECT password FROM users WHERE username = '$username'");
            $getHashedPassword->execute();
            $getHashedPassword = $getHashedPassword->fetch()['password'];

            if (password_verify($password, $getHashedPassword)) {
                $username = $pdo->prepare("SELECT username FROM users WHERE username = '$username'");
                $username->execute();
                $username = $username->fetch()['username'];

                $id = $pdo->prepare("SELECT id FROM users WHERE username = '$username'");
                $id->execute();
                $id = $id->fetch()['id'];


                // faire les user permission

                $_SESSION['username'] = $username;
                $_SESSION['id'] = $id;
                header("Location: ./home.php");
            };
        }
    } else {
        $loginError = 'You need to a enter a username and a password';
    }
}
?>


<?php
require('../partials/header.php');
?>

<div class="wrapper">
    <div class="loginWrapper">
        <h1 class="loginTitle">Log in</h1>
        <form class="formWrapper" method="POST">
            <div class="formUsername">
                <input class="formInput" type="text" name="username" placeholder="Username">
            </div>
            <div class="formPassword">
                <input class="formInput" type="password" name="password" placeholder="Password">
            </div>
            <input class="formSubmit, formInput" type="submit" value="Log in" name="submit">
        </form>
        <p><?php if (isset($loginError)) {
                echo $loginError;
            } else if (isset($errorUsername)) {
                echo $errorUsername;
            } ?>
        </p>
        <div>
            <a href="./signup.php">Don't have an account? Sign in</a>
        </div>
    </div>
</div>
<?php
require('../partials/footer.php');
?>