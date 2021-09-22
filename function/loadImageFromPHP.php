<?php

function imgLoad(string $imageURL){
    $img = @imagecreatefromjpeg($imageURL);

    // if theres any error with the image
    if (!$img){
        $img = imagecreatetruecolor(150, 30);
        // background color
        $bgcolor = imagecolorallocate($img, 255, 255, 255);
        // text color
        $tc = imagecolorallocate($img, 0, 0, 0);
        imagefilledrectangle($img, 0, 0, 150, 30, $bgcolor);
        imagestring($img, 1, 5, 5, "Unable to load image", $tc);
    }

    ob_start();
    imagejpeg($img);
    imagedestroy($img);
    $data = ob_get_contents();
    ob_end_clean();

    return "<img src='data:image/jpeg;base64,".base64_encode ($data)."'>";
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>image load dynamically</title>
</head>
<body>
<h1>image load dynamically</h1>
<?php echo imgLoad("honda.jpg") ?>
</body>
</html>
