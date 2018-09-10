<!DOCTYPE HTML>
<html>
<head>
<title>TUTORIAL OOP AND MVC</title>
</head>
<body>
<?php

$items = scandir('./');

$links = array();
foreach ($items as $item) {
    if(is_dir($item) && !in_array($item, array('.', '..', '.git', 'vendor'))) {
        $linkUrl = $item . '/index.php';
        $tmpArray = explode('_', $item);
        foreach($tmpArray as $count => $tmpString) {
            $tmpArray[$count] = ucfirst(strtolower($tmpString));
        }
        $linkText = implode(' ', $tmpArray);
        $links[] = '<a href="' . $linkUrl . '" target="_blank">' . $linkText . '</a>';
    }
}
echo '<h1>TUTORIAL OOP AND MVC</h1>';
echo '<ol>';
foreach ($links as $link) {
    echo '<li>' . $link . '</li>';
}
echo '</ol>';
?> 
</body>
<html>