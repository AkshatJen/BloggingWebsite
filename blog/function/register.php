


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

        if (isset($_SESSION['user']))
        {
            header('location:../home.php');
        }
//       else
//       {
//            header('location:../index.php');
//       }
    

$name = ltrim(rtrim(filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING)));
$email = ltrim(rtrim(filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL)));
$uid   = ltrim(rtrim(filter_input(INPUT_POST,'uid',FILTER_SANITIZE_STRING)));
$pwd = ltrim(rtrim(filter_input(INPUT_POST,'pwd',FILTER_SANITIZE_STRING)));

if(!empty(($name)&&($email)&&($uid)&&($pwd))){
    
if ($user->register($name,$email,$uid,$pwd))
{
    echo $user->getMessage();
    echo 'Go back and login '. '<a href = "../signup.php"> register </a>';
    
}
else
    {
    echo $user->getMessage();
    echo ' Go back and try again ' . '<a href = "../signup.php"> register </a>';
    
    }
}
?>
        
        <script src="../assets/js/jquery-1.11.1.min.js"></script>
        <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="../assets/js/scripts.js"></script>
           
    </body>
</html>

