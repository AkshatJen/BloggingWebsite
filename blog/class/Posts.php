<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Posts
 *
 * @author Asus
 */
require_once __DIR__ . '/ICreatePDO.php';
 class Posts implements ICreatePDO {
    private $content ;
    private $title ;
    private $tags ;
    private $pdo ;
    private $user ;
    private $prohibited ;
    private $time ;
    private $message ;
    private $comment = true ;
    
    public function __construct(Users $user) {
        
        $this->setPdo($user->getPdo());
//      if(($user->sessionCheck())){
//        $this->setPdo($user->getPdo());
//        }
//      else{
//            $this->setMessage('<br>'.'oops seems like you are not connected');
//          }
    }
    
    function getPdo() {
        return $this->pdo ;
    }
    
    function setPdo($pdo){
        $this->pdo = $pdo ;
    }
    
    function setTime($time){
        $this->time = $time ;
    }
    
    function getMessage(){
        return $this->message;
    }
    
    function setMessage($message){
        $this->message = $message ;
    }
   
    function getTime(){
        //echo date("h:i A l jS \of F Y") . "<br>";
        return $this->time ;
    }
    
    function getContent() {
        return $this->content;
    }

    function getTitle() {
        return $this->title;
    }

    function getTags() {
        return $this->tags;
    }

    function getVotes() {
        return $this->votes;
    }

    function getUser() {
        return $this->user;
    }

    function getProhibited() {
        return $this->prohibited;
    }

    function setContent($content) {
        $this->content = $content;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setTags($tags) {
        $this->tags = $tags;
    }

    function setVotes($votes) {
        $this->votes = $votes;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setProhibited($prohibited) {
        $this->prohibited = $prohibited;
    }

        
     function createPost($title , $content , $tags){
        $author = $_SESSION['user']['email'] ;
        $pdo = $this->getPdo();
        date_default_timezone_get('Europe/Dublin');
        if($this->checkTitle($title)){   
             return false ;
        }
        $stmt = $pdo->prepare('INSERT INTO blogs (author , title , tags , content) VALUES (:author ,:title ,:tags ,:content)');
        $stmt->bindParam(':author', $author , PDO::PARAM_STR);
        $stmt->bindParam(':title', $title , PDO::PARAM_STR);
        $stmt->bindParam(':tags', $tags , PDO::PARAM_STR);
        $stmt->bindParam(':content', $content , PDO::PARAM_STR);
        if($stmt->execute()){          
                   $this->setMessage('Posted Successfully'); 
                   return true; 
        }
     }
     
     private function checkTitle($title){
        $pdo = $this->getPdo();
        $stmt = $pdo->prepare('SELECT id FROM blogs WHERE title = :title');
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count > 0){
            $this->setMessage('Title already exists');
            return true;
            
        }else{
            return false;
        }
         
         
     }
     
     function search($param){
     //    if($this->getUser()->sessionCheck()){
         $search = '%'.$param .'%';
         $pdo = $this->getPdo();
         $stmt= $pdo->prepare('SELECT * FROM blogs WHERE tags LIKE :tags OR title LIKE :title OR author LIKE :author');
         $stmt->bindParam(':tags', $search,  PDO::PARAM_STR);
         $stmt->bindParam(':title', $search, PDO::PARAM_STR);
         $stmt->bindParam(':author', $search , PDO::PARAM_STR);
         $stmt->execute();
         $posts = $stmt->fetchAll();
         $count = $stmt->rowCount();
         $this->displayPost($posts);
         //$this->pagination($count,$posts); 
//  }  
     }
     
     private function displayPost($iterator){
         $comment = '<div class="col-sm-8 col-sm-offset-2 form">
             <form class="navbar-form navbar-left" role="comment">
        <div class="form-group">
          <input type="text" name ="comment" class="form-control" placeholder="Comment">
        </div>
        <a href="function/comment.php" class="btn btn-primary btn-xs">Comment</a>
      </form></div>';
         foreach ($iterator as $post) {
         echo'<div class="col-sm-8 col-sm-offset-2 text">';
         echo '<p><h1>' . $post['title'] .'</h1></p>';
         echo '<div class="alert alert-dismissible alert-info"><strong><h4>' . $post['content'] .'</h4></strong></div></div>';
         echo '<div class="col-sm-3 col-sm-offset-2 text"><b>#</b> '. $post['tags']. '<br>';
         echo '<strong>Author</strong> :' . $post['author']. '<br>';
         echo '<strong>Created</strong> ' . $post['date'] . '<br><br>' ;
         echo '</div>';
         echo $comment;
        }
         
     }
     
     public function pagination($param){
          $pdo = $this->getPdo();
         $stmt1= $pdo->prepare('SELECT * FROM blogs');
         $stmt1->execute();
         $count = $stmt1->rowCount();
         
    $search = '%'.$param .'%';
       
    $limit = 5;
    $pages = ceil($count / $limit);

    // What page are we currently on?
    $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
        'options' => array(
            'default'   => 1,
            'min_range' => 1,
        ),
    )));

    // Calculate the offset for the query
    $offset = ($page - 1)  * $limit;

    // Some information to display to the user
    $start = $offset + 1;
    $end = min(($offset + $limit), $count);

    $prevlink = ($page > 1) ? '<a href="?page=1" title="First page">back&laquo;</a> <a href="?page=' . ($page - 1) . '" title="Previous page">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';

    $nextlink = ($page < $pages) ? '<a href="?page=' . ($page + 1) . '" title="Next page">next&rsaquo;</a> <a href="?page=' . $pages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';

    
    // Prepare the paged query
    $stmt = $this->pdo->prepare('
        SELECT
            *
        FROM
            blogs
            WHERE tags LIKE :tags OR title LIKE :title OR author LIKE :author
        ORDER BY
            date DESC
        LIMIT
            :limit
        OFFSET
            :offset
    ');

    $stmt->bindParam(':tags', $search,  PDO::PARAM_STR);
    $stmt->bindParam(':title', $search, PDO::PARAM_STR);
    $stmt->bindParam(':author', $search , PDO::PARAM_STR);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $iterator = new IteratorIterator($stmt);
        
        $this->displayPost($iterator);
   
    } else {
        echo '<p>No results could be displayed.</p>';
    }
    
    // Display the paging information
    //echo '<div id="paging"><p>', $prevlink, ' Page ', $page, ' of ', $pages, ' pages, displaying ', $start, '-', $end, ' of ', $count, ' results ', $nextlink, ' </p></div>';

    echo '<div class="col-sm-8 col-sm-offset-2 text"><p>', $prevlink, $nextlink, ' </p></div>';

} 
     
    
    }