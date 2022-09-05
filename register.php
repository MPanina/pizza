<?php
$conn = mysqli_connect("localhost", "root", "", "pizza");
if (!$conn) {
    die("Ошибка:" . mysqli_connect_error());
}
if (isset($_POST["login"]) && isset($_POST["password"]) && $_FILES && $_FILES["filename"]["error"] == UPLOAD_ERR_OK) {
    $name = $_FILES["filename"]["name"];
    $type = $_FILES["filename"]["type"];
    $path = __DIR__ . '/img/';
    move_uploaded_file($_FILES["filename"]["tmp_name"], $path . $name);
    $login = $_POST["login"];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $userReg = "INSERT INTO `users` (`login`, `password`, `name`, `type`) VALUES ('$login', '$password', '$name', '$type')";
    if ($conn->query($userReg)) {
        echo "Регистрация прошла успешно";
    } else {
        echo "Ошибка: " . $conn->error;
    }
} else {
    echo "Введите все данные";
}
?>