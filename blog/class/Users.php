<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Users
 *
 * @author Asus
 */
require_once __DIR__ . '/ICreatePDO.php';
class Users implements ICreatePDO {
    private $message ;
    private $name ;
    private $uid ;
    private $pwd ;
    private $email ;
    private $pdo ;
    private static $session = false;
    
    public static function sessionCheck(){
        if(self::$session == true){
            return true ;
        }
        else{
            false ;
    }
    }
    
    public function __construct(Db $db) {
        $this->setPdo($db->getPDO());
        
    }
    
    function getPdo(){
        return $this->pdo;
    }
    
    function getMessage() {
        return $this->message;
    }

    function getEmail() {
        return $this->email;
    }
    
    function getName() {
        return $this->name;
    }

    function getUid() {
        return $this->uid;
    }
    
    
    function setPdo($pdo){
        $this->pdo = $pdo;
    }

    function setMessage($message) {
        $this->message = $message;
    }
    
    function setEmail($email) {
        $this->email = $email;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setUid($uid) {
        $this->uid = $uid;
    }
     
    public static function sessionSet(){
        self::$session = true ;
             
    }
    
    public static function sessionDest(){
        self::$session = false ;
    }

    public function register($name , $email , $uid, $pwd){   
        $this->setName($name);
        $this->setUid($uid);
        $this->setEmail($email);
        $pdo = $this->getPdo();
        if(($this->checkUniqueEmail($email)) || ($this->checkUniqueName($uid))){   
             return false ;
        }
        $newpwd = password_hash($pwd, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO users (name , email , uid , pwd) VALUES (:name ,:email ,:uid ,:pwd)');
        $stmt->bindParam(':name', $name , PDO::PARAM_STR);
        $stmt->bindParam(':email', $email , PDO::PARAM_STR);
        $stmt->bindParam(':uid', $uid , PDO::PARAM_STR);
        $stmt->bindParam(':pwd', $newpwd , PDO::PARAM_STR);
        if($stmt->execute()){          
                   $this->setMessage('User Registered'); 
                   return true; 
        }else{   
            $this->setMessage('Registration failed');
            return false ;
        }}
    
    public function login($email , $pwd){
        $pdo = $this->getPdo();
        if(!is_null($pdo)){
        $stmt = $pdo->prepare('SELECT id, name, email, pwd FROM users WHERE email = :email');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();
       if($user){
           $this->setEmail($email);
           $this->verifyPass($pwd,$user);
           return true;
        }
        else{
            $this->setMessage('Incorrect Email');
             echo $this->getMessage();
       }}
    else{
        $this->setMessage('Connection failed');
        return false ;
    }}
  
    public function logout(){
        self::sessionDest();
        //session_regenerate_id();
        unset($_SESSION['user']);
        return true;
        
    }
    
    public function verifyPass($pwd , $user){
            if(password_verify($pwd, $user['pwd'])){
             self::sessionSet();   
             $this->user = $user ;
                   // session_regenerate_id();
                   $_SESSION['user']['id'] = $user['id'];
                   $_SESSION['user']['name'] = $user['name'];
                   $_SESSION['user']['email'] = $user['email'];
                   $this->setName($user['name']);
                   $this->setEmail($user['email']);
                   $this->setMessage('Welcome');
                   //echo 'welcome ' . $this->getName().$this->getEmail().'<br>';
                    return true; 
        }else{
            $this->setMessage('Password Incorrect');
            return false ;
       }
       
    }
  
    private function checkUniqueEmail($email){
        $pdo = $this->getPdo();
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = :email');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count > 0){
            $this->setMessage('Email already exists');
            return true;
            
        }else{
            return false;
        }
    }
  
    private function checkUniqueName($uid){
        $pdo = $this->getPdo();
        $stmt = $pdo->prepare('SELECT id FROM users WHERE uid = :uid');
        $stmt->bindParam(':uid', $uid, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count > 0){
            $this->setMessage('Username already exists');
            return true ;
        }
        else{
            return false ;
        }
  }
}
