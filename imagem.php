<?php


$image = 'http://images.itracki.com/2011/06/favicon.png';

$imageData = base64_encode(file_get_contents($image));

$src = 'data: '.mime_content_type($image).';base64,'.$imageData;

echo '<img src="' . $src . '">';



?>