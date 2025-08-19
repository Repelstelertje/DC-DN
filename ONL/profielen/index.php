<?php
$base = dirname(__DIR__);
require_once $base . '/includes/site.php';
$config = include $base . '/includes/config.php';

$companyName = 'Oproepjes Nederland';
$pageTitle = 'Profielen — ' . $companyName;
$metaRobots = 'index,follow';

$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 100;

$baseUrl = get_base_url('https://oproepjesnederland.nl');
$canonical = $baseUrl . '/profielen/';
if ($page > 1) {
    $canonical .= '?page=' . $page;
}

$apiUrl = $config['BANNER_ENDPOINT'];
$profiles = [];
$error = false;
$response = @file_get_contents($apiUrl);
if ($response !== false) {
    $data = json_decode($response, true);
    if (isset($data['profiles']) && is_array($data['profiles'])) {
        $profiles = $data['profiles'];
    } else {
        $error = true;
    }
} else {
    $error = true;
}

$total = count($profiles);
$totalPages = (int) ceil($total / $perPage);
$offset = ($page - 1) * $perPage;
$pageProfiles = array_slice($profiles, $offset, $perPage);

include $base . '/includes/header.php';

if ($error) {
    http_response_code(500);
    echo '<div class="container"><h1>Profielen</h1><p>Kon profielen niet laden.</p></div>';
    include $base . '/includes/footer.php';
    exit;
}
?>
<div class="container">
    <h1>Profielen</h1>
    <ul>
        <?php foreach ($pageProfiles as $profile):
            $slug = slugify($profile['name'] ?? '');
            $city = $profile['city'] ?? '';
            $url = '/daten-met-' . $slug . '?id=' . $profile['id'];
        ?>
            <li><a href="<?php echo htmlspecialchars($url, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($profile['name'], ENT_QUOTES, 'UTF-8'); ?><?php if ($city): ?> — <?php echo htmlspecialchars($city, ENT_QUOTES, 'UTF-8'); ?><?php endif; ?></a></li>
        <?php endforeach; ?>
    </ul>
    <?php if ($totalPages > 1): ?>
    <nav>
        <ul class="pagination">
            <?php if ($page > 1):
                $prev = $page - 1;
                $prevLink = $prev === 1 ? '/profielen/' : '/profielen/?page=' . $prev;
            ?>
            <li class="page-item"><a class="page-link" href="<?php echo $prevLink; ?>">Vorige</a></li>
            <?php endif; ?>
            <?php if ($page < $totalPages):
                $next = $page + 1;
                $nextLink = '/profielen/?page=' . $next;
            ?>
            <li class="page-item"><a class="page-link" href="<?php echo $nextLink; ?>">Volgende</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <?php endif; ?>
</div>
<?php include $base . '/includes/footer.php'; ?>
