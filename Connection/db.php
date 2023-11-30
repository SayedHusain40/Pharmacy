<?php 
$db = new PDO('mysql:host=localhost;dbname=pharmacy;charset=utf8', 'root', '');

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>