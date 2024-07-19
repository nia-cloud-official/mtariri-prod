<?php
session_start(); 

if (!isset($_SESSION['name'])) {
    header('Location: ./controllers/auth.php');
    exit(); 
} else {
    header('Location: ./home.php');
    exit(); 
}
?>
