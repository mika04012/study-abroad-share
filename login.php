<?php
session_start();

$dsn = 'mysql:dbname=tb280710db;host=localhost';
$user = 'tb-280710';
$password = 'ZmRV7SRvtJ';

$pdo = new PDO($dsn, $user, $password,
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)
);

if (isset($_POST["email"]) && isset($_POST["password"])) {

    $email = $_POST["email"];
    $password_input = $_POST["password"];

    if ($email != "" && $password_input != "") {

        $sql = "SELECT * FROM users
                WHERE email = :email AND password = :password";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password_input, PDO::PARAM_STR);

        $stmt->execute();

        $row = $stmt->fetch();

        if ($row) {

            $_SESSION["user_id"] = $row["id"];
            $_SESSION["user_name"] = $row["name"];

            header("Location: index.php");
            exit;

        } else {
            echo "メールアドレスまたはパスワードが違います。";
        }
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
<h2>ログイン</h2>

<form action="login.php" method="post">

    <input type="email" name="email" placeholder="メールアドレス"><br><br>

    <input type="password" name="password" placeholder="パスワード"><br><br>

    <input type="submit" value="ログイン">

</form>

<p>
    <a href="register.php">新規登録はこちら</a>
</p>

</body>
</html>