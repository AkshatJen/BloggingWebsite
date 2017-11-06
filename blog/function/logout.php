<?php

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/../class/Users.php';


$user->logout();
header('location:../index.php');

