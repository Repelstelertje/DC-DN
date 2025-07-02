<?php
  $companyName = "Dating Contact";
  include $base . '/includes/nav_items.php';
  // Config is required for API lookups when rendering profile pages
  // Capture the returned configuration array for later use
  $config = include $base . '/config.php';
  /**
   * Convert a string to a URL friendly slug.
   *
   * @param string $text
   * @return string
   */
  function slugify($text) {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
  }
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
    $baseUrl = "https://datingcontact.co.uk";
    // Default canonical URL uses current request URI so every page gets
    // its own canonical tag
    $canonicalUrl = $baseUrl . $_SERVER['REQUEST_URI'];
    $title = "Dating Contact"; // Default title
    if (isset($_GET['item'])) {
        $canonicalUrl = $baseUrl . "/dating-" . htmlspecialchars($_GET['item']);
        $title = "Dating " . htmlspecialchars($_GET['item']);
    } else if (isset($_GET['id'])) {
        $id = preg_replace('/[^0-9]/', '', $_GET['id']);
        $apiResponse = @file_get_contents("https://22mlf09mds22.com/profile/get0/8/" . $id);
        if ($apiResponse !== false) {
            $data = json_decode($apiResponse, true);
            if (isset($data['profile']['name'])) {
                $profileName = $data['profile']['name'];
                $slug = strtolower($profileName);
                $slug = preg_replace('/\s+/', '-', $slug);
                $slug = preg_replace('/[^a-z0-9-]/', '', $slug);
                $slug = trim($slug, '-');
                $canonicalUrl = $baseUrl . '/date-with-' . $slug;
                $title = 'Date with ' . htmlspecialchars($profileName);
            } else {
                $canonicalUrl = $baseUrl . "/profile?id=" . htmlspecialchars($_GET['id']);
                $title = "Date with " . htmlspecialchars($_GET['id']);
            }
        } else {
            $canonicalUrl = $baseUrl . "/profile?id=" . htmlspecialchars($_GET['id']);
            $title = "Date with " . htmlspecialchars($_GET['id']);
        }
    } else if (isset($_GET['tip'])) {
        $canonicalUrl = $baseUrl . "/datingtips-" . htmlspecialchars($_GET['tip']);
        $title = "Dating Tips " . htmlspecialchars($_GET['tip']);
    }
    // When no query parameters are present, build canonical from script name
    if (empty($_GET)) {
        $script = basename($_SERVER['SCRIPT_NAME']);
        if ($script !== 'index.php') {
            $canonicalUrl = $baseUrl . '/' . $script;
        }
    }

    // Page level overrides for canonical URL and title
    if (isset($canonical) && !empty($canonical)) {
        $canonicalUrl = $canonical;
    }
    if (isset($pageTitle) && !empty($pageTitle)) {
        $title = $pageTitle;
    } elseif (defined('TITLE')) {
        $title = TITLE;
    }

    // Always append site name to the title when not already present
    if (strpos($title, 'Dating Contact') === false) {
        $title .= ' - Dating Contact';
    }

    echo '<link rel="canonical" href="' . $canonicalUrl . '" >';
    echo '<title>' . $title . '</title>';
