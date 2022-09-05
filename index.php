<?php

use LDAP\Result;

session_start();
$conn = mysqli_connect("localhost", "root", "", "pizza");
if (!$conn) {
    die("Ошибка: " . mysqli_connect_error());
}
$sql = "SELECT id, title FROM `site` ";
$result = mysqli_query($conn, $sql);
if (isset($_GET["id"])) {
    $id = $_GET["id"];
}
if (isset($_GET["pizzaid"])) {
    $pizzaid = $_GET["pizzaid"];
}
if (isset($_GET["promoid"])) {
    $promoid = $_GET["promoid"];
}
$napolnenie = "SELECT * FROM `site` WHERE id='$id'";
$result1 = mysqli_query($conn, $napolnenie);
$row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);
$pizzaId = mysqli_real_escape_string($conn, $_GET["pizzaid"]);
$pizzaSelection = "SELECT * FROM `pizza_list`";
$pizzaIdSelection = "SELECT * FROM `pizza_list`  WHERE id = '$pizzaId'";
$pizzaIdResult = mysqli_query($conn, $pizzaIdSelection);
$pizzaResult = mysqli_query($conn, $pizzaSelection);
$siteId = mysqli_real_escape_string($conn, $_GET["id"]);
$siteIdSelection = "SELECT * FROM `site` WHERE id = '$siteId' ";
$promoId =  mysqli_real_escape_string($conn, $_GET["promoid"]);
$promoIdSelection = "SELECT * FROM `promotion` WHERE id = '$promoId'";
$promoSelection = "SELECT * FROM `promotion` ORDER BY rand() limit 2";
$promoIdResult = mysqli_query($conn, $promoIdSelection);
$promoSelectionResult = mysqli_query($conn, $promoSelection);
$promoAllSelection = "SELECT * FROM `promotion`";
$promoAllResult = mysqli_query($conn, $promoAllSelection);
?>

<!DOCTYPE html>
<html lang="ru">

</style>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Ancap Pizza</title>

</head>

