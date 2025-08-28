<?php 

$base = __DIR__;

require_once $base . '/includes/array_tips.php';
require_once $base . '/includes/utils.php';
require_once $base . '/includes/site.php';

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
$baseUrl = get_base_url('https://datingcontact.co.uk');
$canonical = $baseUrl . '/datingtips';
if ($tipSlug !== 'datingtips') {
    $canonical .= '-' . $tipSlug;
}
$pageTitle = $tips['title'] . ' - Dating Contact';

include $base . '/includes/header.php';
?>

<div class="container">
        <div class='jumbotron my-4'>
                <h1 class='text-center'><?php echo htmlspecialchars($tips["title"], ENT_QUOTES, 'UTF-8'); ?></h1>
                <?php echo $tips["intro"]; ?>
        </div>
        <div class='jumbotron my-4'>
                <?php echo $tips["tekst"]; ?>
        </div>
</div>

<?php include $base . '/includes/footer.php'; ?>
