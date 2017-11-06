<?php

        require_once __DIR__ . '/function/config.php';
       require_once __DIR__ . '/class/Users.php';
      require_once __DIR__ . '/class/Posts.php';
       if (!isset($_SESSION['user']))
        {
            header('location:index.php');
        }
              

$search = ltrim(rtrim(filter_input(INPUT_GET,'search', FILTER_SANITIZE_STRING)));
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/form-elements.css">
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>
        <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
      <ul class="nav navbar-nav">
          <li><a href="home.php">Home</a></li>
          <li><a href="create.php">Create</a></li>
        
      </ul>
        <form class="navbar-form navbar-left" role="search" action="search.php">
        <div class="form-group">
          <input type="text" class="form-control" name="search" placeholder="Tags,Title,Author" required>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
          <li><a href="function/logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
        
        <?php
        
        

//echo 'Search results for <b>' .  $search . '</b> are shown here' ;
//echo '<br>'. 'click ' . '<i><a href = "home.php"> here </a></i>'. ' to go back';

            $post->search($search);
        
      // $post->pagination('');
      // echo $user->getMessage();
      // echo $_SESSION['user']['email'];
       
        ?>
        
        
      <script src="assets/js/jquery-1.11.1.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/scripts.js"></script>
           
    </body>
</html>

