<?php
  $companyName = "Dating Nebenan";
  if (!isset($base)) {
    $base = dirname(__DIR__);
  }
  require_once $base . '/includes/site.php';
  include $base . '/includes/nav_items.php';
  // Load datingtips for navigation dropdown
  require_once $base . '/includes/array_tips.php';
  if (file_exists($base . '/includes/array_prov.php')) {
      include $base . '/includes/array_prov.php';
  }
  $config = include $base . '/includes/config.php';

  configure_error_handling();
  $baseUrl = get_base_url('https://datingnebenan.de');
  $cfg = [
      'base_url' => $baseUrl,
      'site_name' => $companyName,
      'default_title' => 'Dating Nebenan',
      'default_og_image' => $baseUrl . '/img/bg.jpg',
      'item_prefix' => 'dating',
      'item_remove_regex' => '/^dating-/',
      'item_page_title_prefix' => 'Dating',
      'slug_prefix' => 'date-mit',
      'profile_prefix' => 'date-mit',
      'profile_title_prefix' => 'Date mit',
      'missing_profile_prefix' => 'Date mit',
      'tips_title_prefix' => 'Datingtipps',
      'profile_endpoint' => $config['PROFILE_ENDPOINT'],
  ];
  list($generatedCanonical, $generatedPageTitle, $generatedOgImage, $generatedMetaDescription) =
      generate_canonical_meta($cfg, isset($province) ? $province : []);
  $canonical = isset($canonical) ? $canonical : $generatedCanonical;
  $pageTitle = isset($pageTitle) ? $pageTitle : $generatedPageTitle;
  $ogImage = isset($ogImage) ? $ogImage : $generatedOgImage;
  if (!isset($metaDescription) && $generatedMetaDescription) {
      $metaDescription = $generatedMetaDescription;
  }
?>
<!DOCTYPE html>
<html lang="de-DE">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<?php
  $defaultDescription = "Dating nebenan? Finde unkomplizierte Dates mit echten Singles aus deiner Nähe – diskret, direkt, ehrlich.";
  $description = isset($metaDescription) ? $metaDescription : $defaultDescription;
?>
<meta name="description" content="<?php echo htmlspecialchars($description, ENT_QUOTES, 'UTF-8'); ?>">
<meta name="author" content="Dating Nebenan">
<meta name="robots" content="<?php echo htmlspecialchars($metaRobots, ENT_QUOTES, 'UTF-8'); ?>">
<link rel="apple-touch-icon" sizes="180x180" href="img/fav/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="img/fav/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="img/fav/favicon-16x16.png">
<link rel="manifest" href="img/fav/site.webmanifest">
<?php
  output_meta_tags($canonical, $pageTitle, $description, $ogImage);
?>
<!-- Bootstrap core CSS -->
<link href="css/vendor/bootstrap.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="css/style.css" rel="stylesheet">
</head>
<body id="top">
    <div id="oproepjes">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container">
                <a class="navbar-brand" href="<?php echo $baseUrl; ?>/">Dating Nebenan</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">Menü</button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <?php include('includes/nav.php'); ?>
                </div>
            </div>
        </nav>
    <main>
