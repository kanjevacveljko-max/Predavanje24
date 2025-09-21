<?php

require_once "models/DB.php";

$db = new DB();

$data = $db->connection->query("SELECT * FROM images");

?>


<!doctype html>

<html>

<head>


</head>

<body>

    <?php foreach($data as $image): ?>

        <img width="100px" height="auto" src="uploads/<?= $image['image'] ?>" />

    <?php endforeach; ?>

</body>

</html>