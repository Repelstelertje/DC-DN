<?php
  $companyName = "Zoekertjes België";
  include $base . '/includes/nav_items.php';
  // Config is required for API lookups when rendering profile pages
  // Capture the returned configuration array for later use
  $config = include $base . '/config.php';
  // Common helper functions
  require_once $base . '/includes/utils.php';
  // Control error visibility through an environment variable. By default
  // errors are hidden in production unless APP_DEBUG is truthy.
  $appDebug = getenv('APP_DEBUG');
  if (filter_var($appDebug, FILTER_VALIDATE_BOOLEAN)) {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
  } else {
    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
  }
?>
<!DOCTYPE html>
<html lang="nl-BE">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<?php
  $defaultDescription = "Gratis erotische zoekertjes voor België – ontdek nieuwe contacten en spannende dates op zoekertjesbelgie.be.";
  $description = isset($metaDescription) ? $metaDescription : $defaultDescription;
?>
<meta name="description" content="<?php echo htmlspecialchars($description, ENT_QUOTES, 'UTF-8'); ?>">
<meta name="author" content="Zoekertjes Belgie">
<link rel="apple-touch-icon" sizes="57x57" href="img/fav/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="img/fav/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="img/fav/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="img/fav/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="img/fav/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="img/fav/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="img/fav/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="img/fav/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="img/fav/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="img/fav/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="img/fav/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="img/fav/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="img/fav/favicon-16x16.png">
<link rel="manifest" href="img/fav/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="img/fav/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
<?php
    // Canonical URL logic
    if (!isset($baseUrl)) {
        $baseUrl = getenv('ONL_BASE_URL') ?: 'https://zoekertjesbelgie.be';
    }
    $canonicalUrl = isset($canonical) ? $canonical : $baseUrl; // Allow pages to override
    $title = isset($pageTitle) ? $pageTitle : "Zoekertjes België"; // Default title

    if (!isset($canonical) && isset($_GET['item'])) {
        $canonicalUrl = $baseUrl . "/dating-" . htmlspecialchars($_GET['item']);
        $title = "Dating " . htmlspecialchars($_GET['item']);
    } else if (!isset($canonical) && isset($_GET['id'])) {
        $id = preg_replace('/[^0-9]/', '', $_GET['id']);
        $apiResponse = @file_get_contents("https://20fhbe2020.be/profile/get0/8/" . $id);
        if ($apiResponse !== false) {
            $data = json_decode($apiResponse, true);
            if (isset($data['profile']['name'])) {
                $profileName = $data['profile']['name'];
                $slug = strtolower($profileName);
                $slug = preg_replace('/\s+/', '-', $slug);
                $slug = preg_replace('/[^a-z0-9-]/', '', $slug);
                $slug = trim($slug, '-');
                $canonicalUrl = $baseUrl . '/daten-met-' . $slug;
                $title = 'Daten met ' . htmlspecialchars($profileName);
            } else {
                $canonicalUrl = $baseUrl . "/profile?id=" . htmlspecialchars($_GET['id']);
                $title = "Daten met " . htmlspecialchars($_GET['id']);
            }
        } else {
            $canonicalUrl = $baseUrl . "/profile?id=" . htmlspecialchars($_GET['id']);
            $title = "Daten met " . htmlspecialchars($_GET['id']);
        }
    } else if (!isset($canonical) && isset($_GET['slug'])) {
        $slug = strtolower($_GET['slug']);
        $slug = preg_replace('/[^a-z0-9-]/', '', $slug);
        $slug = trim($slug, '-');
        $canonicalUrl = $baseUrl . '/daten-met-' . $slug;
        $title = 'Daten met ' . str_replace('-', ' ', ucfirst($slug));
    } else if (!isset($canonical) && isset($_GET['tip'])) {
        $canonicalUrl = $baseUrl . "/datingtips-" . htmlspecialchars($_GET['tip']);
        $title = "Datingtips " . htmlspecialchars($_GET['tip']);
    }
    // When no query parameters are present and no override, build canonical from script name
    if (!isset($canonical) && empty($_GET)) {
        $script = basename($_SERVER['SCRIPT_NAME']);
        if ($script !== 'index.php') {
            $canonicalUrl = $baseUrl . '/' . str_replace('.php', '', $script);
        }
    }
    // Always append site name to the title when not already present
    if (strpos($title, 'Zoekertjes België') === false) {
        $title .= ' - Zoekertjes België';
    }
    echo '<link rel="canonical" href="' . $canonicalUrl . '" >';
    echo '<title>' . $title . '</title>';
