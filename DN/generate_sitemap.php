<?php
require __DIR__ . '/includes/array_prov.php';
require __DIR__ . '/includes/array_tips.php';
$config = include __DIR__ . '/includes/config.php';

$baseUrl = $config['BASE_URL'];

require_once __DIR__ . '/includes/utils.php';
require_once __DIR__ . '/includes/sitemap.php';

$urls = [];

$static = [
    '/',
    '/datingtipps',
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
    if ($slug === 'datingtipps') {
        continue;
    }
    $urls[] = $baseUrl . '/datingtipps-' . $slug;
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

$urls = exclude_noindex($urls, __DIR__);

$urls = array_filter($urls, static function ($u) {
    return is_string($u) && trim($u) !== '';
});

$added = merge_into_sitemap($urls, __DIR__ . '/sitemap.xml');
echo "Added $added new URLs to sitemap\n";
