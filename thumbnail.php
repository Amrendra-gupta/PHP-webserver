<?php
$thumbnailWidth = 124;
$thumbnailHeight = 124;
$imageQuality = 90; // Default image quality (0-100)

if (isset($_GET['file'])) {
    $file = $_GET['file'];
    $filePath = __DIR__ . '/' . $file;

    if (is_file($filePath) && in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), array('jpg', 'jpeg', 'png', 'gif'))) {
        list($originalWidth, $originalHeight) = getimagesize($filePath);

        if ($originalWidth > $originalHeight) {
            $thumbnailWidth = $thumbnailWidth;
            $thumbnailHeight = intval(($originalHeight / $originalWidth) * $thumbnailWidth);
        } else {
            $thumbnailHeight = $thumbnailHeight;
            $thumbnailWidth = intval(($originalWidth / $originalHeight) * $thumbnailHeight);
        }

        $image = imagecreatetruecolor($thumbnailWidth, $thumbnailHeight);
        $fileExtension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        switch ($fileExtension) {
            case 'jpg':
            case 'jpeg':
                $sourceImage = imagecreatefromjpeg($filePath);
                break;
            case 'png':
                $sourceImage = imagecreatefrompng($filePath);
                break;
            case 'gif':
                $sourceImage = imagecreatefromgif($filePath);
                break;
        }

        imagecopyresampled($image, $sourceImage, 0, 0, 0, 0, $thumbnailWidth, $thumbnailHeight, $originalWidth, $originalHeight);

        header("Content-Type: image/jpeg");
        imagejpeg($image, null, $imageQuality);

        imagedestroy($sourceImage);
        imagedestroy($image);
    }
}
?>