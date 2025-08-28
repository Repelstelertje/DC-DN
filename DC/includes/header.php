<?php
  $companyName = "Dating Contact";
    if (!isset($base)) {
    $base = dirname(__DIR__);
  }
  require_once $base . '/includes/site.php';
  include $base . '/includes/nav_items.php';
  // Load province data if available
  if (file_exists($base . '/includes/array_prov.php')) {
      include $base . '/includes/array_prov.php';
  }
  // Config is required for API lookups when rendering profile pages
  // Capture the returned configuration array for later use
  $config = include $base . '/includes/config.php';

  configure_error_handling();
  $baseUrl = get_base_url('https://datingcontact.co.uk');
  list($canonicalUrl, $title) = generate_canonical(
      $baseUrl,
      $config['PROFILE_ENDPOINT'],
      'date-with',
      $canonical ?? null,
      $pageTitle ?? null,
      $companyName
  );
  $metaRobots = isset($metaRobots) ? $metaRobots : 'index,follow';
?>
<!DOCTYPE html>
<html lang="en-GB">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<?php
  $defaultDescription = "Join datingcontact.co.uk for exciting UK hookups and casual dating – meet real people who want real fun.";
  $description = isset($metaDescription) ? $metaDescription : $defaultDescription;
?>
<meta name="description" content="<?php echo htmlspecialchars($description, ENT_QUOTES, 'UTF-8'); ?>">
<meta name="author" content="Dating Contact">
<meta name="robots" content="<?php echo htmlspecialchars($metaRobots, ENT_QUOTES, 'UTF-8'); ?>">
<link rel="apple-touch-icon" sizes="180x180" href="img/fav/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="img/fav/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="img/fav/favicon-16x16.png">
<link rel="manifest" href="img/fav/site.webmanifest">
<?php
    list($canonicalUrl, $title) = generate_canonical(
        $baseUrl,
        $config['PROFILE_ENDPOINT'],
        'date-with',
        $canonical ?? null,
        $pageTitle ?? null,
        $companyName
    );
    echo '<link rel="canonical" href="' . $canonicalUrl . '" >';
    echo '<title>' . $title . '</title>';
?>
<?php
    // Stel standaardwaarden in
    $default_title = "Dating Contact UK";
    $default_description = "Join datingcontact.co.uk for exciting UK hookups and casual dating – meet real people who want real fun.";
    $default_image = $baseUrl . "img/bg.jpg";
    $default_url = $canonicalUrl;
    // Dynamisch genereren van inhoud gebaseerd op de pagina-URL
    $current_url = $canonicalUrl;
    // Mapping van URL-sleutels naar Open Graph gegevens
    $og_title = $default_title;
    $og_description = $default_description;
    $og_image = $default_image;
    $og_url = $canonicalUrl;
    $og_pages = [];
    foreach (['provincies', 'de', 'at', 'ch'] as $listName) {
        if (isset($$listName) && is_array($$listName)) {
            foreach ($$listName as $slug => $data) {
                $og_pages['dating-' . $slug] = [
                    'title' => $data['title'] ?? $og_title,
                    'description' => $data['meta'] ?? $og_description,
                    'image' => $default_image,
                ];
            }
        }
    }
    $og = compute_og($baseUrl, $canonicalUrl, $title, $default_description, $og_pages, $metaDescription ?? null);
    render_og_meta($og);
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
                <a class="navbar-brand" href="<?php echo $baseUrl; ?>/">Dating Contact</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">Menu</button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <?php include('includes/nav.php'); ?>
                </div>
            </div>
        </nav>
    <main>
