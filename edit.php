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

$id = "";
$title = "";
$country = "";
$period = "";
$comment = "";

// 編集する投稿を取得
if (isset($_GET["id"])) {

    $id = $_GET["id"];

    $sql = "SELECT * FROM posts
            WHERE id = :id AND user_id = :user_id";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $_SESSION["user_id"], PDO::PARAM_INT);

    $stmt->execute();

    $row = $stmt->fetch();

    if ($row) {
        $title = $row["title"];
        $country = $row["country"];
        $period = $row["period"];
        $comment = $row["comment"];
    } else {
        echo "編集できる投稿がありません。";
        exit;
    }
}

// 更新処理
if (isset($_POST["id"]) &&
    isset($_POST["title"]) &&
    isset($_POST["country"]) &&
    isset($_POST["period"]) &&
    isset($_POST["comment"])) {

    $id = $_POST["id"];
    $title = $_POST["title"];
    $country = $_POST["country"];
    $period = $_POST["period"];
    $comment = $_POST["comment"];

    if ($title != "" && $country != "" && $period != "" && $comment != "") {

        $sql = "UPDATE posts
                SET title = :title,
                    country = :country,
                    period = :period,
                    comment = :comment
                WHERE id = :id AND user_id = :user_id";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':country', $country, PDO::PARAM_STR);
        $stmt->bindParam(':period', $period, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $_SESSION["user_id"], PDO::PARAM_INT);

        $stmt->execute();

        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>投稿を編集</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<h1>留学経験シェア</h1>

<h2>投稿を編集</h2>

<form action="edit.php" method="post">

    <input type="hidden" name="id"
        value="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>">

    <input type="text" name="title"
        value="<?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?>"
        placeholder="タイトル">
    <br><br>

    <input type="text" name="country"
        value="<?php echo htmlspecialchars($country, ENT_QUOTES, 'UTF-8'); ?>"
        placeholder="留学先">
    <br><br>

    <input type="text" name="period"
        value="<?php echo htmlspecialchars($period, ENT_QUOTES, 'UTF-8'); ?>"
        placeholder="留学期間">
    <br><br>

    <textarea name="comment"
        rows="10"
        cols="50"><?php echo htmlspecialchars($comment, ENT_QUOTES, 'UTF-8'); ?></textarea>

    <br><br>

    <input type="submit" value="更新">

</form>

<p>
    <a href="index.php">投稿一覧に戻る</a>
</p>

</body>
</html>
