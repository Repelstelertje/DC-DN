<?php
$base = __DIR__;
require_once $base . '/includes/utils.php';
require_once $base . '/includes/site.php';

// ==== CONFIG ====
$csvPath   = $base . '/data/profielen.csv';
$delimiter = ',';
$hasHeader = true;
$idField   = 'id';
$nameField = 'name';
$cityField = 'city';

// ==== INPUT ====
$page    = max(1, (int)($_GET['page'] ?? 1));
$perPage = max(50, min(1000, (int)($_GET['per_page'] ?? 500)));
$q       = trim((string)($_GET['q'] ?? ''));

// ==== HELPERS ====
function h(?string $s): string { return htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function csvIterator(string $path, string $delimiter = ',', bool $hasHeader = true): Generator {
    if (!is_readable($path)) { throw new RuntimeException("CSV niet leesbaar: $path"); }
    $f = new SplFileObject($path, 'r');
    $f->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);
    $f->setCsvControl($delimiter);

    $headers = null;
    foreach ($f as $row) {
        if ($row === [null] || $row === false) { continue; }
        if ($headers === null) {
            if ($hasHeader) { $headers = $row; continue; }
            $headers = array_map(fn($i) => "col_$i", array_keys($row));
        }
        $assoc = [];
        foreach ($headers as $i => $key) {
            $assoc[$key] = $row[$i] ?? '';
        }
        yield $assoc;
    }
}

// ==== FILTER + PAGINATION ====
$offset  = ($page - 1) * $perPage;
$shown   = 0;
$total   = 0;
$matches = 0;
$items   = [];

try {
    foreach (csvIterator($csvPath, $delimiter, $hasHeader) as $rec) {
        $match = true;
        if ($q !== '') {
            $hay = strtolower(($rec[$nameField] ?? '') . ' ' . ($rec[$cityField] ?? '') . ' ' . ($rec[$idField] ?? ''));
            $match = str_contains($hay, strtolower($q));
        }
        if (!$match) { $total++; continue; }

        $matches++;
        if ($matches <= $offset) { $total++; continue; }
        if ($shown < $perPage) {
            $items[] = $rec;
            $shown++;
        }
        $total++;
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo '<p>Fout bij lezen CSV: ' . h($e->getMessage()) . '</p>';
    exit;
}

$lastPage = max(1, (int)ceil(($matches > 0 ? $matches : 1) / $perPage));

$baseUrl  = get_base_url('https://datingnebenan.de');
$canonical = $baseUrl . '/profielen' . ($page > 1 ? '?page=' . $page : '');
$pageTitle = 'Profielen — Dating Nebenan';
$metaRobots = 'index,follow';

include $base . '/includes/header.php';
?>
<div class="container">
    <h1>Profielen</h1>

    <form method="get" action="" class="mb-3">
        <input type="text" name="q" value="<?=h($q)?>" placeholder="Zoek op naam, plaats of ID…">
        <input type="number" name="per_page" value="<?=h((string)$perPage)?>" min="50" max="1000" step="50" title="per pagina">
        <button type="submit">Zoeken</button>
        <?php if ($q !== ''): ?>
            <a href="?per_page=<?=h((string)$perPage)?>" style="align-self:center;">Reset</a>
        <?php endif; ?>
    </form>

    <p class="stats">
        Totaal in CSV: <strong><?=number_format($total, 0, ',', '.')?></strong> ·
        Matches: <strong><?=number_format($matches, 0, ',', '.')?></strong> ·
        Pagina <strong><?=number_format($page)?></strong> / <?=number_format($lastPage)?>
    </p>

    <?php if (empty($items)): ?>
        <p>Geen profielen gevonden.</p>
    <?php else: ?>
    <ul class="list-unstyled">
        <?php foreach ($items as $r):
            $id   = trim((string)($r[$idField] ?? ''));
            if ($id === '') continue;
            $name = $r[$nameField] ?? ('Profil ' . $id);
            $city = $r[$cityField] ?? '';
            $slug = slugify($name);
            $href = '/date-mit-' . $slug . '?id=' . rawurlencode($id);
        ?>
        <li class="mb-1">
            <a href="<?=h($href)?>"><?=h($name)?></a>
            <?php if ($city !== ''): ?>
                <span class="text-muted"> — <?=h($city)?></span>
            <?php endif; ?>
            <span class="text-muted"> (ID: <?=h($id)?>)</span>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>

<?php if ($lastPage > 1):
    function qs(array $extra): string {
        $params = $_GET;
        foreach ($extra as $k=>$v) { $params[$k] = $v; }
        return '?' . http_build_query($params);
    }
    $window = 3;
    $start = max(1, $page - $window);
    $end   = min($lastPage, $page + $window);
?>
    <nav class="mt-3">
        <?php if ($page > 1): ?>
            <a class="page" href="<?=h(qs(['page'=>1]))?>">« Eerste</a>
            <a class="page" href="<?=h(qs(['page'=>$page-1]))?>">‹ Vorige</a>
        <?php endif; ?>
        <?php for ($p = $start; $p <= $end; $p++): ?>
            <a class="page <?=$p === $page ? 'active' : ''?>" href="<?=h(qs(['page'=>$p]))?>"><?=$p?></a>
        <?php endfor; ?>
        <?php if ($page < $lastPage): ?>
            <a class="page" href="<?=h(qs(['page'=>$page+1]))?>">Volgende ›</a>
            <a class="page" href="<?=h(qs(['page'=>$lastPage]))?>">Laatste »</a>
        <?php endif; ?>
    </nav>
<?php endif; ?>

</div>
<?php include $base . '/includes/footer.php'; ?>

