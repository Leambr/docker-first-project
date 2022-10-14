<?php
session_start();
require('../partials/header.php');
?>


<a href="../includes/logout.inc.php">Log out</a>
<h1>Welcome on your profile <?= $_SESSION['username'] ?></h1>


<?php
require('../partials/footer.php');
?>