<body>
    <div class="main">
        <header class="head">
            <div class="left">
                <div class="logo">
                    <img src="img/pizzalogo.png" class="respons" alt="">
                    <span class="header_info">Доставка пиццы в Астрахань<br> Время доставки: 35 минут</span>
                    <?php
                    if (isset($_SESSION["userid"])) {
                        $currentID = $_SESSION["userid"];
                        $loginSelect = "SELECT login FROM `users` WHERE id = '$currentID'";
                        $loginResult = mysqli_query($conn, $loginSelect);
                        $loginFetch = mysqli_fetch_array($loginResult);
                        echo "Привет," . $loginFetch['login'];
                        echo "<a href='exit.php'>" . " Выйти?" . "</a>";
                    } else {
                        echo "<a href='auth.php'>" . "Авторизация" . "</a>";
                    }
                    ?>
                </div>

            </div>

        </header>


    </div>
    <div class="menu">

        <?php
        foreach ($result as $row) {
            echo "<ul class='menu'";
            echo "<li><a href='index.php?id=" . $row["id"] . "'>" . " " . $row["title"] . " " . "</a></li>";
        }
        echo "</ul>";
        ?>
    </div>
    <div class="content">

        <?php
        if (isset($_GET["id"]) && $_GET["id"] == 4 ||  isset($_GET["pizzaid"])) {
            echo "<h1>" . "Меню" . "</h1>"
        ?>
            <div class="cont">

                <?php
                if (isset($_GET["pizzaid"])) {
                    foreach ($pizzaIdResult as $pizzaRow) {
                        $show_img = base64_encode($pizzaRow['image']);
                        echo "<div id='pizza_block'>";

                ?>
                        <img id="pizza_image" src="data:image/jpeg;base64, <?php echo $show_img ?>" alt="">
                    <?php

                        echo "<h2>" . $pizzaRow['title'] . "</h2>";
                        echo "<p>" . $pizzaRow['description'] . "</p>";
                        echo "<p>" . $pizzaRow['longDescription'] . "</p>";
                        echo "<h3>" . $pizzaRow['price'] . "</h3>";


                        echo "</div>";
                    }
                } else {
                    foreach ($pizzaResult as $pizzaRow) {
                        $show_img = base64_encode($pizzaRow['image']);
                        echo "<div id='pizza_block'>";

                    ?>
                        <img id="pizza_image" src="data:image/jpeg;base64, <?php echo $show_img ?>" alt="">
                <?php

                        echo "<h2>" . $pizzaRow['title'] . "</h2>";
                        echo "<p>" . $pizzaRow['description'] . "</p>";
                        echo "<h3>" . $pizzaRow['price'] . "</h3>";
                        echo "<h3><a href='index.php?pizzaid=" . $pizzaRow['id'] . "'> Подробнее </a></h3>";


                        echo "</div>";
                    }
                }
            } else if (isset($_GET["id"]) && $_GET["id"] == 5) {
                echo "<div class='cont'>";



                if (isset($_GET["promoid"])) {
                    foreach ($promoIdResult as $promoRow) {
                        echo "<div class='promoBlock'>";
                        echo "<h2>" . $promoRow['title'] . "</h2>";
                        echo "<p>" . $promoRow['description'] . "</p>";
                        echo "<p>" . $promoRow['longDescription'] . "</p>";
                        echo "</div>";
                    }
                } else {
                    foreach ($promoAllResult as $promoRow) {
                        echo "<div class='promoBlock'>";
                        echo "<h2>" . $promoRow['title'] . "</h2>";
                        echo "<p>" . $promoRow['description'] . "</p>";
                        echo "<h3><a href='index.php?promoid=" . $promoRow['id'] . "'> Подробнее </a></h3>";
                        echo "</div>";
                    }
                }
                echo "</div>";
                ?>




            <?php
            } else if (isset($_GET["id"]) && $_GET["id"] == 6) {
            ?>
                <div class="cont">
                    <form action="register.php" method="POST" enctype="multipart/form-data">
                        <h2>Введите данные для регистрации</h2>
                        <p>Логин: <input type="text" name="login"></p>
                        <p>Пароль: <input type="text" name="password"></p>
                        <p>Выберите файл для аватарки: <input type="file" name="filename" size="10"></p>
                        <p><input type="submit" value="Отправить"></p>
                    </form>
                </div>


            <?php
            } else if (isset($_GET["id"]) && $_GET["id"] == 7 && isset($_SESSION["userid"])) {


                $currentID = $_SESSION["userid"];
                $loginSelect = "SELECT * FROM `users` WHERE id = '$currentID'";
                $loginResult = mysqli_query($conn, $loginSelect);
                $loginFetch = mysqli_fetch_array($loginResult);

            ?>
                <div class="cont">

                    <div class="promoBlock">

                        <?php
                        foreach ($loginResult as $userRow) {
                            echo "<p>" . "Логин: " . $userRow['login'] .  "</p>";
                            echo "<img id='pizza_image' src='img/" . $userRow['name'] . "' alt=''>";
                        }
                        ?>


                        <form method="POST" enctype="multipart/form-data">

                            <p>Выберите файл для аватарки: <input type="file" name="filename" size="10"></p>
                            <br>
                            <input type="submit" value="Загрузить">
                        </form>
                        <?php
                        if ($_FILES && $_FILES["filename"]["error"] == UPLOAD_ERR_OK) {
                            $name = $_FILES["filename"]["name"];
                            $type = $_FILES["filename"]["type"];
                            $path = __DIR__ . '/img/';
                            move_uploaded_file($_FILES["filename"]["tmp_name"], $path . $name);
                            $fileInfoUpload = "UPDATE `users` SET `name` = '$name', `type` = '$type' WHERE `id` = '$currentID'";
                            if ($conn->query($fileInfoUpload)) {
                                echo "Аватарка успешно добавлена";
                            } else {
                                echo "Ошибка: " . $conn->error;
                            }
                        }
                        ?>
                    </div>
                </div>



            <?php
            } else {

                echo $row1["content"];
            }

            ?>

            </div>

    </div>

    <div class="news">

        <div class="cont">

            <?php
            if (isset($_GET["promoid"]) && $_GET["id"] != 5) {

                foreach ($promoIdResult as $promoRow) {

                    echo "<div class='promoBlock'>";
                    echo "<h2>" . $promoRow['title'] . "</h2>";
                    echo "<p>" . $promoRow['longDescription'] . "</p>";
                    echo "</div>";
                }
            } else if (!isset($_GET["promoid"]) && $_GET["id"] != 5) {

                foreach ($promoSelectionResult as $promoRow) {
                    echo "<div class='promoBlock'>";
                    echo "<h2>" . $promoRow['title'] . "</h2>";
                    echo "<p>" . $promoRow['description'] . "</p>";
                    echo "<h3><a href='index.php?promoid=" . $promoRow['id'] . "'> Подробнее </a></h3>";
                    echo "</div>";
                }
            }


            ?>
        </div>

    </div>

    <footer>
        <div>Ancap Pizza</div>
    </footer>
</body>



</html>