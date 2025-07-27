<?php
require_once __DIR__ . "/config/session.php";
require_once $_SESSION["ROOT_PATH"] . "/config/db.php";
require_once $_SESSION["ROOT_PATH"] . "/includes/auth.php";
session_destroy();
header("Location: login.php");
exit();
