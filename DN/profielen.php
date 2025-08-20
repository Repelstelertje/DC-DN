<?php
/* ==== CONFIG ==== */
$csvPath     = __DIR__ . '/data/profielen.csv'; // pad naar je CSV
$delimiter   = ',';      // pas aan indien ';' of '\t'
$hasHeader   = true;     // zet op false als CSV geen kopregel heeft
$idField     = 'id';     // kolomnaam of index voor profiel-ID
$nameField   = 'name';   // optioneel: wordt getoond als anchor-tekst
$cityField   = 'city';   // optioneel: extra info in linktekst

/* ==== INPUT ==== */
$page     = max(1, (int)($_GET['page'] ?? 1));
$perPage  = max(50, min(1000, (int)($_GET['per_page'] ?? 500)));
$q        = trim((string)($_GET['q'] ?? ''));

/* ==== HELPERS ==== */
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
            // synthetische headers als er geen header is
            $headers = array_map(fn($i) => "col_$i", array_keys($row));
        }
        // map naar assoc
        $assoc = [];
        foreach ($headers as $i => $key) {
            $assoc[$key] = $row[$i] ?? '';
        }
        yield $assoc;
    }
}

/* ==== FILTER + PAGINATION (one-pass) ==== */
$offset   = ($page - 1) * $perPage;
$shown    = 0;
$total    = 0;
$matches  = 0;
$items    = []; // alleen huidige pagina in geheugen

try {
    foreach (csvIterator($csvPath, $delimiter, $hasHeader) as $rec) {
        // zoekfilter
        $match = true;
        if ($q !== '') {
            $hay = strtolower(($rec[$nameField] ?? '') . ' ' . ($rec[$cityField] ?? '') . ' ' . ($rec[$idField] ?? ''));
            $match = str_contains($hay, strtolower($q));
        }
        if (!$match) { $total++; continue; }

        $matches++;
        // naar juiste pagina "scrollen"
        if ($matches <= $offset) { $total++; continue; }
        if ($shown < $perPage) {
            $items[] = $rec;
            $shown++;
        }
        $total++; // tellen we alle records? Ja — voor "totaal" van dataset
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo "<p>Fout bij lezen CSV: ".h($e->getMessage())."</p>";
    exit;
}

// NB: $total = totaal aantal rijen in CSV; $matches = aantal rijen na filter (q).
$lastPage = max(1, (int)ceil(($matches > 0 ? $matches : 1) / $perPage));
$baseUrl  = '/date-mit-holde-maid';

/* ==== HTML ==== */
?>
<!doctype html>
<html lang="de">
<head>
<meta charset="utf-8">
<title>Profielen – index</title>
<meta name="robots" content="index,follow">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
  body { font: 16px/1.5 system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; margin: 2rem; }
  form { margin-bottom: 1rem; display:flex; gap:.5rem; flex-wrap:wrap; }
  input[type="text"]{ padding:.5rem; border:1px solid #ccc; border-radius:8px; min-width:260px;}
  .grid { display:grid; grid-template-columns: repeat(auto-fill,minmax(280px,1fr)); gap:.5rem; }
  .item { padding:.5rem .75rem; border:1px solid #eee; border-radius:10px; }
  .muted{ color:#666; font-size:.9em; }
  nav { margin-top: 1rem; display:flex; gap:.5rem; flex-wrap:wrap; align-items:center;}
  .page { padding:.35rem .6rem; border:1px solid #ddd; border-radius:8px; text-decoration:none; }
  .page.active { background:#f0f0f0; font-weight:600; }
  .stats { margin:.5rem 0 1rem 0; color:#444; }
</style>
</head>
<body>

<h1>Profielen</h1>

<form method="get" action="">
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

<div class="grid">
<?php if (empty($items)): ?>
  <p>Geen profielen gevonden.</p>
<?php else: ?>
  <?php foreach ($items as $r): 
      $id   = trim((string)($r[$idField] ?? ''));
      if ($id === '') continue;
      $name = $r[$nameField] ?? ("Profil ".$id);
      $city = $r[$cityField] ?? '';
      $href = $baseUrl . '?id=' . rawurlencode($id);
  ?>
    <div class="item">
      <a href="<?=h($href)?>"><?=h($name)?></a>
      <?php if ($city !== ''): ?>
        <div class="muted"><?=h($city)?></div>
      <?php endif; ?>
      <div class="muted">ID: <?=h($id)?></div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>
</div>

<?php
// eenvoudige paginering
if ($lastPage > 1):
  // helper om querystring te bewaren
  function qs(array $extra): string {
      $params = $_GET;
      foreach ($extra as $k=>$v) { $params[$k] = $v; }
      return '?' . http_build_query($params);
  }
  $window = 3; // hoeveel pagina’s rondom huidige
  $start = max(1, $page - $window);
  $end   = min($lastPage, $page + $window);
?>
<nav>
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
<?php include $base . '/includes/footer.php'; ?>