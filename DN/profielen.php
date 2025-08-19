<?php
$base = __DIR__;
require_once $base . '/includes/utils.php';
require_once $base . '/includes/site.php';
$config = include $base . '/includes/config.php';

$perPage = 120;
$page = isset($_GET['page']) && ctype_digit($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;

$cacheFile = sys_get_temp_dir() . '/dn_profiles_cache_' . $page . '.json';
$cacheTtl = 300; // 5 minutes
$profiles = [];
$totalProfiles = 0;
$totalPages = 1;
$apiError = false;

if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cacheTtl)) {
    $data = json_decode(@file_get_contents($cacheFile), true);
    if (isset($data['profiles']) && is_array($data['profiles'])) {
        $profiles = $data['profiles'];
        $totalProfiles = (int)($data['total'] ?? $data['total_profiles'] ?? 0);
        $totalPages = (int)($data['total_pages'] ?? ($totalProfiles > 0 ? (int)ceil($totalProfiles / $perPage) : 1));
    }
}

if (!$profiles) {
    $apiUrl = $config['BASE_API_URL'] . '/profiles?page=' . $page . '&per_page=' . $perPage;
    $response = @file_get_contents($apiUrl);
    if ($response !== false) {
        $data = json_decode($response, true);
        if (isset($data['profiles']) && is_array($data['profiles'])) {
            $profiles = $data['profiles'];
            $totalProfiles = (int)($data['total'] ?? $data['total_profiles'] ?? 0);
            $totalPages = (int)($data['total_pages'] ?? ($totalProfiles > 0 ? (int)ceil($totalProfiles / $perPage) : 1));
            @file_put_contents($cacheFile, $response);
        } else {
            $apiError = true;
        }
    } else {
        $apiError = true;
    }
}

$totalProfiles = $totalProfiles ?: count($profiles);
$totalPages = $totalPages > 0 ? $totalPages : ($totalProfiles > 0 ? (int)ceil($totalProfiles / $perPage) : 1);
$profilesSlice = array_slice($profiles, 0, $perPage);

$baseUrl = get_base_url('https://datingnebenan.de');
$canonical = $baseUrl . '/profielen' . ($page > 1 ? '?page=' . $page : '');
$pageTitle = 'Profielen — Dating Nebenan';
$metaRobots = 'index,follow';

if ($apiError) {
    http_response_code(500);
}

include $base . '/includes/header.php';
?>
<div class="container">
    <div class="jumbotron jumbotron-sm">
        <h1 class="text-center">Profielen</h1>
        <?php if ($apiError): ?>
            <p>Er ging iets mis bij het ophalen van de profielen.</p>
        <?php else: ?>
        <ul>
        <?php foreach ($profilesSlice as $p):
            $name = htmlspecialchars($p['name'] ?? '', ENT_QUOTES, 'UTF-8');
            $city = htmlspecialchars($p['city'] ?? '', ENT_QUOTES, 'UTF-8');
            $id = (int)($p['id'] ?? 0);
            $slug = slugify($name);
            $url = '/date-mit-' . $slug . '?id=' . $id;
        ?>
            <li><a href="<?= $url ?>"><?= $name ?><?php if ($city) echo ' — ' . $city; ?></a></li>
        <?php endforeach; ?>
        </ul>
        <?php if ($totalPages > 1): ?>
        <nav aria-label="Paginierung">
            <ul class="pagination">
                <?php if ($page > 1):
                    $prev = $page - 1;
                    $prevUrl = '/profielen' . ($prev > 1 ? '?page=' . $prev : '');
                ?>
                <li class="page-item"><a class="page-link" href="<?= $prevUrl ?>">Vorige</a></li>
                <?php endif; ?>
                <?php if ($page < $totalPages):
                    $next = $page + 1;
                    $nextUrl = '/profielen?page=' . $next;
                ?>
                <li class="page-item"><a class="page-link" href="<?= $nextUrl ?>">Volgende</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
<?php endif; ?>
<?php endif; ?>
</div>
</div>
<?php include $base . '/includes/footer.php'; ?>
