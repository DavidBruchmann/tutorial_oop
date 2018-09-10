<?php

function loadClassesRecursive($folder = 'Classes', $excludes = array())
{
    $items = scandir($folder);
    foreach ($items as $count => $item) {
        if (!in_array($item, array('.','..'))) {
            $currentPath = $folder.'/'.$item;
            if (!in_array($currentPath, $excludes)) {
                if (is_dir($currentPath)) {
                    loadClassesRecursive($currentPath, $excludes);
                } else {
                    if (is_file($currentPath)
                     && strpos($currentPath,'.php') == strlen($currentPath)-4
                     && strpos($item, '_') !== 0
                    ) {
                        require_once($currentPath);
                    }
                }
            }
        }
    }
}

loadClassesRecursive('Classes');
$excludes = array(
    '../vendor/smarty/demo',
);
loadClassesRecursive('../vendor', $excludes);
