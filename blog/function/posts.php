
    
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
          <li><a href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

      <?php

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/../class/Users.php';
require_once __DIR__ . '/../class/Posts.php';
            
 
if (!isset($_SESSION['user'])){
            header('location:../index.php');
        }
      
        
$title = ltrim(rtrim(filter_input(INPUT_POST,'title', FILTER_SANITIZE_STRING)));
$content = ltrim(rtrim(filter_input(INPUT_POST,'content',FILTER_SANITIZE_STRING)));
$tags = ltrim(rtrim(filter_input(INPUT_POST,'tags',FILTER_SANITIZE_STRING)));
        
$filtered = wordFilter($content);

function wordFilter($content)
{
    //array of undesired words
    $words = array('\bass(es|holes?)?\b', '\bshit(e|ted|ting|ty|head)\b','\bf+u+c+k+\b' , '\ba+s+s+', 'fucker' , 'fuckin');
    $filtered_text = $content;
    foreach($words as $word)
    {
        $match_count = preg_match_all('/' . $word . '/i', $content, $matches);
        for($i = 0; $i < $match_count; $i++)
            {
                $new = trim($matches[0][$i]);
                $filtered_text = preg_replace('/\b' . $new . '\b/', str_repeat("*", strlen($new)), $filtered_text);
            }
    }
    return $filtered_text;
 
}

if ($post->createPost($title , $filtered , $tags))
{
    $post->getMessage();
    header('location:../home.php');
}
else
    {
    echo $post->getMessage();
    echo 'click here to go back ' . '<a href = "../create.php"> go back </a>';
    
    }
?>
        
        <script src="../assets/js/jquery-1.11.1.min.js"></script>
        <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="../assets/js/scripts.js"></script>
           
    </body>
</html>




