<?php

$dsn = 'mysql:dbname=tb280710db;host=localhost';
$user = 'tb-280710';
$password = '********';

$pdo = new PDO($dsn, $user, $password,
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)
);

if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["password"])) {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password_input = $_POST["password"];

    if ($name != "" && $email != "" && $password_input != "") {

        $sql = "INSERT INTO users (name, email, password)
                VALUES (:name, :email, :password)";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password_input, PDO::PARAM_STR);

        $stmt->execute();

        echo "登録しました！";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>留学経験シェア - 新規登録</title>
</head>

<body>

<h1>留学経験シェア</h1>
<h2>新規登録</h2>

<form action="register.php" method="post">

    <input type="text" name="name" placeholder="名前"><br><br>

    <input type="email" name="email" placeholder="メールアドレス"><br><br>

    <input type="password" name="password" placeholder="パスワード"><br><br>

    <input type="submit" value="登録">

</form>

</body>
</html>
