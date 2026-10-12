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
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>留学経験シェア</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<h1>留学経験シェア</h1>

<p>
    <?php
    echo htmlspecialchars($_SESSION["user_name"], ENT_QUOTES, 'UTF-8');
    ?>
    さん、こんにちは！
</p>

<p>
    <a href="post.php">＋ 留学経験を投稿する</a>
    |
    <a href="logout.php">ログアウト</a>
</p>

<hr>

<h2>みんなの留学経験</h2>

<?php

$sql = "SELECT posts.*, users.name
        FROM posts
        JOIN users ON posts.user_id = users.id
        ORDER BY posts.id DESC";

$stmt = $pdo->query($sql);

foreach ($stmt as $row) {

    echo "<h3>";
    echo htmlspecialchars($row["title"], ENT_QUOTES, 'UTF-8');
    echo "</h3>";

    echo "投稿者：";
    echo htmlspecialchars($row["name"], ENT_QUOTES, 'UTF-8');
    echo "<br>";

    echo "留学先：";
    echo htmlspecialchars($row["country"], ENT_QUOTES, 'UTF-8');
    echo "<br>";

    echo "留学期間：";
    echo htmlspecialchars($row["period"], ENT_QUOTES, 'UTF-8');
    echo "<br>";

    echo "<p>";
    echo nl2br(htmlspecialchars($row["comment"], ENT_QUOTES, 'UTF-8'));
    echo "</p>";

    echo "投稿日：";
    echo $row["created_at"];

    // 自分の投稿だけ編集・削除を表示
    if ($row["user_id"] == $_SESSION["user_id"]) {

        echo "<p>";

        echo '<a href="edit.php?id=' . $row["id"] . '">【編集】</a>';

        echo " ";

        echo '<a href="delete.php?id=' . $row["id"] . '">【削除】</a>';

        echo "</p>";
    }

    echo "<hr>";
}

?>

</body>
</html>
