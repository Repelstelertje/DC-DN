<?php
require __DIR__ . '/includes/array_prov.php';
require __DIR__ . '/includes/array_tips.php';
$config = include __DIR__ . '/config.php';

$baseUrl = getenv('ONL_BASE_URL') ?: 'https://datingnebenan.de';

function slugify($text) {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}

$urls = [];

$static = [
    '/',
    '/datingtips',
    '/partnerlinks',
    '/privacy',
    '/cookie-policy',
    '/dating-deutschland',
    '/dating-osterreich',
    '/dating-schweiz',
];
foreach ($static as $path) {
    $urls[] = $baseUrl . $path;
}

foreach (array_keys($de) as $slug) {
    $urls[] = $baseUrl . '/dating-' . $slug;
}
foreach (array_keys($at) as $slug) {
    $urls[] = $baseUrl . '/dating-' . $slug;
}
foreach (array_keys($ch) as $slug) {
    $urls[] = $baseUrl . '/dating-' . $slug;
}
foreach (array_keys($datingtips) as $slug) {
    $urls[] = $baseUrl . '/datingtips-' . $slug;
}

$provinceApiBase = rtrim($config['BASE_API_URL'], '/') . '/profile/province';
$countryMap = [ 'de' => $de, 'at' => $at, 'ch' => $ch ];
$profilePaths = [];
foreach ($countryMap as $code => $provArr) {
    foreach ($provArr as $prov) {
        $endpoint = $provinceApiBase . '/' . $code . '/' . rawurlencode($prov['name']) . '/120';
        $json = @file_get_contents($endpoint);
        if ($json === false) continue;
        $data = json_decode($json, true);
        if (!$data || !isset($data['profiles'])) continue;
        foreach ($data['profiles'] as $prof) {
            if (empty($prof['id']) || empty($prof['name'])) continue;
            $slug = slugify($prof['name']);
            $profilePaths[$prof['id']] = $baseUrl . '/date-mit-' . $slug . '?id=' . $prof['id'];
        }
    }
}
foreach ($profilePaths as $url) {
    $urls[] = $url;
}

$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset></urlset>');
$xml->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
$xml->addAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
$xml->addAttribute('xsi:schemaLocation', 'http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd');
$lastMod = date('c');
foreach ($urls as $loc) {
    $url = $xml->addChild('url');
    $url->addChild('loc', htmlspecialchars($loc, ENT_XML1));
    $url->addChild('lastmod', $lastMod);
}
file_put_contents(__DIR__ . '/sitemap.xml', $xml->asXML());

echo "Generated sitemap with " . count($urls) . " URLs\n";
