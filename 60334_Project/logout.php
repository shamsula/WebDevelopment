<?php
    $_SESSION = array();
    setcookie(session_name(), '', time() - 1, '/');
    session_destroy();

header('Location:homepage.php');


?>