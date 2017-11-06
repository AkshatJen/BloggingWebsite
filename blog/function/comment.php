<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

       require_once __DIR__ . '/../class/Users.php';
       require_once __DIR__ . '/../class/Db.php';
       require_once __DIR__ . '/../class/Posts.php';
       require_once __DIR__ . '/../class/Comment.php';
       
       if (!isset($_SESSION['user'])){
            header('location:../index.php');
        }
       
       $comments = ltrim(rtrim(filter_input(INPUT_GET,'comment', FILTER_SANITIZE_STRING)));
   if(!empty($comments)){   
       
   if ($comment->postComment($comments))
{
    $post->getMessage();
    header('location:../home.php');
}
   }
   header('location:../home.php');