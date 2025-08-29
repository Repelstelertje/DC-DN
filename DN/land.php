<?php
    include('includes/array_prov.php');
    require_once __DIR__ . '/includes/utils.php';

    $land = isset($_GET['land']) ? strip_bad_chars($_GET['land']) : '';

    $data = [
        'de' => [
            'provVar'   => 'de',
            'landVar'   => 'deLand',
            'landTitle' => 'Deutschland',
            'canonical' => 'https://datingnebenan.de/dating-deutschland',
            'pageTitle' => 'Dating Deutschland - Dating Nebenan',
        ],
        'at' => [
            'provVar'   => 'at',
            'landVar'   => 'atLand',
            'landTitle' => 'Österreich',
            'canonical' => 'https://datingnebenan.de/dating-osterreich',
            'pageTitle' => 'Dating Österreich - Dating Nebenan',
        ],
        'ch' => [
            'provVar'   => 'ch',
            'landVar'   => 'chLand',
            'landTitle' => 'Schweiz',
            'canonical' => 'https://datingnebenan.de/dating-schweiz',
            'pageTitle' => 'Dating Schweiz - Dating Nebenan',
        ],
    ];

    if (!isset($data[$land])) {
        header('Location: 404.php');
        exit;
    }

    $info = $data[$land];
    $provArray = ${$info['provVar']};
    $landInfo = ${$info['landVar']};
    $landTitle = $info['landTitle'];
    $canonical = $info['canonical'];
    $pageTitle = $info['pageTitle'];
    $metaDescription = isset($landInfo['meta']) ? $landInfo['meta'] : '';

    $base = __DIR__;
    include $base . '/includes/header.php';
?>
<div class="container">
    <div class="jumbotron my-4" >
        <h1 class="text-center"><?php echo $landInfo['title']; ?></h1>
        <hr>
        <p><?php echo $landInfo['intro']; ?></p>
    </div>
    <div class="row text-center" id="keuze">
    <?php
      foreach ($provArray as $slugKey => $item) {
          $slug = 'dating-' . $slugKey;
    ?>
    <div class="col-lg-3 col-md-6 mb-4">
      <div class="card h-100 text-left">
        <a href="<?php echo $slug; ?>"><img class="card-img-top" src="img/front/<?php echo $item['img']; ?>.jpeg" alt="Sexdate <?php echo $item['name']; ?>" @error="imgError"></a>
        <div class="card-body">
          <a href="<?php echo $slug; ?>"><h4 class="card-title"><?php echo $item['name']; ?></h4></a>
          <hr>
          <p class="card-text"><?php echo $item['meta']; ?></p>
        </div>
        <a href="<?php echo $slug; ?>" class="card-footer btn btn-primary">Dating <?php echo $item['name']; ?></a>
      </div>
    </div>
    <?php } ?>
    </div>
    <div class="jumbotron">
        <?php echo $landInfo['tekst']; ?>
    </div>
</div><!-- container -->
<?php include('includes/footer.php'); ?>

