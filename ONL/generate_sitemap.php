<?php
require __DIR__ . '/includes/array_prov.php';
require __DIR__ . '/includes/array_tips.php';
$config = include __DIR__ . '/includes/config.php';

$baseUrl = getenv('ONL_BASE_URL') ?: 'https://oproepjesnederland.nl';

require_once __DIR__ . '/includes/utils.php';

$urls = [];

$static = [
    '/',
    '/datingtips',
    '/partnerlinks',
    '/privacy',
    '/cookie-policy',
];
foreach ($static as $path) {
    $urls[] = $baseUrl . $path;
}

foreach (array_keys($provincies) as $slug) {
    $urls[] = $baseUrl . "/dating-" . $slug;
}
foreach (array_keys($datingtips) as $slug) {
    $urls[] = $baseUrl . "/datingtips-" . $slug;
}

$provinceApiBase = rtrim($config['BASE_API_URL'], '/') . '/profile/province';
$countryMap = [ 'nl' => $provincies ];
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
            $profilePaths[$prof['id']] = $baseUrl . '/daten-met-' . $slug . '?id=' . $prof['id'];
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
