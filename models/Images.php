<?php

require_once "DB.php";
class Images extends DB{
    
    const ALLOWED_EXSTENSIONS = ["jpg", "jpeg", "png", "gif"];
    const MAX_FILE_SIZE = 2 * 1024 * 1024;
    const MAX_IMAGE_WIDTH = 1920;
    const MAX_IMAGE_HEIGHT = 1024;

    public function upload($image, $finalName, $destination)
    {
        $finalDestination = $destination."/".$finalName;
        move_uploaded_file($image, $finalDestination);

        $finalName = $this->connection->real_escape_string($finalName);
        $this->connection->query("insert into images (image) values ('$finalName')");
    }

    public function isValidProportions($width, $height)
    {
        return $width <= self::MAX_IMAGE_WIDTH && $height <= self::MAX_IMAGE_HEIGHT;
    }

    public function isValidExtension($extension)
    {
        return in_array($extension, self::ALLOWED_EXSTENSIONS);
    }

    public function isValidSize($size)
    {
       return  $size <= self::MAX_FILE_SIZE;
    }

    public function generateRandomName($extension)
    {
        return uniqid().".".$extension;
    }
}