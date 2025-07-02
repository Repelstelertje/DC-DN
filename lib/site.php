<?php
/**
 * Common utilities for site headers.
 */
function get_base_url(string $default): string {
    $url = getenv('ONL_BASE_URL');
    return $url !== false && $url !== '' ? $url : $default;
}

function configure_error_handling(): void {
    $appDebug = getenv('APP_DEBUG');
    if (filter_var($appDebug, FILTER_VALIDATE_BOOLEAN)) {
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);
    } else {
        ini_set('display_errors', '0');
        ini_set('display_startup_errors', '0');
    }
}

function slugify(string $text): string {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}

function generate_canonical(string $baseUrl, string $apiEndpoint, string $slugPrefix, ?string $overrideUrl, ?string $titleOverride, string $siteName): array {
    $canonicalUrl = $baseUrl . $_SERVER['REQUEST_URI'];
    $title = $siteName;
    $titlePrefix = ucfirst(str_replace('-', ' ', $slugPrefix)) . ' ';

    if (isset($_GET['item'])) {
        $canonicalUrl = $baseUrl . '/dating-' . htmlspecialchars($_GET['item']);
        $title = 'Dating ' . htmlspecialchars($_GET['item']);
    } elseif (isset($_GET['slug'])) {
        $slug = slugify($_GET['slug']);
        $canonicalUrl = $baseUrl . '/' . $slugPrefix . '-' . $slug;
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $canonicalUrl .= '?id=' . $_GET['id'];
        }
        $title = $titlePrefix . ucwords(str_replace('-', ' ', $slug));
    } elseif (isset($_GET['id'])) {
        $id = preg_replace('/[^0-9]/', '', $_GET['id']);
        $apiResponse = @file_get_contents($apiEndpoint . $id);
        if ($apiResponse !== false) {
            $data = json_decode($apiResponse, true);
            if (isset($data['profile']['name'])) {
                $profileName = $data['profile']['name'];
                $slug = slugify($profileName);
                $canonicalUrl = $baseUrl . '/' . $slugPrefix . '-' . $slug;
                $title = $titlePrefix . htmlspecialchars($profileName);
            } else {
                $canonicalUrl = $baseUrl . '/profile?id=' . htmlspecialchars($_GET['id']);
                $title = $titlePrefix . htmlspecialchars($_GET['id']);
            }
        } else {
            $canonicalUrl = $baseUrl . '/profile?id=' . htmlspecialchars($_GET['id']);
            $title = $titlePrefix . htmlspecialchars($_GET['id']);
        }
    } elseif (isset($_GET['tip'])) {
        $canonicalUrl = $baseUrl . '/datingtips-' . htmlspecialchars($_GET['tip']);
        $title = 'Datingtips ' . htmlspecialchars($_GET['tip']);
    } elseif (empty($_GET)) {
        $script = basename($_SERVER['SCRIPT_NAME']);
        if ($script !== 'index.php') {
            $canonicalUrl = $baseUrl . '/' . str_replace('.php', '', $script);
        } else {
            $canonicalUrl = $baseUrl;
        }
    }

    if ($overrideUrl) {
        $canonicalUrl = $overrideUrl;
    }
    if ($titleOverride) {
        $title = $titleOverride;
    }
    if (strpos($title, $siteName) === false) {
        $title .= ' - ' . $siteName;
    }

    return [$canonicalUrl, $title];
}

function compute_og(string $baseUrl, string $canonicalUrl, string $title, string $defaultDescription, array $ogPages, ?string $metaDescription): array {
    $current_url = $canonicalUrl;
    $og_title = $title;
    $og_description = $defaultDescription;
    $og_image = $baseUrl . '/img/bg.jpg';
    $og_url = $current_url;

    foreach ($ogPages as $keyword => $data) {
        if (strpos($current_url, $keyword) !== false) {
            $og_title = $data['title'] ?? $og_title;
            $og_description = $data['description'] ?? $og_description;
            $og_image = $data['image'] ?? $og_image;
            $og_url = $current_url;
            break;
        }
    }

    if ($metaDescription) {
        $og_description = htmlspecialchars($metaDescription, ENT_QUOTES, 'UTF-8');
    }

    return [
        'title' => $og_title,
        'description' => $og_description,
        'image' => $og_image,
        'url' => $og_url,
    ];
}

function render_og_meta(array $og): void {
    echo '<meta property="og:title" content="' . $og['title'] . '">';
    echo '<meta property="og:description" content="' . $og['description'] . '">';
    echo '<meta property="og:url" content="' . $og['url'] . '">';
    echo '<meta property="og:type" content="website">';
    echo '<meta property="og:image" content="' . $og['image'] . '">';

    echo '<meta name="twitter:card" content="summary_large_image">';
    echo '<meta name="twitter:title" content="' . $og['title'] . '">';
    echo '<meta name="twitter:description" content="' . $og['description'] . '">';
    echo '<meta name="twitter:image" content="' . $og['image'] . '">';
    echo '<meta name="twitter:url" content="' . $og['url'] . '">';
}
?>
