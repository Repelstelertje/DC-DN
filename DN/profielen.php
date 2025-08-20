<?php
$base = __DIR__;
require_once $base . '/includes/utils.php';
require_once $base . '/includes/site.php';

// ==== CONFIG ====
$csvPath   = $base . '/data/profielen.csv';
$delimiter = ';';
$hasHeader = true;
$idField   = 'id';
$nameField = 'name';
$cityField = 'city';
$linkField = 'link';

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
            if ($hasHeader) {
                // remove possible UTF-8 BOM and whitespace from header names
                $headers = array_map(function ($h) {
                    $h = (string) $h;
                    // strip BOM if present
                    $h = preg_replace('/^\xEF\xBB\xBF/', '', $h);
                    return trim($h);
                }, $row);
                continue;
            }
            $headers = array_map(fn($i) => "col_$i", array_keys($row));
        }
        $assoc = [];
        foreach ($headers as $i => $key) {
            $assoc[$key] = $row[$i] ?? '';
        }
        yield $assoc;
    }
}

// ==== LOAD PROFILES ====
$profiles = [];
try {
    foreach (csvIterator($csvPath, $delimiter, $hasHeader) as $rec) {
        $id = trim((string)($rec[$idField] ?? ''));
        if ($id === '') {
            continue;
        }
        $profiles[] = $rec;
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo '<p>Fout bij lezen CSV: ' . h($e->getMessage()) . '</p>';
    exit;
}
// ==== PAGINATION ====
$perPage = 500;
$page    = max(1, (int)($_GET['page'] ?? 1));
$total   = count($profiles);
$pages   = (int) ceil($total / $perPage);
$offset  = ($page - 1) * $perPage;
$profiles = array_slice($profiles, $offset, $perPage);

$baseUrl  = get_base_url('https://datingnebenan.de');
$canonical = $baseUrl . '/profielen' . ($page > 1 ? '?page=' . $page : '');
$pageTitle = 'Profielen — Dating Nebenan';
$metaRobots = 'index,follow';

include $base . '/includes/header.php';
?>
<div class="container">
    <div class="jumbotron my-4">
        <h1>Profielen</h1>

        <?php if (empty($profiles)): ?>
            <p>Geen profielen gevonden.</p>
        <?php else: ?>
        <?php $chunks = array_chunk($profiles, 250); ?>
        <div class="row">
            <?php foreach ($chunks as $chunk): ?>
            <div class="col-md-6">
                <ul class="list-unstyled">
                    <?php foreach ($chunk as $r):
                        $id   = trim((string)($r[$idField] ?? ''));
                        if ($id === '') continue;
                        $name = $r[$nameField] ?? ('Profil ' . $id);
                        $city = $r[$cityField] ?? '';
                        $link = $r[$linkField] ?? '';
                    ?>
                    <li class="mb-1">
                        <?=h($name)?> - <?=h($city)?> - <a href="<?=h($link)?>">Profil ansehen</a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php if ($pages > 1): ?>
    <nav aria-label="Profielen paginering">
        <?php
        $prevPage = max(1, $page - 1);
        $nextPage = min($pages, $page + 1);
        ?>
        <ul class="pagination">
            <li class="page-item<?= $page <= 1 ? ' disabled' : '' ?>">
                <a class="page-link" href="?page=1">Erste</a>
            </li>
            <li class="page-item<?= $page <= 1 ? ' disabled' : '' ?>">
                <a class="page-link" href="?page=<?=$prevPage?>">Zurück</a>
            </li>
            <li class="page-item disabled">
                <span class="page-link">Seite <?=$page?> van <?=$pages?></span>
            </li>
            <li class="page-item<?= $page >= $pages ? ' disabled' : '' ?>">
                <a class="page-link" href="?page=<?=$nextPage?>">Weiter</a>
            </li>
            <li class="page-item<?= $page >= $pages ? ' disabled' : '' ?>">
                <a class="page-link" href="?page=<?=$pages?>">Letzte</a>
            </li>
        </ul>
    </nav>
    <?php endif; ?>
    <?php endif; ?>
</div>
<?php include $base . '/includes/footer.php'; ?>
