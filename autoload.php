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
                    if (is_file($currentPath) && strpos($currentPath,'.php') == strlen($currentPath)-4) {
                        require_once($currentPath);
                    }
                }
            }
        }
    }
}

$excludes = array(
    'Classes/Libs/smarty-3.1.32/demo',
);
loadClassesRecursive('Classes', $excludes);