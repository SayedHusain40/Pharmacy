<?php
session_start();
include '../Connection/init.php';

// Fetch the orders from the database
$stmt = $db->prepare("SELECT * FROM `order data`");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
