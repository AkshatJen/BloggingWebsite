<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Db
 *
 * @author Asus
 */
require_once __DIR__ . '/../function/config.php';
class Db {
    
private $pdo ;
     
public function __construct() {
    
        try {
        $this->pdo = new PDO('mysql:host='.server.';dbname='. db , user , pwd);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        
    } catch (PDOException $ex) {
        die($ex->getMessage());
    }
}


public function getPDO(){
  return $this->pdo;   
}

}