?>
<?php
    // Stel standaardwaarden in
    $default_title = "Zoekertjes België - Vind en Plaats zoekertjes in België";
    $default_description = "Zoek en plaats eenvoudig oproepjes in heel België. Van dating tot vriendschap, ontdek de beste oproepjes op Zoekertjes België.";
    $default_image = $baseUrl . "img/bg.jpg";
    $default_url = $baseUrl;
    // Dynamisch genereren van inhoud gebaseerd op de pagina-URL
    $current_url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    // Mapping van URL-sleutels naar Open Graph gegevens
    $og_title = $default_title;
    $og_description = $default_description;
    $og_image = $default_image;
    $og_url = $canonicalUrl;
    $og_pages = [
        'dating-antwerpen' => [
            'title' => 'Dating in Antwerpen - Vind je Match op Zoekertjes België',
            'description' => 'Op zoek naar een date in Antwerpen? Plaats je oproepje of reageer op anderen via Zoekertjes België.',
            'image' => $baseUrl . 'img/belgie/antwerpen.jpg'
        ],
        'dating-brussel' => [
            'title' => 'Dating in Brussel - Ontmoet Singles via Zoekertjes België',
            'description' => 'Vind singles in Brussel en plaats je datingoproep eenvoudig via Zoekertjes België.',
            'image' => $baseUrl . 'img/belgie/brussel.jpg'
        ],
        'dating-henegouwen' => [
            'title' => 'Dating in Henegouwen - Vind Je Date op Zoekertjes België',
            'description' => 'Zoek of plaats een datingoproep in Henegouwen. Ontmoet nieuwe mensen via Zoekertjes België.',
            'image' => $baseUrl . 'img/belgie/henegouwen.jpg'
        ],
        'dating-limburg' => [
            'title' => 'Dating in Limburg - Ontmoet Singles via Zoekertjes België',
            'description' => 'Plaats of bekijk datingoproepjes in Limburg op Zoekertjes België en ontmoet nieuwe mensen.',
            'image' => $baseUrl . 'img/belgie/limburg.jpg'
        ],
        'dating-luik' => [
            'title' => 'Dating in Luik - Vind je Match op Zoekertjes België',
            'description' => 'Ontmoet singles in Luik en plaats je oproepje eenvoudig op Zoekertjes België.',
            'image' => $baseUrl . 'img/belgie/luik.jpg'
        ],
        'dating-luxemburg' => [
            'title' => 'Dating in Luxemburg - Vind Singles via Zoekertjes België',
            'description' => 'Zoek of plaats een datingoproep in Luxemburg via Zoekertjes België en ontmoet nieuwe mensen.',
            'image' => $baseUrl . 'img/belgie/luxemburg.jpg'
        ],
        'dating-namen' => [
            'title' => 'Dating in Namen - Ontmoet Singles via Zoekertjes België',
            'description' => 'Vind of plaats een datingoproep in Namen op Zoekertjes België en vergroot je kansen op een geslaagde date.',
            'image' => $baseUrl . 'img/belgie/namen.jpg'
        ],
        'dating-oost-vlaanderen' => [
            'title' => 'Dating in Oost-Vlaanderen - Vind je Date op Zoekertjes België',
            'description' => 'Ontmoet singles in Oost-Vlaanderen en plaats eenvoudig je oproepje via Zoekertjes België.',
            'image' => $baseUrl . 'img/belgie/oostvlaanderen.jpg'
        ],
        'dating-vlaams-brabant' => [
            'title' => 'Dating in Vlaams-Brabant - Vind Singles via Zoekertjes België',
            'description' => 'Zoek of plaats een datingoproep in Vlaams-Brabant op Zoekertjes België en ontmoet nieuwe mensen.',
            'image' => $baseUrl . 'img/belgie/vlaamsbrabant.jpg'
        ],
        'dating-waals-brabant' => [
            'title' => 'Dating in Waals-Brabant - Vind je Match op Zoekertjes België',
            'description' => 'Ontmoet singles in Waals-Brabant en plaats je datingoproep via Zoekertjes België.',
            'image' => $baseUrl . 'img/belgie/waalsbrabant.jpg'
        ],
        'dating-west-vlaanderen' => [
            'title' => 'Dating in West-Vlaanderen - Ontmoet Nieuwe Mensen via Zoekertjes België',
            'description' => 'Plaats of bekijk datingoproepjes in West-Vlaanderen via Zoekertjes België en vind je date.',
            'image' => $baseUrl . 'img/belgie/westvlaanderen.jpg'
        ],
    ];
    // Zoek een match in de array
    foreach ($og_pages as $keyword => $data) {
        if (strpos($current_url, $keyword) !== false) {
            $og_title = $data['title'];
            $og_description = $data['description'];
            $og_image = $data['image'];
            $og_url = $current_url;
            break;
        }
    }
    // Override Open Graph description when a specific meta description is provided
    if (isset($metaDescription) && !empty($metaDescription)) {
        $og_description = htmlspecialchars($metaDescription, ENT_QUOTES, 'UTF-8');
    }
?>
<!-- Voeg dynamische Open Graph-tags toe in de HTML -->
<meta property="og:title" content="<?php echo $og_title; ?>">
<meta property="og:description" content="<?php echo $og_description; ?>">
<meta property="og:url" content="<?php echo $og_url; ?>">
<meta property="og:type" content="website">
<meta property="og:image" content="<?php echo $og_image; ?>">
<!-- Twitter Cards voor betere integratie met Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo $og_title; ?>">
<meta name="twitter:description" content="<?php echo $og_description; ?>">
<meta name="twitter:image" content="<?php echo $og_image; ?>">
<meta name="twitter:url" content="<?php echo $og_url; ?>">
<!-- Bootstrap core CSS -->
<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="css/style.css" rel="stylesheet">
</head>
<body id="top">
    <div id="oproepjes">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container">
                <a class="navbar-brand" href="<?php echo $baseUrl; ?>/">Zoekertjes België</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">Menu</button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <?php include('includes/nav.php'); ?>
                </div>
            </div>
        </nav>
    <main>
