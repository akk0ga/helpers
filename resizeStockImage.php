<?php
/**
 * resize and stock image / the path must end with "/" and the new name without the image ext
 * @param array $image
 * @param int $newWidth
 * @param int $newHeight
 * @param string $path
 * @param string $imageNewName
 * @return bool
 */
function resizeImg(array $image, int $newWidth, int $newHeight, string $path, string $imageNewName): bool
{
    /*
     * check ext png / jpg / jpeg
     * create image to edit
     * */
    switch ($image["type"]){
        case "image/png":
            @$originalImage = imagecreatefrompng($image["tmp_name"]);
            break;

        case "image/jpg":
        case "image/jpeg":
            @$originalImage = imagecreatefromjpeg($image["tmp_name"]);
            break;
    }

    /*
     * check if image has been create
     * */
    if (isset($originalImage) && !empty($originalImage)){

        //stock image infos
        $imageParam = [
            "original" => [
                "width" => getimagesize($image["tmp_name"])[0],
                "height" => getimagesize($image["tmp_name"])[1],
                "type" => $image["type"]
            ],

            "new" => [
                "width" => $newWidth,
                "height" => $newHeight
            ]
        ];

        //create image
        $newImage = imagecreatetruecolor($imageParam["new"]["width"], $imageParam["new"]["height"]);

        //resize image
        $resizedImage = imagecopyresampled($newImage, $originalImage,0, 0, 0, 0, $imageParam["new"]["width"], $imageParam["new"]["height"], $imageParam["original"]["width"], $imageParam["original"]["height"]);

        //check if resized is done without error
        if ($resizedImage === true){
            //create and stock final image
            switch ($imageParam["original"]["type"]){
                case "image/png":
                    @$image = imagepng($newImage, $path.$imageNewName.".png");
                    return $image === true;

                case "image/jpg":
                case "image/jpeg":
                    @$image = imagejpeg($newImage, $path.$imageNewName.".jpeg");
                    return $image === true;
            }
        }else{
            return false;
        }
    }else{
        return false;
    }
    return false;
}