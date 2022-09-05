<?php
$conn = mysqli_connect("localhost", "root", "", "pizza");
if (!$conn) {
    die("Ошибка: " . mysqli_connect_error());
}
if (isset($_GET["id"])) {
    $id = $_GET["id"];
}
if (isset($_GET["promoid"])) {
    $promoid = $_GET["promoid"];
}
$promoId =  mysqli_real_escape_string($conn, $_GET["promoid"]);
$promoIdSelection = "SELECT * FROM `promotion` WHERE id = '$promoId'";
$promoSelection = "SELECT * FROM `promotion` ORDER BY rand() limit 2";
$promoIdResult = mysqli_query($conn, $promoIdSelection);
$promoSelectionResult = mysqli_query($conn, $promoSelection);
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/styles.css">
    <title>Акции</title>
</head>

<body>
    <div class="main">

        <header class="head">
            <div class="left">
                <div class="logo">
                    <img src="img/pizza.png" class="respons" alt="">
                    <span class="header_info">Доставка пиццы в Астрахань<br> Время доставки: 35 минут</span>
                </div>

            </div>


        </header>


    </div>
    <div class="content">
        <h1>Акции</h1>
        <div class="cont">

            <?php

            if (isset($_GET["promoid"])) {
                foreach ($promoIdResult as $promoRow) {
                    echo "<div class='promoBlock'>";
                    echo "<h2>" . $promoRow['title'] . "</h2>";
                    echo "<p>" . $promoRow['description'] . "</p>";
                    echo "<p>" . $promoRow['longDescription'] . "</p>";
                    echo "</div>";
                } 
            } else {
                foreach ($promoSelectionResult as $promoRow) {
                    echo "<div class='promoBlock'>";
                    echo "<h2>" . $promoRow['title'] . "</h2>";
                    echo "<p>" . $promoRow['description'] . "</p>";
                    echo "<h3><a href='promo.php?promoid=" . $promoRow['id'] . "'> Подробнее </a></h3>";
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