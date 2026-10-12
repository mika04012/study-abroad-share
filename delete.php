<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$dsn = 'mysql:dbname=tb280710db;host=localhost';
$user = 'tb-280710';
$password = '********';

$pdo = new PDO($dsn, $user, $password,
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)
);

if (isset($_GET["id"])) {

    $id = $_GET["id"];

    $sql = "DELETE FROM posts
            WHERE id = :id AND user_id = :user_id";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $_SESSION["user_id"], PDO::PARAM_INT);

    $stmt->execute();
}

header("Location: index.php");
exit;

?>
