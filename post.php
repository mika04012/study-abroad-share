<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$dsn = 'mysql:dbname=tb280710db;host=localhost';
$user = 'tb-280710';
$password = 'ZmRV7SRvtJ';

$pdo = new PDO($dsn, $user, $password,
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)
);

// 投稿処理
if (isset($_POST["title"]) && isset($_POST["country"]) && isset($_POST["period"]) && isset($_POST["comment"])) {

    $title = $_POST["title"];
    $country = $_POST["country"];
    $period = $_POST["period"];
    $comment = $_POST["comment"];

    if ($title != "" && $country != "" && $period != "" && $comment != "") {

        $sql = "INSERT INTO posts (user_id, title, country, period, comment, created_at)
                VALUES (:user_id, :title, :country, :period, :comment, :created_at)";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':user_id', $_SESSION["user_id"], PDO::PARAM_INT);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':country', $country, PDO::PARAM_STR);
        $stmt->bindParam(':period', $period, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);

        $date = date("Y-m-d H:i:s");
        $stmt->bindParam(':created_at', $date, PDO::PARAM_STR);

        $stmt->execute();

        echo "投稿しました！";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>留学経験シェア - 新規登録</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<h1>留学経験シェア</h1>

<h2>留学経験を投稿する</h2>

<form action="post.php" method="post">

    <input type="text" name="title" placeholder="タイトル">
    <br><br>

    <input type="text" name="country" placeholder="留学先">
    <br><br>

    <input type="text" name="period" placeholder="留学期間">
    <br><br>

    <textarea name="comment" rows="10" cols="50"
        placeholder="留学経験を入力してください"></textarea>
    <br><br>

    <input type="submit" value="投稿">

</form>

<p>
    <a href="index.php">投稿一覧に戻る</a>
</p>

</body>
</html>