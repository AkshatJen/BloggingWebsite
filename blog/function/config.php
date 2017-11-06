<?php
require_once __DIR__ . '/../class/Users.php';
require_once __DIR__ . '/../class/Db.php';
require_once __DIR__ . '/../class/Posts.php';
require_once __DIR__ . '/../class/Comment.php';
session_start();
session_regenerate_id();
define('user', 'root');
define('server', 'localhost');
define('db', 'blog_site');
define('pwd', '');
define('imgtype', 'png');  

$db = new Db();
$user = new Users($db);
$post = new Posts($user);
$comment = new Comment($post);
//$post->search('php');
//$post->pagination('java');
