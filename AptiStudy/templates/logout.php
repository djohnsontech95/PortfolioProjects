<?php
session_start();
// unset the session
session_unset();
// destroy the session
session_destroy();
// redirect the user back to the login page
header('Location: login.php');
?>