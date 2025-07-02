<?php 
$base = __DIR__;
define("TITLE", "Datingtipps");

$canonical = 'https://datingnebenan.de/datingtips';
$pageTitle = 'Datingtipps - Dating Nebenan';

include $base . '/includes/array_tips.php';

require_once $base . '/includes/utils.php';

$param = $_GET['tip'] ?? $_GET['item'] ?? null;
$tipSlug = null;
if ($param !== null) {
    $candidate = strip_bad_chars($param);
    if (isset($datingtips[$candidate])) {
        $tipSlug = $candidate;
    }
}

if ($tipSlug === null) {
    $metaDescription = 'Entdecke hilfreiche Datingtipps bei Dating Nebenan.';
    include $base . '/includes/header.php';
    ?>
    <div class="container">
        <div class='jumbotron my-4 text-center'>
            <h1>Datingtipps</h1>
            <p>Wähle einen unserer Tipps:</p>
            <?php foreach ($datingtips as $slug => $tip) { ?>
                <p><a class="btn btn-primary btn-tips" href="datingtips-<?php echo $slug; ?>"><?php echo htmlspecialchars($tip['name']); ?></a></p>
            <?php } ?>
        </div>
    </div>
    <?php include $base . '/includes/footer.php'; ?>
    <?php
    return;
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
