<?php
  $companyName = "Oproepjes Nederland";
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
<html lang="nl-NL">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<?php
  $defaultDescription = "Plaats en ontdek spannende oproepjes op oproepjesnederland.nl – dé plek voor discreet contact in jouw regio.";
  $description = isset($metaDescription) ? $metaDescription : $defaultDescription;
?>
<meta name="description" content="<?php echo htmlspecialchars($description, ENT_QUOTES, 'UTF-8'); ?>">
<meta name="author" content="Oproepjes Nederland">
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
        $baseUrl = getenv('ONL_BASE_URL') ?: 'https://oproepjesnederland.nl';
    }
    $canonicalUrl = $baseUrl; // Default canonical URL
    $title = "Oproepjes Nederland"; // Default title
    if (isset($_GET['item'])) {
        $canonicalUrl = $baseUrl . "/dating-" . htmlspecialchars($_GET['item']);
        $title = "Dating " . htmlspecialchars($_GET['item']);
    } else if (isset($_GET['id'])) {
        $id = preg_replace('/[^0-9]/', '', $_GET['id']);
        $apiResponse = @file_get_contents("https://16hl07csd16.nl/profile/get0/8/" . $id);
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
    } else if (isset($_GET['tip'])) {
        $canonicalUrl = $baseUrl . "/datingtips-" . htmlspecialchars($_GET['tip']);
        $title = "Datingtips " . htmlspecialchars($_GET['tip']);
    }
    // When no query parameters are present, build canonical from script name
    if (empty($_GET)) {
        $script = basename($_SERVER['SCRIPT_NAME']);
        if ($script !== 'index.php') {
            $canonicalUrl = $baseUrl . '/' . $script;
        }
    }
    // Always append site name to the title when not already present
    if (strpos($title, 'Oproepjes Nederland') === false) {
        $title .= ' - Oproepjes Nederland';
    }
    // Allow individual pages to override the canonical URL when provided
    if (isset($canonical) && filter_var($canonical, FILTER_VALIDATE_URL)) {
        $canonicalUrl = $canonical;
    }
    echo '<link rel="canonical" href="' . $canonicalUrl . '" >';
    echo '<title>' . $title . '</title>';
?>
<?php
    // Stel standaardwaarden in
    $default_title = "Oproepjes Nederland - Dé plek voor oproepjes in Nederland";
    $default_description = "Vind en plaats oproepjes in heel Nederland. Eenvoudig platform om jouw oproepje snel en gemakkelijk te delen.";
    $default_image = $baseUrl . "img/bg.jpg";
    $default_url = $baseUrl;
    // Dynamisch genereren van inhoud gebaseerd op de pagina-URL
    $current_url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    // Mapping van URL-sleutels naar Open Graph gegevens
    $og_title = $default_title;
    $og_description = $default_description;
    $og_image = $default_image;
    $og_url = $default_url;
    $og_pages = [
        'dating-drenthe' => [
            'title' => 'Dating in Drenthe - Vind je date op Oproepjes Nederland',
            'description' => 'Op zoek naar een date in Drenthe? Plaats je oproepje of reageer op een oproep via Oproepjes Nederland.',
            'image' => $baseUrl . '/img/nederland/drenthe.png'
        ],
        'dating-flevoland' => [
            'title' => 'Dating in Flevoland - Ontmoet singles via Oproepjes Nederland',
            'description' => 'Vind singles in Flevoland en plaats je datingoproep eenvoudig op Oproepjes Nederland.',
            'image' => $baseUrl . '/img/nederland/flevoland.png'
        ],
        'dating-friesland' => [
            'title' => 'Dating in Friesland - Vind je match via Oproepjes Nederland',
            'description' => 'Zoek of plaats een datingoproep in Friesland op Oproepjes Nederland. Dé plek voor contact en nieuwe ontmoetingen.',
            'image' => $baseUrl . '/img/nederland/friesland.png'
        ],
        'dating-gelderland' => [
            'title' => 'Dating in Gelderland - Oproepjes Nederland voor singles',
            'description' => 'Ontmoet nieuwe mensen in Gelderland. Plaats eenvoudig je datingoproep op Oproepjes Nederland.',
            'image' => $baseUrl . '/img/nederland/gelderland.png'
        ],
        'dating-groningen' => [
            'title' => 'Dating in Groningen - Vind je match op Oproepjes Nederland',
            'description' => 'Zoek of plaats een datingoproep in Groningen via Oproepjes Nederland. Eenvoudig, snel en gratis.',
            'image' => $baseUrl . '/img/nederland/groningen.png'
        ],
        'dating-limburg' => [
            'title' => 'Dating in Limburg - Ontmoet singles via Oproepjes Nederland',
            'description' => 'Op zoek naar een date in Limburg? Plaats of bekijk oproepjes via Oproepjes Nederland.',
            'image' => $baseUrl . '/img/nederland/limburg.png'
        ],
        'dating-noord-brabant' => [
            'title' => 'Dating in Noord-Brabant - Vind jouw match via Oproepjes Nederland',
            'description' => 'Zoek of plaats een datingoproep in Noord-Brabant via Oproepjes Nederland. Ontmoet singles bij jou in de buurt.',
            'image' => $baseUrl . '/img/nederland/noordbrabant.png'
        ],
        'dating-noord-holland' => [
            'title' => 'Dating in Noord-Holland - Ontmoet singles via Oproepjes Nederland',
            'description' => 'Vind singles in Noord-Holland en plaats je datingoproep eenvoudig op Oproepjes Nederland.',
            'image' => $baseUrl . '/img/nederland/noordholland.png'
        ],
        'dating-overijssel' => [
            'title' => 'Dating in Overijssel - Vind je match via Oproepjes Nederland',
            'description' => 'Ontmoet nieuwe mensen in Overijssel. Plaats je oproepje op Oproepjes Nederland en vind je date.',
            'image' => $baseUrl . '/img/nederland/overijssel.png'
        ],
        'dating-utrecht' => [
            'title' => 'Dating in Utrecht - Plaats of zoek oproepjes op Oproepjes Nederland',
            'description' => 'Zoek of plaats een datingoproep in Utrecht via Oproepjes Nederland. Vind jouw match eenvoudig.',
            'image' => $baseUrl . '/img/nederland/utrecht.png'
        ],
        'dating-zeeland' => [
            'title' => 'Dating in Zeeland - Vind je date via Oproepjes Nederland',
            'description' => 'Ontmoet singles in Zeeland. Plaats of bekijk datingoproepjes via Oproepjes Nederland.',
            'image' => $baseUrl . '/img/nederland/zeeland.png'
        ],
        'dating-zuid-holland' => [
            'title' => 'Dating in Zuid-Holland - Vind je match via Oproepjes Nederland',
            'description' => 'Zoek of plaats een datingoproep in Zuid-Holland via Oproepjes Nederland en ontmoet nieuwe mensen.',
            'image' => $baseUrl . '/img/nederland/zuidholland.png'
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
    // When no match is found, ensure the OG URL follows the canonical URL
    if ($og_url === $default_url) {
        $og_url = $canonicalUrl;
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
                <a class="navbar-brand" href="<?php echo $baseUrl; ?>/">Oproepjes Nederland</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">Menu</button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <?php include('includes/nav.php'); ?>
                </div>
            </div>
        </nav>
    <main>
