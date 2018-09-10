<?php

require_once('autoload.php');

$basePath = __DIR__;
// for Windows: replacing backslashes (\) by slashes (/)
if(strpos($basePath,'\\') !== FALSE) {
    $basePath = str_replace('\\', '/', $basePath);
}

// ----------------------------------------
// Adjustable Parameters
// ----------------------------------------
$repositoryConfiguration = array(
    'type' => 'csv',                        // string   [csv]  Only used option currently
    'file' => $basePath.'/Data/Cars.csv'    // string   Path to CSV-file
);
$templateEngine='arrayBased';               // string   [arrayBased | objectBased]    "objectBased" is implemented but not tested.

// ----------------------------------------
// Below nothing intended for adjustments
// ----------------------------------------

/**
 * Returns $baseUrl to this framework, also if it's resided in a subdirectory relative to the domain-root.
 * The port is respected but omitted in $baseUrl if standard for http (80) or https (443).
 *
 * @return string $baseUrl
 */
function getBaseUrl()
{
    $port = ':' . $_SERVER['SERVER_PORT'];
    if (($_SERVER['REQUEST_SCHEME']=='http'  && $_SERVER['SERVER_PORT']=='80')
     || ($_SERVER['REQUEST_SCHEME']=='https' && $_SERVER['SERVER_PORT']=='443')
    ) {
        $port = '';
    }
    $path = $_SERVER['SCRIPT_NAME'];
    if (strrpos($path,'index.php')==strlen($path)-9) {
        $path = substr($path,0,-9);
    }
    $baseUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $port . $path;
    return $baseUrl;
}
$baseUrl = getBaseUrl();

$controller = new \Bruchmann\Examples\Cars1\Controller\CarController($basePath, $baseUrl, $repositoryConfiguration, $templateEngine);
