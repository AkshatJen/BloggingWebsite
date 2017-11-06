<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Comment
 *
 * @author Asus
 */
class Comment {
    private $user ;
    private $message ;
    private $pdo ;
    private $comment ;
    private $enabled ;
    private $prohibitedCheck ;
    private $post ;
    private static $likes ;
    
    public function __construct(Posts $post) {
        $this->setPdo($post->getPdo());
        
    }
    
    public static function setLikes($static){
        self::$static = $static ;
    }
    
    public static function getLikes(){
        return self::$likes;
    }
    
    public function getUser(){
        return $this->user ;
        
    }
    
    public function setUser($user){
        $this->user = $user ;
    }
   
    function getMessage() {
        return $this->message;
    }

    function getPdo() {
        return $this->pdo;
    }

    function getComment() {
        return $this->comment;
    }

    function getEnabled() {
        return $this->enabled;
    }

    function getProhibitedCheck() {
        return $this->prohibitedCheck;
    }

    function getPost() {
        return $this->post;
    }

    function setMessage($message) {
        $this->message = $message;
    }

    function setPdo($pdo) {
        $this->pdo = $pdo;
    }

    function setComment($comment) {
        $this->comment = $comment;
    }

    function setEnabled($enabled) {
        $this->enabled = $enabled;
    }

    function setProhibitedCheck($prohibitedCheck) {
        $this->prohibitedCheck = $prohibitedCheck;
    }

    function setPost($post) {
        $this->post = $post;
    }
    
    function postComment($content){
        $author = $_SESSION['user']['email'] ;
        $pdo = $this->getPdo();
        date_default_timezone_get('Europe/Dublin');
        $stmt = $pdo->prepare('INSERT INTO comments (author , content) VALUES (:author ,:content)');
        $stmt->bindParam(':author', $author , PDO::PARAM_STR);
        $stmt->bindParam(':content', $content , PDO::PARAM_STR);
        if($stmt->execute()){          
                   $this->setMessage('Posted Successfully'); 
                   return true; 
        }
       
    }


}
