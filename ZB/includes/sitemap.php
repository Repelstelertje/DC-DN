<?php
function merge_into_sitemap(array $urls, string $sitemapPath): int {
    $namespace = 'http://www.sitemaps.org/schemas/sitemap/0.9';
    $existing = [];
    $xml = null;
    if (file_exists($sitemapPath)) {
        $xml = simplexml_load_file($sitemapPath);
        if ($xml !== false) {
            $xml->registerXPathNamespace('sm', $namespace);
            foreach ($xml->xpath('//sm:url') as $node) {
                $locNode = $node->xpath('sm:loc');
                if ($locNode) {
                    $existing[(string)$locNode[0]] = $node;
                }
            }
        } else {
            $xml = null;
        }
    }
    if ($xml === null) {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset></urlset>');
        $xml->addAttribute('xmlns', $namespace);
        $xml->addAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $xml->addAttribute('xsi:schemaLocation', $namespace . ' ' . $namespace . '/sitemap.xsd');
    }
    $lastMod = date('c');
    $added = 0;
    foreach ($urls as $loc) {
        if (!isset($existing[$loc])) {
            $url = $xml->addChild('url', null, $namespace);
            $url->addChild('loc', htmlspecialchars($loc, ENT_XML1), $namespace);
            $url->addChild('lastmod', $lastMod, $namespace);
            $added++;
        }
    }
    file_put_contents($sitemapPath, $xml->asXML());
    return $added;
}
?>
