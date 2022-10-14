<?php
session_start();
require('../includes/pdo.php');

$submit = filter_input(INPUT_POST, 'submit');
$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST, 'password');

if (isset($submit)) {
    if (!empty($username) && !empty($password)) {
        $getUsername = $pdo->query("SELECT username FROM users WHERE username = '$username'");
        if ($getUsername->rowCount() > 0) {
            $errorUsername = 'This user already exists!';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $userData = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $userData->execute([
                ":username" => $username,
                ":password" => $hashedPassword,
            ]);

            $id = $pdo->prepare("SELECT id FROM users WHERE username = '$username'");
            $id->execute();
            $id = $id->fetch()['id'];

            $admin = $pdo->prepare("SELECT is_admin FROM users WHERE username = '$username'");
            $admin->execute();
            $admin = $admin->fetch()['is_admin'];

            $_SESSION['username'] = $username;
            $_SESSION['id'] = $id;
            $_SESSION['admin'] = $admin;

            header("Location: ./home.php");
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
    <div class="signUpWrapper">
        <h1 class="signupTitle">Sign up</h1>
        <form class="formWrapper" method="POST">
            <div class="formUsername">
                <input class="formInput" type="text" name="username" placeholder="Username">
            </div>
            <div class="formPassword">
                <input class="formInput" type="password" name="password" placeholder="Password">
            </div>
            <input class="formSubmit, formInput" type="submit" value="Sign in" name="submit">
        </form>
        <p><?php if (isset($errorUsername)) {
                echo $errorUsername;
            } else if (isset($loginError)) {
                echo $loginError;
            } ?>
        </p>
        <div>
            <a href="./login.php">Already have an account? Log in</a>
        </div>
    </div>
</div>
<?php
require('../partials/footer.php');
?>