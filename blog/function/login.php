
      
    


<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="../assets/css/form-elements.css">
        <link rel="stylesheet" href="../assets/css/style.css">
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
      
      <ul class="nav navbar-nav navbar-right">
          <li><a href="../index.php">Login</a></li>
      </ul>
    </div>
  </div>
</nav>

            <?php
       require_once __DIR__ . '/config.php';
       require_once __DIR__ . '/../class/Users.php';
       require_once __DIR__ . '/../class/Posts.php';
            
     if (isset($_SESSION['user'])){
            header('location:../home.php');
        } 

      
 
$email = ltrim(rtrim(filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL)));
$pwd = ltrim(rtrim(filter_input(INPUT_POST,'pwd',FILTER_SANITIZE_STRING)));

    
     
     if ($user->login($email,$pwd)){
             $post = new Posts($user);
            header('location:../home.php');
        }
         else{
            $user->getMessage();
            echo ' <br> click ' . '<a href = "../index.php">here!</a>' . ' to go back';
         }
    ?>
        
        <script src="../assets/js/jquery-1.11.1.min.js"></script>
        <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="../assets/js/scripts.js"></script>
           
    </body>
</html>


