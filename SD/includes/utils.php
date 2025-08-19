<?php
function strip_bad_chars($input) {
    return preg_replace('/[^a-zA-Z0-9_-]/', '', $input);
}

function slugify($text) {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}

function related_profiles_links(array $profiles, callable $urlBuilder, ?string $excludeSlug = null, int $count = 6): string {
    if ($excludeSlug !== null && isset($profiles[$excludeSlug])) {
        unset($profiles[$excludeSlug]);
    }
    if (empty($profiles)) {
        return '';
    }
    $keys = array_keys($profiles);
    shuffle($keys);
    $keys = array_slice($keys, 0, $count);
    $html = '<section class="related-profiles" aria-label="Gerelateerde profielen"><ul>';
    foreach ($keys as $slug) {
        $name = $profiles[$slug]['name'] ?? $slug;
        $href = $urlBuilder($slug);
        $html .= '<li><a href="' . $href . '">' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '</a></li>';
    }
    $html .= '</ul></section>';
    return $html;
}
?>
