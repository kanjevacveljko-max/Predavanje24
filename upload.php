<?php

require_once "models/Images.php";

$image = new Images();





$connection = mysqli_connect("localhost", "root", "", "php24");

if(!($_FILES['profileImage'])){
    die("Niste prosledili profilnu sliku!");
}

//PROVERA VELICINE SLIKE
$imageSize = $_FILES['profileImage']['size'];
if(!$image->isValidSize($imageSize)){
    die("Slika je prevelika");
}

//SLIKA MOZE BITI MAXIMALNO 1920 SIRINE I 1024 VISINE
list($width, $height) = getimagesize($_FILES["profileImage"]["tmp_name"]);
if(!$image->isValidProportions($width, $height)){
    die("Slika je presiroka ili previsoka!");
}

//PROVERA EKSTENZIJE
$imageType = pathinfo($_FILES['profileImage']['name'], PATHINFO_EXTENSION);
if(!$image->isValidExtension($imageType)) {
    die("Format slike nije dobar!");
}

//GENERISANJE RANDOM IMENA SLIKE
$randomName = $image->generateRandomName('jpg');

$finalPath = "./uploads/$randomName";
$tmpFileName = $_FILES['profileImage']['tmp_name'];

if(!is_dir("./uploads")){
    mkdir("./uploads", 0755, true);
}

$image->upload($_FILES['profileImage']['tmp_name'], $randomName, "./uploads");