?>
<?php
    // Stel standaardwaarden in
    $default_title = "Dating Contact UK";
    $default_description = "Free dating - Are you looking for a partner or a fun free date? Here you will find more than 10,000 singles. Registration is 100% free.";
    $default_image = $baseUrl . "img/bg.jpg";
    $default_url = $canonicalUrl;
    // Dynamisch genereren van inhoud gebaseerd op de pagina-URL
    $current_url = $canonicalUrl;
    // Mapping van URL-sleutels naar Open Graph gegevens
    $og_title = $default_title;
    $og_description = $default_description;
    $og_image = $default_image;
    $og_url = $default_url;
    $og_pages = [
        'dating-east-midlands' => [
            'title' => 'Dating in East Midlands',
            'description' => 'The East Midlands, home to cities like Nottingham, Leicester, and Derby, offers a vibrant and diverse dating scene. Whether you enjoy cozy pubs, scenic walks in the Peak District, or cultural outings, there\'s something for everyone. Singles in this region are often looking for genuine connections, and the blend of urban life and countryside charm creates great opportunities for memorable dates. Both online platforms and local events play a key role in bringing people together across the East Midlands.',
            'image' => $baseUrl . ''
        ],
        'dating-east-of-england' => [
            'title' => 'Dating in East of England',
            'description' => 'The East of England, featuring areas like Cambridge, Norwich, and Essex, offers a unique mix of historic charm and coastal beauty—perfect for romantic connections. With its picturesque countryside, seaside towns, and vibrant university cities, the region sets the stage for both relaxed and exciting dates. Whether you\'re meeting through online platforms or local events, singles in the East of England often seek meaningful relationships in a welcoming and down-to-earth atmosphere.',
            'image' => $baseUrl . '/'
        ],
        'dating-london' => [
            'title' => 'Dating in London',
            'description' => 'Dating in London is fast-paced, diverse, and full of possibilities. As one of the world’s most multicultural cities, it offers endless opportunities to meet people from all walks of life. From rooftop bars and art galleries to scenic parks and hidden cafes, London provides the perfect backdrop for any kind of date. While the city\'s busy lifestyle can make dating feel competitive, it also means there\'s always something new to explore together. Whether online or in person, London’s dating scene is as dynamic and exciting as the city itself.',
            'image' => $baseUrl . ''
        ],
        'dating-north-east-england' => [
            'title' => 'Dating in North East England',
            'description' => 'Dating in North East England, with cities like Newcastle, Sunderland, and Durham, is known for its warmth, friendliness, and strong sense of community. The region combines stunning coastlines, historic landmarks, and lively nightlife, making it ideal for both casual meetups and meaningful connections. Whether you\'re enjoying a walk along the beach or a night out in the city, the North East offers a down-to-earth and genuine dating experience that reflects the welcoming spirit of its people.',
            'image' => $baseUrl . ''
        ],
        'dating-north-west-england' => [
            'title' => 'Dating in North West England',
            'description' => 'North West England, home to vibrant cities like Manchester, Liverpool, and Chester, offers a lively and diverse dating scene. Known for its rich cultural heritage, iconic music history, and friendly locals, the region is perfect for both fun nights out and relaxed daytime dates. Whether you\'re meeting someone over coffee in a cozy café or dancing the night away in the city, dating in the North West is full of energy, personality, and opportunities to form real connections.',
            'image' => $baseUrl . ''
        ],
        'dating-northern-ireland' => [
            'title' => 'Dating in Northern Ireland',
            'description' => 'Dating in Northern Ireland combines natural beauty with heartfelt connections. From the charming streets of Belfast to the breathtaking landscapes of the Causeway Coast, the region offers a romantic setting for every kind of date. Whether you\'re enjoying a quiet pub, exploring historic sites, or walking along scenic trails, Northern Ireland’s dating scene is friendly, relaxed, and rooted in genuine community values. It\'s a place where meaningful relationships can blossom in both urban and rural surroundings.',
            'image' => $baseUrl . ''
        ],
        'dating-scotland' => [
            'title' => 'Dating in Scotland',
            'description' => 'Scotland offers a dating experience as rich and varied as its landscapes—from the vibrant cities of Edinburgh and Glasgow to the serene Highlands and islands. With its blend of culture, history, and natural beauty, Scotland sets the perfect stage for romance. Whether it\'s a stroll through an ancient castle, a night at a cozy pub, or an outdoor adventure in the countryside, dating here is full of charm and authenticity. Scottish people are known for their warmth and wit, making the search for meaningful connections both enjoyable and memorable.',
            'image' => $baseUrl . ''
        ],
        'dating-south-east-england' => [
            'title' => 'Dating in South East England',
            'description' => 'South East England, home to places like Brighton, Oxford, and Canterbury, offers a diverse and exciting dating scene. From vibrant coastal towns to historic cities and scenic countryside, the region is full of romantic settings for memorable dates. Whether you\'re sipping wine by the sea, exploring charming villages, or enjoying a cultural event, there\'s something for every dating style. With its mix of relaxed charm and cosmopolitan flair, South East England is a great place to find meaningful connections.',
            'image' => $baseUrl . ''
        ],
        'dating-south-west-england' => [
            'title' => 'Dating in South West England',
            'description' => 'Dating in South West England blends laid-back charm with natural beauty. With picturesque locations like Bristol, Bath, and the Cornish coast, the region offers endless possibilities for romantic outings—from coastal walks and countryside picnics to vibrant city nights. Known for its friendly vibe and slower pace, the South West is ideal for those seeking genuine, lasting connections in a relaxed and scenic setting. Whether you meet online or at a local event, dating here feels warm, welcoming, and refreshingly down-to-earth.',
            'image' => $baseUrl . ''
        ],
        'dating-wales' => [
            'title' => 'Dating in Wales',
            'description' => 'Dating in Wales offers a unique mix of natural beauty, rich culture, and heartfelt connections. From the vibrant streets of Cardiff to the serene landscapes of Snowdonia and the Pembrokeshire coast, Wales provides stunning backdrops for romance. Whether it\’s a walk along a rugged beach, a cosy night in a local pub, or exploring historic castles, dating in Wales is full of charm and warmth. With friendly people and a strong sense of community, it\'s a wonderful place to build meaningful relationships.',
            'image' => $baseUrl . ''
        ],
        'dating-west-midlands' => [
            'title' => 'Dating in West Midlands',
            'description' => 'Dating in the West Midlands, with cities like Birmingham, Coventry, and Wolverhampton, offers a lively and multicultural experience. The region blends urban energy with cultural heritage, making it easy to find exciting date spots—whether you\'re exploring art galleries, enjoying live music, or relaxing in beautiful parks. Known for its friendly and down-to-earth people, the West Midlands provides a welcoming environment for singles looking to connect. With a mix of modern city life and historic charm, it\'s a great place to spark meaningful relationships.',
            'image' => $baseUrl . ''
        ],
        'dating-yorkshire-and-the-humber' => [
            'title' => 'Dating in Yorkshire and The Humber',
            'description' => 'Dating in Yorkshire and The Humber offers a perfect blend of historic charm and natural beauty. With vibrant cities like Leeds, Sheffield, and York, as well as the stunning Yorkshire Dales and coastline, the region is full of romantic possibilities. Whether you\'re enjoying a cosy café in a bustling city or walking hand-in-hand through rolling countryside, dating here is relaxed, genuine, and full of character. Known for its friendly locals and strong sense of community, Yorkshire and The Humber is an ideal place to build real, lasting connections.',
            'image' => $baseUrl . ''
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
                <a class="navbar-brand" href="<?php echo $baseUrl; ?>/">Dating Contact</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">Menu</button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <?php include('includes/nav.php'); ?>
                </div>
            </div>
        </nav>
    <main>
