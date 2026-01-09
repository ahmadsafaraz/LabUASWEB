<?php
// auth/logout.php

require_once '../config/database.php';
require_once '../classes/User.php';

User::logout();
header('Location: login.php');
exit;
?>