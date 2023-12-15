<?php

//connection
$db = new PDO
(
    'mysql:host=127.0.0.1;dbname=lighthouse',
    'dckap',
    'Dckap2023Ecommerce'
);


$id = $_POST['deleteToId'];

try {
    $delete = $db->query("DELETE FROM qa_lighthouse WHERE id = '$id'");
    header("location:/");
} catch (Exception $e) {
    die("Deletion error " . $e->getMessage());
}

require 'index.php';