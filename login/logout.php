<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
unset($_SESSION['user']);
header('Location: ' . (isset($_GET['r']) ? '..' . $_GET['r'] : '/login/'));
die('Logged out.');