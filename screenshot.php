<?php
header('Content-Type: application/json');

require __DIR__ . '/vendor/autoload.php';
use Spatie\Browsershot\Browsershot;

$userAgent = "Mozilla/5.0 (compatible; MSIE 10.6; Windows NT 6.1; Trident/5.0; InfoPath.2; SLCC1; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729; .NET CLR 2.0.50727) 3gpp-gba UNTRUSTED/1.0";
$path = 'v2/screenshots/';

$parseURL = parse_url($_POST['url']);

/** Format our URL string. Likely making some assumptions here **/
if (!isset($parseURL['scheme'])) {
    $url = 'http://' . $parseURL['path'];
} else {
    $url = $_POST['url'];
}


/** Avoid having long-ass filenames **/
if (!isset($parseURL['host'])) {
    $host = explode('/', $parseURL['path']);
    $fileName = $host[0];
} else {
    $fileName = $parseURL['host'];
}


//$fileName = isset($parseURL['host']) ?$parseURL['host']:$parseURL['path'];

$path = $path . date('Ymd.h-i-s') ."_". $fileName . '.png';

Browsershot::url($url)
    ->windowSize(1280, 1024)
    ->userAgent($userAgent)
    ->fullPage()
    ->dismissDialogs()
    ->save($path);

echo json_encode($path);
?>