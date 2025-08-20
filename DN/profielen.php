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

$baseUrl  = get_base_url('https://datingnebenan.de');
$canonical = $baseUrl . '/profielen';
$pageTitle = 'Profielen — Dating Nebenan';
$metaRobots = 'index,follow';

include $base . '/includes/header.php';
?>
<div class="container">
    <h1>Profielen</h1>

    <?php if (empty($profiles)): ?>
        <p>Geen profielen gevonden.</p>
    <?php else: ?>
    <ul class="list-unstyled">
        <?php foreach ($profiles as $r):
            $id   = trim((string)($r[$idField] ?? ''));
            if ($id === '') continue;
            $name = $r[$nameField] ?? ('Profil ' . $id);
            $city = $r[$cityField] ?? '';
            $link = $r[$linkField] ?? '';
        ?>
        <li class="mb-1">
            <?php if ($link !== ''): ?>
                <a href="<?=h($link)?>" target="_blank" rel="noopener"><?=h($name)?></a>
            <?php else: ?>
                <span><?=h($name)?></span>
            <?php endif; ?>
            <?php if ($city !== ''): ?>
                <span class="text-muted"> — <?=h($city)?></span>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
</div>
<?php include $base . '/includes/footer.php'; ?>
