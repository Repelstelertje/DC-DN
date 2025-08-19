<?php 
$base = __DIR__;
$pageTitle = 'Datingtipps - Dating Nebenan';
$canonical = 'https://datingnebenan.de/datingtips';

include $base . '/includes/array_tips.php';

require_once $base . '/includes/utils.php';

$param = $_GET['tip'] ?? $_GET['item'] ?? null;
if ($param !== null) {
    $candidate = strip_bad_chars($param);
    if (isset($datingtips[$candidate])) {
        $tipSlug = $candidate;
    } else {
        http_response_code(404);
        include $base . '/404.php';
        return;
    }
} else {
    $tipSlug = 'datingtips';
}

$tips = $datingtips[$tipSlug];
$metaDescription = $tips['meta'];
include $base . '/includes/header.php';
?>

<div class="container">
    <div class='jumbotron my-4'>
        <h1 class='text-center'><?php echo htmlspecialchars($tips["title"], ENT_QUOTES, 'UTF-8'); ?></h1>
    </div>
    <div class='jumbotron my-4'>
        <?php echo $tips["tekst"]; ?>
    </div>
</div>

<?php include $base . '/includes/footer.php'; ?>
