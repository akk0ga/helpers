<?php

function imgLoad(string $path){
    define("DEFAULTW", 342);
    define("DEFAULTH", 342);
    $img = @imagecreatefromjpeg($path);

    // if theres any error with the image
    if (!$img){
        $img = imagecreatetruecolor(DEFAULTW, DEFAULTH);
        // background color
        $bgcolor = imagecolorallocate($img, 255, 255, 255);
        // text color
        $tc = imagecolorallocate($img, 0, 0, 0);
        imagefilledrectangle($img, 0, 0, DEFAULTW, DEFAULTH, $bgcolor);
        imagestring($img, 5, DEFAULTW/4, DEFAULTH/2, "Unable to load image", $tc);
    }

    ob_start();
    imagejpeg($img);
    imagedestroy($img);
    $data = ob_get_contents();
    ob_end_clean();

    return "<img src='data:image/jpeg;base64,".base64_encode($data)."'>";
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>image load dynamic</h1>
<?php echo imgLoad("https://picsum.photos/342/342") ?>
</body>
</html>