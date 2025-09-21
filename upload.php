<?php

$connection = mysqli_connect("localhost", "root", "", "php24");

if(!($_FILES['profileImage'])){
    die("Niste prosledili profilnu sliku!");
}

//PROVERA VELICINE SLIKE
$imageSize = $_FILES['profileImage']['size'];
$maxFileSize = 2 * 1024 * 1024;
if($imageSize > $maxFileSize){
    die("Slika je prevelika!");
}

//SLIKA MOZE BITI MAXIMALNO 1920 SIRINE I 1024 VISINE
list($width, $height) = getimagesize($_FILES["profileImage"]["tmp_name"]);
if($width > 1920 || $height > 1024){
    die("Maksimalna sirina slike moze biti 1920px a visina 1024px");
}

//PROVERA EKSTENZIJE
$allowedExtensions = ["jpg", "jpeg", "png", "gif"];
$imageType = pathinfo($_FILES['profileImage']['name'], PATHINFO_EXTENSION);
if(!in_array($imageType, $allowedExtensions)) {
    die("Format slike nije dobar, mora biti: ". implode(', ', $allowedExtensions));
}

//GENERISANJE RANDOM IMENA SLIKE
$imageName = time().".".$imageType;

$finalPath = "./uploads/$imageName";
$tmpFileName = $_FILES['profileImage']['tmp_name'];

if(!is_dir("./uploads")){
    mkdir("./uploads", 0755, true);
}

$imageUploaded = move_uploaded_file($tmpFileName, $finalPath);

if($imageUploaded){
    $imageName = $connection->real_escape_string($imageName);
    $connection->query("insert into images (image) values ('$imageName')");
    die("Uspesno ste dodali sliku");
}
else{
    die("Doslo je do greske");
}


