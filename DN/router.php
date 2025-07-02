<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = rawurldecode($path);

// Reject suspicious paths
if (strpos($path, '..') !== false || strpos($path, "\0") !== false) {
    http_response_code(400);
    exit;
}

$fullPath = __DIR__ . $path;
$real = realpath($fullPath);
if ($real !== false) {
    if (strpos($real, __DIR__) !== 0) {
        http_response_code(404);
        exit;
    }
    $fullPath = $real;
}
if ($path !== '/' && file_exists($fullPath)) {
    return false; // serve the requested resource as-is
}

// /dating-deutschland, /dating-osterreich, /dating-schweiz => land.php?land=<code>
$countryRoutes = [
    '/dating-deutschland' => 'de',
    '/dating-osterreich'  => 'at',
    '/dating-schweiz'     => 'ch',
];
if (isset($countryRoutes[$path])) {
    $_GET['land'] = $countryRoutes[$path];
    include __DIR__ . '/land.php';
    return;
}

// /dating-<slug> => provincie.php?item=<slug>
if (preg_match('#^/dating-([^/]+)$#', $path, $m)) {
    $_GET['item'] = $m[1];
    include __DIR__ . '/provincie.php';
    return;
}

// /date-mit-<slug> => profile.php?slug=<slug>
if (preg_match('#^/date-mit-([^/]+)$#', $path, $m)) {
    $_GET['slug'] = $m[1];
    include __DIR__ . '/profile.php';
    return;
}

// /datingtips-<slug> => datingtips.php?tip=<slug>
if (preg_match('#^/datingtips-([^/]+)$#', $path, $m)) {
    $_GET['tip'] = $m[1];
    include __DIR__ . '/datingtips.php';
    return;
}

$routes = [
    '/'              => 'index.php',
    '/index'         => 'index.php',
    '/partnerlinks'  => 'partnerlinks.php',
    '/privacy'       => 'privacy.php',
    '/cookie-policy' => 'cookie-policy.php',
    '/datingtips'    => 'datingtips.php',
    '/land'          => 'land.php',
];

if (isset($routes[$path])) {
    include __DIR__ . '/' . $routes[$path];
    return;
}

$phpFile = __DIR__ . $path . '.php';
if ($path !== '/' && file_exists($phpFile)) {
    include $phpFile;
    return;
}

http_response_code(404);
include __DIR__ . '/404.php';

